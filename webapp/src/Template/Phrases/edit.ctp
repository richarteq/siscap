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
    ['action' => 'delete', $phrase->id],
    ['confirm' => __('¿Esta seguro que quiere eliminar esta frase?')]
    )
?></li>
<li><?= $this->Html->link(__('Frases'), ['action' => 'index']) ?></li>
<!-- ACCIONES> -->
</ul>

</div>
<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="phrases form large-9 medium-8 columns content">
    <?= $this->Form->create($phrase) ?>
    <fieldset>
        <legend><?= __('Editar frase') ?></legend>
        <?php
            echo $this->Form->control('phrase',['label'=>'Frase']);
            echo $this->Form->control('author',['label'=>'Autor']);
            echo $this->Form->control('state',['label'=>'Visible']);
            echo$this->Form->button(__('Guardar cambios'),['class'=>'button'])
            ?>
            </fieldset>
            <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>