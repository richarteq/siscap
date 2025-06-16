<?php
/**
  *
  */
?>
<div class="menu-left">

<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Form->postLink(
        __('Eliminar'),
        ['action' => 'delete', $instructor->id],
        ['confirm' => __('¿Esta seguro que quiere dejar de instruir este curso?')]
    )
?></li>
<li><?= $this->Html->link(__('Instructores'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<!-- ACCIONES> -->
</ul>

</div>
<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="instructors form large-9 medium-8 columns content">
    <?= $this->Form->create($instructor) ?>
    <fieldset>
        <legend><?= __('Editar instrucción de un curso') ?></legend>
        <?php
        echo $this->Form->control('course_id', ['options' => $courses,'label'=>'Curso a instruir','empty'=>'Seleccione un Curso','default'=>$instructor->course_id]);
        echo $this->Form->control('user_id', ['options' => $users,'required'=>true,'default'=>$user_id,'label'=>'Profesor instructor del curso','empty'=>'Seleccione un Profesor']);
        echo $this->Form->control('state',['label'=>'¿El instructor esta habilitado?']);
        echo$this->Form->button(__('Instruir curso'),['class'=>'button'])
          ?>
        </fieldset>
        <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->

</section>
</div>
<!-- VISTA> -->
