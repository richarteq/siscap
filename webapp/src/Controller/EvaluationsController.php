<?php
namespace App\Controller;

use App\Controller\AppController;

//DLince
use Cake\Filesystem\Folder;
use Cake\Mailer\Email;

/**
 * Evaluations Controller
 *
 * @property \App\Model\Table\EvaluationsTable $Evaluations
 *
 * @method \App\Model\Entity\Evaluation[] paginate($object = null, array $settings = [])
 */
class EvaluationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $query = $this->Evaluations->find('all')        
            ->contain(['Courses'])
            ->where(['Courses.finish >=' => date('Y-m-d')])
            ->order(['Evaluations.created' => 'desc']);
        $this->set('evaluations', $this->paginate($query));

        $this->set(compact('evaluations'));
        $this->set('_serialize', ['evaluations']);
    }

    /**
     * View method
     *
     * @param string|null $id Evaluation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $evaluation = $this->Evaluations->get($id, [
            'contain' => ['Courses', 'Questions']
        ]);

        $this->set('evaluation', $evaluation);
        $this->set('_serialize', ['evaluation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $evaluation = $this->Evaluations->newEntity();
        if ($this->request->is('post')) 
        {
            if( $this->request->data['filename']==null ){
                $filename = null;
            }else{
                $filename = $this->request->data['filename'];
                $ext = substr(strtolower(strrchr($filename['name'], '.')), 1); //get the extension
            }
                     
          //only process if the extension is valid
          $max_size_attachment = ($this->viewVars['dlince_max_size_files']>=1048576)?round($this->viewVars['dlince_max_size_files']/1048576,2).' MB':round($this->viewVars['dlince_max_size_files']/1024,2).' KB';
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
            $evaluation = $this->Evaluations->patchEntity($evaluation, $this->request->getData());
            if ($this->Evaluations->save($evaluation)) 
            {
              $this->Flash->success(__('La evaluación a sido agregada satisfactoriamente.'));
              /*  */
              $path_course = $this->viewVars['dlince_folder'].'evaluations'.DS.$evaluation->course_id;
              /* */
              $folder_course = new Folder($path_course);
              $folder_course->create($evaluation->id);
              /*  */
              if( intval($filename['size'])>0 )
              {
                if( move_uploaded_file($filename['tmp_name'], $path_course.DS.$evaluation->id.DS.$filename['name']) )
                {                
                  $this->Flash->success(__('El archivo ha sido subido al servidor.'));                  
                }
              }
              /**/
              //<DLince-Envio de correo a cada participante
              /**/
              /**/
							//Buscando estudiantes y enviando emails acerca del nuevo curso
							/**/
							if($this->viewVars['dlince_email'] && $this->viewVars['dlince_email_participantsComunicate'] && false)
							{
		            $students = $this->Evaluations->Courses->Participants->find('list',['keyField' => 'slug','valueField' => 'student_id'])
		              ->select(['student_id'])
		              ->where( [ 'course_id'=>intval($evaluation->course_id)]);
		            if( $students->count()>0 )
		            {
		              $users = $this->Evaluations->Courses->Participants->Students->find('list',['keyField' => 'slug','valueField' => 'user_id'])
		                ->select(['user_id'])
		                ->where(['id IN'=>$students->toArray()]);
		              if( $users->count()>0 )
		              {
		                $realUsers = $this->Evaluations->Courses->Users->find('list',['keyField' => 'slug','valueField' => 'email'])
		                  ->select(['email'])
		                  ->where(['id IN'=>$users->toArray()]);
		                $course = $this->Evaluations->Courses->findById($evaluation->course_id)->first();
		                foreach($realUsers as $user)
		                {
		                  //DLince-Email
		                  /**/
		                  $email = new Email();
		                  $email->transport('dlince');
		                  $email->template('evaluationAdd');
		                  $email->emailFormat('html');
		                  $email->viewVars([
		                    'course' => $course->name,
		                    'src' => $filename['name'],
		                    'id' => $course->id,
		                  ]);
		                  $email->from($this->viewVars['dlince_email_from'])
		                    ->bcc($user)
		                    ->subject('SISCAP - Se envió una nueva evaluación');
		                    if( intval($filename['size'])>0 )
              					{
		                    	$email->attachments($path_course.DS.$evaluation->id.DS.$filename['name']);
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
              //return $this->redirect(['action' => 'index']);
              return $this->redirect(['controller'=>'Questions','action' => 'add',$evaluation->course_id,$evaluation->id]);
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
        
        $courses = $this->Evaluations->Courses->find('list')
        ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
        ->order(['name' => 'ASC']);
        $this->set(compact('evaluation', 'courses'));
        $this->set('_serialize', ['evaluation']);
    }

    /**
     * getCourseDates method
     *
     */
    public function getCourseDates($course_id = null){
      $this->viewBuilder()->setLayout('ajax');
      $this->autoRender = false;
      $fechas = array();
      $query = $this->Evaluations->Courses->find('all')
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

    public function download($course=null,$evaluation=null,$filename=null)
    {
      $full_path_filename = $this->viewVars['dlince_folder'].'evaluations'.DS.$course.DS.$evaluation.DS.$filename;
      $full_path_about = $this->viewVars['dlince_folder'].'files'.DS.'dlince_siscap_logo.pdf';
      /**/
      if($course!=null && $evaluation!=null && $filename!=null)
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
     * @param string|null $id Evaluation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $evaluation = $this->Evaluations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $evaluation = $this->Evaluations->patchEntity($evaluation, $this->request->getData());
            if ($this->Evaluations->save($evaluation)) {
                $this->Flash->success(__('The evaluation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The evaluation could not be saved. Please, try again.'));
        }
        $courses = $this->Evaluations->Courses->find('list', ['limit' => 200]);
        $this->set(compact('evaluation', 'courses'));
        $this->set('_serialize', ['evaluation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Evaluation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $evaluation = $this->Evaluations->get($id);
        if ($this->Evaluations->delete($evaluation)) {
            //$this->Flash->success(__('La evaluación a sido eliminada'));
            $folder_evaluation = new Folder($this->viewVars['dlince_folder'].DS.'evaluations'.DS.$evaluation->course_id.DS.$evaluation->id);         
            if ($folder_evaluation->delete()) {
              $this->Flash->success(__('La evaluación a sido eliminada'));
            }
        } else {
            $this->Flash->error(__('The evaluation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //DLince
  	public function isAuthorized($user)
  	{

  		return true;

  	}
}
