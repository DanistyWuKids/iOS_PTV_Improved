<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Add New User');
?>

<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a><?= $this->Html->link('Dashboard', ['controller' => 'Pages', 'action' => 'index']) ?></a>
        </li>
        <li class="breadcrumb-item">
            <a><?= $this->Html->link('Manage Users', ['controller' => 'Users', 'action' => 'index']) ?></a></li>
        <li class="breadcrumb-item active">Add new user</li>
    </ol>

    <div class="container">
        <h1>Add new user</h1><br>
        <p>Please fill up this form to create a new user.</p>
    </div>
    <br>
    <div class="card mb-0" style="width: 100%;">
        <div class="card-header">
            <i class="fas fa-clipboard-check"></i>New user form
        </div>
        <div class="card-body" style="width: 100%;">
            <div class="table-responsive">
                <?= $this->Form->create($user) ?>
                <?= $this->Form->control('username', array('label' => 'New Username', 'required' => 'true', 'class' => 'form-control', 'type' => 'text')); ?>
                <?= $this->Form->control('password', array('label' => 'New Password', 'required' => 'true', 'class' => 'form-control', 'type' => 'password')); ?>
                <?= $this->Form->button('Submit',array('class'=>'btn btn-primary form-control')) ?>
                <br><br>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
