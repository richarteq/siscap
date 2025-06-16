<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Settings Controller
 *
 * @property \App\Model\Table\SettingsTable $Settings
 *
 * @method \App\Model\Entity\Setting[] paginate($object = null, array $settings = [])
 */
class SettingsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $setting = $this->Settings->get(1, [
            'contain' => ['Users']
        ]);

        $this->set('setting', $setting);
        $this->set('_serialize', ['setting']);
    }

    /**
     * View method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $setting = $this->Settings->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('setting', $setting);
        $this->set('_serialize', ['setting']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $setting = $this->Settings->newEntity();
        if ($this->request->is('post')) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The setting could not be saved. Please, try again.'));
        }
        $users = $this->Settings->Users->find('list', ['limit' => 200]);
        $this->set(compact('setting', 'users'));
        $this->set('_serialize', ['setting']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        $setting = $this->Settings->get(1, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('La configuración a sido guardada'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The setting could not be saved. Please, try again.'));
        }
        $users = $this->Settings->Users->find('list', ['limit' => 1]);
        $this->set(compact('setting', 'users'));
        $this->set('_serialize', ['setting']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $setting = $this->Settings->get($id);
        if ($this->Settings->delete($setting)) {
            $this->Flash->success(__('The setting has been deleted.'));
        } else {
            $this->Flash->error(__('The setting could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //DLince
    public function isAuthorized($user)
    {
        return true;
    }
}
