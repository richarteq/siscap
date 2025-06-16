<?php
namespace App\Controller;

use App\Controller\AppController;

//DLince
use Cake\Mailer\Email;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

	//DLince
	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['logout']);
		// Add the 'add' action to the allowed actions list.
    	//$this->Auth->allow(['logout', 'add']);

		// load the Captcha component and set its parameter
    $this->loadComponent('CakeCaptcha.Captcha', [
      'captchaConfig' => 'ExampleCaptcha'
    ]);
	}

	//DLince-ActionController - Iniciar sesion
	public function login()
	{
		if ($this->request->is('post')) {
			// validate the user-entered Captcha code
		  $isHuman = captcha_validate($this->request->data['CaptchaCode']);
		  // clear previous user input, since each Captcha code can only be validated once
		  unset($this->request->data['CaptchaCode']);
		  if ($isHuman) 
		  {
		    $user = $this->Auth->identify();
		    if ( $user ) // Verifica las credenciales del usuario
				{
					if ( $user['state'] ) // Verifica que el usuario este activo
					{
						//DLince-Query - Buscando el rol del usuario que inicia sesión
						$role = $this->Users->Roles->findById($user['role_id']);
						$user['role'] = $role->toArray()[0];
						//
						//DLince-Query - Actualizar ultimo acceso(login) del usuario
						$this->loadModel('Users');
						$query = $this->Users->query();
						$query->update()
					    ->set(['last_login' => date('Y-m-d H:i:s')])
					    ->where(['id' => $user['id']])
					    ->execute();
						//
						$this->Auth->setUser($user);
		        return $this->redirect($this->Auth->redirectUrl());
					}
					else
					{
						$this->Flash->error('Su cuenta ha sido desabilitada, póngase en contacto con el administrador');
					}
		    }
				else {
					$this->Flash->error('Su correo electrónico y/o su contraseña SISCAP son incorrectos');
				}
			}
			else 
			{
      	// TODO: Captcha validation failed, show error message
      	$this->Flash->error('Verifique e ingrese el nuevo código de seguridad');
  		}
		}
		//
		if( $this->Auth->user('id') !== null){
			$this->Flash->success(__('Para cerrar sesión haga clic en el botón Cerrar sesión'));
		}
		else
		{
			$this->Flash->success(__('Para iniciar sesión ingrese su correo electrónico y su contraseña SISCAP'));
		}
		
	}	

	//DLince-ActionController - Cerrar sesion
	public function logout()
	{
		$this->Flash->success('Ud. acaba de cerrar su sesión, hasta pronto');
		return $this->redirect($this->Auth->logout());
	}

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
      $this->paginate = [
        'contain' => ['Roles'],
        'order' => array('created' => 'desc')
      ];
      $users = $this->paginate($this->Users);

      $this->set(compact('users'));
      $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
      $user = $this->Users->get($id, [
          'contain' => ['Roles', 'Courses', 'Messages', 'Recipients', 'Students', 'Teachers']
      ]);

      $this->set('user', $user);
      $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $user = $this->Users->newEntity();
      if ($this->request->is('post'))
			{
				$this->request->data['dni'] = (strlen(trim($this->request->data['dni']))==0)?null:$this->request->data['dni'];
				$this->request->data['names']=mb_convert_case(trim($this->request->data['names']), MB_CASE_TITLE, 'UTF-8');
				$this->request->data['father_surname']=mb_convert_case(trim($this->request->data['father_surname']), MB_CASE_TITLE, 'UTF-8');
				$this->request->data['mother_surname']=mb_convert_case(trim($this->request->data['mother_surname']), MB_CASE_TITLE, 'UTF-8');
				$this->request->data['changed'] = 0;
				$this->request->data['when_changed'] = null;
				$this->request->data['last_login'] = null;
				$this->request->data['firm'] = (strlen(trim($this->request->data['firm']))==0)?null:$this->request->data['firm'];
				$this->request->data['created'] = date('Y-m-d H:i:s');
				$this->request->data['modified'] = date('Y-m-d H:i:s');
	      $user = $this->Users->patchEntity($user, $this->request->getData());
				/**/
        if ($this->Users->save($user))
				{
								$rol = '';
								switch(intval($this->request->data['role_id'])){
									case 1:
										$this->Flash->success(__('Un nuevo administrador a sido agregado satisfactoriamente'));
										$rol = 'Administrador';
									break;
									case 3:
										$teacher = $this->Users->Teachers->newEntity();
										$dataTeacher = array(
											'resume' => null,
											'web_page' => null,
											'creator' => intval($this->request->session()->read('Auth.User.id')),
											'state' => 1,
											'user_id' => $user->id,
											'created' => date('Y-m-d H:i:s'),
											'modified' => date('Y-m-d H:i:s')
										);
										$teacher = $this->Users->Teachers->patchEntity($teacher, $dataTeacher);
										if ($this->Users->Teachers->save($teacher)) {
											$this->Flash->success(__('Un nuevo profesor a sido agregado satisfactoriamente'));
											$rol = 'Profesor';
										}
									break;
									case 4:
										$student = $this->Users->Students->newEntity();
										$dataStudent = array(
											'creator' => intval($this->request->session()->read('Auth.User.id')),
											'state' => 1,
											'user_id' => $user->id,
											'created' => date('Y-m-d H:i:s'),
											'modified' => date('Y-m-d H:i:s')
										);
										$student = $this->Users->Students->patchEntity($student, $dataStudent);
										if ($this->Users->Students->save($student)) {
											$this->Flash->success(__('Un nuevo estudiante a sido agregado satisfactoriamente'));
											$rol = 'Estudiante';
										}
									break;
								}
								//<DLince-Email - Enviar email de Bienvenida a usuario
								if( $this->viewVars['dlince_email'] && $this->viewVars['dlince_email_userAdd'] )
								{
									$email = new Email();
									$email->transport('dlince');
									$email->template('userAdd');
									$email->emailFormat('html');
									$email->viewVars(['full_name'=>$user->full_name, 'rol' => $rol, 'email' => $user->email, 'id'=>$user->id]);
									$email->from($this->viewVars['dlince_email_from'])
								    ->to($this->request->data['email'])
								    ->subject('SISCAP - Bienvenido usuario '.$rol)
								    ->send();
								}//DLince-Email>
								/**/
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El nuevo usuario no pudo ser grabado en el sistema, inténte de nuevo'));
        }
				//$this->Users->Roles->locale('es_PE');
        $roles = $this->Users->Roles->find('list', ['limit' => 200])->where(['state'=>1])->toArray();
				//Traduccion de roles
				foreach($roles as $id=>$name)
				{
					$roles[$id]= ucfirst(__($name));
				}
				//
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
					$this->request->data['dni'] = (strlen(trim($this->request->data['dni']))==0)?null:$this->request->data['dni'];
					if( isset($this->request->data['password']) && strlen(trim($this->request->data['password'])>0 ) ){
						$this->request->data['changed'] = 1;
						$this->request->data['when_changed'] = date('Y-m-d H:i:s');
					}
					$this->request->data['modified'] = date('Y-m-d H:i:s');
					$this->request->data['names']=mb_convert_case(trim($this->request->data['names']), MB_CASE_TITLE, 'UTF-8');
					$this->request->data['father_surname']=mb_convert_case(trim($this->request->data['father_surname']), MB_CASE_TITLE, 'UTF-8');
					$this->request->data['mother_surname']=mb_convert_case(trim($this->request->data['mother_surname']), MB_CASE_TITLE, 'UTF-8');
					$this->request->data['firm'] = (strlen(trim($this->request->data['firm']))==0)?null:$this->request->data['firm'];
          $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Se han guardado los cambios relizados al usuario'));
								//DLince-Email
								//Enviar email de Bienvenida a usuario
								if( $this->viewVars['dlince_email'] && $this->viewVars['dlince_email_userEdit'] )
								{
									$email = new Email();
									$email->transport('dlince');
									$email->template('userEdit');
									$email->emailFormat('html');
									$email->viewVars(['email' => $user->email]);
									$email->from($this->viewVars['dlince_email_from'])
								    ->to($this->request->data['email'])
								    ->subject('SISCAP - Cambios en tu cuenta ')
								    ->send();
								}
								//
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se han podido guardar los cambios, inténtalo de nuevo'));
        }

				$roles = $this->Users->Roles->find('list', ['limit' => 200])->where(['state'=>1])->toArray();
				foreach($roles as $id=>$name)
				{
					$roles[$id]= ucfirst(__($name));
				}
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('El usuario ha sido eliminado'));
        } else {
            $this->Flash->error(__('El usuario pudo ser eliminado, inténtalo de nuevo'));
        }

        return $this->redirect(['action' => 'index']);
    }

	//DLince
	public function isAuthorized($user)
	{

		return true;

	}

}
