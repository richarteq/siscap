<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Criterions Controller
 *
 * @property \App\Model\Table\CriterionsTable $Criterions
 *
 * @method \App\Model\Entity\Criterion[] paginate($object = null, array $settings = [])
 */
class CriterionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Polls']
        ];
        $criterions = $this->paginate($this->Criterions);

        $this->set(compact('criterions'));
        $this->set('_serialize', ['criterions']);
    }

    /**
     * View method
     *
     * @param string|null $id Criterion id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $criterion = $this->Criterions->get($id, [
            'contain' => ['Polls']
        ]);

        $this->set('criterion', $criterion);
        $this->set('_serialize', ['criterion']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $criterion = $this->Criterions->newEntity();
        if ($this->request->is('post')) {
            $criterion = $this->Criterions->patchEntity($criterion, $this->request->getData());
            if ($this->Criterions->save($criterion)) {
                $this->Flash->success(__('The criterion has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The criterion could not be saved. Please, try again.'));
        }
        $polls = $this->Criterions->Polls->find('list', ['limit' => 200]);
        $this->set(compact('criterion', 'polls'));
        $this->set('_serialize', ['criterion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Criterion id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $criterion = $this->Criterions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $criterion = $this->Criterions->patchEntity($criterion, $this->request->getData());
            if ($this->Criterions->save($criterion)) {
                $this->Flash->success(__('The criterion has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The criterion could not be saved. Please, try again.'));
        }
        $polls = $this->Criterions->Polls->find('list', ['limit' => 200]);
        $this->set(compact('criterion', 'polls'));
        $this->set('_serialize', ['criterion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Criterion id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $criterion = $this->Criterions->get($id);
        if ($this->Criterions->delete($criterion)) {
            $this->Flash->success(__('The criterion has been deleted.'));
        } else {
            $this->Flash->error(__('The criterion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
