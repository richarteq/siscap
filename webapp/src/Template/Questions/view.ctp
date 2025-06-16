<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">
<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $question->id], ['confirm' => __('¿Esta seguro de eliminar esta pregunta?')]) ?> </li>
<li><?= $this->Html->link(__('Preguntas'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<!-- ACCIONES> -->
</ul>
</section>
</div>
<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="questions view large-9 medium-8 columns content">
    
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Evaluación') ?></th>
            <td><strong><?= $question->evaluation->title ?></strong></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pregunta') ?></th>
            <td><?= h($question->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripción') ?></th>
            <td><?= h($question->description) ?></td>
        </tr>
        
        <tr>
            <th scope="row"><?= __('Fecha de creación') ?></th>
            <td colspan="2"><?= $question->created->format('d \d\e ').__($question->created->format('F')).$question->created->format(' \d\e\l Y \a \l\a\s H:i:s A') ?>          
      </td>
        </tr>
        <tr>
            <th scope="row"><?= __('¿Activo?') ?></th>
            <td>
            <?php
                if(intval($question->state)==1){
                    echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                }else{
                    echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                }
            ?>
            </td>
        </tr>
    </table>
    
    
    <div class="related">
        
        <?php if (!empty($question->options)): ?>
        <table cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                
                
                <th scope="col"><?= __('Opción') ?></th>
                <th scope="col"><?= __('¿Correcto?') ?></th>
                <th scope="col"><?= __('Creado') ?></th>
                
                <th scope="col"><?= __('¿Activo?') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($question->options as $options): ?>
            <tr>
                
                
                <td>
                <?php
                    if(intval($options->correct)==1){
                        echo "<strong>".h($options->choise)."</strong>";
                    }else{
                        echo h($options->choise);
                    } 
                ?>                    
                </td>
                
                <td>
                <?php
                    if(intval($options->correct)==1){
                        echo $this->Html->image(Configure::read('DLince.icon.ok'), ["alt" => __('Correcto')]);
                    }else{
                        echo '';
                    }
                ?>
                </td>
                
                <td><?= h($options->created) ?></td>
                
                <td>
                    <?php
                    if(intval($options->state)==1){
                        echo $this->Html->image(Configure::read('DLince.icon.active'), ["alt" => __('Yes')]);
                    }else{
                        echo $this->Html->image(Configure::read('DLince.icon.bloqued'), ["alt" => __('No')]);
                    }
                    ?>
                </td>
                <td class="actions">
                <?php
                    
                    echo $this->Form->postLink(
                        $this->Html->image(Configure::read('DLince.icon.delete'), ["alt" => __('Delete')]),
                        ['controller' => 'Options', 'action' => 'delete', $options->id],
                        ['escape' => false, 'confirm' => __('¿Esta seguro de eliminar la opción?')]
                    );
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
        <?php endif; ?>
    </div>
    
</div>

<!-- CONTENIDO PRINCIPAL> -->
</section>
</div>
