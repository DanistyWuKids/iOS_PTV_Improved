<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sensor $sensor
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sensor'), ['action' => 'edit', $sensor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sensor'), ['action' => 'delete', $sensor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sensor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sensors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sensor'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sensors view large-9 medium-8 columns content">
    <h3><?= h($sensor->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($sensor->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Triggered') ?></th>
            <td><?= $this->Number->format($sensor->triggered) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Filename') ?></h4>
        <?= $this->Text->autoParagraph(h($sensor->filename)); ?>
    </div>
</div>
