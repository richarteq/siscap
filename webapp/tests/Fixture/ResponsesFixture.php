<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResponsesFixture
 *
 */
class ResponsesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Código de la respuesta', 'autoIncrement' => true, 'precision' => null],
        'question_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Referencia a código de la pregunta', 'precision' => null, 'autoIncrement' => null],
        'value' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Valor de la respuesta', 'precision' => null, 'autoIncrement' => null],
        'participant_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Referencia al código del participante', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Fecha y hora de creación de la respuesta', 'precision' => null],
        '_indexes' => [
            'question_id' => ['type' => 'index', 'columns' => ['question_id'], 'length' => []],
            'participant_id' => ['type' => 'index', 'columns' => ['participant_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'responses_ibfk_1' => ['type' => 'foreign', 'columns' => ['question_id'], 'references' => ['criterions', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'responses_ibfk_2' => ['type' => 'foreign', 'columns' => ['participant_id'], 'references' => ['participants', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'question_id' => 1,
            'value' => 1,
            'participant_id' => 1,
            'created' => '2017-08-21 21:36:34'
        ],
    ];
}
