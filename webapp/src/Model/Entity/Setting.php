<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Setting Entity
 *
 * @property int $id
 * @property bool $sendEmail
 * @property bool $sendEmailUserAdd
 * @property bool $sendEmailUserEdit
 * @property bool $sendEmailUserDisabled
 * @property bool $sendEmailCourseAdd
 * @property bool $sendEmailInstructorAdd
 * @property bool $sendEmailParticipantAdd
 * @property bool $sendEmailParticipantsComunicate
 * @property string $folder
 * @property string $typeFiles
 * @property string $typeBanners
 * @property string $limitsTime
 * @property string $maxSizeFiles
 * @property string $maxSizeBanners
 * @property string $emailFrom
 * @property string $nameEmailFrom
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 *
 * @property \App\Model\Entity\User $user
 */
class Setting extends Entity
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
