<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Settings Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Setting get($primaryKey, $options = [])
 * @method \App\Model\Entity\Setting newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Setting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Setting|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Setting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Setting[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Setting findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SettingsTable extends Table
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

        $this->setTable('settings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->boolean('sendEmail')
            ->requirePresence('sendEmail', 'create')
            ->notEmpty('sendEmail');

        $validator
            ->boolean('sendEmailUserAdd')
            ->requirePresence('sendEmailUserAdd', 'create')
            ->notEmpty('sendEmailUserAdd');

        $validator
            ->boolean('sendEmailUserEdit')
            ->requirePresence('sendEmailUserEdit', 'create')
            ->notEmpty('sendEmailUserEdit');

        $validator
            ->boolean('sendEmailUserDisabled')
            ->requirePresence('sendEmailUserDisabled', 'create')
            ->notEmpty('sendEmailUserDisabled');

        $validator
            ->boolean('sendEmailCourseAdd')
            ->requirePresence('sendEmailCourseAdd', 'create')
            ->notEmpty('sendEmailCourseAdd');

        $validator
            ->boolean('sendEmailInstructorAdd')
            ->requirePresence('sendEmailInstructorAdd', 'create')
            ->notEmpty('sendEmailInstructorAdd');

        $validator
            ->boolean('sendEmailParticipantAdd')
            ->requirePresence('sendEmailParticipantAdd', 'create')
            ->notEmpty('sendEmailParticipantAdd');

        $validator
            ->boolean('sendEmailParticipantsComunicate')
            ->requirePresence('sendEmailParticipantsComunicate', 'create')
            ->notEmpty('sendEmailParticipantsComunicate');

        $validator
            ->requirePresence('folder', 'create')
            ->notEmpty('folder');

        $validator
            ->requirePresence('typeFiles', 'create')
            ->notEmpty('typeFiles');

        $validator
            ->requirePresence('typeBanners', 'create')
            ->notEmpty('typeBanners');

        $validator
            ->requirePresence('limitsTime', 'create')
            ->notEmpty('limitsTime');

        $validator
            ->requirePresence('maxSizeFiles', 'create')
            ->notEmpty('maxSizeFiles');

        $validator
            ->requirePresence('maxSizeBanners', 'create')
            ->notEmpty('maxSizeBanners');

        $validator
            ->email('emailFrom')
            ->requirePresence('emailFrom', 'create')
            ->notEmpty('emailFrom');

        $validator
            ->requirePresence('nameEmailFrom', 'create')
            ->notEmpty('nameEmailFrom');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
