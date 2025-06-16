<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RecipientsFixture
 *
 */
class RecipientsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Código del envió de un mensaje', 'autoIncrement' => true, 'precision' => null],
        'message_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Código del mensaje que se envía', 'precision' => null, 'autoIncrement' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Código de un usuario destinatario', 'precision' => null, 'autoIncrement' => null],
        'reviewed' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => 'Estado Revisado/NoRevisado del mensaje, \'1\' para  Revisado y \'0\' para No revisado. Por defecto es No Revisado', 'precision' => null],
        'favourite' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => 'Estado Favorito/NoFavorito del mensaje, \'0\' para No favorito y \'1\' para Favorito. Por defecto No es favorito', 'precision' => null],
        'trash' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => 'Estado Basurero/NoBasurero, \'0\' para No esta en basurero y \'1\' para Enviar al basurero. Los mensajes del basurero son para eliminar definitivamente', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => 'Fecha y hora de creación de envío', 'precision' => null],
        '_indexes' => [
            'message_id' => ['type' => 'index', 'columns' => ['message_id'], 'length' => []],
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'recipients_ibfk_1' => ['type' => 'foreign', 'columns' => ['message_id'], 'references' => ['messages', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'recipients_ibfk_2' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
            'message_id' => 1,
            'user_id' => 1,
            'reviewed' => 1,
            'favourite' => 1,
            'trash' => 1,
            'created' => '2017-06-28 16:09:13'
        ],
    ];
}
