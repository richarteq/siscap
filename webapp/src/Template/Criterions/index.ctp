<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Criterion[]|\Cake\Collection\CollectionInterface $criterions
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Criterion'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Polls'), ['controller' => 'Polls', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Poll'), ['controller' => 'Polls', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="criterions index large-9 medium-8 columns content">
    <h3><?= __('Criterions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('poll_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('state') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($criterions as $criterion): ?>
            <tr>
                <td><?= $this->Number->format($criterion->id) ?></td>
                <td><?= $criterion->has('poll') ? $this->Html->link($criterion->poll->title, ['controller' => 'Polls', 'action' => 'view', $criterion->poll->id]) : '' ?></td>
                <td><?= h($criterion->state) ?></td>
                <td><?= h($criterion->created) ?></td>
                <td><?= h($criterion->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $criterion->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $criterion->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $criterion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $criterion->id)]) ?>
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
