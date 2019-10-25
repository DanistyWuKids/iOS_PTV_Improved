<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recording $recording
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Recordings'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="recordings form large-9 medium-8 columns content">
    <?= $this->Form->create($recording) ?>
    <fieldset>
        <legend><?= __('Add Recording') ?></legend>
        <?php
            echo $this->Form->control('recTime');
            echo $this->Form->control('recTriggered');
            echo $this->Form->control('recType');
            echo $this->Form->control('recIp');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
