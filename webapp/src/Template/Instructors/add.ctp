<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<script>
$(window).load(function() {
  $("#course-id").focus();
});
</script>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Instructores'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add'],['style'=>'font-weight:bold']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="instructors form large-9 medium-8 columns content">
    <?= $this->Form->create($instructor) ?>
    <fieldset>
        <legend><?= __('Agregar instructor a un curso') ?></legend>
        <?php

            echo $this->Form->control('course_id', ['options' => $courses,'label'=>'Curso a instruir','empty'=>'Seleccione un Curso']);
            echo $this->Form->control('teacher_id', ['options' => $users,'label'=>'Profesor instructor del curso','empty'=>'Seleccione un Profesor']);
            echo $this->Form->control('state',['label'=>'¿El instructor esta habilitado?']);
            echo $this->Form->button(
          __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Agregar instructor al curso</span>'),
          ['class'=>'button', 'escape' => false]
        );        
          ?>
        </fieldset>
        <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->

</section>
</div>
<!-- VISTA> -->
