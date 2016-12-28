<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RequestsIssues Controller
 *
 * @property \App\Model\Table\RequestsIssuesTable $RequestsIssues
 */
class RequestsIssuesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Requests', 'Issues']
        ];
        $requestsIssues = $this->paginate($this->RequestsIssues);

        $this->set(compact('requestsIssues'));
        $this->set('_serialize', ['requestsIssues']);
    }

    /**
     * View method
     *
     * @param string|null $id Requests Issue id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requestsIssue = $this->RequestsIssues->get($id, [
            'contain' => ['Requests', 'Issues']
        ]);

        $this->set('requestsIssue', $requestsIssue);
        $this->set('_serialize', ['requestsIssue']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $requestsIssue = $this->RequestsIssues->newEntity();
        if ($this->request->is('post')) {
            $requestsIssue = $this->RequestsIssues->patchEntity($requestsIssue, $this->request->data);
            if ($this->RequestsIssues->save($requestsIssue)) {
                $this->Flash->success(__('The requests issue has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The requests issue could not be saved. Please, try again.'));
            }
        }
        $requests = $this->RequestsIssues->Requests->find('list', ['limit' => 200]);
        $issues = $this->RequestsIssues->Issues->find('list', ['limit' => 200]);
        $this->set(compact('requestsIssue', 'requests', 'issues'));
        $this->set('_serialize', ['requestsIssue']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Requests Issue id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requestsIssue = $this->RequestsIssues->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestsIssue = $this->RequestsIssues->patchEntity($requestsIssue, $this->request->data);
            if ($this->RequestsIssues->save($requestsIssue)) {
                $this->Flash->success(__('The requests issue has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The requests issue could not be saved. Please, try again.'));
            }
        }
        $requests = $this->RequestsIssues->Requests->find('list', ['limit' => 200]);
        $issues = $this->RequestsIssues->Issues->find('list', ['limit' => 200]);
        $this->set(compact('requestsIssue', 'requests', 'issues'));
        $this->set('_serialize', ['requestsIssue']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Requests Issue id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requestsIssue = $this->RequestsIssues->get($id);
        if ($this->RequestsIssues->delete($requestsIssue)) {
            $this->Flash->success(__('The requests issue has been deleted.'));
        } else {
            $this->Flash->error(__('The requests issue could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
