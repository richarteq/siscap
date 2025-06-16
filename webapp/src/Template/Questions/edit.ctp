<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">

<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Form->postLink(
__('Delete'),
['action' => 'delete', $question->id],
['confirm' => __('¿Esta seguro que quiere eliminar esta pregunta?')]
)
?></li>
<li><?= $this->Html->link(__('Preguntas'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<!-- ACCIONES> -->
</ul>
</div>

<div class="questions form large-9 medium-8 columns content">
    <?= $this->Form->create($question) ?>
    <fieldset>
        <legend><?= __('Edición de pregunta') ?></legend>
        <?php
            
            echo $this->Form->control('title',['label'=>'Título de la pregunta']);
            echo $this->Form->control('description',['label'=>'Descripción de la pregunta']);
            echo $this->Form->button(
          __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Guardar cambios</span>'),
          ['class'=>'button', 'escape' => false]
        );        
          ?>
        </fieldset>
        <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>
