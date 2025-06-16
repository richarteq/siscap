<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<?php use Cake\Routing\Router; ?>
<script>
$(document).ready(function() {
  
  /**/
  /*
   * Selecciona curso y evaluacion enviados en la URL como parametros
   */
  <?php if( $course_id!=null): ?>  
  $("#course-id").val(<?= $course_id ?>);
  <?php endif; ?>
  <?php if( count($evaluations)>0 && $evaluation_id!=null): ?>  
  $("#evaluation-id").val(<?= $evaluation_id ?>);
  loadEvaluation(<?= $evaluation_id ?>);
  <?php endif; ?>
  /**/
  
  /**/
  $( "#course-id" ).change(function() 
  {
    /**/
    var courseId = $(this).val();
    loadEvaluations(courseId);
    $("#evaluation-id").focus();
    /**/
  });
  /**/

  /**/
  $( "#evaluation-id" ).change(function() 
  {
    /**/
    var evaluationId = $(this).val();
    loadEvaluation(evaluationId);
    $("#title").focus();
    /**/
  });
  /**/

  /**/
  function loadEvaluations(course){
    /**/
    $.ajax(
    {
      type:'POST',
      url: '<?php echo Router::url(array('controller'=>'Questions','action'=>'getCourseEvaluations'));?>' + '/'+ course,
      dataType:'html',
      success:function(htmlEvaluations){
        $('#evaluation-id').html(htmlEvaluations);
      }
    });
    /**/
  }
  /**/

  /**/
  function loadEvaluation(evaluation){
    /**/
    $.ajax(
    {
      type:'POST',
      url: '<?php echo Router::url(array('controller'=>'Questions','action'=>'getEvaluationQuestionsChoises'));?>' + '/'+ evaluation,
      dataType:'html',
      success:function(htmlEvaluationQuestionsChoises){
        $('#evaluation-questions-choises').html(htmlEvaluationQuestionsChoises);
      }
    });
    /**/
  }
  /**/

  /**/
  $( "#button-save-question-choises" ).click(function() 
  {
    /**/
    //alert( $('#course-id').val() )
    if( $('#course-id').val() !='' )
    {
      /**/
      if( $('#evaluation-id').val() !='' )
      {
        /**/
        var selectedValues = 0;
        //var selectedValues = $("input[type=checkbox][name='values[]']:checked").length;
        /**/
        $("input[type=checkbox][name='values[]']:checked").each(function()
        {
          //alert($(this).val());
          if( $.trim(($("input[type=text][name='options[]']").eq($(this).val()-1)).val()).length>0 )
          {
            selectedValues = selectedValues + 1;
          }
        });
        /**/  
        if( $.trim($('#title').val()).length>0 )
        {
          if( $.trim($('#opcion2').val()).length>0 && $.trim($('#opcion1').val()).length>0 )
          {
            if (selectedValues>0)
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
                success: function(respuesta){
                  //alert(options.toString());
                  //alert(values.toString());
                  loadEvaluation(evaluation_id);
                  $("input[name='options[]']").val('');
                  $("input[type=checkbox][name='values[]']").attr('checked', false);
                  $("textarea[name='description']").val('');
                  $("#title").val('');
                  $("#title").focus();
                  $(".tr-added-for-two-choises").remove();
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
            }else{/* checkeds */
              alert("Debe seleccionar al menos una opción correcta");
              /**/
              $("input[type=checkbox][name='values[]']:checked").each(function()
              {
                $(this).prop('checked', false); // UnChecks it
              });
              /**/
            }      
          }
          else
          {/* opcion2 */
            /**/
            alert("Las opciones 1 y 2 son obligatorias");           
            if( !$.trim($('#opcion2').val()).lengt>0 ){
              $('#opcion2').val('');
              $('#opcion2').focus();
            }
            if( !$.trim($('#opcion1').val()).length>0 ){
              $('#opcion1').val('');
              $('#opcion1').focus();
            }
            /**/
          }
        }else{/* title */
          alert("Debe ingresar el título de la pregunta");
          $("#title").val('');
          $("#title").focus();
        }
        /**/
      }else{
        alert("Debe seleccionar una evaluación");
        $("#evaluation-id").focus();
      }
    }else{
      alert("Debe seleccionar un curso");
      $("#course-id").focus();
    }
  });
  /**/

  /**/
  function addTwoChoises(){
    var numOptions = 0;
    $('input[name="options[]"]').each(function() {
      numOptions = numOptions+1;
    });
    //alert(numOptions);
    /**/
    $.ajax(
    {
      type:'POST',
      url: '<?php echo Router::url(array('controller'=>'Questions','action'=>'addTwoChoises'));?>',
      data: {numberO:numOptions},
      dataType:'html',
      success:function(htmlAddTwoChoises){
        $("#tbody-input-choises").append(htmlAddTwoChoises);
      }
    });
    /**/
  }
  /**/

  /**/
  $( "#button-add-two-choises" ).click(function() 
  {
    addTwoChoises();
  });
  /**/

});
/**/
$(window).load(function() {
  $("#title").focus();
});
/**/
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
  <?= $this->Form->create(null) ?>
  <fieldset>
    <legend><?= __('Agregar preguntas a una evaluación') ?></legend>
    <?php
      echo $this->Form->control('course_id', ['options' => $courses,'required'=>true, 'label'=>'Curso','empty'=>'Seleccione un Curso']);
      echo $this->Form->control('evaluation_id', ['options' => $evaluations, 'required'=>true, 'label'=>'Evaluación','empty'=>'Seleccione una Evaluación']);
      
      echo $this->Form->control('title',['type'=>'textarea', 'label'=>'Título de la Pregunta','style'=>'width:880px']);
      echo $this->Form->control('description',['label'=>'Descripción de la Pregunta','style'=>'width:880px;height:55px']);
      /**/
      echo $this->Form->button(
      __($this->Html->image(Configure::read('DLince.icon.add')).'<span>Agregar 2 opciones más</span>'),
        ['class'=>'icon', 'id'=>'button-add-two-choises', 'type'=>'button','escape' => false, 'style'=>'float:right;']
      );        
      
      /**/
      /**
       * <Opciones
       */
      echo "<table class=\"table_input_choises\" id=\"table-input-choises\"><tbody id=\"tbody-input-choises\">";
      echo "<tr>";
      echo $this->Form->control('options[]',['label'=>'Opción 1','required'=>'true', 'id'=>'opcion1', 'style'=>'width:400px',
        'templates' => [
          'inputContainer' => '<td><div class="input text required">{{content}}</div></td>
          <td><input type="checkbox" name="values[]" value="1" id="correct-1" class="input-choise-checkbox"></td>'
        ]
      ]);
      echo $this->Form->control('options[]',['label'=>'Opción 2','required'=>'true', 'id'=>'opcion2', 'style'=>'width:400px',
        'templates' => [
          'inputContainer' => '<td><div class="input text required">{{content}}</div></td>
          <td><input type="checkbox" name="values[]" value="2" id="correct-2" class="input-choise-checkbox"></td>'
        ]
      ]);
      echo "</tr><tr>";
      echo $this->Form->control('options[]',['label'=>'Opción 3','style'=>'width:400px',
        'templates' => [
          'inputContainer' => '<td>{{content}}</td><td><input type="checkbox" name="values[]" value="3" id="correct-3" class="input-choise-checkbox"></td>'
        ]
      ]);
      echo $this->Form->control('options[]',['label'=>'Opción 4','style'=>'width:400px',
        'templates' => [
          'inputContainer' => '<td>{{content}}</td><td><input type="checkbox" name="values[]" value="4" id="correct-4" class="input-choise-checkbox"></td>'
        ]
      ]);
      echo "</tr>";
      echo "</tbody></table>";
      /* Opciones>*/
          
      echo $this->Form->button(
      __($this->Html->image(Configure::read('DLince.icon.processadd')).'<span>Agregar pregunta</span>'),
        ['class'=>'button', 'id'=>'button-save-question-choises', 'type'=>'button','escape' => false]
      );
      echo $this->Form->button(
      __($this->Html->image(Configure::read('DLince.icon.processok')).'<span>Cerrar y enviar Evaluación</span>'),
        ['class'=>'button', 'id'=>'button-save-question-choises', 'type'=>'button','escape' => false]
      );         
      ?>
  </fieldset>
  <?= $this->Form->end() ?>
  <form id="form-evaluation">
    <fieldset>
      <legend>Vista preliminar de Evaluación</legend>
      <div id="evaluation-questions-choises" style="heigth;auto; font-family:'Montserrat','Helvetica Neue',helvetica,arial,sans-serif;font-size:12pt;"></div>
    </fieldset>
  </form>
  <?php
  	
  ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>
