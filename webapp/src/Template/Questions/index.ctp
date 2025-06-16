<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Html->link(__('Preguntas'), ['action' => 'index'],['style'=>'font-weight:bold']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="questions index large-9 medium-8 columns content">
    
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                
                <th scope="col"><?= $this->Paginator->sort('evaluation_id','Evaluación') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title','Título') ?></th>
                <th scope="col"><?= $this->Paginator->sort('state','¿Activo?') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created','Creado') ?></th>
                
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question): ?>
            <tr>
                
                <td><strong><?= $question->evaluation->title ?></strong></td>
                <td><?= h($question->title) ?></td>
                <td>
                    <?php
                    if(intval($question->state)==1){
                        echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                    }else{
                        echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                    }
                    ?>
                </td>
                
                <td><?= h($question->created) ?></td>
                
                <td class="actions">
                <?php
                    echo $this->Html->link(
                        $this->Html->image(Configure::read('DLince.icon.view'), ["alt" => __('View')]),
                        ['action' => 'view', $question->id],
                        ['escape' => false]
                    );
                    
                    echo $this->Form->postLink(
                        $this->Html->image(Configure::read('DLince.icon.delete'), ["alt" => __('Delete')]),
                        ['action' => 'delete', $question->id],
                        ['escape' => false, 'confirm' => __('¿Esta seguro de eliminar la pregunta?')]
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
