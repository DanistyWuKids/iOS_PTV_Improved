<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recording[]|\Cake\Collection\CollectionInterface $recordings
 */

$this->assign('title', 'Statics');

echo $this->Html->css("/vendor/sbadmin2/datatables/dataTables.bootstrap4.min.css");
echo $this->Html->script('/vendor/sbadmin2/datatables/jquery.dataTables.min.js');
echo $this->Html->script('/vendor/sbadmin2/datatables/dataTables.bootstrap4.min.js');
echo $this->Html->script('sbadmin2/demo/datatables-demo.js');
?>
<div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a><?= $this->Html->link('Dashboard', ['controller'=>'Pages','action'=>'home'])?></a></li>
        <li class="breadcrumb-item active">Recordings</li>
        <li class="breadcrumb-item active">Statics</li>
    </ol><br>
    <h1 class="h3 mb-2 text-gray-800"><?= __('Statics') ?></h1>

    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Detection Statics</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Detection Time Statics</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Morning (6am-12pm)
                    </span><br>
                        <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Afternoon (12pm-6pm)
                    </span><br>
                        <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Night (6pm-6am)
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
