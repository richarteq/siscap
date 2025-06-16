<?php
namespace App\Controller;

use App\Controller\AppController;

//DLince
use Cake\Mailer\Email;

/**
 * Instructors Controller
 *
 * @property \App\Model\Table\InstructorsTable $Instructors
 *
 * @method \App\Model\Entity\Instructor[] paginate($object = null, array $settings = [])
 */
class InstructorsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Teachers'=>'Users', 'Courses'],
            'order' => array('Instructors.created' => 'desc')
        ];
        $instructors = $this->paginate($this->Instructors);

        $this->set(compact('instructors'));
        $this->set('_serialize', ['instructors']);
    }

    /**
     * View method
     *
     * @param string|null $id Instructor id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $instructor = $this->Instructors->get($id, [
            'contain' => ['Teachers'=>['Users'], 'Courses']
        ]);

        $this->set('instructor', $instructor);
        $this->set('_serialize', ['instructor']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $instructor = $this->Instructors->newEntity();

        if ($this->request->is('post')) {
          $this->request->data['created'] = date('Y-m-d H:i:s');
          $this->request->data['modified'] = date('Y-m-d H:i:s');
          $teacher = $this->Instructors->Teachers->find()
            ->select(['id'])
            ->where(['user_id'=>intval($this->request->data['teacher_id'])])->first();
          $search_instructor = $this->Instructors->find('all')
            ->where(['course_id'=>intval($this->request->data['course_id']), 'teacher_id'=>intval($teacher->id)]);
          if($search_instructor->count()==0){

            $this->request->data['teacher_id'] = $teacher->id;
            $instructor = $this->Instructors->patchEntity($instructor, $this->request->getData());
            if ($this->Instructors->save($instructor)) {
                $this->Flash->success(__('El instructor ha sido agregado'));

                /**/
                $types = array(1=>'Presencial',2=>'Virtual',3=>'Presencial y Virtual');
                /**/                                
                //
                // <DLince-Email - Comunicar a los participantes del curso nuevo
                //
                if( $this->viewVars['dlince_email'] && $this->viewVars['dlince_email_instructorAdd'] )
                {
                    $email = new Email();
                    $email->transport('dlince');
                    $email->template('instructorAdd');
                    $email->emailFormat('html');
                    $course = $this->Instructors->Courses->findById($instructor->course_id)->first();
                    $teacher = $this->Instructors->Teachers->findById($instructor->teacher_id)->contain(['Users'])->first();
                    $email->viewVars([
                        'id' => $course->id,
                        'name' => $course->name,
                        'start' => $course->start->format('d \d\e ').__($course->start->format('F')).$course->start->format(' \d\e\l Y'),
                        'finish' => $course->finish->format('d \d\e ').__($course->finish->format('F')).$course->finish->format(' \d\e\l Y'),
                        'type' => $types[$course->type],
                        'quota' => $course->quota,
                    ]);
                    $email->from($this->viewVars['dlince_email_from'])
                        ->to($teacher->user->email)
                        ->subject('SISCAP - Asignación para instructor de curso')
                        ->send();
                } // DLince-Email>
                /**/

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The instructor could not be saved. Please, try again.'));
          }else{
            $this->Flash->error(__('El profesor ya es instructor del curso, no es necesario volver a asignar.'));
          }
        }

        $courses = $this->Instructors->Courses->find('list')
          ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
          ->order(['name' => 'ASC']);

        $users = $this->Instructors->Teachers->Users->find('list')
          ->where(['role_id'=>3,'state'=>1])
          ->order(['names' => 'ASC']);



        $this->set(compact('instructor', 'users', 'courses'));
        $this->set('_serialize', ['instructor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Instructor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $instructor = $this->Instructors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

          $this->request->data['modified'] = date('Y-m-d H:i:s');
            $instructor = $this->Instructors->patchEntity($instructor, $this->request->getData());
            if ($this->Instructors->save($instructor)) {
                $this->Flash->success(__('The instructor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The instructor could not be saved. Please, try again.'));
        }
        $courses = $this->Instructors->Courses->find('list')
          ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
          ->order(['name' => 'ASC']);

        $users = $this->Instructors->Teachers->Users->find('list')
          ->where(['role_id'=>3,'state'=>1])
          ->order(['names' => 'ASC']);

        $user_id = $this->Instructors->Teachers->find()
          ->select(['user_id'])
          ->where(['id'=>intval($instructor->teacher_id)])->first()->user_id;

        $this->set(compact('instructor', 'user_id', 'users', 'courses'));
        $this->set('_serialize', ['instructor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Instructor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $instructor = $this->Instructors->get($id);
        if ($this->Instructors->delete($instructor)) {
            $this->Flash->success(__('La instrucción ha sido eliminada'));
        } else {
            $this->Flash->error(__('The instructor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //DLince
  	public function isAuthorized($user)
  	{
  		return true;
  	}
}
