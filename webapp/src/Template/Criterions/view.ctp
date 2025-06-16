<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Criterion $criterion
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Criterion'), ['action' => 'edit', $criterion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Criterion'), ['action' => 'delete', $criterion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $criterion->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Criterions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Criterion'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Polls'), ['controller' => 'Polls', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Poll'), ['controller' => 'Polls', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="criterions view large-9 medium-8 columns content">
    <h3><?= h($criterion->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Poll') ?></th>
            <td><?= $criterion->has('poll') ? $this->Html->link($criterion->poll->title, ['controller' => 'Polls', 'action' => 'view', $criterion->poll->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($criterion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($criterion->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($criterion->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $criterion->state ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Criterion') ?></h4>
        <?= $this->Text->autoParagraph(h($criterion->criterion)); ?>
    </div>
</div>
