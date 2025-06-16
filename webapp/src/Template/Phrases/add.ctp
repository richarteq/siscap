<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<script>
$(window).load(function() {
  $("#phrase").focus();
});
</script>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Frases'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add'],['style'=>'font-weight:bold']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="phrases form large-9 medium-8 columns content">
    <?= $this->Form->create($phrase) ?>
    <fieldset>
        <legend><?= __('Agregar frase') ?></legend>
        <?php
            echo $this->Form->control('phrase',['label'=>'Frase']);
            echo $this->Form->control('author',['label'=>'Autor']);
            echo $this->Form->control('state',['label'=>'Visible']);


        echo $this->Form->button(
          __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Agregar frase</span>'),
          ['class'=>'button', 'escape' => false]
        );        
          ?>
        </fieldset>
        <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>