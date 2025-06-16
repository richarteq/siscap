<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Instructors Model
 *
 * @property \App\Model\Table\TeachersTable|\Cake\ORM\Association\BelongsTo $Teachers
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\BelongsTo $Courses
 *
 * @method \App\Model\Entity\Instructor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Instructor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Instructor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Instructor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Instructor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Instructor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Instructor findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InstructorsTable extends Table
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

        $this->setTable('instructors');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Teachers', [
            'foreignKey' => 'teacher_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->boolean('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->requirePresence('course_id', array('create','update'))
            ->notEmpty('course_id');

        $validator
            ->requirePresence('teacher_id', array('create','update'))
            ->notEmpty('teacher_id');
        /*
        $validator
          ->add('teacher_id', 'validTeacher', [
                'rule' => 'isValidTeacher',
                'message' => __('Seleccione un profesor válido'),
                'provider' => 'table',
            ]);

        $validator
          ->add('course_id', 'validCourse', [
                'rule' => 'isValidCourse',
                'message' => __('Seleccione un curso válido'),
                'provider' => 'table',
            ]);
        */
        return $validator;
    }

    //DLince
    /*
    public function isValidTeacher($value, array $context)
    {
        if( $this->Teachers->findById($value) ){
          return true;
        }
        else {
          return false;
        }
    }

    //DLince
    public function isValidCourse($value, array $context)
    {
      if( $this->Courses->findById($value) ){
        return true;
      }
      else {
        return false;
      }
    }
    */

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['teacher_id'], 'Teachers'));
        $rules->add($rules->existsIn(['course_id'], 'Courses'));

        return $rules;
    }
}
