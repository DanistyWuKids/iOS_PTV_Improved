<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;

/**
 * Recordings Controller
 *
 * @property \App\Model\Table\RecordingsTable $Recordings
 *
 * @method \App\Model\Entity\Recording[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RecordingsController extends AppController
{
    /**
     * All method
     *
     * @param string|null $options Selection of video/photos
     * @return \Cake\Http\Response|null
     */
    public function index($options = null)
    {
        $photopath = TableRegistry::getTableLocator()->get('Settings')->get(1)->toArray()['attribute'];
        $videopath = TableRegistry::getTableLocator()->get('Settings')->get(2)->toArray()['attribute'];
        $photos = new Folder();
        $photos->cd($photopath);
        $videos = new Folder();
        $videos->cd($videopath);

        if ($options == null){
            $nums = $this->Recordings->find()->count();
            $recordings = $this->Recordings->find()->toArray();
        } else {
            if ($options == 0) {
                $nums = $this->Recordings->find()->where(['recType' => '0'])->count();
                $recordings = $this->Recordings->find()->where(['recType' => '0'])->toArray();
            } else if ($options == 1) {
                $nums = $this->Recordings->find()->where(['recType' => '1'])->count();
                $recordings = $this->Recordings->find()->where(['recType' => '1'])->toArray();
            }
        }
        $this->set(compact('nums'));
        $this->set(compact('recordings'));
        $this->set(compact('options'));
    }

    /**
     * View method
     *
     * @param string|null $id Recording id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recording = $this->Recordings->get($id, [
            'contain' => []
        ]);

        $this->set('recording', $recording);
    }

    public function poll($id = null)
    {
        $recording = $this->Recordings->get($id, [
            'contain' => []
        ]);

        $this->set('recording', $recording);
    }

    /**
     * Delete method
     *
     * @param string|null $id Recording id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recording = $this->Recordings->get($id);
        if ($this->Recordings->delete($recording)) {
            $this->Flash->success(__('The recording has been deleted.'));
        } else {
            $this->Flash->error(__('The recording could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['view','photo']);
    }
}
