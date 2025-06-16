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
                ['action' => 'delete', $recipient->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $recipient->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Recipients'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Messages'), ['controller' => 'Messages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Message'), ['controller' => 'Messages', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="recipients form large-9 medium-8 columns content">
    <?= $this->Form->create($recipient) ?>
    <fieldset>
        <legend><?= __('Edit Recipient') ?></legend>
        <?php
            echo $this->Form->control('message_id', ['options' => $messages]);
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('reviewed');
            echo $this->Form->control('favourite');
            echo $this->Form->control('trash');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
