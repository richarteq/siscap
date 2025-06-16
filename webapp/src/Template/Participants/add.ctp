<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<script>
$(window).load(function() {
  $("#student-id").focus();
});
</script>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Participantes'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add'],['style'=>'font-weight:bold']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="participants form large-9 medium-8 columns content">
    <?= $this->Form->create($participant) ?>
    <fieldset>
        <legend><?= __('Agregar participante a un curso') ?></legend>
        <?php

            echo $this->Form->control('course_id', ['options' => $courses,'label'=>'Curso para inscribir','empty'=>'Seleccione un Curso']);
            echo $this->Form->control('student_id', ['options' => $users,'label'=>'Estudiante participante en el curso','empty'=>'Seleccione un Estudiante']);
            echo $this->Form->control('state',['label'=>'¿La participación esta habilitada?']);
            echo $this->Form->button(
          __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Agregar participante al curso</span>'),
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
