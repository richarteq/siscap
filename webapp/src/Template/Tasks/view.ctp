<?php
/**
  *
  */
?>
<?php use Cake\Core\Configure; ?>
<div class="menu-left">
<ul class="list-menu-left">
<!-- <ACCIONES -->
<li><?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $task->id], ['confirm' => __('¿Esta seguro de eliminar esta tarea?')]) ?> </li>
<li><?= $this->Html->link(__('Tareas'), ['action' => 'index']) ?></li>
<li><?= $this->Html->link(__('Agregar'), ['action' => 'add']) ?></li>
<!-- ACCIONES> -->
</ul>
</section>
</div>

<div class="9u skel-cell-important">
<section>
<!-- <CONTENIDO PRINCIPAL -->

<div class="tasks view large-9 medium-8 columns content">
    
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Course') ?></th>
            <td><?= $task->has('course') ? $this->Html->link($task->course->name, ['controller' => 'Courses', 'action' => 'view', $task->course->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($task->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('File') ?></th>
            <td><?= h($task->file) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($task->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start') ?></th>
            <td><?= h($task->start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Finish') ?></th>
            <td><?= h($task->finish) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($task->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($task->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $task->state ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($task->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Presentations') ?></h4>
        <?php if (!empty($task->presentations)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Task Id') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('File') ?></th>
                <th scope="col"><?= __('Qualification') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($task->presentations as $presentations): ?>
            <tr>
                <td><?= h($presentations->id) ?></td>
                <td><?= h($presentations->task_id) ?></td>
                <td><?= h($presentations->student_id) ?></td>
                <td><?= h($presentations->file) ?></td>
                <td><?= h($presentations->qualification) ?></td>
                <td><?= h($presentations->created) ?></td>
                <td><?= h($presentations->state) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Presentations', 'action' => 'view', $presentations->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Presentations', 'action' => 'edit', $presentations->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Presentations', 'action' => 'delete', $presentations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $presentations->id)]) ?>
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
<!-- VISTA> -->
