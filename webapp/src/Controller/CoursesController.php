<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

//DLince
use Cake\Mailer\Email;
use Cake\Filesystem\Folder;
//use Cake\I18n\Number;

/**
 * Courses Controller
 *
 * @property \App\Model\Table\CoursesTable $Courses
 *
 * @method \App\Model\Entity\Course[] paginate($object = null, array $settings = [])
 */
class CoursesController extends AppController
{

	//DLince-Function
	public function initialize()
	{
		parent::initialize();

		/**/
		//$this->loadComponent('RequestHandler', [
    		//	'enableBeforeRedirect' => false
		//]);
		/**/

		$this->Auth->allow(['index','view','register','downloadBanner']); // Operaciones permitidas
	}

	//DLince-Function
	public function mine()
	{
		
	}

	public function participants($id = null)
	{
		/**/
		$students = $this->Courses->Participants->find('list',['keyField' => 'slug','valueField' => 'student_id'])
			->select(['student_id'])
			->where( [ 'course_id'=>intval($id)]);
		if( $students->count()>0)
		{
			$users = $this->Courses->Participants->Students->find('list',['keyField' => 'slug','valueField' => 'user_id'])
				->select(['user_id'])
				->where(['id IN'=>$students->toArray()]);
			if( $users->count()>0)
			{
				$realUsers = $this->Courses->Users->find('list',['keyField' => 'slug','valueField' => 'email'])
					->select(['email'])
					->where(['id IN'=>$users->toArray()]);
				$course = $this->Courses->findById($id)->first();
				/**/
				//<DLince-Email - Enviar archivo a participantes
				if( $this->viewVars['dlince_email'] && $this->viewVars['dlince_email_participantsComunicate'] )
				{
					foreach($realUsers as $user)
					{ //<Para cada participante
						$email = new Email();
						$email->transport('dlince');
						$email->template('fileAdd');
						$email->emailFormat('html');
						$email->viewVars([
							'course' => $course->name,
							'src' => 'DLince_SisCap_Logo.pdf',
						]);
						$email->from($this->viewVars['dlince_email_from'])
							->bcc($user)
							->subject('SISCAP - Se envió un archivo de prueba')
							->attachments($this->viewVars['dlince_folder'].'files'.DS.'DLince_SisCap_Logo.pdf');
						/**/
						if( $email->send() ){
							$this->Flash->success(__('Se han enviado correos electrónicos.'));
						}else{
							$this->Flash->error(__('No se han enviado correos electrónicos.'));
						}
   					/**/
					} //Para cada participante>
				} //DLince-Email>
			}
		}
	}

  /**
   * Index method
   *
   * @return \Cake\Http\Response|void
   */
  public function index()
  {
    $this->paginate = [
      'contain' => ['States', 'Users'],
			'order' => array('created' => 'desc')
    ];
    $courses = $this->paginate($this->Courses);

    
    /*
    $users = $this->Courses->Users->find('all');
    
    $teachers = $this->Courses->Users->Teachers->find('all');
    */
    $this->set(compact('courses'/*,'users','teachers'*/));
    
    $this->set('_serialize', ['courses']);
  }

  /**
   * View method
   *
   * @param string|null $id Course id.
   * @return \Cake\Http\Response|void
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function view($id = null)
  {
  	/**/
    $course = $this->Courses->get($id, [
      'contain' => ['States', 'Users', 'Schedules',
				'Files'=>[
					'conditions' => ['Files.state' => 1],
					'sort' => ['Files.created' => 'DESC']
				],
				'Instructors', 'Participants', 'Polls',
				'Videos'=> [
					'conditions' => ['Videos.state' => 1],
      		'sort' => ['Videos.created' => 'DESC']
				],
				'Evaluations'=> [
					'Questions'=>[
						'Answers'=>[
							'conditions' => [
								'Answers.state' => 1,
								'Answers.student_id' => $this->request->session()->read('Auth.User.student.id'),
							],
							'sort' => [
								'Answers.created' => 'DESC'
							]
						],
						'conditions' => [
							'Questions.state' => 1,
						],
						'sort' => [
							'Questions.created' => 'DESC'
						]
					],
					'conditions' => ['Evaluations.state' => 1,'Evaluations.closed' => 1],
      		'sort' => ['Evaluations.created' => 'DESC'],
				],
				'Tasks'=> [
					'Presentations'=>[
						'conditions' => [
							'Presentations.state' => 1,
							'Presentations.student_id' => $this->request->session()->read('Auth.User.student.id'),
						],
						'sort' => [
							'Presentations.created' => 'DESC'
						]
					],
					'conditions' => ['Tasks.state' => 1],
      		'sort' => ['Tasks.created' => 'DESC'],
				],
			],			
		]);

