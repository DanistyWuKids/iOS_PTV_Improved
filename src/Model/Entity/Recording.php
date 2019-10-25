<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Recording Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $recTime
 * @property int $recTriggered
 * @property int $recType
 * @property string $recIp
 */
class Recording extends Entity
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
        'recTime' => true,
        'recTriggered' => true,
        'recType' => true,
        'recIp' => true
    ];
}
