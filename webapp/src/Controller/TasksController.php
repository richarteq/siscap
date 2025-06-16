<?php
namespace App\Controller;

use App\Controller\AppController;

//DLince
use Cake\Filesystem\Folder;
use Cake\Mailer\Email;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 *
 * @method \App\Model\Entity\Task[] paginate($object = null, array $settings = [])
 */
class TasksController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
      /*
      $this->paginate = [
        'contain' => ['Courses'],
        'where' => array('Tasks.state' => 1),
        'order' => array('Tasks.created' => 'desc')
      ];
      $tasks = $this->paginate($this->Tasks);
      */
      $query = $this->Tasks->find('all')        
        ->contain(['Courses'])
        ->where(['Courses.finish >=' => date('Y-m-d')])
        ->order(['Tasks.created' => 'desc']);
      $this->set('tasks', $this->paginate($query));

      $this->set(compact('tasks'));
      $this->set('_serialize', ['tasks']);
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['Courses', 'Presentations']
        ]);

        $this->set('task', $task);
        $this->set('_serialize', ['task']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $task = $this->Tasks->newEntity();
        if ($this->request->is('post')) 
        {
          $filename = ($this->request->data['filename']==null)?null:$this->request->data['filename'];
          $ext = substr(strtolower(strrchr($this->request->data['filename']['name'], '.')), 1); //get the extension
          //only process if the extension is valid
          $max_size_attachment = ($this->viewVars['dlince_max_size_files']>=1048576)?round($this->viewVars['dlince_max_size_files']/1048576,2).' MB':round($this->viewVars['dlince_max_size_files']/1024,2).' KB';
          /**/
          if( intval($filename['size'])==0 || (intval($filename['size'])<=$this->viewVars['dlince_max_size_files'] && in_array($ext, $this->viewVars['dlince_type_files'])) )
          {
            $this->request->data['created'] = date('Y-m-d H:i:s');
            $this->request->data['modified'] = date('Y-m-d H:i:s');
            $this->request->data['title'] = (strlen(trim($this->request->data['title']))==0)?null:$this->request->data['title'];
            $this->request->data['description'] = (strlen(trim($this->request->data['description']))==0)?null:$this->request->data['description'];
            $this->request->data['user_id'] = intval($this->request->session()->read('Auth.User.id'));
            //$realFile = $this->request->data['filename'];
            $this->request->data['filename'] = (intval($filename['size'])==0)?null:$filename['name'];
            /**/
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) 
            {
              $this->Flash->success(__('La tarea a sido agregada satisfactoriamente.'));
              /*  */
              $path_course = $this->viewVars['dlince_folder'].'tasks'.DS.$task->course_id;
              /* */
              $folder_course = new Folder($path_course);
              $folder_course->create($task->id);
              /*  */
              $folder_task = new Folder($path_course.DS.$task->id);
              $folder_task->create('presentations');
              /*  */
              if( intval($filename['size'])>0 )
              {
                if( move_uploaded_file($filename['tmp_name'], $path_course.DS.$task->id.DS.$filename['name']) )
                {                
                  $this->Flash->success(__('El archivo ha sido subido al servidor.'));                  
                }
              }
              /**/
              //<DLince-Envio de correo a cada participante
              /**/
							//Buscando estudiantes y enviando emails acerca del nuevo curso
							/**/
							if( $this->viewVars['dlince_email'] && $this->viewVars['dlince_email_participantsComunicate'] )
							{
		            $students = $this->Tasks->Courses->Participants->find('list',['keyField' => 'slug','valueField' => 'student_id'])
		              ->select(['student_id'])
		              ->where( [ 'course_id'=>intval($task->course_id)]);
		            if( $students->count()>0 )
		            {
		              $users = $this->Tasks->Courses->Participants->Students->find('list',['keyField' => 'slug','valueField' => 'user_id'])
		                ->select(['user_id'])
		                ->where(['id IN'=>$students->toArray()]);
		              if( $users->count()>0 )
		              {
		                $realUsers = $this->Tasks->Courses->Users->find('list',['keyField' => 'slug','valueField' => 'email'])
		                  ->select(['email'])
		                  ->where(['id IN'=>$users->toArray()]);
		                $course = $this->Tasks->Courses->findById($task->course_id)->first();
		                foreach($realUsers as $user)
		                {
		                  //DLince-Email
		                  /**/
		                  $email = new Email();
		                  $email->transport('dlince');
		                  $email->template('taskAdd');
		                  $email->emailFormat('html');
		                  $email->viewVars([
		                    'course' => $course->name,
		                    'src' => $filename['name'],
		                    'id' => $course->id,
		                  ]);
		                  $email->from($this->viewVars['dlince_email_from'])
		                    ->bcc($user)
		                    ->subject('SISCAP - Se envió una nueva tarea');
		                  if( intval($filename['size'])>0 )
              				{
		                    $email->attachments($path_course.DS.$task->id.DS.$filename['name']);
		                  }
	                    $email->send();
		                  /**/
		                  //DLince-Email
		                }
		              }
		            }
		            /**/
		            //DLince-Envio de correo a cada participante>
              }
              return $this->redirect(['action' => 'index']);
            }
            else
            {
              $this->Flash->error(__('La tarea no ha posido ser agregada. Intente otra vez.'));
            }            
          }
          else
          {
            $this->Flash->error(__('El archivo enviado debe tener como máximo '.$max_size_attachment.' y solo se permiten los formatos '.implode(', ',$this->viewVars['dlince_type_files'])));
          }
        }
        /**/
        $courses = $this->Tasks->Courses->find('list')
          ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
          ->order(['name' => 'ASC']);
        /**/
        $this->set(compact('task', 'courses'));
        $this->set('_serialize', ['task']);
    }

    /**
     * getCourseDates method
     *
     */
    public function getCourseDates($course_id = null){
      $this->viewBuilder()->setLayout('ajax');
      $this->autoRender = false;
      $fechas = array();
      $query = $this->Tasks->Courses->find('all')
  			->select(['start','finish'])
  			->where(['id'=>intval($course_id),'state_id'=>1,'visible'=>1,'finish >= '=>date('Y-m-d')])->toArray();
      if( count($query)>0)
      {
        $fechas['start']['day'] = $query[0]['start']->format('d');
        $fechas['start']['month'] = $query[0]['start']->format('m');
        $fechas['start']['year'] = $query[0]['start']->format('Y');
        $fechas['finish']['day'] = $query[0]['finish']->format('d');
        $fechas['finish']['month'] = $query[0]['finish']->format('m');
        $fechas['finish']['year'] = $query[0]['finish']->format('Y');
      }
      $this->set('_serialize', 'fechas');
      echo json_encode($fechas);
    }

    public function download($course=null,$task=null,$filename=null)
    {
      $full_path_filename = $this->viewVars['dlince_folder'].'tasks'.DS.$course.DS.$task.DS.$filename;
      $full_path_about = $this->viewVars['dlince_folder'].'files'.DS.'dlince_siscap_logo.pdf';
      /**/
      if($course!=null && $task!=null && $filename!=null)
      {        
        if( file_exists($full_path_filename) )
        {
          $response = $this->response->withFile($full_path_filename);
        }
        else
        {
          $response = $this->response->withFile($full_path_about);
        }
      }
      else
      {
        $response = $this->response->withFile($full_path_about);
      }
      return $response;
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }
        $courses = $this->Tasks->Courses->find('list', ['limit' => 200]);
        $this->set(compact('task', 'courses'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            //$this->Flash->success(__('La tarea a sido eliminada.'));
            $folder_task = new Folder($this->viewVars['dlince_folder'].DS.'tasks'.DS.$task->course_id.DS.$task->id);         
            if ($folder_task->delete()) {
              $this->Flash->success(__('La tarea a sido eliminada'));
            }
        } else {
            $this->Flash->error(__('La tarea no ha podido eliminarse, intente otra vez.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //DLince
  	public function isAuthorized($user)
  	{

  		return true;

  	}
}
