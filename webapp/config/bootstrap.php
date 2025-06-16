<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// You can remove this if you are confident that your PHP version is sufficient.
if (version_compare(PHP_VERSION, '5.6.0') < 0) {
    trigger_error('Your PHP version must be equal or higher than 5.6.0 to use CakePHP.', E_USER_ERROR);
}

/*
 *  You can remove this if you are confident you have intl installed.
 */
if (!extension_loaded('intl')) {
    trigger_error('You must enable the intl extension to use CakePHP.', E_USER_ERROR);
}

/*
 * You can remove this if you are confident you have mbstring installed.
 */
if (!extension_loaded('mbstring')) {
    trigger_error('You must enable the mbstring extension to use CakePHP.', E_USER_ERROR);
}

/*
 * Configure paths required to find CakePHP + general filepath
 * constants
 */
require __DIR__ . '/paths.php';

/*
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\Utility\Inflector;
use Cake\Utility\Security;

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

/*
 * Load an environment local configuration file.
 * You can use a file like app_local.php to provide local overrides to your
 * shared configuration.
 */
//Configure::load('app_local', 'default');

/*
 * When debug = true the metadata cache should only last
 * for a short time.
 */
if (Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+2 minutes');
    Configure::write('Cache._cake_core_.duration', '+2 minutes');
}

/*
 * Set server timezone to UTC. You can change it to another timezone of your
 * choice but using UTC makes time calculations / conversions easier.
 */
//date_default_timezone_set('UTC');

//DLince
date_default_timezone_set('America/Lima');

/*
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/*
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

/*
 * Register application error and exception handlers.
 */
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new ErrorHandler(Configure::read('Error')))->register();
}

/*
 * Include the CLI bootstrap overrides.
 */
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
    }
    unset($httpHost, $s);
}

Cache::setConfig(Configure::consume('Cache'));
ConnectionManager::setConfig(Configure::consume('Datasources'));
Email::setConfigTransport(Configure::consume('EmailTransport'));
Email::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::salt(Configure::consume('Security.salt'));

/*
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
//Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/*
 * Setup detectors for mobile and tablet.
 */
Request::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
Request::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

/*
 * Enable immutable time objects in the ORM.
 *
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link http://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
Type::build('time')
    ->useImmutable();
Type::build('date')
    ->useImmutable();
Type::build('datetime')
    ->useImmutable();
Type::build('timestamp')
    ->useImmutable();

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
//Inflector::rules('irregular', ['red' => 'redlings']);
//Inflector::rules('uninflected', ['dontinflectme']);
//Inflector::rules('transliteration', ['/å/' => 'aa']);

/*
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on Plugin to use more
 * advanced ways of loading plugins
 *
 * Plugin::loadAll(); // Loads all plugins at once
 * Plugin::load('Migrations'); //Loads a single plugin named Migrations
 *
 */

/*
 * Only try to load DebugKit in development mode
 * Debug Kit should not be installed on a production system
 */
if (Configure::read('debug')) {
    Plugin::load('DebugKit', ['bootstrap' => true]);
}

//Plugin::load('DebugKit');

