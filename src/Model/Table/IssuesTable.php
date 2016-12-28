<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Issues Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Requests
 *
 * @method \App\Model\Entity\Issue get($primaryKey, $options = [])
 * @method \App\Model\Entity\Issue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Issue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Issue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Issue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Issue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Issue findOrCreate($search, callable $callback = null)
 */
class IssuesTable extends Table
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

        $this->table('issues');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsToMany('Requests', [
            'foreignKey' => 'issue_id',
            'targetForeignKey' => 'request_id',
            'joinTable' => 'requests_issues'
        ]);
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
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['id']));

        return $rules;
    }
}
