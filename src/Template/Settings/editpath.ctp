<?php
$this->assign('title','Set Storage Path');

echo $this->Html->css("/vendor/sbadmin2/datatables/dataTables.bootstrap4.min.css");
echo $this->Html->script('/vendor/sbadmin2/datatables/jquery.dataTables.min.js');
echo $this->Html->script('/vendor/sbadmin2/datatables/dataTables.bootstrap4.min.js');
echo $this->Html->script('sbadmin2/demo/datatables-demo.js');
?>
<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a><?= $this->Html->link('Dashboard', ['controller' => 'Pages', 'action' => 'index']) ?></a>
        </li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Change saving path</li>
    </ol>

    <h1 class="h3 mb-2 text-gray-800"><?= __('Change saving path') ?></h1>
    <p class="mb-4"><br>
        You can modify your preference storage path at here.
        <br><br>
        Once submitted, it will take some time to move all files to new places.
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Path</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <p>Note: File path are case sensitive.</p>
                <?= $this->Form->create() ?>
                <?php echo $this->Form->control('path',['label'=>'Store path:','value'=>$path->attribute,'class'=>'form-control','required'=>'true']);?>
                <?php echo $this->Form->control('photopath',['label'=>'Current Photo Path:','disabled'=>'true','class'=>'form-control','type'=>'text','value'=>$photopath->attribute]); ?>
                <?php echo $this->Form->control('videopath',['label'=>'Current Video Path:','disabled'=>'true','class'=>'form-control','tuype'=>'text','value'=>$videopath->attribute]); ?>
                <br><br>
                <?= $this->Form->button('Submit',['class'=>'btn btn-primary']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
