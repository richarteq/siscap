<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 * @property |\Cake\ORM\Association\HasMany $Files
 * @property \App\Model\Table\MessagesTable|\Cake\ORM\Association\HasMany $Messages
 * @property |\Cake\ORM\Association\HasMany $Polls
 * @property \App\Model\Table\RecipientsTable|\Cake\ORM\Association\HasMany $Recipients
 * @property \App\Model\Table\StudentsTable|\Cake\ORM\Association\HasMany $Students
 * @property \App\Model\Table\TeachersTable|\Cake\ORM\Association\HasMany $Teachers
 * @property |\Cake\ORM\Association\HasMany $Videos
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('full_name_and_email');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Files', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Messages', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Polls', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Recipients', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Students', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Teachers', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Tasks', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Evaluations', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Questions', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Videos', [
            'foreignKey' => 'user_id'
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
          ->add('dni', [
            'minLength' => [
                'rule' => ['minLength', 8],
                'last' => true,
                'message' => __('La longitud del DNI es 8 caractéres')
            ],
            'maxLength' => [
                'rule' => ['maxLength', 8],
                'last' => true,
                'message' => __('La longitud del DNI es 8 caractéres')
            ],
            'numeric' => [
                'rule' => 'numeric',
                'message' => __('El DNI debe ser un número')
            ],
            'unique' => [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => __('Ya tenemos registrado este número de DNI')
            ]
          ])
          ->allowEmpty('dni',['create','update']);

        $validator
          ->requirePresence('names', 'create')
          ->notEmpty('names')
          ->add('names', [
            'lettersOnly' => [
                'rule' => array('custom', '/[a-zA-Z]+/'),
                'message' => __('El nombre debe contender solo letras')
            ]
          ]);

        $validator
          ->add('password', [
            'lengthBetween' => [
                'rule' => array('lengthBetween', 8, 12),
                'message' => __('La contraseña debe tener un tamaño entre 8 y 12 caracteres')
            ]
          ]);

        $validator
          ->requirePresence('father_surname', 'create')
          ->notEmpty('father_surname')
          ->add('father_surname', [
            'lettersOnly' => [
                'rule' => array('custom', '/[a-zA-Z]+/'),
                'message' => __('El apellido paterno debe contender solo letras')
            ]
          ]);

        $validator
          //->requirePresence('mother_surname', 'create')
          //->notEmpty('mother_surname')
          ->add('mother_surname', [
            'lettersOnly' => [
                'rule' => array('custom', '/[a-zA-Z]+/'),
                'message' => __('El apellido materno debe contender solo letras')
            ]
          ]);

        $validator
          ->requirePresence('role_id', 'create');

        $validator
        ->add('role_id', 'inList', [
            'rule' => ['inlist', [1,3,4]],
            'message' => 'Por favor ingrese un rol válido'
            ]);

        $validator
            ->boolean('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table','message' => __('Ya tenemos registrado este correo electrónico')]);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->boolean('changed')
            ->requirePresence('changed', 'create')
            ->notEmpty('changed');

        $validator
            ->dateTime('when_changed')
            ->allowEmpty('when_changed');

        $validator
            ->allowEmpty('firm');




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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
