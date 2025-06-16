<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Course Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $quota
 * @property int $state_id
 * @property \Cake\I18n\FrozenDate $start
 * @property \Cake\I18n\FrozenDate $finish
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\File[] $files
 * @property \App\Model\Entity\Instructor[] $instructors
 * @property \App\Model\Entity\Participant[] $participants
 * @property \App\Model\Entity\Poll[] $polls
 * @property \App\Model\Entity\Video[] $videos
 */
class Course extends Entity
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
