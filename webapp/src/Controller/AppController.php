<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');

		//DLince
		$this->loadComponent('Auth', [
			'authorize'=> 'Controller',//added this line
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => $this->referer() // If unauthorized, return them to page they were just on
        ]);

			//DLince
      // Allow the display action so our pages controller
      // continues to work.
      $this->Auth->allow(['display']);
      //$this->Auth->allow(['display','index','edit']);
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

	//DLince-Function
	public function beforeFilter(Event $event)
  {
    /*
     * Default variables
     */
    $dlinceValues = array(
      'title'       => 'SISCAP - Sistema de Capacitación',
      'description' => 'El Sistema de Capacitación (SISCAP) es una aplicación Web para el soporte de cursos de capacitación.',
      'sitemap'     => 'SISCAP',
      'keywords'    => 'siscap, richartescobedo',
      'url'         => 'http://127.0.0.1:8090/siscap',
      'copyright'   => 'SISCAP - Sistema de capacitación. Realizado por <a href="mailto:richartescoebdo@gmail.com">Richart Escobedo Quispe</a> @ 2017',
    );
		$this->set('dlince_values', $dlinceValues);
    /**/
    $dlinceShow = array(
      'home'  => array(
        'all'           => true,
        'logo'          => true,
        'logo_span'     => true,
        'menu_main'     => true,
        'banner'        => true,
        'information'   => array(
          'all'         => true,
          'date'        => true, //change
          'welcome'     => true,
          'last_login'  => true, //change
        ),
        'user_menu'     => array(
          'all'     => true,
          'items'   => true,
          'logout'  => true, //change
          'timer'   => true, //change
        ),
      ),
      'default'  => array(
        'all'           => true,
        'logo'          => true,
        'logo_span'     => true,
        'menu_main'     => true,
        'banner'        => false,
        'information'   => array(
          'all'         => true,
          'date'        => true, //change
          'welcome'     => true,
          'last_login'  => true, //change
        ),
        'block_videos'   => true, //change
        'foot'   => true, //change
        'user_menu'     => array(
          'all'     => true,
          'items'   => true,
          'logout'  => true, //change
          'timer'   => true, //change
        ),
      ),
    );
    $this->set('dlince_show', $dlinceShow);
    /**/
    /*
     * Flags and others default variables
     */
    $this->loadModel('Settings');
    $setting = $this->Settings->findById(1)->toArray()[0];
    /**/
    $this->set('dlince_email', $setting->sendEmail);
    $this->set('dlince_email_userAdd', $setting->sendEmailUserAdd);
    $this->set('dlince_email_userEdit', $setting->sendEmailUserEdit);
    $this->set('dlince_email_userDisabled', $setting->sendEmailUserDisabled);
    $this->set('dlince_email_courseAdd', $setting->sendEmailCourseAdd);
    $this->set('dlince_email_instructorAdd', $setting->sendEmailInstructorAdd);
    $this->set('dlince_email_participantAdd', $setting->sendEmailParticipantAdd);
    $this->set('dlince_email_participantsComunicate', $setting->sendEmailParticipantsComunicate);
    
    $this->set('dlince_folder', $setting->folder);
    $this->set('dlince_type_files', explode(',',$setting->typeFiles));
    $this->set('dlince_type_banners', explode(',',$setting->typeBanners));
    $this->set('dlince_limits_time', explode(',',$setting->limitsTime));
    $this->set('dlince_max_size_files', $setting->maxSizeFiles );
    $this->set('dlince_max_size_banners', $setting->maxSizeBanners);
    $this->set('dlince_email_from', [ $setting->emailFrom => $setting->nameEmailFrom ]);
    //

  	//DLince-Query
  	//Busca todos los cursos visibles contando el numero de total de participantes para cada curso
  	$this->loadModel('Courses');
  	$search_courses = $this->Courses->find('all')
  	  ->select(['id','name','description','start','finish','quota'])
  	  ->where(['state_id'=>1,'visible'=>1,'finish >= '=>date('Y-m-d')])
        ->order(['start' => 'DESC'])
        ->contain('States');
  	$search_courses->select(['total_participants' => $search_courses->func()->count('Participants.course_id')])
  	  ->leftJoinWith('Participants')
  	  ->group(['Courses.id'])
  	  ->autoFields(true);
  	$this->set('dlince_courses', $search_courses);

  	if( $this->request->session()->read('Auth.User')!==null && $this->request->session()->read('Auth.User.role.name') === 'student' )
  	{
  		//Busca datos del estudiante y los escribe en la SESSION
  		$this->loadModel('Students');
  		$student = $this->Students->findByUserId(intval($this->request->session()->read('Auth.User.id')));
        if($student && $student->count()>0)
        {
          $this->request->session()->write('Auth.User.student', $student->toArray()[0]);
        }
      	//Busca los cursos del estudiante y los escribe en la SESSION
      	$myCourses = $this->Students->Participants->find()
      		->select(['course_id'])
      		->distinct()
      		->where(['student_id =' => $this->request->session()->read('Auth.User.student.id')]);
      	$dlinceCourses = array();
      	foreach($myCourses->toArray() as $item)
      	{
      		array_push($dlinceCourses,$item['course_id']);
      	}
      	$this->request->session()->write('Auth.User.courses', $dlinceCourses);
      	$this->set('dlince_mycourses', $dlinceCourses);

  	}

  	//DLince-Query
  	//Busca todas las frases visibles
  	$this->loadModel('Phrases');
  	$search_phrase = $this->Phrases->find('all',
  		array('conditions'=>array('Phrases.state'=>1),
  			'order' => 'rand()','limit' => 1
  		));
      
      if($search_phrase->count()>0)
      {
  		    $this->set('dlince_phrase', $search_phrase->toArray()[0]);
      }else{
          $this->set('dlince_phrase', null);
      }

	}

  //DLince-Function
	public function isAuthorized($user)
	{
		return false;
		//return true;
	}
}
