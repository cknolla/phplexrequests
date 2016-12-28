<?php
namespace App\Controller;

use App\Controller\AppController;

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
        $this->paginate = [
            'contain' => ['Users']
        ];
        $requests = $this->paginate($this->Requests);

        $this->set(compact('requests'));
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
    	$token = null;
		$existingToken = \Cake\ORM\TableRegistry::get('Tokens')->find('all', [
			'conditions' => [
				'domain' => 'https://api.thetvdb.com',
				'expires >' => new \Cake\I18n\Time('+6 hours'),
			]
		]);
		if(!empty($existingToken)) {
			$token = $existingToken->first()->value;
		} else {
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
		}
		$http = new \Cake\Http\Client();
		$response = $http->get('https://api.thetvdb.com/search/series', [
			'name' => 'Shark',
		], [
			'headers' => [
				'Authorization' => 'Bearer '.$token,
			]
		]);

		$results = json_decode($response->body);
		$queryData = [];
		if(empty($results->data)) {
			debug("No results");
		} else {
			$queryData = $results->data;
			foreach($queryData as $item) {
				$poster = $item->banner;
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
			}
		}


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
        $this->set(compact('request', 'issues', 'queryData', 'poster'));
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
}
