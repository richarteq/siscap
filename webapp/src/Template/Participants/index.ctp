<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Participantes'), ['action' => 'index'],['style'=>'font-weight:bold']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="participants index large-9 medium-8 columns content">
    
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('course_id','Curso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('student_id','Estudiante') ?></th>                
                <th scope="col"><?= $this->Paginator->sort('state','¿Activo?') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participants as $participant): ?>
            <tr>
                <td><?= $this->Html->link($participant->course->name, ['controller'=>'Courses','action' => 'view', $participant->course->id]) ?></td>
                <td><?= $this->Html->link($participant->student->user->full_name_and_email, ['controller'=>'Users','action' => 'view', $participant->student->user->id]) ?></td>
                
                <td>
                    <?php
                    if(intval($participant->state)==1){
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
                        ['action' => 'view', $participant->id],
                        ['escape' => false]
                    );
                    echo $this->Form->postLink(
                        $this->Html->image(Configure::read('DLince.icon.delete'), ["alt" => __('Delete')]),
                        ['action' => 'delete', $participant->id],
                        ['escape' => false, 'confirm' => __('¿Esta seguro de eliminar esta participación, {0}: {1}?', $participant->student->user->full_name,$participant->course->name)]
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
