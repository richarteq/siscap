<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TasksFixture
 *
 */
class TasksFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Código de la tarea', 'autoIncrement' => true, 'precision' => null],
        'course_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Referencia al código del curso', 'precision' => null, 'autoIncrement' => null],
        'start' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Fecha y hora de inicio de la tarea', 'precision' => null],
        'finish' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Fecha y hora final para entrega de la tarea', 'precision' => null],
        'title' => ['type' => 'string', 'length' => 150, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Título de la tarea', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Descripción de la tarea', 'precision' => null],
        'file' => ['type' => 'string', 'length' => 250, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => 'Archivo para considerar en la tarea', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Fecha y hora de la creación de la tarea', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Fecha y hora de la última modificación de la tarea', 'precision' => null],
        'state' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => 'Estado activo de la tarea', 'precision' => null],
        '_indexes' => [
            'course_id' => ['type' => 'index', 'columns' => ['course_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tasks_ibfk_1' => ['type' => 'foreign', 'columns' => ['course_id'], 'references' => ['courses', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'course_id' => 1,
            'start' => '2017-08-21 21:35:19',
            'finish' => '2017-08-21 21:35:19',
            'title' => 'Lorem ipsum dolor sit amet',
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'file' => 'Lorem ipsum dolor sit amet',
            'created' => '2017-08-21 21:35:19',
            'modified' => '2017-08-21 21:35:19',
            'state' => 1
        ],
    ];
}
