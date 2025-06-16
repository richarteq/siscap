<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>

<div class="menu-left">
    <ul class="list-menu-left">
        <li><?= $this->Html->link(__('Instructores'), ['action' => 'index'],['style'=>'font-weight:bold']) ?></li>
        <li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
    </ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="instructors index large-9 medium-8 columns content">
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('course_id','Curso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('teacher_id','Profesor instructor') ?></th>                
                <th scope="col"><?= $this->Paginator->sort('state','Habilitado?') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($instructors as $instructor): ?>
            <tr>
            <td style="font-weight:bold;">
                <?= $instructor->has('course') ? $instructor->course->id .' '. $this->Html->link($instructor->course->name, ['controller' => 'Courses', 'action' => 'view', $instructor->course->id]) : '' ?>                    
            </td>            
            <td>
                <span style="clear:left; float:left;"><?= $instructor->teacher->user->full_name ?></span>
                <span style="clear:left; float:left; margin-top: 5px;"><?= $instructor->teacher->user->email ?></span>
            </td>                
            <td>
                <?php
					if(intval($instructor->state))
                    {
						echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
					}else{
						echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
					}
				?>
            </td>
            <td class="actions">
                <?php

              		echo $this->Html->link(
										$this->Html->image(Configure::read('DLince.icon.view'), ["alt" => __('View')]),
										['action' => 'view', $instructor->id],
										['escape' => false]
									);
									echo $this->Html->link(
										$this->Html->image(Configure::read('DLince.icon.edit'), ["alt" => __('Edit')]),
										['action' => 'edit', $instructor->id],
										['escape' => false]
									);
									echo $this->Form->postLink(
										$this->Html->image(Configure::read('DLince.icon.delete'), ["alt" => __('Delete')]),
										['action' => 'delete', $instructor->id],
										['escape' => false, 'confirm' => __('¿Esta seguro que quiere dejar de instruir este curso?')]
									);

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
<!-- VISTA> -->
