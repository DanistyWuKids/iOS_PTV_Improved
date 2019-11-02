<?php
$this->layout=false;
$this->assign('title', 'View Recording');
$filename=$recording->recTime->i18nFormat('yyyy-MM-dd HH:mm:ss');
if($recording->recType == 0){
    echo $this->Html->image("/Pictures/".$filename.".jpg",['width'=>'100%']);
} else if ($recording->recType == 1){
    echo $this->Html->media("/Videos/".$filename.".mp4",['width'=>'100%','type'=>'video/mp4','controls','autoplay']);
}
?>