    //DLince-Query
    //Cuenta las participaciones de usuario estudiante en un curso determinado. Deberia ser siempre 1.
    $register = $this->Courses->Participants->find()
    	->where([
    		'student_id' => $this->request->session()->read('Auth.User.student.id'),
    		'course_id' => $id
  		])->count();
		$this->set('register', $register);

    $this->set('course', $course);
    $this->set('_serialize', ['course']);
    /**/
  }

  public function downloadBanner($course=null,$banner=null)
  {
    $full_path_filename = $this->viewVars['dlince_folder'].'banners'.DS.$course.DS.$banner;
    $images_banners = array('training01.jpg','training02.jpg','training03.jpg','training04.jpg');
    $select_image = $images_banners[rand(0,3)];
    $full_path_logo = WWW_ROOT.'img'.DS.$select_image;
    /**/
    if($course!=null && $banner!=null)
    {        
      if( file_exists($full_path_filename) )
      {
        $response = $this->response->withFile($full_path_filename);
      }
      else
      {
        $response = $this->response->withFile($full_path_logo);
      }
    }
    else
    {
      $response = $this->response->withFile($full_path_logo);
    }
    return $response;
  }

  /**
   * Add method
   *
   * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
   */
  public function add()
  {
		//$data = $this->request->data;
		$course = $this->Courses->newEntity();
      if ($this->request->is('post')) {
				/*
					$this->request->data['submittedfile']
					// would contain the following array:
					[
					    'name' => 'conference_schedule.pdf',
					    'type' => 'application/pdf',
					    'tmp_name' => 'C:/WINDOWS/TEMP/php1EE.tmp',
					    'error' => 0, // On Windows this can be a string.
					    'size' => 41737,
					];
				*/
				$banner = ($this->request->data['banner']==null)?null:$this->request->data['banner'];
				$ext = substr(strtolower(strrchr($this->request->data['banner']['name'], '.')), 1); //get the extension
				/**/
				$max_size_attachment = ($this->viewVars['dlince_max_size_banners']>=1048576)?round($this->viewVars['dlince_max_size_banners']/1048576,2).' MB':round($this->viewVars['dlince_max_size_banners']/1024,2).' KB';
				//only process if the extension is valid
        if( intval($banner['size'])==0 || (intval($banner['size'])<=$this->viewVars['dlince_max_size_banners'] && in_array($ext, $this->viewVars['dlince_type_banners'])) )
        {
					/**/
	    		$this->request->data['user_id'] = intval($this->request->session()->read('Auth.User.id'));
					$this->request->data['name']=mb_convert_case(trim($this->request->data['name']), MB_CASE_UPPER, 'UTF-8');
					$this->request->data['description'] = (strlen(trim($this->request->data['description']))==0)?null:$this->request->data['description'];
					$this->request->data['place'] = (strlen(trim($this->request->data['place']))==0)?null:$this->request->data['place'];
					$this->request->data['destined'] = (strlen(trim($this->request->data['destined']))==0)?null:$this->request->data['destined'];
					$this->request->data['type'] = intval($this->request->data['type']);

					$this->request->data['banner'] = (intval($banner['size'])==0)?null:$banner['name'];
					/**/
					$course = $this->Courses->patchEntity($course, $this->request->getData());
					if( $this->Courses->save($course) )
					{
						$folder_banners = new Folder($this->viewVars['dlince_folder'].DS.'banners');
						$folder_banners->create($course->id);
						$folder_evaluations = new Folder($this->viewVars['dlince_folder'].DS.'evaluations');
						$folder_evaluations->create($course->id);
						$folder_files = new Folder($this->viewVars['dlince_folder'].DS.'files');
						$folder_files->create($course->id);						
						$folder_tasks = new Folder($this->viewVars['dlince_folder'].DS.'tasks');
						$folder_tasks->create($course->id);
						
						if( intval($banner['size'])>0 )
						{
							if( move_uploaded_file($banner['tmp_name'], $this->viewVars['dlince_folder'].'banners'.DS.$course->id.DS.$banner['name']) )
		          {
								$this->Flash->success(__('La pancarta a sido subida al servidor.'));
							}
						}
						$this->Flash->success(__('El curso ha sido agregado satisfactoriamente.'));
						/* Creando el horario para el curso */
						$onSchedules = array();
						if( isset($this->request->data['schedule']) )
						{
							for( $i=0;$i<count($this->request->data['schedule']);$i++ )
							{
								if( intval($this->request->data['schedule'][$i]) != false ){
									$data = explode(",", strval($this->request->data['schedule'][$i]));
									$schedule = array(
										'course_id' => intval($course->id),
										'hour' => floatval($data[0]),
										'day' => intval($data[1]),
									);
									array_push($onSchedules, $schedule);
								}
							}
						}
						if( count($onSchedules)>=1 )
						{
							$schedules = $this->Courses->Schedules->newEntities($onSchedules);
							$schedules = $this->Courses->Schedules->patchEntities($schedules, $onSchedules);
							if ($this->Courses->Schedules->saveMany($schedules))
							{
								$this->Flash->success(__('El horario ha sido asignado satisfactoriamente.'));
							}
						}
						/**/
						//Buscando estudiantes y enviando emails acerca del nuevo curso
						/**/
						if( $this->viewVars['dlince_email'] && $this->viewVars['dlince_email_courseAdd'] )
						{
							$email_students = $this->Courses->Users->find('')
								->select(['email'])
								->where(['role_id'=>4, 'state'=>1]);
								//DLince-Email
								//Enviar email de Bienvenida a usuario
								//print_r($email_students->toArray());
								$emails = array();
								foreach($email_students as $item){
									array_push($emails, $item->email);
								}
								if( count($emails)>0 )
								{
									$types = array(1=>'Presencial',2=>'Virtual',3=>'Presencial y Virtual');
									$email = new Email();
									$email->transport('dlince');
									$email->template('courseAdd');
									$email->emailFormat('html');
									$email->viewVars([
										'id' => $course->id,
										'name' => $course->name,
										'place' => $course->place,
										'destined' => $course->destined,
										'type' => $types[$course->type],
										'quota' => $course->quota,
										'start' => $course->start->format('d \d\e ').__($course->start->format('F')).$course->start->format(' \d\e\l Y'),
										'finish' => $course->finish->format('d \d\e ').__($course->finish->format('F')).$course->finish->format(' \d\e\l Y'),						
									]);
									$email->from($this->viewVars['dlince_email_from'])
										->bcc($emails)
										->subject('SISCAP - Curso nuevo disponible');
									/**/
									if( $email->send() ){
										$this->Flash->success(__('Se han enviado correos electrónicos.'));
									}else{
										$this->Flash->error(__('No se han enviado correos electrónicos.'));
									}
			   					/**/
								}
							}
							/**/
            	return $this->redirect(['action' => 'index']);
          }
          $this->Flash->error(__('El curso no ha podido ser agregado. Intente de nuevo.'));
				}else{
					$this->Flash->error(__('La pancarta enviada debe tener como máximo '.$max_size_attachment.' y solo se permiten los formatos '.implode(', ',$this->viewVars['dlince_type_banners'])));
				}
      }
      $states = $this->Courses->States->find('list', ['limit' => 200]);
      $this->set(compact('course', 'states'));
      $this->set('_serialize', ['course']);
  }

	public function showSchedule($type=null)
	{
		$this->viewBuilder()->setLayout('ajax');
		$this->autoRender = false;
		//$this->render(false);
		//$type = $_GET['q'];
		switch( intval($type) )
		{
			case 1:
				echo $this->_printSchedule(); break;
			case 2:
				echo "<p>La modalidad virtual no necesita horario.</p>"; break;
			case 3:
				echo $this->_printSchedule(); break;
			default:
				echo ""; break;
		}
		return null;
	}

	public function _printSchedule()
	{
		/**/
		$html = "";
		$html .=  "<label>Horario</label>";
		$hour= array(
			'es'=>'Hora',
		);
		$days = array(
			'es'=>array(
				'Hora',
				'Lunes',
				'Martes',
				'Miércoles',
				'Jueves',
				'Viernes',
				'Sábado',
				'Domingo'
			)
		);
		$start_time = 7; // start hours
		$lenght_time = 60; // minutes
		$top_time = 20; // finish hour
		$step_time = round(($lenght_time/60),2);
		//$step_time = (($lenght_time/60)<1)?$lenght_time:$lenght_time/60; // pass hour
		$languaje = 'es'; // default language
		$html .= "<table class='schedule'>";
		$k=-1;
		for( $i=$start_time-$step_time;$i<$top_time;$i=$i+$step_time )
		{
			$html .= "<tr>";
			foreach( $days[$languaje] as $index=>$day )
			{
				if( ($days[$languaje][0]==$hour[$languaje]) && $i==($start_time-$step_time) && $index==0 && $day==$days[$languaje][0] ) // Hour cell in default language
				{
					$html .= "<th>".$day."</th>"; //Only one
				}
				elseif( ($days[$languaje][0]==$hour[$languaje]) && $index==0 && $day==$days[$languaje][0] ) //hour:start-time - +step_time
				{
					$html .= "<td class='step-time'>".$this->_strFormatHours($i).' - '.$this->_strFormatHours(($i+$step_time))."</td>";
					//echo self::strFormatHours($i).' - '.self::strFormatHours($i+$step_time);
				}
				elseif( $i==($start_time-$step_time) ) // days of the week
				{
					switch($day){
						case 'Sábado':
							$html .= "<th style=\"color:green\">".$day."</th>"; break;
						case 'Domingo':
							$html .= "<th style=\"color:red\">".$day."</th>"; break;
						default:
							$html .= "<th style=\"color:blue\">".$day."</th>"; break;
					}
				}
				else // alls the others cells
				{
					$k++;
					$html .= "<td class='hourDay'>";
					$html .= "<input type='hidden' name='schedule[".$k."]' value='0'/>";
					$html .= "<input type='checkbox' name='schedule[".$k."]' value='".round(floatval($i), 2).','.strval($index)."' id='schedule-".$k."'>";
					$html .= "</td>";
				}
			}
			$html .= "</tr>";
		}
		$html .= "</table>";

		return $html;
		/**/
	}


	public static function _strFormatHours($hoursOnly){

		$hours = floor($hoursOnly);
		$minutes = round(($hoursOnly - $hours)*60,0);
		return str_pad($hours, 2, "0", STR_PAD_LEFT).':'.str_pad($minutes, 2, "0", STR_PAD_LEFT);

		//return strval($hoursOnly);
	}


	/**
   * Edit method
   *
   * @param string|null $id Course id.
   * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
  public function edit($id = null)
  {
      $course = $this->Courses->get($id, [
          'contain' => ['Schedules']
      ]);
      if ($this->request->is(['patch', 'post', 'put'])) {
				//
				$banner = ($this->request->data['banner']==null)?null:$this->request->data['banner'];
				$ext = substr(strtolower(strrchr($this->request->data['banner']['name'], '.')), 1); //get the extension
				$arr_ext = array('jpg','jpeg','gif','png'); //set allowed extensions
				//only process if the extension is valid
        if( floatval($banner['size'])==0 || (intval($banner['size'])<=150000 && in_array($ext, $arr_ext)) )
        {
					/**/
	    		$this->request->data['user_id'] = intval($this->request->session()->read('Auth.User.id'));
					$this->request->data['name']=mb_convert_case(trim($this->request->data['name']), MB_CASE_UPPER, 'UTF-8');
					$this->request->data['description'] = (strlen(trim($this->request->data['description']))==0)?null:$this->request->data['description'];
					$this->request->data['place'] = (strlen(trim($this->request->data['place']))==0)?null:$this->request->data['place'];
					$this->request->data['destined'] = (strlen(trim($this->request->data['destined']))==0)?null:$this->request->data['destined'];
					$this->request->data['type'] = intval($this->request->data['type']);

					$this->request->data['banner'] = (floatval($banner['size'])==0)?$course->banner:$banner['name'];
					/**/
	          $course = $this->Courses->patchEntity($course, $this->request->getData());
	          if ($this->Courses->save($course)) {
							if( floatval($banner['size'])>0 )
							{
								if( move_uploaded_file($banner['tmp_name'], $this->viewVars['dlince_folder'].'banners'.DS.$course->id.DS.$banner['name']) )
								{
									$this->Flash->success(__('La nueva pancarta a sido subida al servidor'));
								}
							}
              $this->Flash->success(__('Se han guardado los cambios.'));

								/* Volviendo a crear el horario para el curso */
								$this->Courses->Schedules->deleteAll(['course_id' => $course->id]);
								$onSchedules = array();
								for( $i=0;$i<count($this->request->data['schedule']);$i++ )
								{
									if( intval($this->request->data['schedule'][$i]) != false ){
										$data = explode(",", strval($this->request->data['schedule'][$i]));
										$schedule = array(
											'course_id' => intval($course->id),
											'hour' => floatval($data[0]),
											'day' => intval($data[1]),
										);
										array_push($onSchedules, $schedule);
									}
								}
								if( count($onSchedules)>=1 )
								{
									$schedules = $this->Courses->Schedules->newEntities($onSchedules);
									$schedules = $this->Courses->Schedules->patchEntities($schedules, $onSchedules);
									if ($this->Courses->Schedules->saveMany($schedules))
									{
										$this->Flash->success(__('El horario ha sido asignado satisfactoriamente'));
									}
								}
								/**/

	              return $this->redirect(['action' => 'index']);
	          }
	          $this->Flash->error(__('Los cambios no pudierón guardarse. Inténte de nuevo.'));
					}else{
						$this->Flash->error(__('La pancarta enviada debe tener como máximo 150 Kb y solo se permiten los formatos jpg, jpeg, gif o png'));
					}
      }
      $states = $this->Courses->States->find('list', ['limit' => 200]);
      $this->set(compact('course', 'states'));
      $this->set('_serialize', ['course']);
  }

  /**
   * Delete method
   *
   * @param string|null $id Course id.
   * @return \Cake\Http\Response|null Redirects to index.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function delete($id = null)
  {
      $this->request->allowMethod(['post', 'delete']);
      $course = $this->Courses->get($id);
      if ($this->Courses->delete($course)) {
          $this->Flash->success(__('El curso ha sido eliminado'));
          $folder_files = new Folder($this->viewVars['dlince_folder'].DS.'files'.DS.$id);					
					if ($folder_files->delete()) {
				    $this->Flash->success(__('Se eliminarón archivos'));
					}
					$folder_tasks = new Folder($this->viewVars['dlince_folder'].DS.'tasks'.DS.$id);					
					if ($folder_tasks->delete()) {
				    $this->Flash->success(__('Se eliminarón tareas'));
					}
					$folder_banners = new Folder($this->viewVars['dlince_folder'].DS.'banners'.DS.$id);          
					if ($folder_banners->delete()) {
				    $this->Flash->success(__('Se eliminarón pancartas'));
					}
      }
      else
      {
        $this->Flash->error(__('El curso no pudo eliminarse, intente otra vez'));
      }

      return $this->redirect(['action' => 'index']);
  }

	/*
	 * DLince-Function
	 * Funcion que hace particiár un usuario estudiante en un curso
	 */
	public function register($id = null)
  {
    /**/
		$participant = $this->Courses->Participants->newEntity();
		$dataParticipant = array();
		if ($this->request->is('post') || $this->request->is('get'))
		{
			if( $this->request->session()->read('Auth.User')!==null && $this->request->session()->read('Auth.User.role.name') === 'student' )
			{

				$existCourse = $this->Courses->find()
					->select(['id'])
					->where(['id'=>$id])->count();
				if( $existCourse !== 0 ){
					$isMyCourse = $this->Courses->Participants->find()
					->select(['course_id'])
					->where([
							'student_id =' => $this->request->session()->read('Auth.User.student.id'),
							'course_id'=>$id
						])->count();

					if( $isMyCourse==0 )
					{
						$dataParticipant = array(
							'student_id' => intval($this->request->session()->read('Auth.User.student.id')),
							'course_id' => intval($id),
							'state' => 1,
							'created' => date('Y-m-d H:i:s'),
							'modified' => date('Y-m-d H:i:s'),
							'user_id' => intval($this->request->session()->read('Auth.User.id'))
						);
						$participant = $this->Courses->Participants->patchEntity($participant, $dataParticipant);
							if ($this->Courses->Participants->save($participant)) {
								$this->Flash->success(__('Bienvenido,ahora ya eres participante de este curso.'));
								
								/**/
								$types = array(1=>'Presencial',2=>'Virtual',3=>'Presencial y Virtual');
								/**/								
								//
								// <DLince-Email - Comunicar a los participantes del curso nuevo
								//
								if( $this->viewVars['dlince_email'] && $this->viewVars['dlince_email_participantAdd'] )
								{
									$email = new Email();
									$email->transport('dlince');
									$email->template('participantAdd');
									$email->emailFormat('html');
									$course = $this->Courses->findById($id)->first();
									$email->viewVars([
										'id' => $course->id,
										'name' => $course->name,
										'start' => $course->start->format('d \d\e ').__($course->start->format('F')).$course->start->format(' \d\e\l Y'),
										'finish' => $course->finish->format('d \d\e ').__($course->finish->format('F')).$course->finish->format(' \d\e\l Y'),
										'type' => $types[$course->type],
										'quota' => $course->quota,
									]);
									$email->from($this->viewVars['dlince_email_from'])
										->to($this->request->session()->read('Auth.User.email'))
										->subject('SISCAP - Inscripción realizada en Curso de capacitación');
									/**/
									if( $email->send() ){
										$this->Flash->success(__('Se ha enviado un correo electrónico.'));
									}else{
										$this->Flash->error(__('No se ha enviado el correo electrónico.'));
									}
			   					/**/
								} // DLince-Email>
								/**/
								
								return $this->redirect(['controller' => 'Courses', 'action' => 'view',$id]);
							}else{
								$this->Flash->error(__('The participant could not be saved. Please, try again.'));

							}
					}else{
						$this->Flash->success(__('Usted, es un estudiante SISCAP registrado, y ya es participante de este curso.'));
						return $this->redirect(['controller' => 'Courses', 'action' => 'view',$id]);
					}
				}else{
					$this->Flash->error(__('El curso al cuál quieres registrarte, no existe.'));
					return $this->redirect('/');
				}
			}else{
				$this->Flash->error(__('Usted, no es un estudiante. Solicite ser registrado como estudiante SISCAP.'));
				return $this->redirect('/');
			}
		}
		/**/
  }

	//DLince
	public function isAuthorized($user)
	{
		return true;
	}
}
