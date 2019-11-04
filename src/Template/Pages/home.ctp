<?php
$this->assign('title','Dashboard');
use Cake\ORM\TableRegistry;
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2" style="max-height: 100px;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Incidents Static:</div>
                        <?php $monthly=TableRegistry::getTableLocator()->get('Recordings')->find()->where(['MONTH(recTime)=MONTH(current_date())','YEAR(recTime)=YEAR(current_date())','recTriggered'=>'1'])->count()?>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">This month: <?=$monthly?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2" style="max-height: 100px;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Incidents Static:</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <?php $yearly=TableRegistry::getTableLocator()->get('Recordings')->find()->where(['YEAR(recTime)=YEAR(current_date())','recTriggered'=>'1'])->count()?>
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">This year: <?=$yearly?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-sd-card fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2" style="max-height: 100px;"">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Videos Recorded:</div>
                    <?php $videos = TableRegistry::getTableLocator()->get('Recordings')->find()->where(['recType'=>'1'])->count()?>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$videos?> Videos</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-file-video fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2" style="max-height: 100px;">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Photos Taken</div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <?php $photos=TableRegistry::getTableLocator()->get('Recordings')->find()->where(['recType'=>'0'])->count()?>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$photos?> Images</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-camera-retro fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

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

<!-- Content Row -->
<!--<div class="row">-->
<!---->
<!--    <div class="col-lg-12 mb-4">-->
<!---->
<!--        <div class="card shadow mb-4">-->
<!--            <div class="card-header py-3">-->
<!--                <h6 class="m-0 font-weight-bold text-primary">Latest Image</h6>-->
<!--            </div>-->
<!--            <div class="card-body">-->
<!--                <p>Here shows the latest captured images on this device</p>-->
<!--                <div class="text-center">-->
<!--                    --><?php //$item=TableRegistry::getTableLocator()->get('recordings')->find()->orderDesc('recTime')->first();?>
<!--                    --><?php //if ($item == null){
//                        echo $this->Html->image('sbadmin2/undraw_posting_photo.svg',['class'=>'img-fluid px-3 px-sm-4 mt-3 mb-4','style'=>'width: 25rem']);
//                    } else {
//                        echo $this->requestAction('http://'.$item['recIp'].'/recordings/poll/'.$item['id']);
//                    } ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="card shadow mb-4">-->
<!--            <div class="card-header py-3">-->
<!--                <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>-->
<!--            </div>-->
<!--            <div class="card-body">-->
<!--                <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce CSS bloat and poor page performance. Custom CSS classes are used to create custom components and custom utility classes.</p>-->
<!--                <p class="mb-0">Before working with this theme, you should become familiar with the Bootstrap framework, especially the utility classes.</p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
