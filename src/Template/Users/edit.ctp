<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->assign('title', 'Edit User');

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

?>

<h1 class="h3 mb-2 text-gray-800"><?= __('编辑用户信息') ?></h1>
<p class="mb-4"><br>
    Other Actions:<br>
    <?php
    echo $this->Html->link('Add New User', ['action' => 'add'], ['style' => 'padding:3%']);
    if ($user->id != 1) {
        echo $this->Form->postLink('Delete Current User', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure to delete current user?'), 'style' => 'padding:3%']);
    };
    ?><br><br><br>
</p>

<div class="row">
    <div class="card shadow mb-4" style="width: 90%;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= __('Edit User') ?></h6>
        </div>
        <div class="card-body">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <table>
                    <tr>
                        <td>User Name:</td>
                        <td><?= $this->Form->control('username', ['label' => '', 'disabled' => 'false', 'required' => 'true', 'type' => 'text']); ?></td>
                    </tr>
                    <tr>
                        <td>New Password:</td>
                        <td><?= $this->Form->control('password', ['label' => '', 'disabled' => 'false', 'required' => 'true', 'type' => 'password']); ?></td>
                    </tr>
                </table>
            </fieldset>
            <?= $this->Form->button('Submit',['class'=>'btn btn-primary']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
