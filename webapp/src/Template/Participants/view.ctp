<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">
<ul class="list-menu-left">
<!-- <ACCIONES -->

<li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $participant->id], ['confirm' => __('¿Esta seguro de eliminar este participante?')]) ?> </li>
<li><?= $this->Html->link(__('Participantes'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<!-- ACCIONES> -->
</ul>
</section>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="participants view large-9 medium-8 columns content">
    
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Estudiante') ?></th>
            <td><?= $participant->has('student') ? $this->Html->link($participant->student->user->full_name, ['controller' => 'Users', 'action' => 'view', $participant->student->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Correo electrónico') ?></th>
            <td><?= $participant->has('student') ? $this->Html->link($participant->student->user->email, ['controller' => 'Users', 'action' => 'view', $participant->student->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Curso') ?></th>
            <td><?= $participant->has('course') ? $this->Html->link($participant->course->name, ['controller' => 'Courses', 'action' => 'view', $participant->course->id]) : '' ?></td>
        </tr>
       
        <tr>
            <th scope="row"><?= __('Agregado') ?></th>
            <td>
                <?= ($participant->created==null)?'':'El '.$participant->created->format('d \d\e ').__($participant->created->format('F')).$participant->created->format(' \d\e\l Y') ?>              
            </td>
        </tr>
        
        <tr>
            <th scope="row"><?= __('¿Participación activa?') ?></th>
            <td>
            <?php
              if( intval($participant->state) )
              {
                echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
              }
              else
              {
                echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
              }
            ?>
            </td>
        </tr>
    </table>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>