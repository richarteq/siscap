<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<?php use Cake\Routing\Router; ?>
<script>
$(window).load(function() 
{
  $("#course-id").focus();
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
    $.ajax(
    {
      type:'POST',
      url: '<?php echo Router::url(array('controller'=>'Presentations','action'=>'getCourseStudents'));?>' + '/'+ courseId,
      dataType:'html',
      success:function(htmlStudents){
        $('#student-id').html(htmlStudents);
      }
    });
    /**/
  });
  /**/
});
</script>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Presentaciones'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add'],['style'=>'font-weight:bold']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="presentations form large-9 medium-8 columns content">
  <?= $this->Form->create($presentation,['type' => 'file']) ?>
  <fieldset>
    <legend><?= __('Presentar tarea') ?></legend>
    <?php
      echo $this->Form->control('course_id', ['options' => $courses, 'required'=>true, 'label'=>'Curso','empty'=>'Seleccione un Curso']);
      echo $this->Form->control('task_id', ['options' => array(), 'required'=>true, 'label'=>'Tarea','empty'=>'Seleccione una Tarea']);
      echo $this->Form->control('student_id', ['options' => array(), 'required'=>true, 'label'=>'Estudiante','empty'=>'Seleccione un Estudiante']);
      /* <Input FILE */
      $max_size_attachment = ($dlince_max_size_files>=1048576)?round($dlince_max_size_files/1048576,2).' MB':round($dlince_max_size_files/1024,2).' KB';
      echo "<div class=\"input required\">";
      echo $this->Form->label('file', 'Adjuntar archivo ('.$max_size_attachment.' máximo)');
      echo $this->Form->file('file');
      echo "<div class=\"error-message\">Archivo soportados: ".implode(', ',$dlince_type_files).".</div>";
      echo "</div>";
      /* Input FILE> */
      
      echo $this->Form->button(
              $this->Html->image(Configure::read('DLince.icon.save')).'<span>Presentar tarea</span>',
        ['class'=>'button', 'escape' => false]
          );        
        ?>
  </fieldset>
  <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>