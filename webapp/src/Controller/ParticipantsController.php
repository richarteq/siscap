<?php
namespace App\Controller;

use App\Controller\AppController;

//DLince
use Cake\Mailer\Email;

/**
 * Participants Controller
 *
 * @property \App\Model\Table\ParticipantsTable $Participants
 *
 * @method \App\Model\Entity\Participant[] paginate($object = null, array $settings = [])
 */
class ParticipantsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Students'=>['Users'], 'Courses'],
            'order' => array('Participants.created' => 'desc')
        ];
        $participants = $this->paginate($this->Participants);

        $this->set(compact('participants'));
        $this->set('_serialize', ['participants']);
    }

    /**
     * View method
     *
     * @param string|null $id Participant id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $participant = $this->Participants->get($id, [
            'contain' => ['Students'=>['Users'], 'Courses']
        ]);

        $this->set('participant', $participant);
        $this->set('_serialize', ['participant']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $participant = $this->Participants->newEntity();

        if ($this->request->is('post')) {
          $this->request->data['created'] = date('Y-m-d H:i:s');
          $this->request->data['modified'] = date('Y-m-d H:i:s');
          $student = $this->Participants->Students->find()
            ->select(['id'])
            ->where(['user_id'=>intval($this->request->data['student_id'])])->first();
          $search_student = $this->Participants->find('all')
            ->where(['course_id'=>intval($this->request->data['course_id']), 'student_id'=>intval($student->id)]);
          if($search_student->count()==0){

            $this->request->data['student_id'] = $student->id;
            $participant = $this->Participants->patchEntity($participant, $this->request->getData());
            if ($this->Participants->save($participant)) {
                $this->Flash->success(__('El estudiante a sido inscrito en el curso'));

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
                    $course = $this->Participants->Courses->findById($participant->course_id)->first();
                    $student = $this->Participants->Students->findById($participant->student_id)->contain(['Users'])->first();
                    $email->viewVars([
                        'id' => $course->id,
                        'name' => $course->name,
                        'start' => $course->start->format('d \d\e ').__($course->start->format('F')).$course->start->format(' \d\e\l Y'),
                        'finish' => $course->finish->format('d \d\e ').__($course->finish->format('F')).$course->finish->format(' \d\e\l Y'),
                        'type' => $types[$course->type],
                        'quota' => $course->quota,
                    ]);
                    $email->from($this->viewVars['dlince_email_from'])
                        ->to($student->user->email)
                        ->subject('SISCAP - Inscripción en Curso de capacitación')
                        ->send();
                } // DLince-Email>
                /**/

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The instructor could not be saved. Please, try again.'));
          }else{
            $this->Flash->error(__('El estudiante ya esta participando en el curso, no es necesario volver a inscribirlo'));
          }
        }        

        $courses = $this->Participants->Courses->find('list')
          ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
          ->order(['name' => 'ASC']);

        $users = $this->Participants->Students->Users->find('list')
          ->where(['role_id'=>4,'state'=>1])
          ->order(['names' => 'ASC']);
        
        $this->set(compact('participant', 'users', 'courses'));
        $this->set('_serialize', ['participant']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Participant id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $participant = $this->Participants->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $participant = $this->Participants->patchEntity($participant, $this->request->getData());
            if ($this->Participants->save($participant)) {
                $this->Flash->success(__('The participant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The participant could not be saved. Please, try again.'));
        }
        $students = $this->Participants->Students->find('list', ['limit' => 200]);
        $courses = $this->Participants->Courses->find('list', ['limit' => 200]);
        $this->set(compact('participant', 'students', 'courses'));
        $this->set('_serialize', ['participant']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Participant id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $participant = $this->Participants->get($id);
        if ($this->Participants->delete($participant)) {
            $this->Flash->success(__('La participación ha sido eliminada'));
        } else {
            $this->Flash->error(__('The participant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

	//DLince
	public function isAuthorized($user)
	{

		return true;

	}
}
