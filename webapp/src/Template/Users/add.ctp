<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<script>
$(window).load(function() {
  $("#dni").focus();

  $("#dni").change(function() {
    $('#password').val($( "#dni" ).val());
  });

  $("#dni").keyup(function() {
    $('#password').val($( "#dni" ).val());
  });
});
</script>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Usuarios'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add'],['style'=>'font-weight:bold']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Agregar usuario') ?></legend>
        <?php
        echo $this->Form->control('dni',['label'=>'<strong>Nro de DNI</strong>', 'escape' => false, 'autocomplete'=>'off','maxlength'=>8, 'pattern'=>'[0-9]{8}', 'title'=>__('El DNI es numerico y de tamaño 8')]);
        echo $this->Form->control('names',['label'=>'Nombres completos','autocomplete'=>'new-names','maxlength'=>50, 'pattern'=>'[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+', 'title'=>__('Nombre inválido')]);
        echo $this->Form->control('father_surname',['label'=>'Apellido paterno','autocomplete'=>'new-father-surname','maxlength'=>50, 'pattern'=>'[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+', 'title'=>__('Apellido materno inválido')]);
        echo $this->Form->control('mother_surname',['label'=>'Apellido materno','autocomplete'=>'new-mother-surname','maxlength'=>50, 'pattern'=>'[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+', 'title'=>__('Apellido paterno inválido')]);
        echo $this->Form->control('email',['label'=>'Correo electrónico','autocomplete'=>'new-email']);

        echo $this->Form->control('role_id', ['options' => $roles,'label'=>'Rol del usuario','default' => '4']);
        echo $this->Form->control('state',['label'=>'¿Usuario activo?']);
        echo $this->Form->control('password',['label'=>'Contraseña para SISCAP','autocomplete'=>'new-password','maxlength'=>12, 'pattern'=>'.{8,12}', 'title'=>__('De 8 a 12 caracteres')]);
        echo $this->Form->control('firm',['label'=>'Firma para incluir en sus mensajes','autocomplete'=>'new-firm']);
        echo $this->Form->button(
          __($this->Html->image(Configure::read('DLince.icon.save')).'<span>Agregar usuario</span>'),
          ['class'=>'button', 'escape' => false]
        );        
      ?>
    </fieldset>
    <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->

</section>
</div>
