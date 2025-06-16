<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">
<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Html->link(__('Editar'), ['action' => 'edit', $instructor->id]) ?></li>
<li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $instructor->id], ['confirm' => __('¿Esta seguro de eliminar este instructor?')]) ?> </li>
<li><?= $this->Html->link(__('Instructores'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<!-- ACCIONES> -->
</ul>
</section>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="instructors view large-9 medium-8 columns content">

    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Profesor instructor') ?></th>
            <td><?= $instructor->teacher->user->full_name_and_email ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Curso') ?></th>
            <td><?= $instructor->has('course') ? $this->Html->link($instructor->course->name, ['controller' => 'Courses', 'action' => 'view', $instructor->course->id]) : '' ?></td>
        </tr>


        <tr>
            <th scope="row"><?= __('¿El instructor esta habilitado?') ?></th>
            <td>
              <?php
                if(intval($instructor->state)){
                  echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                  echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
              ?>
            </td>
        </tr>
        <tr>
	          <th scope="row"><?= __('Fecha desde que instruye') ?></th>
	          <td colspan="2"><?= 'Desde el '.$instructor->created->format('d \d\e ').__($instructor->created->format('F')).$instructor->created->format(' \d\e\l Y \a \l\a\s H:i:s A') ?></td>
	      </tr>
    </table>
</div>

<!-- CONTENIDO PRINCIPAL> -->

</section>
</div>
<!-- VISTA> -->
