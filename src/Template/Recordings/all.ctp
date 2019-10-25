<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recording[]|\Cake\Collection\CollectionInterface $recordings
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Recording'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="recordings index large-9 medium-8 columns content">
    <h3><?= __('Recordings') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('recTime') ?></th>
            <th scope="col"><?= $this->Paginator->sort('recTriggered') ?></th>
            <th scope="col"><?= $this->Paginator->sort('recType') ?></th>
            <th scope="col"><?= $this->Paginator->sort('recIp') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($recordings as $recording): ?>
            <tr>
                <td><?= $this->Number->format($recording->id) ?></td>
                <td><?= h($recording->recTime) ?></td>
                <td><?= $this->Number->format($recording->recTriggered) ?></td>
                <td><?= $this->Number->format($recording->recType) ?></td>
                <td><?= h($recording->recIp) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $recording->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $recording->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $recording->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recording->id)]) ?>
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
