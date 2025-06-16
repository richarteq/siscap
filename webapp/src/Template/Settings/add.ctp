<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Settings'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="settings form large-9 medium-8 columns content">
    <?= $this->Form->create($setting) ?>
    <fieldset>
        <legend><?= __('Add Setting') ?></legend>
        <?php
            echo $this->Form->control('sendEmail');
            echo $this->Form->control('sendEmailUserAdd');
            echo $this->Form->control('sendEmailUserEdit');
            echo $this->Form->control('sendEmailUserDisabled');
            echo $this->Form->control('sendEmailCourseAdd');
            echo $this->Form->control('sendEmailInstructorAdd');
            echo $this->Form->control('sendEmailParticipantAdd');
            echo $this->Form->control('sendEmailParticipantsComunicate');
            echo $this->Form->control('folder');
            echo $this->Form->control('typeFiles');
            echo $this->Form->control('typeBanners');
            echo $this->Form->control('limitsTime');
            echo $this->Form->control('maxSizeFiles');
            echo $this->Form->control('maxSizeBanners');
            echo $this->Form->control('emailFrom');
            echo $this->Form->control('nameEmailFrom');
            echo $this->Form->control('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
