<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Recipient $recipient
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Recipient'), ['action' => 'edit', $recipient->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Recipient'), ['action' => 'delete', $recipient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recipient->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Recipients'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Recipient'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Messages'), ['controller' => 'Messages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['controller' => 'Messages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="recipients view large-9 medium-8 columns content">
    <h3><?= h($recipient->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Message') ?></th>
            <td><?= $recipient->has('message') ? $this->Html->link($recipient->message->id, ['controller' => 'Messages', 'action' => 'view', $recipient->message->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $recipient->has('user') ? $this->Html->link($recipient->user->id, ['controller' => 'Users', 'action' => 'view', $recipient->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($recipient->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($recipient->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reviewed') ?></th>
            <td><?= $recipient->reviewed ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Favourite') ?></th>
            <td><?= $recipient->favourite ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Trash') ?></th>
            <td><?= $recipient->trash ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
