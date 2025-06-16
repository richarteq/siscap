<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Instructor Entity
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $course_id
 * @property bool $state
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Teacher $teacher
 * @property \App\Model\Entity\Course $course
 */
class Instructor extends Entity
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

    
}
