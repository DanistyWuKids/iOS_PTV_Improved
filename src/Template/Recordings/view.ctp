<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recording $recording
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Recording'), ['action' => 'edit', $recording->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Recording'), ['action' => 'delete', $recording->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recording->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Recordings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Recording'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="recordings view large-9 medium-8 columns content">
    <h3><?= h($recording->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('RecIp') ?></th>
            <td><?= h($recording->recIp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($recording->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('RecTriggered') ?></th>
            <td><?= $this->Number->format($recording->recTriggered) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('RecType') ?></th>
            <td><?= $this->Number->format($recording->recType) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('RecTime') ?></th>
            <td><?= h($recording->recTime) ?></td>
        </tr>
    </table>
</div>
