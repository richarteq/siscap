<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ParticipantsFixture
 *
 */
class ParticipantsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Código del participante', 'autoIncrement' => true, 'precision' => null],
        'student_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Código del estudiante que participa en el curso', 'precision' => null, 'autoIncrement' => null],
        'course_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Código del curso la que participa', 'precision' => null, 'autoIncrement' => null],
        'state' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => 'Estado Activo/Inactivo del ingreso. \'0\' para Inactivo y \'1\' para Activo. Por defecto es Activo', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => 'Fecha y hora de creación del participante', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => 'Fecha y hora de la ultima actualización', 'precision' => null],
        '_indexes' => [
            'student_id' => ['type' => 'index', 'columns' => ['student_id'], 'length' => []],
            'course_id' => ['type' => 'index', 'columns' => ['course_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'participants_ibfk_1' => ['type' => 'foreign', 'columns' => ['student_id'], 'references' => ['students', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'participants_ibfk_2' => ['type' => 'foreign', 'columns' => ['course_id'], 'references' => ['courses', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'student_id' => 1,
            'course_id' => 1,
            'state' => 1,
            'created' => '2017-06-28 16:08:49',
            'modified' => '2017-06-28 16:08:49'
        ],
    ];
}
