<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Presentation $presentation
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Presentation'), ['action' => 'edit', $presentation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Presentation'), ['action' => 'delete', $presentation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $presentation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Presentations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Presentation'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="presentations view large-9 medium-8 columns content">
    <h3><?= h($presentation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Task') ?></th>
            <td><?= $presentation->has('task') ? $this->Html->link($presentation->task->title, ['controller' => 'Tasks', 'action' => 'view', $presentation->task->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $presentation->has('student') ? $this->Html->link($presentation->student->id, ['controller' => 'Students', 'action' => 'view', $presentation->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('File') ?></th>
            <td><?= h($presentation->file) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($presentation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Qualification') ?></th>
            <td><?= $this->Number->format($presentation->qualification) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($presentation->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $presentation->state ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
