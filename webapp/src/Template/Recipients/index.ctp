<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Recipient[]|\Cake\Collection\CollectionInterface $recipients
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Recipient'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Messages'), ['controller' => 'Messages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Message'), ['controller' => 'Messages', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="recipients index large-9 medium-8 columns content">
    <h3><?= __('Recipients') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('message_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reviewed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('favourite') ?></th>
                <th scope="col"><?= $this->Paginator->sort('trash') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipients as $recipient): ?>
            <tr>
                <td><?= $this->Number->format($recipient->id) ?></td>
                <td><?= $recipient->has('message') ? $this->Html->link($recipient->message->id, ['controller' => 'Messages', 'action' => 'view', $recipient->message->id]) : '' ?></td>
                <td><?= $recipient->has('user') ? $this->Html->link($recipient->user->id, ['controller' => 'Users', 'action' => 'view', $recipient->user->id]) : '' ?></td>
                <td><?= h($recipient->reviewed) ?></td>
                <td><?= h($recipient->favourite) ?></td>
                <td><?= h($recipient->trash) ?></td>
                <td><?= h($recipient->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $recipient->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $recipient->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $recipient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recipient->id)]) ?>
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
