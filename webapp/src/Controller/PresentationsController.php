<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
use Cake\Datasource\ConnectionManager;

use Cake\View\View;
use Cake\Core\Configure;
use Cake\Routing\Router;

//use Cake\I18n\Date;
//use Cake\I18n\Time;


/**
 * Presentations Controller
 *
 * @property \App\Model\Table\PresentationsTable $Presentations
 *
 * @method \App\Model\Entity\Presentation[] paginate($object = null, array $settings = [])
 */
class PresentationsController extends AppController
{

  public $helpers = array('Html', 'Form');

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
      /**/
      $courses = $this->Presentations->Tasks->Courses->find('list')
        ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
        ->order(['name' => 'ASC']);
      /**/
      $this->set(compact('courses'));
    }

    /**
     * View method
     *
     * @param string|null $id Presentation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $presentation = $this->Presentations->get($id, [
            'contain' => ['Tasks', 'Students']
        ]);

        $this->set('presentation', $presentation);
        $this->set('_serialize', ['presentation']);
    }

    /**
     * Add method
     *
     * Para envíos de un administrador
     */
    public function add()
    {
        $presentation = $this->Presentations->newEntity();        
        if ($this->request->is('post')) 
        {
          /**/
          $searchPresentation = $this->Presentations->find('all')
            ->select(['id'])
            ->where(['task_id'=> intval($this->request->data['task_id']), 'student_id'=>intval($this->request->data['student_id']), 'state'=>1]);
          if ( $searchPresentation->count()==0 ) 
          {
          /**/
            $filename = ($this->request->data['file']==null)?null:$this->request->data['file'];
            $ext = substr(strtolower(strrchr($this->request->data['file']['name'], '.')), 1); //get the extension
            //only process if the extension is valid
            $max_size_attachment = ($this->viewVars['dlince_max_size_files']>=1048576)?round($this->viewVars['dlince_max_size_files']/1048576,2).' MB':round($this->viewVars['dlince_max_size_files']/1024,2).' KB';
            if( intval($filename['size'])>0 && (intval($filename['size'])<=$this->viewVars['dlince_max_size_files'] && in_array($ext, $this->viewVars['dlince_type_files'])) )
            {
                $course_id = intval($this->request->data['course_id']);
                /**/
                $presentationData = array();
                /**/
                $presentationData['task_id'] = intval($this->request->data['task_id']);
                $presentationData['student_id'] = intval($this->request->data['student_id']);
                $presentationData['file'] = (intval($filename['size'])==0)?null:$filename['name'];
                $presentationData['qualification'] = null;
                $presentationData['created'] = date('Y-m-d H:i:s');
                $presentationData['modified'] = null;
                $presentationData['state'] = 1;
                //print_r($presentationData);
                $presentation = $this->Presentations->patchEntity($presentation, $presentationData);
                if( $this->Presentations->save($presentation) ) 
                {
                  $this->Flash->success(__('Se presentó la tarea.'));
                  /*  */
                  $path_presentations = $this->viewVars['dlince_folder'].'tasks'.DS.$course_id.DS.$presentation->task_id.DS.'presentations';
                  /* */
                  $folder_course = new Folder($path_presentations);
                  $folder_course->create($presentation->id);
                  /*  */
                  if( intval($filename['size'])>0 )
                  {
                    if( move_uploaded_file($filename['tmp_name'], $path_presentations.DS.$presentation->id.DS.$filename['name']) )
                    {                
                      $this->Flash->success(__('El archivo ha sido subido al servidor.'));                      
                    }
                  }
                  /**/
                    //return $this->redirect(['action' => 'index']);
                }else{
                  $this->Flash->error(__('No se pudo presentar la tarea, intente otra véz.'));
                }
            }
            else
            {
              $this->Flash->error(__('El archivo enviado debe tener como máximo '.$max_size_attachment.' y solo se permiten los formatos '.implode(', ',$this->viewVars['dlince_type_files'])));
            }
          }else{
            $this->Flash->error(__('No se puede presentar la tarea, porque el estudiante ya registra un envío.'));
          }
        }       /**/
        $courses = $this->Presentations->Tasks->Courses->find('list')
          ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
          ->order(['name' => 'ASC']);
        /**/
        $this->set(compact('presentation', 'courses'));
        $this->set('_serialize', ['presentation']);
    }

    /**
     * Add2 method
     *
     * Para envios de un estudiante
     */
    public function add2()
    {
      $presentation = $this->Presentations->newEntity();        
      if ($this->request->is('post')) {
        /**/
        $searchPresentation = $this->Presentations->find('all')
          ->select(['id'])
          ->where(['task_id'=> intval($this->request->data['task_id']), 'student_id'=>intval($this->request->session()->read('Auth.User.student.id')), 'state'=>1]);
        /**/
        if ( $searchPresentation->count()==0 ) 
        {
          $filename = ($this->request->data['file']==null)?null:$this->request->data['file'];
          $ext = substr(strtolower(strrchr($this->request->data['file']['name'], '.')), 1); //get the extension
          //only process if the extension is valid
          $max_size_attachment = ($this->viewVars['dlince_max_size_files']>=1048576)?round($this->viewVars['dlince_max_size_files']/1048576,2).' MB':round($this->viewVars['dlince_max_size_files']/1024,2).' KB';
          if( intval($filename['size'])>0 && (intval($filename['size'])<=$this->viewVars['dlince_max_size_files'] && in_array($ext, $this->viewVars['dlince_type_files'])) )
          {
            $course_id = intval($this->request->data['course_id']);
            /**/
            $presentationData = array();
            /**/
            $presentationData['task_id'] = intval($this->request->data['task_id']);
            $presentationData['student_id'] = intval($this->request->session()->read('Auth.User.student.id'));
            $presentationData['file'] = (intval($filename['size'])==0)?null:$filename['name'];
            $presentationData['qualification'] = null;
            $presentationData['created'] = date('Y-m-d H:i:s');
            $presentationData['modified'] = null;
            $presentationData['state'] = 1;
            //print_r($presentationData);
            $presentation = $this->Presentations->patchEntity($presentation, $presentationData);
            if( $this->Presentations->save($presentation) ) 
            {
              $this->Flash->success(__('Se presentó la tarea.'));
              /*  */
              $path_presentations = $this->viewVars['dlince_folder'].'tasks'.DS.$course_id.DS.$presentation->task_id.DS.'presentations';
              /* */
              $folder_course = new Folder($path_presentations);
              $folder_course->create($presentation->id);
              /*  */
              if( intval($filename['size'])>0 )
              {
                if( move_uploaded_file($filename['tmp_name'], $path_presentations.DS.$presentation->id.DS.$filename['name']) )
                {                
                  $this->Flash->success(__('El archivo ha sido subido al servidor.'));                      
                }
              }
              /**/
              return $this->redirect(['controller' => 'Courses', 'action' => 'view',$this->request->data['course_id']]);
            }
            $this->Flash->error(__('No se pudo presentar la tarea, intente otra véz.'));
          }
          else
          {
            $this->Flash->error(__('El archivo enviado debe tener como máximo '.$max_size_attachment.' y solo se permiten los formatos '.implode(', ',$this->viewVars['dlince_type_files'])));
          }
          
          }else{
            $this->Flash->error(__('No se puede presentar la tarea, porque el estudiante ya registra un envío.'));
          }
        }
      /**/
      return $this->redirect(['controller' => 'Courses', 'action' => 'view',$this->request->data['course_id']]);
    }

    /**
     * getCourseTasks method
     *
     */
    public function getCourseTasks($course_id = null){
      $this->viewBuilder()->setLayout('ajax');
      $this->autoRender = false;
      $options = "<option value=\"\">Seleccione una Tarea</option>";
      $query = $this->Presentations->Tasks->find('all')
        ->select(['id','title', 'start','finish'])
        ->where(['course_id'=>intval($course_id),'state'=>1]);
      /**/
      foreach($query as $item)
      {
        $options .= "<option value=\"".$item->id."\">".$item->title.' - desde el '.$item->start->format('d/M/Y H:i')." hasta el ".$item->finish->format('d/M/Y H:i')."</option>";
      }
      
      echo $options;
    }

    /**
     * getCourseTasks method
     *
     */
    public function getCourseStudents($course_id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        $options = "<option value=\"\">Seleccione un Estudiante</option>";
        /**/
        $students = $this->Presentations->Students->Participants->find('list',['keyField' => 'slug','valueField' => 'student_id'])
        ->select(['student_id'])
        ->where( ['course_id'=>intval($course_id), 'state'=>1]);        
        /**/
        if( $students->count()>0)
        {

          $connection = ConnectionManager::get('default');
          $query = 'SELECT S.id student_id, U.dni, U.names, U.father_surname, U.mother_surname, U.email FROM students S INNER JOIN users U WHERE S.id IN (SELECT student_id FROM participants WHERE course_id='.$course_id.') AND S.user_id=U.id';
          $results = $connection->execute($query)->fetchAll('assoc');
        
          foreach($results as $item)
          {
            $options .= "<option value=\"".$item['student_id']."\">".$item['dni'].' '.$item['names'].' '.$item['father_surname'].' '.$item['mother_surname'].' '.$item['email']."</option>";
          }             
         
        }
        echo $options;
    }

    /**
     * searchCourse method
     *
     */
    public function getCourseTasks2($course_id = null){
      $this->viewBuilder()->setLayout('ajax');
      $this->autoRender = false;
      $options = "<option value=\"\">:D</option>";     
      
      echo $options;
    }

    /**
     * add3 method
     * Califica los trabajos
     *
     */
    public function add3(){
      $this->viewBuilder()->setLayout('ajax');
      $this->autoRender = false;
      /**/
      $message = array(
        'type' => 'error',
        'text' => 'No se han podido guardar las calificaciones',
      );
      /**/
      $presentations = $this->request->data['presentations'];
      $registros = count($presentations);
      /**/
      if( $registros>0 )
      {
        $qualifications = $this->request->data['qualifications'];
        /**/
        for($i=0;$i<$registros;$i++)
        {
          $presentation = $this->Presentations->get($presentations[$i]);
          /**/
          if ($this->request->is(['patch', 'post', 'put'])) {
            /**/
            $presentationData = array(
              'qualification' => (intval($qualifications[$i])==-1)?null:intval($qualifications[$i]),
              'modified' => date('Y-m-d H:i:s'),
            );
            $presentation = $this->Presentations->patchEntity($presentation, $presentationData);
            /**/
            if ($this->Presentations->save($presentation))
            {
              /**/
              $message = array(
                'type' => 'sucess',
                'text' => 'Se han guardado las calificaciones',
              );
              /**/              
            }
            /**/
          }
          /**/
        }
        /**/
      }
      /**/
      echo json_encode($message);
      /**/
    }

    /**
     * getPresentations method
     *
     */
    public function getPresentations($task_id = null)
    {
      /**/
      $this->viewBuilder()->setLayout('ajax');
      $this->autoRender = false;
      $html = "<p>No se han encontrado envíos</p>";
      /**/
      $presentations = $this->Presentations->find('all')
      ->where( ['Presentations.task_id'=>intval($task_id), 'Presentations.state'=>1])
      ->contain(['Tasks','Students'=>'Users']);        
      /**/
      if( $presentations->count()>0 )
      {
        /**/
        $view = new View();
        $myHtml = $view->loadHelper('Html');
        $myForm = $view->loadHelper('Form');
        /**/
        ?>
        <script>
          $(document).ready(function() 
          {
            //alert("ya");
            /**/
            $( "#button-save-qualifications2" ).click(function()
            {
              //alert("hola3");
              /* 
               * arreglos
               */
              /**/
              var presentations = [];
              $('input[name="presentations_id[]"]').each(function() {
                presentations.push(this.value);
              });
              /**/
              var tasks = [];
              $('input[name="tasks_id[]"]').each(function() {
                tasks.push(this.value);
              });
              /**/
              var students = [];
              $('input[name="students_id[]"]').each(function() {
                students.push(this.value);
              });
              /**/
              var qualifications = [];
              $('input[name="qualifications[]"]').each(function() {
                if(this.value==""){
                  qualifications.push(-1);
                }else{
                  qualifications.push(this.value);
                }
              });
              /**/
              //alert(presentations.toString());
              //alert(tasks.toString());
              //alert(students.toString());
              //alert(qualifications.toString());
              $.ajax({
                type:'POST',
                dataType: 'json',
                url: '<?php echo Router::url(array('controller'=>'Presentations','action'=>'add3'));?>',      
                data: {presentations: presentations,tasks:tasks,students:students,qualifications:qualifications},
                success: function(respuesta){
                  //alert(options.toString());
                  //alert(values.toString());
                  //loadEvaluation(evaluation_id);
                  /*
                  $("input[name='options[]']").val('');
                  $("input[type=checkbox][name='values[]']").attr('checked', false);
                  $("textarea[name='description']").val('');
                  $("input[name='title']").val('');
                  $("#title").focus();
                  */
                  /**/
                  message = "<div class=\"message "+respuesta['type']+"\" onclick=\"this.classList.add('hidden')\">"+respuesta['text']+"</div>";
                  /**/
                  //alert(respuesta['text']);
                  $('#dlince_messages').html(message);
                  /**/
                },
                error: function(xhr, desc, err){
                  console.log(err);
                }
              });
              /**/
            });
            /**/
          });
        </script>
        <?php
        $html = $myForm->create();
        $html .= "<table cellpadding=\"0\" cellspacing=\"0\">";
        $html .= "<thead>";
        $html .= "<tr>";                
        $html .= "<th scope=\"col\">Tarea</th>";
        $html .= "<th scope=\"col\">Estudiante</th>";
        $html .= "<th scope=\"col\">Archivo</th>";
        $html .= "<th scope=\"col\">Calificación</th>";
        $html .= "<th scope=\"col\">Enviado</th>";
        $html .= "<th scope=\"col\">¿Activo?</th>";                
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody style=\"border:black 1px solid;\">";
        /* <ForEach */        
        foreach ($presentations as $presentation)
        {
          $html .= "<tr>";                
          $html .= "<td style=\"border:black 1px solid;\">".$presentation->task->title."</td>";
          $html .= "<td style=\"border:black 1px solid;\">";
          
          $html .= $myHtml->link(
            $presentation->student->user->full_name,
            ['controller'=>'Users', 'action' => 'view', $presentation->student->user->id],
            ['escape' => false, 'title'=>'Ver usuario']
          );  
          $html .= "</td>";                
          $html .= "<td style=\"border-left:black 1px solid;\">";              
          $icon = 'DLince.icon.download';
          /* <Switch */
          switch( substr($presentation->file, strrpos($presentation->file, ".")+1) )
          {
            case 'pdf':
              $icon = 'DLince.icon.pdf'; break;
            case 'txt':
              $icon = 'DLince.icon.txt'; break;
            case 'rar':
              $icon = 'DLince.icon.rar'; break;
            case '7zip':
              $icon = 'DLince.icon.7zip'; break;
            case 'zip':
              $icon = 'DLince.icon.zip'; break;
            case 'jpeg':
              $icon = 'DLince.icon.jpeg'; break;
            case 'jpg':
              $icon = 'DLince.icon.jpg'; break;
            case 'gif':
              $icon = 'DLince.icon.gif'; break;
            case 'png':
              $icon = 'DLince.icon.png'; break;
            case 'pptx':
              $icon = 'DLince.icon.powerpoint'; break;
            case 'xlsx':
              $icon = 'DLince.icon.excel'; break;
            case 'docx':
              $icon = 'DLince.icon.word'; break;
            case 'doc':
              $icon = 'DLince.icon.word'; break;
            case 'odp':
              $icon = 'DLince.icon.impress'; break;
            case 'odc':
              $icon = 'DLince.icon.calc'; break;
            case 'odt':
              $icon = 'DLince.icon.writer'; break;
            default:
              $icon = 'DLince.icon.download';
          }
          /* Switch>*/
          $html .= $myHtml->link(
            $myHtml->image(Configure::read($icon), ["alt" => __('View')]),
            ['controller'=>'Presentations','action' => 'download', $presentation->task->course_id,$presentation->task->id, $presentation->id, $presentation->file],
            ['escape' => false,'target'=>'_blank', 'title'=>$presentation->file]
          );
          $html .= "</td>";               
          $html .= "<td style=\"border:black 1px solid;\">";
          $html .= $myForm->hidden('presentations_id[]',['value'=>$presentation->id]);
          $html .= $myForm->hidden('tasks_id[]',['value'=>$presentation->task_id]);
          $html .= $myForm->hidden('students_id[]',['value'=>$presentation->student_id]);
          $html .= $myForm->control('qualifications[]', 
            ['label'=>false,'value'=>$presentation->qualification,'style'=>'width:40px; margin:0px; padding:0px;text-align:center;', 'maxlength'=>'2','pattern'=>'[0-9]{2}', 'templates' => ['inputContainer' => '{{content}}']]
          );
          $html .= "</td>";
          $html .= "<td style=\"border:black 1px solid;\">".$presentation->created."</td>";
          $html .= "<td style=\"border:black 1px solid;\">"; 
          /* <If */             
          if(intval($presentation->state)==1){
              $html .= $myHtml->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
          }else{
              $html .= $myHtml->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
          }
          /* If> */
          $html .= "</td>";
          $html .= "</tr>";
        }
        /* EndForEach> */
        $html .= "</tbody>";
        $html .= "</table>";
        $html .= $myForm->button(
          $myHtml->image(Configure::read('DLince.icon.loading')).'<span>Guardar calificaciones</span>',
          ['class'=>'button', 'id'=>'button-save-qualifications2', 'type'=>'button','escape' => false]
        );
        $html .= $myForm->end();
      }
      /* EndIf> */
      echo $html;
      /**/
    }

    public function download($course=null,$task=null,$presentation=null,$filename=null)
    {
      $full_path_filename = $this->viewVars['dlince_folder'].'tasks'.DS.$course.DS.$task.DS.'presentations'.DS.$presentation.DS.$filename;
      $full_path_about = $this->viewVars['dlince_folder'].'files'.DS.'dlince_siscap_logo.pdf';
      /**/
      if($course!=null && $task!=null && $presentation!=null && $filename!=null)
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
     * @param string|null $id Presentation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $presentation = $this->Presentations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $presentation = $this->Presentations->patchEntity($presentation, $this->request->getData());
            if ($this->Presentations->save($presentation)) {
                $this->Flash->success(__('The presentation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The presentation could not be saved. Please, try again.'));
        }
        $tasks = $this->Presentations->Tasks->find('list', ['limit' => 200]);
        $students = $this->Presentations->Students->find('list', ['limit' => 200]);
        $this->set(compact('presentation', 'tasks', 'students'));
        $this->set('_serialize', ['presentation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Presentation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $presentation = $this->Presentations->get($id);
        if ($this->Presentations->delete($presentation)) {
            $this->Flash->success(__('The presentation has been deleted.'));
        } else {
            $this->Flash->error(__('The presentation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

     //DLince
    public function isAuthorized($user)
    {

        return true;

    }
    
}
