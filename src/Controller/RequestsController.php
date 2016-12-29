<?php
namespace App\Controller;

use App\Controller\AppController;
use Kryptonit3\CouchPotato\CouchPotato;

/**
 * Requests Controller
 *
 * @property \App\Model\Table\RequestsTable $Requests
 */
class RequestsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		$http = new \Cake\Http\Client();
    	$requests = $this->Requests->find('all', [
    		'contain' => 'Users'
		]);
		$requestDetail = [];
		foreach($requests as $request) {
			$response = $http->get('http://www.omdbapi.com/', [
				'i' => $request->db_id,
			]);

			$movie = json_decode($response->body);
			//	debug($results);
			if(empty($movie->Title)) {
				$result['error'] = "No results";
			} else {
				$result['success'] = 'yes';

				if($movie->Poster != 'N/A') {
					if(preg_match('/\A.+\/(.+)\Z/', $movie->Poster, $matches)) {
						$poster = $matches[1];
						if(!file_exists('img/'. $poster)) {
							copy($movie->Poster, 'img/_cache/posters/' . $poster);
							$movie->Poster = '/img/_cache/posters/'.$poster;
						}
					}

				}
				$requestDetail[$request->id] = $movie;
			}
		}
		$this->paginate = [
			'order' => [
				'id' => 'desc'
			], 'limit' => 10,
		];
        $requests = $this->paginate($requests);

        $this->set(compact('requests', 'requestDetail'));
        $this->set('_serialize', ['requests']);
    }

    /**
     * View method
     *
     * @param string|null $id Request id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $request = $this->Requests->get($id, [
            'contain' => ['Users', 'Issues']
        ]);

        $this->set('request', $request);
        $this->set('_serialize', ['request']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {



        $request = $this->Requests->newEntity();
        if ($this->request->is('post')) {
            $request = $this->Requests->patchEntity($request, $this->request->data);
            if ($this->Requests->save($request)) {
                $this->Flash->success(__('The request has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The request could not be saved. Please, try again.'));
            }
        }
        $issues = $this->Requests->Issues->find('list', ['limit' => 200]);
        $this->set(compact('request', 'issues', 'queryData'));
        $this->set('_serialize', ['request']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Request id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $request = $this->Requests->get($id, [
            'contain' => ['Issues']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->Requests->patchEntity($request, $this->request->data);
            if ($this->Requests->save($request)) {
                $this->Flash->success(__('The request has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The request could not be saved. Please, try again.'));
            }
        }
        $users = $this->Requests->Users->find('list', ['limit' => 200]);
        $issues = $this->Requests->Issues->find('list', ['limit' => 200]);
        $this->set(compact('request', 'users', 'issues'));
        $this->set('_serialize', ['request']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Request id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $request = $this->Requests->get($id);
        if ($this->Requests->delete($request)) {
            $this->Flash->success(__('The request has been deleted.'));
        } else {
            $this->Flash->error(__('The request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function queryTv()
	{
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$result = [];
			$result['success'] = 'no';
			$searchString = $this->request->data('searchString');
			$token = null;
			$tokensTable = \Cake\ORM\TableRegistry::get('Tokens');
			$existingToken = $tokensTable->find('all', [
				'conditions' => [
					'domain' => 'https://api.thetvdb.com',
				]
			])->first();
			if(!empty($existingToken) and $existingToken->expires > new \Cake\I18n\Time('+1 hour')) {
				$token = $existingToken->value;
			} else {
				if(!empty($existingToken)) {
					$tokensTable->delete($existingToken);
				}
				$credentials = [
					'apikey' => getVariable('theTvDbApikey'),
				];
				$http = new \Cake\Http\Client();
				$response = $http->post('https://api.thetvdb.com/login',
					json_encode($credentials), [
						'type' => 'json',
					]);
				$responseData = json_decode($response->body);
				$token = $responseData->token;
				$tokenEntity = $tokensTable->newEntity();
				$tokenEntity->domain = "https://api.thetvdb.com";
				$tokenEntity->value = $token;
				$tokenEntity->created = new \Cake\I18n\Time('now');
				$tokenEntity->expires = new \Cake\I18n\Time('+24 hours');
				$tokensTable->save($tokenEntity);
			}
			$http = new \Cake\Http\Client();
			$response = $http->get('https://api.thetvdb.com/search/series', [
				'name' => $searchString,
			], [
				'headers' => [
					'Authorization' => 'Bearer '.$token,
				]
			]);

			$results = json_decode($response->body);
			$queryData = [];
			if(empty($results->data)) {
				$result['error'] = "No results";
			} else {
				$result['success'] = 'yes';
				$queryData = $results->data;
				foreach($queryData as $item) {
					if($item->seriesName == "** 403: Series Not Permitted **") {
						continue;
					}
					$poster = null;
					$imageResponse = $http->get('https://api.thetvdb.com/series/'.$item->id.'/images/query', [
						'keyType' => 'poster',
					], [
						'headers' => [
							'Authorization' => 'Bearer '.$token,
						]
					]);
					$imageData = json_decode($imageResponse->body);
					if(!empty($imageData->data)) {
						$poster = $imageData->data[0]->thumbnail;
						$item->poster = $poster;
					}

					if(!empty($poster) and !file_exists('img/'. $poster)) {
						copy("http://thetvdb.com/banners/" . $poster, 'img/' . $poster);
					}
					$result['shows'][] = $item;
				}
			}

		} else {
			die;
		}

		$this->response->body(json_encode($result));
		return $this->response;
	}

	public function queryMovie()
	{
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$result = [];
			$result['success'] = 'no';
			$searchString = $this->request->data('searchString');

			$http = new \Cake\Http\Client();
			$response = $http->get('http://www.omdbapi.com/', [
				's' => $searchString,
				'type' => 'movie',
			]);

			$results = json_decode($response->body);
		//	debug($results);
			if(empty($results->Search)) {
				$result['error'] = "No results";
			} else {
				$result['success'] = 'yes';
				foreach ($results->Search as $item) {
					if($item->Type != 'movie') {
						continue;
					}
					if($item->Poster != 'N/A') {
						if(preg_match('/\A.+\/(.+)\Z/', $item->Poster, $matches)) {
							$poster = $matches[1];
							if(!file_exists('img/'. $poster)) {
								copy($item->Poster, 'img/_cache/posters/' . $poster);
								$item->Poster = '/img/_cache/posters/'.$poster;
							}
						}

					}

					$detailResponse = $http->get('http://www.omdbapi.com/', [
						't' => $item->Title,
					]);
					$detailResult = json_decode($detailResponse->body);
					$item->Genre = $detailResult->Genre;
					$item->Plot = $detailResult->Plot;
					$result['movies'][] = $item;
				}
			}
		} else {
			die;
		}

		$this->response->body(json_encode($result));
		return $this->response;
	}

	public function requestMovie()
	{
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$result = [];
			$result['requested'] = 'no';
			$result['approved'] = 'no';
			$imdbId = $this->request->data('imdbId');

			$request = $this->Requests->find('all', [
				'conditions' => [
					'db_id' => $imdbId
				]
			])->first();
			if(empty($request)) {
				$request = $this->Requests->newEntity();
				$request->user_id = $this->Auth->user()['id'];
				$request->db_id = $imdbId;
				if(getVariable('autoApproveMovies')) {
					$request->approved = true;
				}
				if ($this->Requests->save($request)) {
					$result['requested'] = 'yes';
					if($request->approved) {
						$couchpotato = new CouchPotato(getVariable('couchPotatoUrl'), getVariable('couchPotatoApikey'));

						if($couchpotato->getMovieAdd([
							'identifier' => $imdbId // IMDB ID
						])) {
							$result['approved'] = 'yes';
						}
					}
				}
			} else {
				$result['requested'] = 'duplicate';
			}

		} else {
			die;
		}

		$this->response->body(json_encode($result));
		return $this->response;
	}

	public function approveMovie()
	{
		if ($this->request->is('Ajax')) {
			$this->autoRender = false;
			$result = [];
			$result['approved'] = 'no';
			$imdbId = $this->request->data('imdbId');
			$request = $this->Requests->find('all', [
				'conditions' => [
					'db_id' => $imdbId
				]
			])->first();
			$couchpotato = new CouchPotato(getVariable('couchPotatoUrl'), getVariable('couchPotatoApikey'));

			if($couchpotato->getMovieAdd([
				'identifier' => $imdbId // IMDB ID
			])) {
				$request->approved = true;
				$this->Requests->save($request);
				$result['approved'] = 'yes';
			}
		} else {
			die;
		}

		$this->response->body(json_encode($result));
		return $this->response;
	}

	public function isAuthorized($user = null)
	{
		$action = $this->request->action;

		if ($user['active']) {
			if (in_array($action, [
				'index',
				'add',
				'queryTv',
				'queryMovie',
				'requestMovie',
				'approveMovie',
			])) {
				return true;
			}
		}
		return parent::isAuthorized($user);
	}
}
