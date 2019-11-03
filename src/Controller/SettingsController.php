<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

/**
 * Settings Controller
 *
 * @property \App\Model\Table\SettingsTable $Settings
 *
 * @method \App\Model\Entity\Setting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SettingsController extends AppController
{
    public function editpath(){
        $photopath = $this->Settings->get(1,['contain'=>[]]);
        $videopath = $this->Settings->get(2,['contain'=>[]]);
        $path = $this->Settings->get(3,['contain'=>[]]);
        if ($this->request->is(['patch','post','put'])){
            $path->attribute=$this->request->getData()['path'];
            $photopath->attribute=$this->request->getData()['path'].'/Pictures';
            $videopath->attribute=$this->request->getData()['path'].'/Videos';
            if($this->Settings->save($photopath) && $this->Settings->save($videopath)){
                shell_exec('ln -sfn /var/www/html/webroot/Pictures '.$this->request->getData()['path']);
                shell_exec('ln -sfn /var/www/html/webroot/Videos '.$this->request->getData()['path']);
                $this->Flash->success(__('New path has been saved correctly, please wait for moment to make changes effect.'));
                return $this->redirect($this->referer());
            }
        }
        $this->set(compact('photopath'));
        $this->set(compact('videopath'));
        $this->set(compact('path'));
    }

    public function workingtime(){
        $Mon=$this->Settings->get(11,['contain'=>[]]);
        $Tue=$this->Settings->get(12,['contain'=>[]]);
        $Wed=$this->Settings->get(13,['contain'=>[]]);
        $Thu=$this->Settings->get(14,['contain'=>[]]);
        $Fri=$this->Settings->get(15,['contain'=>[]]);
        $Sat=$this->Settings->get(16,['contain'=>[]]);
        $Sun=$this->Settings->get(17,['contain'=>[]]);

        if ($this->request->is(['patch','post','put'])){
            $thisdata=$this->request->getData();
            $thisMon = $thisdata['mon0'];
            $thisTue = $thisdata['tue0'];
            $thisWed = $thisdata['wed0'];
            $thisThu = $thisdata['thu0'];
            $thisFri = $thisdata['fri0'];
            $thisSat = $thisdata['sat0'];
            $thisSun = $thisdata['sun0'];
            for($i=1;$i<24;$i++) {
                $thisMon=$thisMon.$thisdata['mon'.$i];
                $thisTue=$thisTue.$thisdata['tue'.$i];
                $thisWed=$thisWed.$thisdata['wed'.$i];
                $thisThu=$thisThu.$thisdata['thu'.$i];
                $thisFri=$thisFri.$thisdata['fri'.$i];
                $thisSat=$thisSat.$thisdata['sat'.$i];
                $thisSun=$thisSun.$thisdata['sun'.$i];
            }
            $Mon->attribute=$thisMon;
            $Tue->attribute=$thisTue;
            $Wed->attribute=$thisWed;
            $Thu->attribute=$thisThu;
            $Fri->attribute=$thisFri;
            $Sat->attribute=$thisSat;
            $Sun->attribute=$thisSun;

            if($this->Settings->save($Mon) && $this->Settings->save($Tue)&& $this->Settings->save($Wed)&& $this->Settings->save($Thu)
                && $this->Settings->save($Fri)&& $this->Settings->save($Sat)&& $this->Settings->save($Sun)){
                $this->Flash->success(__('New working time has been set.'));
                return $this->redirect(['controller'=>'Pages','action'=>'home']);
            }
        }
        $this->set('Mon',$Mon);
        $this->set('Tue',$Tue);
        $this->set('Wed',$Wed);
        $this->set('Thu',$Thu);
        $this->set('Fri',$Fri);
        $this->set('Sat',$Sat);
        $this->set('Sun',$Sun);
    }

    public function changeState(){
        $workingstate = $this->Settings->get(4,['contain'=>[]]);
        if ($workingstate->attribute == "1"){
            $workingstate->attribute=0;
            if ($this->Settings->save($workingstate)){
                $this->Flash->warning(__('Sensor is now inactive...'));
            }
        } else{
            $workingstate->attribute=1;
            if ($this->Settings->save($workingstate)){
                $this->Flash->success(__('Sensor is now activated...'));
            }
        }
        return $this->redirect($this->referer());
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow([]);
    }
}
