<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>

<div class="menu-left">
<ul class="list-menu-left">
<li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $evaluation->id], ['confirm' => __('¿Esta seguro de eliminar esta evaluación?')]) ?> </li>
<li><?= $this->Html->link(__('Evaluaciones'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
</ul>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="evaluations view large-9 medium-8 columns content">
    
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Curso') ?></th>
            <td><strong><?=$evaluation->course->name ?></strong></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Evaluación') ?></th>
            <td><?= h($evaluation->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripción') ?></th>
            <td><?= h($evaluation->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha de creación') ?></th>
            <td colspan="2"><?= $evaluation->created->format('d \d\e ').__($evaluation->created->format('F')).$evaluation->created->format(' \d\e\l Y \a \l\a\s H:i:s A') ?>          
      </td>
        </tr>
       
        <tr>
            <th scope="row"><?= __('¿Activo?') ?></th>
            <td>
            <?php
                if(intval($evaluation->state)==1){
                    echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                    echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
            ?>
            </td>
        </tr>
    </table>
    
    <div class="related">
        
        <?php if (!empty($evaluation->questions)): ?>
        <table cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                
                <th scope="col"><?= __('Pregunta') ?></th>
                <th scope="col"><?= __('Creado') ?></th>
                <th scope="col"><?= __('¿Activo?') ?></th>
                
                
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
            <?php foreach ($evaluation->questions as $questions): ?>
            <tr>
                
                <td><?= h($questions->title) ?></td>
                <td><?= h($questions->created) ?></td>
                <td>
                    <?php
                    if(intval($questions->state)==1){
                        echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                    }else{
                        echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                    }
                    ?>
                </td>
                
               
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Questions', 'action' => 'view', $questions->id]) ?>
                    
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Questions', 'action' => 'delete', $questions->id], ['confirm' => __('¿Esta seguro de eliminar la pregunta?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>