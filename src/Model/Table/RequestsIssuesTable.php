<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RequestsIssues Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Requests
 * @property \Cake\ORM\Association\BelongsTo $Issues
 *
 * @method \App\Model\Entity\RequestsIssue get($primaryKey, $options = [])
 * @method \App\Model\Entity\RequestsIssue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RequestsIssue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RequestsIssue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RequestsIssue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RequestsIssue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RequestsIssue findOrCreate($search, callable $callback = null)
 */
class RequestsIssuesTable extends Table
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

        $this->table('requests_issues');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Requests', [
            'foreignKey' => 'request_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Issues', [
            'foreignKey' => 'issue_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['request_id'], 'Requests'));
        $rules->add($rules->existsIn(['issue_id'], 'Issues'));

        return $rules;
    }
}
