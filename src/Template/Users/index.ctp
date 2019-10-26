<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
$this->assign('title', 'User Management');

echo $this->Html->css("/vendor/sbadmin/datatables/dataTables.bootstrap4.min.css");
echo $this->Html->script('/vendor/sbadmin/datatables/jquery.dataTables.min.js');
echo $this->Html->script('/vendor/sbadmin/datatables/dataTables.bootstrap4.min.js');
echo $this->Html->script('sbadmin2/demo/datatables-demo.js');
?>
<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a><?= $this->Html->link('Dashboard', ['controller' => 'Pages', 'action' => 'index']) ?></a>
        </li>
        <li class="breadcrumb-item">User Management</li>
    </ol>

    <h1 class="h3 mb-2 text-gray-800"><?= __('User Management') ?></h1>
    <p class="mb-4"><br>
        This page showing all users available in this system.
        <br><br>
        Click to <?php echo $this->Html->link(__('Add new user'), ['action' => 'add']); ?>.
        <br><br>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $this->Number->format($user->id) ?></td>
                            <td><?= h($user->username) ?></td>
                            <td class="actions">
                                <?php if (($this->request->getSession()->read('Auth.User')['id'] == 1) ||
                                    ($this->request->getSession()->read('Auth.User')['id'] == $user->id)) {
                                    echo $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]);
                                } ?>
                                <?php if ($user->id != 1 && $user->id == $this->request->getSession()->read('Auth.User')['id']) {
                                    echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id],
                                        ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]);}?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
