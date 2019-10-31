<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recording[]|\Cake\Collection\CollectionInterface $recordings
 */

$this->assign('title', 'Recordings');

echo $this->Html->css("/vendor/sbadmin2/datatables/dataTables.bootstrap4.min.css");
echo $this->Html->script('/vendor/sbadmin2/datatables/jquery.dataTables.min.js');
echo $this->Html->script('/vendor/sbadmin2/datatables/dataTables.bootstrap4.min.js');
echo $this->Html->script('sbadmin2/demo/datatables-demo.js');
?>
<div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a><?= $this->Html->link('Dashboard', ['controller'=>'Pages','action'=>'home'])?></a></li>
        <?php if($options == null){?>
            <li class="breadcrumb-item active">Recordings</li>
        <?php }  else {?>
            <li class="breadcrumb-item">
            <a><?= $this->Html->link('Recordings', ['controller'=>'Recordings','action'=>'all'])?></a>
            </li>
            <?php if($options == 0){?>
                <li class="breadcrumb-item active">Photos</li>
            <?php } else if($options == 1){?>
                <li class="breadcrumb-item active">Videos</li>
            <?php }}?>
    </ol><br>
    <h1 class="h3 mb-2 text-gray-800"><?= __('Recordings') ?></h1>
    <p class="mb-4"><br>All recordings will be available to view from here.<br><br>
    <?php if($options != null){
        if ($options == 0){?>
        NB: This page only showing photo records.
    <?php } else if ($options == 1){?>
        NB: This page only showing video records.
    <?php }}?>
    </p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Files</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>File id</th>
                        <th>Sensor Status</th>
                        <th>File Format</th>
                        <th>Record Time</th>
                        <th>Store Server</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>File id</th>
                        <th>Sensor Status</th>
                        <th>File Format</th>
                        <th>Record Time</th>
                        <th>Store Server</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($recordings as $recording): ?>
                        <tr>
                            <td><?= $this->Number->format($recording->id) ?></td>
                            <td><?php if ($recording->recTriggered==1) { echo h("Triggered"); }
                                else{ echo h("Inactive"); } ?>
                            </td>
                            <td><?php if ($recording->recType==1) { echo h("Video"); }
                                else{ echo h("Image"); } ?>
                            </td>
                            <td><?= h($recording->recTime) ?></td>
                            <td><?= h($recording->recIp)?></td>
                            <td class="actions">
                                <?= $this->Html->link('View', 'http://'.$recording->recIp.'/recordings/view'.$recording->id) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $recording->id], ['confirm' => __('Are you sure to delete this file?', $recording->id)]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
