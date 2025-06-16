<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Videos'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="videos form large-9 medium-8 columns content">
    <?= $this->Form->create($video) ?>
    <fieldset>
      <legend><?= __('Editando video') ?></legend>
      <?php
      echo $this->Form->control('course_id', ['options' => $courses,'label'=>'Curso','empty'=>'Seleccione un Curso']);
      echo $this->Form->control('url',['label'=>'URL del video']);
      echo $this->Form->control('title',['label'=>'Título del video']);
      echo $this->Form->control('description',['label'=>'Descripción breve del video']);
      echo $this->Form->control('width',['label'=>'Ancho']);
      echo $this->Form->control('height',['label'=>'Alto']);
      echo $this->Form->control('state',['label'=>'¿El video esta visible?']);
      echo$this->Form->button(__('Editar el video'),['class'=>'button'])
      ?>
      </fieldset>
      <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->

</section>
</div>
<!-- VISTA> -->
