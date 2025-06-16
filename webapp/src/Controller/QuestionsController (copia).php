<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Questions Controller
 *
 * @property \App\Model\Table\QuestionsTable $Questions
 *
 * @method \App\Model\Entity\Question[] paginate($object = null, array $settings = [])
 */
class QuestionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Evaluations']
        ];
        $questions = $this->paginate($this->Questions);

        $this->set(compact('questions'));
        $this->set('_serialize', ['questions']);
    }

    /**
     * View method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $question = $this->Questions->get($id, [
            'contain' => ['Evaluations', 'Answers', 'Options', 'Responses']
        ]);

        $this->set('question', $question);
        $this->set('_serialize', ['question']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $question = $this->Questions->newEntity();
        if ($this->request->is('post')) 
        {
            /**/
            $questionData = array(
                'evaluation_id' => $this->request->data['evaluation_id'],
                'title' => $this->request->data['title'],
                'description' => (strlen(trim($this->request->data['description']))==0)?null:$this->request->data['description'],
                'state' => 1,
                'user_id' => intval($this->request->session()->read('Auth.User.id')),
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            );
            /**/
            $question = $this->Questions->patchEntity($question, $questionData);
            if ($this->Questions->save($question)) 
            {
                $optionOrder = 1;
                foreach($this->request->data['options'] as $option)
                { 
                    /**/
                    $optionData = array(
                        'question_id' => $question->id,
                        'choise' => $option,
                        'correct' => (isset($this->request->data['values']))?array_search($optionOrder, $this->request->data['values'])?1:0:0,
                        'state' => 1,
                        'user_id' => intval($this->request->session()->read('Auth.User.id')),
                        'created' => date('Y-m-d H:i:s'),
                        'modified' => date('Y-m-d H:i:s'),
                    );
                    $optionOrder++;
                    /**/
                    $option = $this->Questions->Options->newEntity();
                    $option = $this->Questions->Options->patchEntity($option, $optionData);
                    if ($this->Questions->Options->save($option)) 
                    {}
                }
            }
            //$this->Flash->error(__('La pregunta no ha podido ser grabada, intente otra vez'));
            /**/
        }
        $courses = $this->Questions->Evaluations->Courses->find('list')
          ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
          ->order(['name' => 'ASC']);
        /**/
        $this->set(compact('question', 'courses'));
        $this->set('_serialize', ['question']);
        
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add2()
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        /**/
        if ($this->request->is('post')) 
        {
            /**/
            $questionData = array(
                'evaluation_id' => $this->request->data['evaluation_id'],
                'title' => $this->request->data['title'],
                'description' => (strlen(trim($this->request->data['description']))==0)?null:$this->request->data['description'],
                'state' => 1,
                'user_id' => intval($this->request->session()->read('Auth.User.id')),
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            );
            /**/
            //$this->Flash->success( implode(",", $this->request->data['options']) );
            //$this->Flash->success( implode(",", $this->request->data['values']) );
            $question = $this->Questions->newEntity();
            $question = $this->Questions->patchEntity($question, $questionData);
            if ($this->Questions->save($question)) 
            {               
                $optionOrder = 1;
                foreach($this->request->data['options'] as $option)
                {           
                    $optionData = array(
                        'question_id' => $question->id,
                        'choise' => $option,
                        'correct' => isset($this->request->data['values'])?((in_array($optionOrder, $this->request->data['values']))?1:0):0,
                        'state' => 1,
                        'user_id' => intval($this->request->session()->read('Auth.User.id')),
                        'created' => date('Y-m-d H:i:s'),
                        'modified' => date('Y-m-d H:i:s'),
                    );
                    $optionOrder++;                    
                    $option = $this->Questions->Options->newEntity();
                    $option = $this->Questions->Options->patchEntity($option, $optionData);
                    if ($this->Questions->Options->save($option)) 
                    {}
                }
                
                /**/                
            }
            //$this->Flash->error(__('La pregunta no ha podido ser grabada, intente otra vez'));
            /**/
        }
        /**/
        echo json_encode(array());
    }

    /**
     * getCourseTasks method
     *
     */
    public function getCourseEvaluations($course_id = null){
      $this->viewBuilder()->setLayout('ajax');
      $this->autoRender = false;
      $options = "<option value=\"\">Seleccione una Evaluación</option>";
      $query = $this->Questions->Evaluations->find('all')
        ->select(['id','title'])
        ->where(['course_id'=>intval($course_id),'state'=>1]);
      /**/
      foreach($query as $item)
      {
        $options .= "<option value=\"".$item->id."\">".$item->title."</option>";
      }
      
      echo $options;
    }

    /**
     * getEvaluationQuestionsChoises method
     *
     */
    public function getEvaluationQuestionsChoises($evaluationId = null){
      $this->viewBuilder()->setLayout('ajax');
      $this->autoRender = false;
      
      $evaluation = $this->Questions->Evaluations->findById(intval($evaluationId));
      /**/
      if( $evaluation->count()>0 )
      {
              /**/
            $questions = $this->Questions->find('all')
                ->select(['id','title'])
                ->where(['evaluation_id'=>intval($evaluationId),'state'=>1])
                ->order(['created' => 'desc']);
            if( $questions->count()>0 ){
                $numberQuestion = $questions->count();
                $html = "";
                foreach($questions as $question)
                {
                    $html .= "<p style=\"font-weight:bold; color:#0000CE\">".$numberQuestion.".- ".$question->title."</p>";
                    $numberQuestion--;            
                    $options = $this->Questions->Options->find('all')
                    ->select(['id','choise','correct'])
                    ->where(['question_id'=>intval($question->id),'state'=>1]);
                    $html .= "<ol>";
                    if( $options->count()>0 )
                    {
                        foreach($options as $option)
                        {
                            if( intval($option->correct)){
                                $html .= "<li style=\"color:green\"><input type=\"checkbox\" name=\"".$option->id."\">".$option->choise."</li>";
                            }else{
                                $html .= "<li style=\"color:red\"><input type=\"checkbox\" name=\"".$option->id."\">".$option->choise."</li>";
                            }
                        }
                    }else{
                        $html .= "<li style=\"color:#E994AB\">No se han encontrado opciones</li>";
                    }
                    $html .= "</ol>";
                    
                }
            }else{
                $html = "<p>No se han encontrado preguntas</p>";
            }
        }else{
            $html = "<p>No se han encontrado evaluaciones</p>";
        }
      
        echo $html;
    }

    /**
     * Edit method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $question = $this->Questions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            if ($this->Questions->save($question)) {
                $this->Flash->success(__('The question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The question could not be saved. Please, try again.'));
        }
        $evaluations = $this->Questions->Evaluations->find('list', ['limit' => 200]);
        $this->set(compact('question', 'evaluations'));
        $this->set('_serialize', ['question']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $question = $this->Questions->get($id);
        if ($this->Questions->delete($question)) {
            $this->Flash->success(__('The question has been deleted.'));
        } else {
            $this->Flash->error(__('The question could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //DLince
  	public function isAuthorized($user)
  	{

  		return true;

  	}
}
