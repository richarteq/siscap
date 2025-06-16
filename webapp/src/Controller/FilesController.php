<?php
namespace App\Controller;

use App\Controller\AppController;

//DLince
use Cake\Filesystem\Folder;
use Cake\Mailer\Email;

/**
 * Files Controller
 *
 * @property \App\Model\Table\FilesTable $Files
 *
 * @method \App\Model\Entity\File[] paginate($object = null, array $settings = [])
 */
class FilesController extends AppController
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
            'order' => array('Files.created' => 'desc')
        ];
        $files = $this->paginate($this->Files);

        $this->set(compact('files'));
        $this->set('_serialize', ['files']);
    }

    /**
     * View method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $file = $this->Files->get($id, [
            'contain' => ['Users', 'Courses']
        ]);

        $this->set('file', $file);
        $this->set('_serialize', ['file']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $file = $this->Files->newEntity();
      /* <POST */
      if( $this->request->is('post') ) 
      {
        /* Respaldo del archivo */        
        $attach_file = $this->request->data['src'];
        /* Get the extension of filename */
				$ext = substr(strtolower(strrchr($this->request->data['src']['name'], '.')), 1);
        /* Get the max size filename */
				$max_size_attachment = ($this->viewVars['dlince_max_size_files']>=1048576)?round($this->viewVars['dlince_max_size_files']/1048576,2).' MB':round($this->viewVars['dlince_max_size_files']/1024,2).' KB';
        
        /* Only process if the extension is valid or no file attach */
        if( intval($attach_file['size'])>0 && intval($attach_file['size'])<=$this->viewVars['dlince_max_size_files'] && in_array($ext, $this->viewVars['dlince_type_files']) )
        {
          $this->request->data['created'] = date('Y-m-d H:i:s');
          $this->request->data['modified'] = date('Y-m-d H:i:s');
          $this->request->data['title'] = (strlen(trim($this->request->data['title']))==0)?null:$this->request->data['title'];
          $this->request->data['description'] = (strlen(trim($this->request->data['description']))==0)?null:$this->request->data['description'];
          $this->request->data['user_id'] = intval($this->request->session()->read('Auth.User.id'));
          $this->request->data['src'] = $attach_file['name'];
          $file = $this->Files->patchEntity($file, $this->request->getData());
          if ($this->Files->save($file)) 
          {
            $this->Flash->success(__('El archivo a sido adjuntado al curso'));
            /*  */
            $path_course = $this->viewVars['dlince_folder'].'files'.DS.$file->course_id;
            $folder_course = new Folder($path_course);
            $folder_course->create($file->id);
            /*  */
            if (move_uploaded_file($attach_file['tmp_name'], $path_course.DS.$file->id.DS. $attach_file['name']))
            {
              //  $this->request->data['filename'] = $realFile['name'];
              $this->Flash->success(__('El archivo se ha sido subido al servidor'));
              /* <DLince-Envio de correo a cada participante */
              $students = $this->Files->Courses->Participants->find('list',['keyField' => 'slug','valueField' => 'student_id'])
                ->select(['student_id'])
                ->where( [ 'course_id'=>intval($file->course_id)]);
              if( $students->count()>0)
              {
                $users = $this->Files->Courses->Participants->Students->find('list',['keyField' => 'slug','valueField' => 'user_id'])
                  ->select(['user_id'])
                  ->where(['id IN'=>$students->toArray()]);
                if( $users->count()>0)
                {
                  $realUsers = $this->Files->Courses->Users->find('list',['keyField' => 'slug','valueField' => 'email'])
                    ->select(['email'])
                    ->where(['id IN'=>$users->toArray()]);
                  $course = $this->Files->Courses->findById($file->course_id)->first();
                  /* <DLince-Email - Enviar archivo a participantes */
                  if( $this->viewVars['dlince_email'] && $this->viewVars['dlince_email_participantsComunicate'] )
                  {
                    foreach($realUsers as $user)
                    {
                      $email = new Email();
                      $email->transport('dlince');
                      $email->template('fileAdd');
                      $email->emailFormat('html');
                      $email->viewVars([
                        'course' => $course->name,
                        'src' => $attach_file['name'],
                        'id' => $course->id,
                      ]);
                      $email->from($this->viewVars['dlince_email_from'])
                        ->bcc($user)
                        ->subject('SISCAP - Se envió un nuevo archivo')
                        ->attachments($path_course.DS.$file->id.DS.$attach_file['name'])
                        ->send();
                    }
                  } /* DLince-Email> */
                }
              }
              /* DLince-Envio de correo a cada participante> */
            }
            /*  */            
            return $this->redirect(['action' => 'index']);
          }
          else
          {
            $this->Flash->error(__('No se pudo adjuntar el archivo. Intente de nuevo'));
          }
        }
        else
        {
          $this->Flash->error(__('El archivo enviado debe tener como máximo '.$max_size_attachment.' y solo se permiten los formatos '.implode(', ',$this->viewVars['dlince_type_files'])));
        }

      }/* POST> */

      $courses = $this->Files->Courses->find('list')
        ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
        ->order(['name' => 'ASC']);
      $this->set(compact('file', 'courses'));
      $this->set('_serialize', ['file']);
    }

    public function download($course=null,$file=null,$filename=null)
    {
      $full_path_filename = $this->viewVars['dlince_folder'].'files'.DS.$course.DS.$file.DS.$filename;
      $full_path_about = $this->viewVars['dlince_folder'].'files'.DS.'dlince_siscap_logo.pdf';
      /**/
      if($course!=null && $file!=null && $filename!=null)
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
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $file = $this->Files->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

          $this->request->data['modified'] = date('Y-m-d H:i:s');
          $this->request->data['title'] = (strlen(trim($this->request->data['title']))==0)?null:$this->request->data['title'];
          $this->request->data['description'] = (strlen(trim($this->request->data['description']))==0)?null:$this->request->data['description'];
          $this->request->data['user_id'] = intval($this->request->session()->read('Auth.User.id'));
          $file = $this->Files->patchEntity($file, $this->request->getData());
            if ($this->Files->save($file)) {
                $this->Flash->success(__('El archivo ha sido editado satisfactoriamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No de puedo editar el archivo. Intente de nuevo.'));
        }

        $courses = $this->Files->Courses->find('list', ['limit' => 200]);
        $this->set(compact('file', 'courses'));
        $this->set('_serialize', ['file']);
    }

    /**
     * Delete method
     *
     * @param string|null $id File id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $file = $this->Files->get($id);
        if ($this->Files->delete($file)) {
            //$this->Flash->success(__('El archivo ha sido eliminado'));
            $folder_file = new Folder($this->viewVars['dlince_folder'].DS.'files'.DS.$file->course_id.DS.$file->id);         
            if ($folder_file->delete()) {
              $this->Flash->success(__('El archivo ha sido eliminado'));
            }
        } else {
            $this->Flash->error(__('No se pudo eliminar el archivo. Intente de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //DLince
  	public function isAuthorized($user)
  	{

  		return true;

  	}
}
