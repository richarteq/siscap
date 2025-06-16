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
<li><?= $this->Html->link(__('Archivos'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add'],['style'=>'font-weight:bold']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="files form large-9 medium-8 columns content">
  <?= $this->Form->create($file,['type' => 'file']) ?>
  <fieldset>
    <legend><?= __('Adjuntar archivo a un curso') ?></legend>
    <?php
      echo $this->Form->control('course_id', ['options' => $courses,'label'=>'Curso','empty'=>'Seleccione un Curso']);
      /* <Input FILE */
      $max_size_attachment = ($dlince_max_size_files>=1048576)?round($dlince_max_size_files/1048576,2).' MB':round($dlince_max_size_files/1024,2).' KB';
      echo "<div class=\"input required\">";
      echo $this->Form->label('src', 'Adjuntar archivo ('.$max_size_attachment.' máximo)');
      echo $this->Form->file('src');
      echo "<div class=\"error-message\">Archivo soportados: ".implode(', ',$dlince_type_files).".</div>";
      echo "</div>";
      /* Input FILE> */
      echo $this->Form->control('title',['label'=>'Titulo de la publicación']);
      echo $this->Form->control('description',['label'=>'Descripción de la publicación']);
      echo $this->Form->control('state',['label'=>'¿Archivo visible?']);

      echo $this->Form->button(
        $this->Html->image(Configure::read('DLince.icon.save')).'<span>Adjuntar archivo</span>',
        ['class'=>'button', 'escape' => false]
      );        
    ?>
  </fieldset>
  <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>