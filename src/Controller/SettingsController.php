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
        if ($this->request->is(['patch','post','put'])){
            $photopath->attribute=$this->request->getData()['photopath'];
            $videopath->attribute=$this->request->getData()['videopath'];
            if($this->Settings->save($photopath) && $this->Settings->save($videopath)){
                $this->Flash->success(__('New path has been saved correctly, please wait for moment to make changes effect.'));
                return $this->redirect($this->referer());
            }
        }
        $this->set(compact('photopath'));
        $this->set(compact('videopath'));
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

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow([]);
    }
}
