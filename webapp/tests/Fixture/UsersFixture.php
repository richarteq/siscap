<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Código único de usuario', 'autoIncrement' => true, 'precision' => null],
        'names' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Nombres del usuario', 'precision' => null, 'fixed' => null],
        'father_surname' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Apellido paterno del usuario', 'precision' => null, 'fixed' => null],
        'mother_surname' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Apellido materno del usuario', 'precision' => null, 'fixed' => null],
        'role_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Código del rol del usuario', 'precision' => null, 'autoIncrement' => null],
        'state' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => 'Estado Activo/Inactivo del usuario, \'1\' para Activo y \'0\' para Inactivo', 'precision' => null],
        'email' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Correo electrónico de usuario', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Contraseña del usuario', 'precision' => null, 'fixed' => null],
        'changed' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => 'Estado Si-cambio/No-Cambio su contraseña, \'0\' para indicar que nunca se cambio y \'1\' para indicar que si se cambio', 'precision' => null],
        'when_changed' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'Fecha y hora de la ultima vez que cambio su contraseña', 'precision' => null],
        'firm' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Firma del usuario', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => 'Fecha de creación del usuario', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => 'Fecha de ultima actualización al usuario', 'precision' => null],
        '_indexes' => [
            'role_id' => ['type' => 'index', 'columns' => ['role_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'email' => ['type' => 'unique', 'columns' => ['email'], 'length' => []],
            'users_ibfk_1' => ['type' => 'foreign', 'columns' => ['role_id'], 'references' => ['roles', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'names' => 'Lorem ipsum dolor sit amet',
            'father_surname' => 'Lorem ipsum dolor sit amet',
            'mother_surname' => 'Lorem ipsum dolor sit amet',
            'role_id' => 1,
            'state' => 1,
            'email' => 'Lorem ipsum dolor sit amet',
            'password' => 'Lorem ipsum dolor sit amet',
            'changed' => 1,
            'when_changed' => '2017-06-28 16:09:38',
            'firm' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'created' => '2017-06-28 16:09:38',
            'modified' => '2017-06-28 16:09:38'
        ],
    ];
}
