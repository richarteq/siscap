<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<?php use Cake\Routing\Router; ?>
<script>
$(document).ready(function() 
{
  
  /**/
  $( "#course-id" ).change(function() 
  {
    var courseId = $(this).val();
    /**/
    $.ajax(
    {
      type:'POST',
      url: '<?php echo Router::url(array('controller'=>'Presentations','action'=>'getCourseTasks'));?>' + '/'+ courseId,
      dataType:'html',
      success:function(htmlTasks){
        $('#task-id').html(htmlTasks);
      }
    });
    /**/
    $('#presentations-id').html('');
    /**/
  });
  /**/
  $( "#task-id" ).change(function() 
  {
    var taskId = $(this).val();
    /**/
    $.ajax(
    {
      type:'POST',
      url: '<?php echo Router::url(array('controller'=>'Presentations','action'=>'getPresentations'));?>' + '/'+ taskId,
      dataType:'html',
      success:function(htmlPresentations){
        $('#presentations-id').html(htmlPresentations);
      }
    });
    /**/
  });
  /**/
});
/**/
$(window).load(function() {
  $("#course-id").focus();
});
/**/
</script>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Presentaciones'), ['action' => 'index'],['style'=>'font-weight:bold']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="presentations form large-9 medium-8 columns content">
  <?= $this->Form->create() ?>
  <fieldset>
    <legend><?= __('Calificación a presentaciones de tareas') ?></legend>
    <?php
      echo $this->Form->control('course_id', ['options' => $courses, 'required'=>true, 'label'=>'Curso','empty'=>'Seleccione un Curso']);
      echo $this->Form->control('task_id', ['options' => array(), 'required'=>true, 'label'=>'Tarea','empty'=>'Seleccione una Tarea']);
      /*
      echo $this->Form->button(
      __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Enviar mensaje</span>'),
        ['class'=>'button', 'id'=>'button-send-message', 'type'=>'button','escape' => false]
      );
      */
    ?>
    <div id="presentations-id"></div>
  </fieldset>
  <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>