<?php
$this->assign('title', 'Set Working Time');

echo $this->Html->css("/vendor/sbadmin2/datatables/dataTables.bootstrap4.min.css");
echo $this->Html->script('/vendor/sbadmin2/datatables/jquery.dataTables.min.js');
echo $this->Html->script('/vendor/sbadmin2/datatables/dataTables.bootstrap4.min.js');
//echo $this->Html->script('sbadmin2/demo/datatables-demo.js');
?>
<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a><?= $this->Html->link('Dashboard', ['controller' => 'Pages', 'action' => 'index']) ?></a>
        </li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active">Set Working time</li>
    </ol>

    <h1 class="h3 mb-2 text-gray-800"><?= __('Working time') ?></h1>
    <p class="mb-4"><br>
        You can modify the alarmed time by selecting following box.
        <br><br>
    </p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Time selection</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                        <th>Sun</th>
                    </tr>
                    </thead>
                    <?= $this->Form->create() ?>
                    <?php for($i=0;$i<24;$i++){?>
                    <tr>
                        <td style="text-align:center"><?= $i?>:00-<?= $i+1?>:00</td>
                        <td style="text-align:center"><?= $this->Form->checkbox('mon'.$i,['label'=>'']);?></td>
                        <td style="text-align:center"><?= $this->Form->checkbox('tue'.$i,['label'=>'']);?></td>
                        <td style="text-align:center"><?= $this->Form->checkbox('wed'.$i,['label'=>'']);?></td>
                        <td style="text-align:center"><?= $this->Form->checkbox('thu'.$i,['label'=>'']);?></td>
                        <td style="text-align:center"><?= $this->Form->checkbox('fri'.$i,['label'=>'']);?></td>
                        <td style="text-align:center"><?= $this->Form->checkbox('sat'.$i,['label'=>'']);?></td>
                        <td style="text-align:center"><?= $this->Form->checkbox('sun'.$i,['label'=>'']);?></td>
                    </tr>
                    <?php }?>
                </table>
                    <?= $this->Form->button('Submit',['class'=>'btn btn-primary']) ?>
                    <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
