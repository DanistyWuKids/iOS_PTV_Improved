<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Recordings Model
 *
 * @method \App\Model\Entity\Recording get($primaryKey, $options = [])
 * @method \App\Model\Entity\Recording newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Recording[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Recording|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Recording saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Recording patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Recording[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Recording findOrCreate($search, callable $callback = null, $options = [])
 */
class RecordingsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('recordings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmptyString('id', null, 'create');

        $validator
            ->dateTime('recTime')
            ->requirePresence('recTime', 'create')
            ->notEmptyDateTime('recTime');

        $validator
            ->requirePresence('recTriggered', 'create')
            ->notEmptyString('recTriggered');

        $validator
            ->requirePresence('recType', 'create')
            ->notEmptyString('recType');

        $validator
            ->scalar('recIp')
            ->maxLength('recIp', 64)
            ->requirePresence('recIp', 'create')
            ->notEmptyString('recIp');

        return $validator;
    }
}
