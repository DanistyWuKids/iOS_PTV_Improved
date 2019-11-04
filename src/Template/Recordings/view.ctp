<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recording $recording
 */

$this->assign('title', 'View Recording');
use Cake\ORM\TableRegistry;
?>
<div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a><?= $this->Html->link('Dashboard', ['controller' => 'Pages', 'action' => 'index']) ?></a>
        </li>
        <li class="breadcrumb-item">Recordings</li>
        <li class="breadcrumb-item active">View Recordings</li>
    </ol>

    <h1 class="h3 mb-2 text-gray-800"><?= __('View Recording') ?></h1>
    <p class="mb-4"><br>
        Your recording information will be shown here
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recordings</h6>
        </div>
        <div class="card-body">
            <?php $hostpath=$recording->recIp?>
            <?php $filename=$recording->recTime->i18nFormat('yyyy_MM_dd_HH_mm_ss')?>
            <?php if($recording->recType == 0){?>
                <?php echo $this->Html->image("/Pictures/".$filename.".jpg",['width'=>'100%'])?>
            <?php } else if ($recording->recType == 1){?>
                <?php echo $this->Html->media("/Videos/".$filename.".h264",['width'=>'100%','type'=>'video/mp4','controls','autoplay'])?>
            <?php }?>
        </div>
    </div>
</div>
