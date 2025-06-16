<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Presentation Entity
 *
 * @property int $id
 * @property int $task_id
 * @property int $student_id
 * @property string $file
 * @property int $qualification
 * @property \Cake\I18n\FrozenTime $created
 * @property bool $state
 *
 * @property \App\Model\Entity\Task $task
 * @property \App\Model\Entity\Student $student
 */
class Presentation extends Entity
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
