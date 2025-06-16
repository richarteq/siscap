<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Response $response
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Response'), ['action' => 'edit', $response->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Response'), ['action' => 'delete', $response->id], ['confirm' => __('Are you sure you want to delete # {0}?', $response->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Responses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Response'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Questions'), ['controller' => 'Questions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Question'), ['controller' => 'Questions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="responses view large-9 medium-8 columns content">
    <h3><?= h($response->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Question') ?></th>
            <td><?= $response->has('question') ? $this->Html->link($response->question->id, ['controller' => 'Questions', 'action' => 'view', $response->question->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Participant') ?></th>
            <td><?= $response->has('participant') ? $this->Html->link($response->participant->id, ['controller' => 'Participants', 'action' => 'view', $response->participant->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($response->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Value') ?></th>
            <td><?= $this->Number->format($response->value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($response->created) ?></td>
        </tr>
    </table>
</div>
