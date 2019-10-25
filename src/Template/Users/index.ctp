<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
$this->assign('title','User Management');

echo $this->Html->css("/vendor/sbadmin/datatables/dataTables.bootstrap4.min.css");
echo $this->Html->script('/vendor/sbadmin/datatables/jquery.dataTables.min.js');
echo $this->Html->script('/vendor/sbadmin/datatables/dataTables.bootstrap4.min.js');
echo $this->Html->script('sbadmin2/demo/datatables-demo.js');
?>
<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a><?= $this->Html->link('Dashboard', ['controller'=>'Pages','action'=>'index']) ?></a>
        </li>
        <li class="breadcrumb-item">User Management</li>
    </ol>

    <h1 class="h3 mb-2 text-gray-800"><?= __('User Management') ?></h1>
    <p class="mb-4"><br>
        This page showing all users available in this system<?php echo $this->Html->link(__('Add new user'), ['action' => 'add']); ?>。
        <br>You can search user in the table box.
        <br><br>


</div>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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
