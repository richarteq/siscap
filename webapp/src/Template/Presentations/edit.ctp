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
                ['action' => 'delete', $presentation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $presentation->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Presentations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="presentations form large-9 medium-8 columns content">
    <?= $this->Form->create($presentation) ?>
    <fieldset>
        <legend><?= __('Edit Presentation') ?></legend>
        <?php
            echo $this->Form->control('task_id', ['options' => $tasks]);
            echo $this->Form->control('student_id', ['options' => $students]);
            echo $this->Form->control('file');
            echo $this->Form->control('qualification');
            echo $this->Form->control('state');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
