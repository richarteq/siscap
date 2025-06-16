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
            'contain' => ['Evaluations', 'Options']
        ]);

        $this->set('question', $question);
        $this->set('_serialize', ['question']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($course_id=null,$evaluation_id=null)
    {
      /**/      
      $courses = $this->Questions->Evaluations->Courses->find('list')
        ->where(['state_id'=>1,'finish >= '=>date('Y-m-d')])
        ->order(['name' => 'ASC']);
      /**/
      $evaluations = array();
      if( $course_id!=null )
      {
        $evaluations = $this->Questions->Evaluations->find('list')
          ->where(['state'=>1,'course_id'=>$course_id])
          ->order(['title' => 'ASC']);
      }
      /**/
      $this->set(compact('courses','course_id','evaluations', 'evaluation_id'));
    }

    /**
     * Add method
     *
     * Agrega preguntas a una evaluación usando AJAX
     * 
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add2()
    {
      $this->viewBuilder()->setLayout('ajax');
      $this->autoRender = false;
      /**/
      $message = array(
        'type' => 'error',
        'text' => 'No se ha podido agregar la pregunta',
      );
      /**/
      if ($this->request->is('post')) 
      {
        /**/
        $questions = $this->Questions->find('all')
          ->select(['id'])
          ->where(['Questions.evaluation_id' => intval($this->request->data['evaluation_id'])])
          ->contain(['Answers']);
        /**/
        $questionsN = count($questions);
        $answersN = 0;
        foreach($questions as $question)
        {
          $answersN = $answersN + count($question->answers);          
        }
        /**/
        
        if( $answersN==0 )
        {
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
          $question = $this->Questions->newEntity();
          $question = $this->Questions->patchEntity($question, $questionData);
          /**/
          if ($this->Questions->save($question)) 
          {
            $optionOrder = 1;
            /**/
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
              {
                $message = array(
                  'type' => 'sucess',
                  'text' => 'Se agrego la pregunta satisfactoriamente',
                );
              }
            }             
            /**/                
          }
          /**/
        }else{
           $message = array(
            'type' => 'error',
            'text' => 'La evaluación ya registra respuestas, no se puede agregar la pregunta',
          );
        }
        /**/        
      }
      /**/
      echo json_encode($message);
      /**/
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
        ->where(['course_id'=>intval($course_id),'state'=>1, 'closed'=>0]);
      /**/
      foreach($query as $item)
      {
        $options .= "<option value=\"".$item->id."\">".$item->title."</option>";
      }
      
      echo $options;
    }

    /**
     * getEvaluationQuestionsChoises method
     * Metodo que consigue la evaluación, preguntas y respuestas para vista rápida.
     *
     */
    public function getEvaluationQuestionsChoises($evaluationId = null)
    {
      $this->viewBuilder()->setLayout('ajax');
      $this->autoRender = false;
      
      $evaluation = $this->Questions->Evaluations->find('all')
        ->where(['Evaluations.id'=>intval($evaluationId)])
        ->contain(['Courses'])
        ->toArray();
      /**/
      //print_r($evaluation);
      /**/
      if( count($evaluation)>0 )
      {
        $html = "";
        /**/        
        $html .= "<h2 class=\"title-evaluation\">".$evaluation[0]['title']."</h2>";
        $html .= "<ul class=\"description-evaluation\">";
        $html .= "<li style=\"margin-bottom:0px;\" ><span class=\"label\">Curso </span>: <span class=\"text\">".$evaluation[0]['course']['name']."</span></li>";
        $html .= "<li style=\"margin-bottom:0px;\" ><span class=\"label\">Duración </span>: <span class=\"text\">".$evaluation[0]['time_limit']." minutos</span></li>";
        $html .= "<li style=\"margin-bottom:0px;\" ><span class=\"label\">A partir del </span>: <span class=\"text\">".$evaluation[0]['start']->format('d \d\e ').strtolower(__($evaluation[0]['start']->format('F'))).$evaluation[0]['start']->format(' \d\e\l Y \d\e\s\d\e \l\a\s H:i:s')."</span></li>";
        $html .= "<li style=\"margin-bottom:0px;\" ><span class=\"label\">Hasta el </span>: <span class=\"text\">".$evaluation[0]['finish']->format('d \d\e ').strtolower(__($evaluation[0]['finish']->format('F'))).$evaluation[0]['finish']->format(' \d\e\l Y \h\a\s\t\a \l\a\s H:i:s')."</span></li>";
        $html .= ($evaluation[0]['description']==null)?"":"<li style=\"margin-bottom:0px;\"><span class=\"label\">Descripción </span>: <span class=\"text\">".$evaluation[0]['description']."</span></li>";
        $html .= "</ul>";
        $html .= "<hr>";
        /**/
        $questions = $this->Questions->find('all')
            ->select(['id','title','description'])
            ->where(['evaluation_id'=>intval($evaluationId),'state'=>1])
            ->order(['created' => 'desc'])
            ;
        if( $questions->count()>0 )
        {
          $numberQuestion = $questions->count();
          
          foreach($questions as $question)
          {
            $html .= "<ul class=\"questions-evaluation\">";
            $html .= "<li class=\"question\"><span style=\"color:#0174DF\">Pregunta ".$numberQuestion." : </span><span style=\"color:#0174DF\">".$question->title."</span></li>";
            $html .= ($question->description==null)?"":"<li class=\"description\"><em>".$question->description."</em></li>";
            $html .= "<li>";
            $numberQuestion--;            
            $options = $this->Questions->Options->find('all')
            ->select(['id','choise','correct'])
            ->where(['question_id'=>intval($question->id),'state'=>1]);
            $html .= "<ul class=\"options-question\">";
            if( $options->count()>0 )
            {
                foreach($options as $option)
                {
                    if( intval($option->correct)){
                        $html .= "<li style=\"color:#088A29\"><input type=\"checkbox\" name=\"".$option->id."\">".$option->choise."<img src=\"/siscap/img/dlince/icons/24/Ok-icon.png\" alt=\" (Correcto)\"></li>";
                    }else{
                        $html .= "<li style=\"color:#DF0101; text-decoration:line-through;\"><input type=\"checkbox\" name=\"".$option->id."\">".$option->choise."</li>";
                    }
                }
            }else{
              $html .= "<li>No se han encontrado opciones</li>";
            }
            $html .= "</ul>";
            $html .= "</ul>";
          }
        }else{
          $html = "<li>No se han encontrado preguntas</li>";
        }
      }else{
        $html = "<p>No se han encontrado evaluaciones</p>";
      }
      
      echo $html;
    }

    /**
     * Add two choises method
     *
     * @description Método que agrega 2 opciones más para la elaboración de preguntas.
     * @param 
     *
     */
    public function addTwoChoises(){
      $this->viewBuilder()->setLayout('ajax');
      $this->autoRender = false;

      $numberO = intval($this->request->data['numberO']);      
      $html = "<tr class=\"tr-added-for-two-choises\">";
      for($i=$numberO+1;$i<=$numberO+2;$i++){
        $html .= "<td><label for=\"opcion".$i."\">Opción ".$i."</label><input type=\"text\" name=\"options[]\" id=\"opcion".$i."\" style=\"width:400px\"></td><td><input type=\"checkbox\" name=\"values[]\" value=\"".$i."\" id=\"correct-".$i."\" class=\"input-choise-checkbox\"></td>";
      }
      $html .= "</tr>";
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
                $this->Flash->success(__('Se han guardado los cambios'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The question could not be saved. Please, try again.'));
        }
        //$evaluations = $this->Questions->Evaluations->find('list', ['limit' => 200]);
        $this->set(compact('question'));
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
            $this->Flash->success(__('La pregunta a sido eliminada'));
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
