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
<li><?= $this->Html->link(__('Videos'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add'],['style'=>'font-weight:bold']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="videos form large-9 medium-8 columns content">
    <?= $this->Form->create($video) ?>
    <fieldset>
        <legend><?= __('Agregar video a un curso') ?></legend>
        <?php
        echo $this->Form->control('course_id', ['options' => $courses,'label'=>'Curso','empty'=>'Seleccione un Curso']);
        echo $this->Form->control('url',['label'=>'URL del video']);
        echo $this->Form->control('title',['label'=>'Título del vídeo']);
        echo $this->Form->control('description',['label'=>'Descripción breve del vídeo']);
        echo $this->Form->control('width',['label'=>'Ancho del video']);
        echo $this->Form->control('height',['label'=>'Alto del vídeo']);
        echo $this->Form->control('state',['label'=>'¿El video esta visible?']);
        echo $this->Form->button(
          __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Agregar video</span>'),
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
