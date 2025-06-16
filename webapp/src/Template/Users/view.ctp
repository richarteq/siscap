<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">
<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id]) ?></li>
<li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $user->id], ['confirm' => __('¿Esta seguro de eliminar este usuario?')]) ?> </li>
<li><?= $this->Html->link(__('Usuarios'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<!-- ACCIONES> -->
</ul>
</section>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="users view large-9 medium-8 columns content">
    <?php
      switch($user->role->name){
        case 'administrator':
          $icono = $this->Html->image(Configure::read('DLince.icon.administrator'), ["alt" => __('Administrador')]);
          break;
        case 'teacher':
          $icono = $this->Html->image(Configure::read('DLince.icon.teacher'), ["alt" => __('Profesor')]);
          break;
        case 'student':
          $icono = $this->Html->image(Configure::read('DLince.icon.student'), ["alt" => __('Estudiante')]);
          break;
        default:
          $icono = $this->Html->image(Configure::read('DLince.icon.user'), ["alt" => __('Usuario')]);
      }
    ?>
    <table class="vertical-table">
      <tr>
          <th scope="row"><?= __('Rol del usuario') ?></th>
          <td><?= $icono ?></td>
          <td style="font-weight:bold;"><?= ucfirst(__($user->role->name)) ?></td>
      </tr>
      <tr>
          <th scope="row"><?= __('Código del usuario') ?></th>
          <td style="font-weight:bold;" colspan="2"><?= $this->Number->format($user->id) ?></td>
      </tr>
      <tr>
          <th scope="row"><?= __('Nro de DNI') ?></th>
          <td colspan="2"><?= h($user->dni) ?></td>
      </tr>
      <tr>
          <th scope="row"><?= __('Nombres completos') ?></th>
          <td colspan="2"><?= h($user->names) ?></td>
      </tr>
      <tr>
          <th scope="row"><?= __('Apellido paterno') ?></th>
          <td colspan="2"><?= h($user->father_surname) ?></td>
      </tr>
      <tr>
          <th scope="row"><?= __('Apellido materno') ?></th>
          <td colspan="2"><?= h($user->mother_surname) ?></td>
      </tr>
      <tr>
          <th scope="row"><?= __('Correo electrónico') ?></th>
          <td colspan="2"><?= h($user->email) ?></td>
      </tr>
      <tr>
          <th scope="row"><?= __('¿El usuario esta activo?') ?></th>
          <td colspan="2">
          <?php
            if(intval($user->state)){
              echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
            }else{
              echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
            }
          ?>
          </td>
      </tr>
      <tr>
          <th scope="row"><?= __('¿Cambio su contraseña?') ?></th>
          <td colspan="2"><?= $user->changed ? __('Yes') : __('No'); ?></td>
      </tr>
      <tr>
          <th scope="row"><?= __('Fecha que cambio su contraseña') ?></th>
          <?php if($user->changed): ?>
          <td colspan="2"><?= $user->when_changed->format('d \d\e ').__($user->when_changed->format('F')).$user->when_changed->format(' \d\e\l Y \a \l\a\s H:i:s A') ?></td>
          <?php else: ?>
          <td colspan="2">Nunca cambio su contraseña</td>
          <?php endif; ?>
      </tr>
      <tr>
          <th scope="row"><?= __('Fecha de creación del usuario') ?></th>
          <td colspan="2"><?= $user->created->format('d \d\e ').__($user->created->format('F')).$user->created->format(' \d\e\l Y \a \l\a\s H:i:s A') ?></td>          
      </tr>
    </table>

    <?php if ( $user->firm!=null ): ?>
      <div class="description">
        <h4><?= __('Firma') ?></h4>
        <?= $this->Text->autoParagraph(h($user->firm)); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($user->courses)): ?>
      <div class="related">
        <h4><?= __('Cursos') ?></h4>        
        <table cellpadding="0" cellspacing="0">
          <tr>
            <th scope="col"><?= __('Name') ?></th>
          </tr>
            <?php foreach ($user->courses as $courses): ?>
              <tr>
                <td><?= h($courses->name) ?></td>
              </tr>
            <?php endforeach; ?>
        </table>    
      </div>
    <?php endif; ?>

    <?php if (!empty($user->messages)): ?>
      <div class="related">
        <h4><?= __('Mensajes') ?></h4>        
        <table cellpadding="0" cellspacing="0">
          <tr>
            <th scope="col"><?= __('Subject') ?></th>
            <th scope="col"><?= __('Body') ?></th>
          </tr>
          <?php foreach ($user->messages as $messages): ?>
            <tr>
              <td><?= h($messages->subject) ?></td>
              <td><?= h($messages->body) ?></td>
            </tr>
          <?php endforeach; ?>
        </table>     
      </div>
    <?php endif; ?>

    <?php if (!empty($user->recipients)): ?>
      <div class="related">
        <h4><?= __('Destinatarios') ?></h4>        
        <table cellpadding="0" cellspacing="0">
            <tr>
              <th scope="col"><?= __('User Id') ?></th>
            </tr>
            <?php foreach ($user->recipients as $recipients): ?>
              <tr>
                <td><?= h($recipients->user_id) ?></td>
              </tr>
            <?php endforeach; ?>
        </table>        
      </div>
    <?php endif; ?>


</div>
<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>