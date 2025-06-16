<?php
namespace App\Model\Entity;

//DLince
use Cake\Auth\DefaultPasswordHasher;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $names
 * @property string $father_surname
 * @property string $mother_surname
 * @property int $role_id
 * @property bool $state
 * @property string $email
 * @property string $password
 * @property bool $changed
 * @property \Cake\I18n\FrozenTime $when_changed
 * @property string $firm
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Course[] $courses
 * @property \App\Model\Entity\Message[] $messages
 * @property \App\Model\Entity\Recipient[] $recipients
 * @property \App\Model\Entity\Student[] $students
 * @property \App\Model\Entity\Teacher[] $teachers
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

	//DLince
	protected function _setPassword($value)
  {
    $hasher = new DefaultPasswordHasher();
    return $hasher->hash($value);
  }

  //DLince
  /**/
	protected $_virtual = ['full_name','full_name_and_email'];
  protected function _getFullName() {
    return $this->_properties['names'].' '.$this->_properties['father_surname'];
  }
  protected function _getFullNameAndEmail() {
    return $this->_properties['names'].' '.$this->_properties['father_surname'].' ('.$this->_properties['email'].') ';
  }
	/**/
}
