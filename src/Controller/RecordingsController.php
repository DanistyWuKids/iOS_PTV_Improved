<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

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
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $recordings = $this->Recordings->find()->toArray();

        $this->set(compact('recordings'));
    }

    /**
     * All method
     *
     * @param string|null $options Selection of video/photos
     * @return \Cake\Http\Response|null
     */
    public function all($options = null)
    {
        $recordings = $this->Recordings->find()->toArray();

        $this->set(compact('recordings'));
        $this->set(compact('options'));
    }

    /**
     * All method
     *
     * @return \Cake\Http\Response|null
     */
    public function statics(){

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

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $recording = $this->Recordings->newEntity();
        if ($this->request->is('post')) {
            $recording = $this->Recordings->patchEntity($recording, $this->request->getData());
            if ($this->Recordings->save($recording)) {
                $this->Flash->success(__('The recording has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recording could not be saved. Please, try again.'));
        }
        $this->set(compact('recording'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Recording id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $recording = $this->Recordings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recording = $this->Recordings->patchEntity($recording, $this->request->getData());
            if ($this->Recordings->save($recording)) {
                $this->Flash->success(__('The recording has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recording could not be saved. Please, try again.'));
        }
        $this->set(compact('recording'));
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
        $this->Auth->allow([]);
    }
}
