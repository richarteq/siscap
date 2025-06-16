<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Phrases Controller
 *
 * @property \App\Model\Table\PhrasesTable $Phrases
 *
 * @method \App\Model\Entity\Phrase[] paginate($object = null, array $settings = [])
 */
class PhrasesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $phrases = $this->paginate($this->Phrases);

        $this->set(compact('phrases'));
        $this->set('_serialize', ['phrases']);
    }

    /**
     * View method
     *
     * @param string|null $id Phrase id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $phrase = $this->Phrases->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('phrase', $phrase);
        $this->set('_serialize', ['phrase']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $phrase = $this->Phrases->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['user_id'] = intval($this->request->session()->read('Auth.User.id'));
            $phrase = $this->Phrases->patchEntity($phrase, $this->request->getData());
            if ($this->Phrases->save($phrase)) {
                $this->Flash->success(__('La frase ha sido agregada satisfactoriamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The phrase could not be saved. Please, try again.'));
        }
        $users = $this->Phrases->Users->find('list', ['limit' => 200]);
        $this->set(compact('phrase', 'users'));
        $this->set('_serialize', ['phrase']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Phrase id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $phrase = $this->Phrases->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['user_id'] = intval($this->request->session()->read('Auth.User.id'));
            $phrase = $this->Phrases->patchEntity($phrase, $this->request->getData());
            if ($this->Phrases->save($phrase)) {
                $this->Flash->success(__('The phrase has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The phrase could not be saved. Please, try again.'));
        }
        $users = $this->Phrases->Users->find('list', ['limit' => 200]);
        $this->set(compact('phrase', 'users'));
        $this->set('_serialize', ['phrase']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Phrase id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $phrase = $this->Phrases->get($id);
        if ($this->Phrases->delete($phrase)) {
            $this->Flash->success(__('La frase ha sido eliminada'));
        } else {
            $this->Flash->error(__('The phrase could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //DLince
		public function isAuthorized($user)
		{

			return true;

		}
}
