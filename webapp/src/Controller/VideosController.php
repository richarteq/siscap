<?php
namespace App\Controller;

use App\Controller\AppController;
//DLince
use Cake\Mailer\Email;
/**
 * Videos Controller
 *
 * @property \App\Model\Table\VideosTable $Videos
 *
 * @method \App\Model\Entity\Video[] paginate($object = null, array $settings = [])
 */
class VideosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Courses'],
            'order' => array('Videos.created' => 'desc')
        ];
        $videos = $this->paginate($this->Videos);

        $this->set(compact('videos'));
        $this->set('_serialize', ['videos']);
    }

    /**
     * View method
     *
     * @param string|null $id Video id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $video = $this->Videos->get($id, [
            'contain' => ['Users', 'Courses']
        ]);

        $this->set('video', $video);
        $this->set('_serialize', ['video']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $video = $this->Videos->newEntity();
        if ($this->request->is('post')) {
          $this->request->data['created'] = date('Y-m-d H:i:s');
          $this->request->data['modified'] = date('Y-m-d H:i:s');
          $this->request->data['title'] = (strlen(trim($this->request->data['title']))==0)?null:$this->request->data['title'];
          $this->request->data['description'] = (strlen(trim($this->request->data['description']))==0)?null:$this->request->data['description'];
          $this->request->data['user_id'] = intval($this->request->session()->read('Auth.User.id'));
            $video = $this->Videos->patchEntity($video, $this->request->getData());
            if ($this->Videos->save($video)) {
                $this->Flash->success(__('El video ha sido agregado satisfactoriamente.'));
                //<DLince-Envio de correo a cada participante
                /**/
            		$students = $this->Videos->Courses->Participants->find('list',['keyField' => 'slug','valueField' => 'student_id'])
            			->select(['student_id'])
            			->where( [ 'course_id'=>intval($this->request->data['course_id'])]);
            		//$this->set('students', $students->toArray());
            		if( $students->count()>0)
            		{
            			$users = $this->Videos->Courses->Participants->Students->find('list',['keyField' => 'slug','valueField' => 'user_id'])
            				->select(['user_id'])
            				->where(['id IN'=>$students->toArray()]);
            				//$this->set('users', $users);
            			if( $users->count()>0)
            			{
            				$realUsers = $this->Videos->Courses->Users->find('list',['keyField' => 'slug','valueField' => 'email'])
            					->select(['email'])
            					->where(['id IN'=>$users->toArray()]);
            				//$this->set('realUsers', $realUsers);
            				$course = $this->Videos->Courses->findById($this->request->data['course_id'])->first();
            				//$this->set('course', $course);
                    if( $this->viewVars['dlince_email'] && $this->viewVars['dlince_email_participantsComunicate'] )
                    {
              				foreach($realUsers as $user){
              					//DLince-Email
              					/**/
              					$email = new Email();
              					$email->transport('dlince');
              					$email->template('videoAdd');
              					$email->emailFormat('html');
              					$email->viewVars([
              						'course' => $course->name,
              						'url' => $video->url,
                          'id' => $course->id,
              					]);
              					$email->from($this->viewVars['dlince_email_from'])
              						->bcc($user)
              						->subject('SISCAP - Se envió un nuevo video')
                          //->attachments('/home/richart/siscap/files/' . $realFile['name'])
              						->send();
              				}
                    } /* DLince-Email> */
            			}
            		}
            		/**/
                //DLince-Envio de correo a cada participante>
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El video no pudo agregarse. Intente de nuevo.'));
        }

        $courses = $this->Videos->Courses->find('list')
          ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
          ->order(['name' => 'ASC']);
        $this->set(compact('video', 'courses'));
        $this->set('_serialize', ['video']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Video id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $video = $this->Videos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

          $this->request->data['modified'] = date('Y-m-d H:i:s');
          $this->request->data['user_id'] = intval($this->request->session()->read('Auth.User.id'));
            $video = $this->Videos->patchEntity($video, $this->request->getData());
            if ($this->Videos->save($video)) {
                $this->Flash->success(__('El video ha sido editado satisfactoriamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se puedo editar el video. Intente de nuevo.'));
        }

        $courses = $this->Videos->Courses->find('list')
          ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
          ->order(['name' => 'ASC']);
        $this->set(compact('video', 'courses'));
        $this->set('_serialize', ['video']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Video id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $video = $this->Videos->get($id);
        if ($this->Videos->delete($video)) {
            $this->Flash->success(__('El video ha sido eliminado.'));
        } else {
            $this->Flash->error(__('No se ha podido eliminar el video. Intente de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //DLince
  	public function isAuthorized($user)
  	{

  		return true;

  	}
}
