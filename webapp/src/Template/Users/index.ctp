<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Usuarios'), ['action' => 'index'],['style'=>'font-weight:bold']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="users index large-9 medium-8 columns content">
  <table cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th scope="col"><?= $this->Paginator->sort('id','Usuario') ?></th>
        <th scope="col"><?= $this->Paginator->sort('dni','DNI') ?></th>
        <th scope="col"><?= $this->Paginator->sort('names','Nombre del Usuario') ?></th>
        <th scope="col" colspan="2"><?= $this->Paginator->sort('role_id','Rol') ?></th>
        <th scope="col"><?= $this->Paginator->sort('state','¿Activo?') ?></th>
        <th scope="col"><?= $this->Paginator->sort('email','Correo electrónico') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
      </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td style="text-align: center; font-weight:bold;"><?= $user->id ?></td>
                <td><?= $user->dni ?></td>
                <td>
                  <?php 
                    echo $this->Html->link(
                      $user->full_name,
                      ['action' => 'view', $user->id],
                      ['escape' => false, 'title'=>'Ver usuario']
                  );
                  ?>                    
                </td>
                <td>
                  <?php
                  switch($user->role->name){
                    case 'administrator':
                      echo $this->Html->image(Configure::read('DLince.icon.administrator'), ["alt" => __('Administrador')]);
                      break;
                    case 'teacher':
                      echo $this->Html->image(Configure::read('DLince.icon.teacher'), ["alt" => __('Profesor')]);
                      break;
                    case 'student':
                      echo $this->Html->image(Configure::read('DLince.icon.student'), ["alt" => __('Estudiante')]);
                      break;
                    default:
                      echo $this->Html->image(Configure::read('DLince.icon.user'), ["alt" => __('Usuario')]);
                  }
                  ?>
                </td>
                <td>
                  <?= $user->has('role') ? ucfirst(__($user->role->name)): '' ?>
                </td>
                <td>
                <?php
									if(intval($user->state)){
										echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
									}else{
										echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
									}
								?>
                </td>
                <td><?= h($user->email) ?></td>


                <td class="actions">
                <?php
                //if( 'richarteq@gmail.com' == $this->request->session()->read('Auth.User.email') || $user->email!=='richarteq@gmail.com' )
                if( $user->email!=='admin@siscap.com' )
                {
              		echo $this->Html->link(
										$this->Html->image(Configure::read('DLince.icon.view'), ["alt" => __('View')]),
										['action' => 'view', $user->id],
										['escape' => false, 'title'=>'Ver usuario']
									);
									echo $this->Html->link(
										$this->Html->image(Configure::read('DLince.icon.edit'), ["alt" => __('Edit')]),
										['action' => 'edit', $user->id],
										['escape' => false, 'title'=>'Editar usuario']
									);
									echo $this->Form->postLink(
										$this->Html->image(Configure::read('DLince.icon.delete'), ["alt" => __('Delete')]),
										['action' => 'delete', $user->id],
										['escape' => false, 'title'=>'Eliminar usuario', 'confirm' => __('¿Esta seguro de eliminar el {0}, {1}: {2}?', __($user->role->name), $user->id, $user->full_name_and_email)]
									);
								}
								?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>
