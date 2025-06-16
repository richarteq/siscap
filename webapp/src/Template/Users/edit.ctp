<?php
/**
  *
  */
?>
<script>
$(window).load(function() {
  $("#change-password").change(function() {
    if($(this).is(':checked') ){
      $('#password').removeAttr('disabled');
      $("#password").focus();
    }else{
      $("#password").val('');
      $("#password").prop( "disabled", true );
    }
  });
});
</script>
<div class="menu-left">
<ul class="list-menu-left">
<!-- <ACCIONES -->

<li><?= $this->Form->postLink(
        __('Eliminar'),
        ['action' => 'delete', $user->id],
        ['confirm' => __('¿Esta seguro de eliminar el {0}, {1}: {2}?', __($user->role->name), $user->id, $user->full_name_and_email)]
    )
?></li>
<li><?= $this->Html->link(__('Usuarios'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>

<!-- ACCIONES> -->
</ul>
</div>
<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Editar '.__($user->role->name)) ?></legend>
        <?php
          echo $this->Form->control('dni',['label'=>'Nro de DNI']);
          echo $this->Form->control('names',['label'=>'Nombres completos']);
          echo $this->Form->control('father_surname',['label'=>'Apellido paterno']);
          echo $this->Form->control('mother_surname',['label'=>'Apeliido materno']);
          echo $this->Form->control('email',['label'=>'Correo electrónico']);

          //echo $this->Form->control('role_id', ['options' => $roles,'label'=>'Rol del usuario']);

          echo $this->Form->control('state',['label'=>'¿Usuario activo?']);
          echo $this->Form->control('change_password',['type'=>'checkbox', 'label'=>'¿Cambiar la contraseña?','id'=>'change-password']);
          echo $this->Form->control('password',['label'=>'Nueva contraseña para SISCAP', 'value'=>'', 'disabled'=>true, 'autocomplete'=>'new-password','maxlength'=>12, 'pattern'=>'.{8,12}', 'title'=>__('De 8 a 12 caracteres')]);
          echo $this->Form->control('firm',['label'=>'Firma']);
          echo$this->Form->button(__('Guardar cambios'),['class'=>'button'])
          ?>
          </fieldset>
          <?= $this->Form->end() ?>
</div>

<!-- CONTENIDO PRINCIPAL> -->

</section>
</div>
<!-- VISTA> -->
