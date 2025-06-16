<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="3u">
<section class="sidebar">
<header>
<h2><?= __('Actions') ?></h2>
</header>
<ul class="style1">
<!-- <ACCIONES -->

<li><?= $this->Form->postLink(
        __('Eliminar este archivo'),
        ['action' => 'delete', $file->id],
        ['confirm' => __('¿Esta seguro de eliminar el archivo {0}?', __($file->src))]
    )
?></li>
<li><?= $this->Html->link(__('Lista de archivos'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar nuevo archivo'), ['action' => 'add']) ?></li>

<!-- ACCIONES> -->
</ul>
</section>
</div>
<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="files form large-9 medium-8 columns content">
    <?= $this->Form->create($file) ?>
    <fieldset>
        <legend><?= __('Editar archivo') ?></legend>
        <?php
            echo $this->Form->control('course_id', ['options' => $courses,'label'=>'Curso','empty'=>'Seleccione un Curso']);
            echo $this->Form->control('title',['label'=>'Título de la publicación']);
            echo $this->Form->control('description',['label'=>'Descripción de la publicación']);

            echo $this->Form->control('state',['label'=>'¿Archivo activo?']);
            echo$this->Form->button(__('Editar archivo'),['class'=>'button'])
            ?>
            </fieldset>
            <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->

</section>
</div>
<!-- VISTA> -->
