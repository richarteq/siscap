<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Message $message
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Message'), ['action' => 'edit', $message->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Message'), ['action' => 'delete', $message->id], ['confirm' => __('Are you sure you want to delete # {0}?', $message->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Messages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Recipients'), ['controller' => 'Recipients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Recipient'), ['controller' => 'Recipients', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="messages view large-9 medium-8 columns content">
    <h3><?= h($message->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $message->has('user') ? $this->Html->link($message->user->id, ['controller' => 'Users', 'action' => 'view', $message->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subject') ?></th>
            <td><?= h($message->subject) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($message->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($message->created) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Body') ?></h4>
        <?= $this->Text->autoParagraph(h($message->body)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Recipients') ?></h4>
        <?php if (!empty($message->recipients)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Message Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Reviewed') ?></th>
                <th scope="col"><?= __('Favourite') ?></th>
                <th scope="col"><?= __('Trash') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($message->recipients as $recipients): ?>
            <tr>
                <td><?= h($recipients->id) ?></td>
                <td><?= h($recipients->message_id) ?></td>
                <td><?= h($recipients->user_id) ?></td>
                <td><?= h($recipients->reviewed) ?></td>
                <td><?= h($recipients->favourite) ?></td>
                <td><?= h($recipients->trash) ?></td>
                <td><?= h($recipients->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Recipients', 'action' => 'view', $recipients->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Recipients', 'action' => 'edit', $recipients->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Recipients', 'action' => 'delete', $recipients->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recipients->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