//DLince-Icons
$sizeIcon = '32';
Configure::write('DLince', 
[
    'icon' => [
		'active'        => 'dlince/icons/'.$sizeIcon.'/sign-check-icon.png',
		'bloqued'       => 'dlince/icons/'.$sizeIcon.'/sign-ban-icon.png',
		'view'          => 'dlince/icons/'.$sizeIcon.'/Favorities-icon.png',
		'edit'          => 'dlince/icons/'.$sizeIcon.'/pencil-icon.png',
		'delete'        => 'dlince/icons/'.$sizeIcon.'/delete-icon.png',
    'file'          => 'dlince/icons/'.$sizeIcon.'/Files-icon.png',
    'administrator' => 'dlince/icons/'.$sizeIcon.'/admin-privilege-icon.png',
    'teacher'       => 'dlince/icons/'.$sizeIcon.'/Teachers-icon.png',
    'student'       => 'dlince/icons/'.$sizeIcon.'/Student-3-icon.png',
    'user'          => 'dlince/icons/'.$sizeIcon.'/User-blue-icon.png',
    'video'         => 'dlince/icons/'.$sizeIcon.'/video-camera-icon.png',
    'vimeo'         => 'dlince/icons/'.$sizeIcon.'/vimeo-icon.png',
    'youtube'       => 'dlince/icons/'.$sizeIcon.'/youtube-icon.png',
    /* <extensiones */
    'txt'           => 'dlince/icons/'.$sizeIcon.'/txt-icon.png',
    'rar'           => 'dlince/icons/'.$sizeIcon.'/Folder-RAR-icon.png',
    '7zip'          => 'dlince/icons/'.$sizeIcon.'/Apps-7-Zip-icon.png',
    'zip'           => 'dlince/icons/'.$sizeIcon.'/Mimetypes-zip-icon.png',
    'jpeg'          => 'dlince/icons/'.$sizeIcon.'/jpeg-icon.png',
    'gif'           => 'dlince/icons/'.$sizeIcon.'/gif-icon.png',
    'png'           => 'dlince/icons/'.$sizeIcon.'/png-icon.png',
    'jpg'           => 'dlince/icons/'.$sizeIcon.'/Filetype-jpg-icon.png',
    'powerpoint'    => 'dlince/icons/'.$sizeIcon.'/PowerPoint-icon.png',
    'excel'         => 'dlince/icons/'.$sizeIcon.'/Excel-icon.png',
    'word'          => 'dlince/icons/'.$sizeIcon.'/Word-icon.png',
    'impress'       => 'dlince/icons/'.$sizeIcon.'/libreoffice-impress-icon.png',
    'calc'          => 'dlince/icons/'.$sizeIcon.'/Apps-Libreoffice-Calc-icon.png',
    'writer'        => 'dlince/icons/'.$sizeIcon.'/libreoffice-writer-icon.png',
    'pdf'           => 'dlince/icons/'.$sizeIcon.'/pdf-icon.png',
    /* extensiones> */
    'download'      => 'dlince/icons/'.$sizeIcon.'/Files-Download-File-icon.png',
    'save'          => 'dlince/icons/'.$sizeIcon.'/Save-icon.png',
    'login'         => 'dlince/icons/'.$sizeIcon.'/Login-icon.png',
    /**/
    'correct'       => 'dlince/icons/'.$sizeIcon.'/App-clean-icon.png',
    'ok'          	=> 'dlince/icons/'.$sizeIcon.'/Ok-icon.png',
    'processok'     => 'dlince/icons/'.$sizeIcon.'/process-accept-icon.png',
    'loading'       => 'dlince/icons/'.$sizeIcon.'/loading-icon',
    'processadd'    => 'dlince/icons/'.$sizeIcon.'/process-add-icon.png',
    'add'          	=> 'dlince/icons/'.$sizeIcon.'/add-icon.png',
    /**/
	],
    'icon16' => [
			'active'        => 'dlince/icons/16/sign-check-icon.png',
			'bloqued'       => 'dlince/icons/16/sign-ban-icon.png',
			'view'          => 'dlince/icons/16/Favorities-icon.png',
			'edit'          => 'dlince/icons/16/pencil-icon.png',
			'delete'        => 'dlince/icons/16/delete-icon.png',
		  'file'          => 'dlince/icons/16/Files-icon.png',
		  'administrator' => 'dlince/icons/16/admin-privilege-icon.png',
		  'teacher'       => 'dlince/icons/16/Teachers-icon.png',
		  'student'       => 'dlince/icons/16/Student-3-icon.png',
		  'user'          => 'dlince/icons/16/User-blue-icon.png',
		  'youtube'       => 'dlince/icons/16/youtube-icon.png',
		  'vimeo'         => 'dlince/icons/16/vimeo-icon.png',
		  'video'         => 'dlince/icons/16/video-camera-icon.png',
	],
    'icon24' => [
			'active'        => 'dlince/icons/24/sign-check-icon.png',
			'bloqued'       => 'dlince/icons/24/sign-ban-icon.png',
			'view'          => 'dlince/icons/24/Favorities-icon.png',
			'edit'          => 'dlince/icons/24/pencil-icon.png',
			'delete'        => 'dlince/icons/24/delete-icon.png',
		  'file'          => 'dlince/icons/24/Files-icon.png',
		  'administrator' => 'dlince/icons/24/admin-privilege-icon.png',
		  'teacher'       => 'dlince/icons/24/Teachers-icon.png',
		  'student'       => 'dlince/icons/24/Student-3-icon.png',
		  'user'          => 'dlince/icons/24/User-blue-icon.png',
		  'youtube'       => 'dlince/icons/24/youtube-icon.png',
		  'vimeo'         => 'dlince/icons/24/vimeo-icon.png',
		  'video'         => 'dlince/icons/24/video-camera-icon.png',
	],
    'icon256' => [
      'video'           => 'dlince/icons/256/Movies-icon.png',
	],
]
);

/**/
Plugin::load('CakeCaptcha', ['routes' => true]);

