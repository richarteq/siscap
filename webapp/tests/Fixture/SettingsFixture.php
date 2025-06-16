<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SettingsFixture
 *
 */
class SettingsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Código de propiedades', 'autoIncrement' => true, 'precision' => null],
        'sendEmail' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '¿Enviar correos electrónicos?', 'precision' => null],
        'sendEmailUserAdd' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '¿Enviar correos electrónicos al agregar usuario?', 'precision' => null],
        'sendEmailUserEdit' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '¿Enviar correos electrónicos al editar usuario?', 'precision' => null],
        'sendEmailUserDisabled' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '¿Enviar correos electrónicos al desativar usuario?', 'precision' => null],
        'sendEmailCourseAdd' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '¿Enviar correos electrónicos al agregar curso?', 'precision' => null],
        'sendEmailInstructorAdd' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '¿Enviar correos electrónicos al agregar instructor?', 'precision' => null],
        'sendEmailParticipantAdd' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '¿Enviar correos electrónicos al agregar participantes a un curso?', 'precision' => null],
        'sendEmailParticipantsComunicate' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '¿Enviar correos electrónicos a participantes?', 'precision' => null],
        'folder' => ['type' => 'string', 'length' => 250, 'null' => false, 'default' => '/home/siscap/dlince_siscap_folder/', 'collate' => 'latin1_swedish_ci', 'comment' => 'Dirección al directorio de los archivos subidos', 'precision' => null, 'fixed' => null],
        'typeFiles' => ['type' => 'string', 'length' => 250, 'null' => false, 'default' => '\'txt\', \'pdf\', \'zip\', \'rar\', \'7zip\', \'jpg\', \'gif\', \'jpeg\', \'png\', \'doc\', \'docx\', \'xls\', \'xlsx\', \'ppt\', \'pptx\', \'odt\', \'ods\', \'odp\'', 'collate' => 'latin1_swedish_ci', 'comment' => 'Tipos de archivos aprobados en las subídas', 'precision' => null, 'fixed' => null],
        'typeBanners' => ['type' => 'string', 'length' => 250, 'null' => false, 'default' => '\'jpg\', \'gif\', \'jpeg\', \'png\'', 'collate' => 'latin1_swedish_ci', 'comment' => 'Tipos de archivos para pancartas aprobados en las subídas', 'precision' => null, 'fixed' => null],
        'limitsTime' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '0,30,45,60,900,120', 'collate' => 'latin1_swedish_ci', 'comment' => 'Tiempos límites disponibles para rendir evaluaciones', 'precision' => null, 'fixed' => null],
        'maxSizeFiles' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => '5242880', 'collate' => 'latin1_swedish_ci', 'comment' => 'Máximo tamaño para subida de archivos en Kilobytes', 'precision' => null, 'fixed' => null],
        'maxSizeBanners' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => '150000', 'collate' => 'latin1_swedish_ci', 'comment' => 'Máximo tamaño para subida de pancartas en Kilobytes', 'precision' => null, 'fixed' => null],
        'emailFrom' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => 'info@dlince.com', 'collate' => 'latin1_swedish_ci', 'comment' => 'Correo electrónico que envía los mensajes', 'precision' => null, 'fixed' => null],
        'nameEmailFrom' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => 'DLince - Info', 'collate' => 'latin1_swedish_ci', 'comment' => 'Nombre del correo electrónico que envía los mensajes', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Fecha de creación de las configuraciones', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'Fecha de modificación de las configuraciones', 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'Último usuario que edito las configuraciones', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
            'sendEmail' => 1,
            'sendEmailUserAdd' => 1,
            'sendEmailUserEdit' => 1,
            'sendEmailUserDisabled' => 1,
            'sendEmailCourseAdd' => 1,
            'sendEmailInstructorAdd' => 1,
            'sendEmailParticipantAdd' => 1,
            'sendEmailParticipantsComunicate' => 1,
            'folder' => 'Lorem ipsum dolor sit amet',
            'typeFiles' => 'Lorem ipsum dolor sit amet',
            'typeBanners' => 'Lorem ipsum dolor sit amet',
            'limitsTime' => 'Lorem ipsum dolor sit amet',
            'maxSizeFiles' => 'Lorem ipsum dolor ',
            'maxSizeBanners' => 'Lorem ipsum dolor ',
            'emailFrom' => 'Lorem ipsum dolor sit amet',
            'nameEmailFrom' => 'Lorem ipsum dolor sit amet',
            'created' => '2017-10-15 12:43:43',
            'modified' => '2017-10-15 12:43:43',
            'user_id' => 1
        ],
    ];
}
