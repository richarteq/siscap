<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<?php use Cake\Routing\Router; ?>
<script>
$(window).load(function() {
  $("#course-id").focus();
  /**/
  $( "#course-id" ).change(function() 
  {
    var courseId = $(this).val();
    /**/
    $.ajax(
    {
      type:'POST',
      url: '<?php echo Router::url(array('controller'=>'Questions','action'=>'getCourseEvaluations'));?>' + '/'+ courseId,
      dataType:'html',
      success:function(htmlEvaluations){
        $('#evaluation-id').html(htmlEvaluations);
      }
    });
    /**/
  });
  /**/
  $( "#evaluation-id" ).change(function() 
  {
    var evaluationId = $(this).val();
    /**/
    createEvaluation(evaluationId)
    /**/
  });
  /**/
  function createEvaluation(evaluation){
    $.ajax(
    {
      type:'POST',
      url: '<?php echo Router::url(array('controller'=>'Questions','action'=>'getEvaluationQuestionsChoises'));?>' + '/'+ evaluation,
      dataType:'html',
      success:function(htmlEvaluationQuestionsChoises){
        $('#evaluation-questions-choises').html(htmlEvaluationQuestionsChoises);
      }
    });
  }
  /**/
  $( "#button-save-question-choises" ).click(function() 
  {
    /**/
    var evaluation_id = $('#evaluation-id').val();
    var title = $('#title').val();
    var description = $('#description').val();
    /* 
     * arreglos
     */
    var options = [];
    $('input[name="options[]"]').each(function() {
      options.push(this.value);
    });
    /**/
    var values = [];
    if( document.getElementsByName("values[]") ){
      $('input[name="values[]"]').each(function() {
        if($(this).is(':checked')){
          values.push(this.value);
        } 
      });
    }
    /**/
    $.ajax({
      type:'POST',
      dataType: 'json',
      url: '<?php echo Router::url(array('controller'=>'Questions','action'=>'add2'));?>',      
      data: {evaluation_id: evaluation_id,title:title,description:description,options:options,values:values},
      success: function(data){
        alert(options.toString());
        alert(values.toString());
        createEvaluation(evaluation_id);
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

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Preguntas'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add'],['style'=>'font-weight:bold']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<header>
<!-- HEADER -->
</header>
<!-- <CONTENIDO PRINCIPAL -->

<div class="questions form large-9 medium-8 columns content">
  <?= $this->Form->create($question,['id'=>'form123']) ?>
  <fieldset>
    <legend><?= __('Agregar pregunta a una evaluación') ?></legend>
    <?php
      echo $this->Form->control('course_id', ['options' => $courses,'required'=>true, 'label'=>'Curso','empty'=>'Seleccione un Curso']);
      echo $this->Form->control('evaluation_id', ['options' => array(), 'required'=>true, 'label'=>'Evaluación','empty'=>'Seleccione una Evaluación']);
      
      echo $this->Form->control('title',['label'=>'Título de la Pregunta','style'=>'width:600px']);
      echo $this->Form->control('description',['label'=>'Descripción de la Pregunta','style'=>'width:600px;height:55px']);
      /**
       * <Opciones
       */
      echo "<table class=\"table-input-choises\">";
      echo "<tr>";
      echo $this->Form->control('options[]',['label'=>'Opción 1','required'=>'true', 'style'=>'width:400px',
        'templates' => [
          'inputContainer' => '<td><div class="input text required">{{content}}</div></td>
          <td><input type="checkbox" name="values[]" value="1" id="correct-1" class="input-choise-checkbox"></td>'
        ]
      ]);
      echo $this->Form->control('options[]',['label'=>'Opción 2','required'=>'true', 'style'=>'width:400px',
        'templates' => [
          'inputContainer' => '<td><div class="input text required">{{content}}</div></td>
          <td><input type="checkbox" name="values[]" value="2" id="correct-1" class="input-choise-checkbox"></td>'
        ]
      ]);
      echo "</tr><tr>";
      echo $this->Form->control('options[]',['label'=>'Opción 3','style'=>'width:400px',
        'templates' => [
          'inputContainer' => '<td>{{content}}</td><td><input type="checkbox" name="values[]" value="3" id="correct-1" class="input-choise-checkbox"></td>'
        ]
      ]);
      echo $this->Form->control('options[]',['label'=>'Opción 4','style'=>'width:400px',
        'templates' => [
          'inputContainer' => '<td>{{content}}</td><td><input type="checkbox" name="values[]" value="4" id="correct-1" class="input-choise-checkbox"></td>'
        ]
      ]);
      echo "</tr>";
      echo "</table>";
      /* Opciones>*/
          
      echo $this->Form->button(
      __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Agregar pregunta</span>'),
        ['class'=>'button', 'id'=>'button-save-question-choises', 'type'=>'button','escape' => false]
      );        
      ?>
  </fieldset>
  <?= $this->Form->end() ?>
  <form>
    <fieldset>
      <legend>Vista rapida de la Evaluación</legend>
    <div id="evaluation-questions-choises" style="font-family:'Montserrat','Helvetica Neue',helvetica,arial,sans-serif;font-size:12pt;">
    </div>
    </fieldset>
  </form>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>