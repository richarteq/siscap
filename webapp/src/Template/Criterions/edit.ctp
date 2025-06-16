<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $criterion->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $criterion->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Criterions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Polls'), ['controller' => 'Polls', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Poll'), ['controller' => 'Polls', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="criterions form large-9 medium-8 columns content">
    <?= $this->Form->create($criterion) ?>
    <fieldset>
        <legend><?= __('Edit Criterion') ?></legend>
        <?php
            echo $this->Form->control('poll_id', ['options' => $polls]);
            echo $this->Form->control('criterion');
            echo $this->Form->control('state');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
