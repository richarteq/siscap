<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Courses Model
 *
 * @property \App\Model\Table\StatesTable|\Cake\ORM\Association\BelongsTo $States
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\FilesTable|\Cake\ORM\Association\HasMany $Files
 * @property \App\Model\Table\InstructorsTable|\Cake\ORM\Association\HasMany $Instructors
 * @property \App\Model\Table\ParticipantsTable|\Cake\ORM\Association\HasMany $Participants
 * @property \App\Model\Table\PollsTable|\Cake\ORM\Association\HasMany $Polls
 * @property \App\Model\Table\VideosTable|\Cake\ORM\Association\HasMany $Videos
 *
 * @method \App\Model\Entity\Course get($primaryKey, $options = [])
 * @method \App\Model\Entity\Course newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Course[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Course|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Course patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Course[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Course findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CoursesTable extends Table
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

        $this->setTable('courses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Files', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('Instructors', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('Participants', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('Polls', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('Videos', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('Schedules', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('Tasks', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('Evaluations', [
            'foreignKey' => 'course_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
        ->add('type', 'inList', [
            'rule' => ['inlist', [1,2,3]],
            'message' => 'Por favor ingrese un tipo de curso válido'
            ]);

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('place');

        $validator
            ->allowEmpty('destined');

        $validator
            ->allowEmpty('description');

        $validator
            ->integer('quota')
            ->requirePresence('quota', 'create')
            ->notEmpty('quota');

        $validator
            ->date('start')
            ->allowEmpty('start');

        $validator
            ->date('finish')
            ->allowEmpty('finish');

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
        $rules->add($rules->existsIn(['state_id'], 'States'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
