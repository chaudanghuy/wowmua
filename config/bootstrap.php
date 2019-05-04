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
/**
 * Configure paths required to find CakePHP + general filepath
 * constants
 */
require __DIR__ . '/paths.php';

// Use composer to load the autoloader.
require ROOT . DS . 'vendor' . DS . 'autoload.php';

/**
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

// You can remove this if you are confident you have intl installed.
if (!extension_loaded('intl')) {
	trigger_error('You must enable the intl extension to use CakePHP.', E_USER_ERROR);
}

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
use Cake\Routing\DispatcherFactory;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
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
	die($e->getMessage() . "\n");
}

// Load an environment local configuration file.
// You can use a file like app_local.php to provide local overrides to your
// shared configuration.
//Configure::load('app_local', 'default');
// When debug = false the metadata cache should last
// for a very very long time, as we don't want
// to refresh the cache while users are doing requests.
if (!Configure::read('debug')) {
	Configure::write('Cache._cake_model_.duration', '+1 years');
	Configure::write('Cache._cake_core_.duration', '+1 years');
}

/**
 * Set server timezone to UTC. You can change it to another timezone of your
 * choice but using UTC makes time calculations / conversions easier.
 */
date_default_timezone_set('UTC');

/**
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/**
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', 'en_US');

/**
 * Register application error and exception handlers.
 */
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
	(new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
	(new ErrorHandler(Configure::read('Error')))->register();
}

// Include the CLI bootstrap overrides.
if ($isCli) {
	require __DIR__ . '/bootstrap_cli.php';
}

/**
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

Cache::config(Configure::consume('Cache'));
ConnectionManager::config(Configure::consume('Datasources'));
Email::configTransport(Configure::consume('EmailTransport'));
Email::config(Configure::consume('Email'));
Log::config(Configure::consume('Log'));
Security::salt(Configure::consume('Security.salt'));

Log::config('default', function () {
	$log = new Logger('app');
	$log->pushHandler(new StreamHandler(ROOT . DS . 'logs' . DS . 'wowmua.log'));
	return $log;
});
// Log::drop('debug');
// Log::drop('error');

/**
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
// Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/**
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

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 *
 * Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
 * Inflector::rules('irregular', ['red' => 'redlings']);
 * Inflector::rules('uninflected', ['dontinflectme']);
 * Inflector::rules('transliteration', ['/å/' => 'aa']);
 */
/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on Plugin to use more
 * advanced ways of loading plugins
 *
 * Plugin::loadAll(); // Loads all plugins at once
 * Plugin::load('Migrations'); //Loads a single plugin named Migrations
 *
 */
Plugin::load('Migrations');
Plugin::load('Bootstrap');
Plugin::load('Utils');

// Only try to load DebugKit in development mode
// Debug Kit should not be installed on a production system
if (Configure::read('debug')) {
	Plugin::load('DebugKit', ['bootstrap' => true]);
}

/**
 * Connect middleware/dispatcher filters.
 */
DispatcherFactory::add('Asset');
DispatcherFactory::add('Routing');
DispatcherFactory::add('ControllerFactory');

/**
 * Enable default locale format parsing.
 * This is needed for matching the auto-localized string output of Time() class when parsing dates.
 */
Type::build('date')->useLocaleParser();
Type::build('datetime')->useLocaleParser();

Plugin::load('WyriHaximus/MinifyHtml', ['bootstrap' => true]);

/**
 * Global
 */
Configure::write('site', $_SERVER['SERVER_NAME']);

/**
 * Frontend
 */
Configure::write('from_location', [
	"ÚC" => "ÚC",
	"NHẬT BẢN" => "NHẬT BẢN",
	"HÀN QUỐC" => "HÀN QUỐC",
	"ANH" => "ANH",
	"PHÁP" => "PHÁP",
	"ĐỨC" => "ĐỨC",
]);

Configure::write('from_en_location', [
	"AUSTRALIA" => "AUSTRALIA",
	"JAPAN" => "JAPAN",
	"KOREA" => "KOREA",
	"UNITED KINGDOM" => "UNITED KINGDOM",
	"FRANCE" => "FRANCE",
	"GERMANY" => "GERMANY",
]);

Configure::write('currency_countries', [
	'KRW' => ['KOREA', 'HÀN QUỐC'],
	'AUD' => ['AUSTRALIA', 'ÚC'],
	'JPY' => ['JAPAN', 'NHẬT BẢN'],
	'GPB' => ['UNITED KINGDOM', 'ANH'],
	'EUR' => ['FRANCE', 'PHÁP', 'GERMANY', 'ĐỨC'],
]);

Configure::write('to_location', [
	"Hồ Chí Minh (SGN)" => "Hồ Chí Minh (SGN)",
	"Hà Nội (HAN)" => "Hà Nội (HAN)",
	"Đà Nẵng (DAD)" => "Đà Nẵng (DAD)",
	"Nha Trang (CXR)" => "Nha Trang (CXR)",
	"Phú Quốc (PQC)" => "Phú Quốc (PQC)",
	"Đà Lạt (DLI)" => "Đà Lạt (DLI)",
	"Hải Phòng (HPH)" => "Hải Phòng (HPH)",
	"Vinh (VII)" => "Vinh (VII)",
	"Quy Nhơn (UIH)" => "Quy Nhơn (UIH)",
	"Thanh Hoá (THD)" => "Thanh Hoá (THD)",
	"Đồng Hới (VDH)" => "Đồng Hới (VDH)",
	"Cần Thơ (VCA)" => "Cần Thơ (VCA)",
	"Huế (HUI)" => "Huế (HUI)",
	"Chu Lai (VCL)" => "Chu Lai (VCL)",
	"Tuy Hoà (TBB)" => "Tuy Hoà (TBB)",
	"Buôn Mê Thuột (BMV)" => "Buôn Mê Thuột (BMV)",
	"Pleiku (PXU)" => "Pleiku (PXU)",
	"Côn Đảo (VCS)" => "Côn Đảo (VCS)",
	"Rạch Giá (VKG)" => "Rạch Giá (VKG)",
	"Cà Mau (CAH)" => "Cà Mau (CAH)",
	"Điện Biên (DIN)" => "Điện Biên (DIN)",
]);

/**
 * Backend
 */
Configure::write('order_statuses', [
	'UNPAID' => 'Chờ thanh toán',
	'PROCESS' => 'Đang xử lý',
	'ASSIGNEE' => 'Đã mua hàng',
	'TRANSPORT' => 'Đã về VN',
	'DELIVERY' => 'Đã giao hàng',
	'INCOMPLETE' => 'Huỷ đơn',
	'PRICE_CHANGE' => 'Hết hàng',
]);

Configure::write('order_statuses_en', [
	'UNPAID' => 'Waiting for payment',
	'PROCESS' => 'In processing',
	'ASSIGNEE' => 'Is bought',
	'TRANSPORT' => 'Arrival to Vietnam',
	'DELIVERY' => 'Delivery',
	'INCOMPLETE' => 'Cancel',
	'PRICE_CHANGE' => 'Out of stock',
]);

/**
 * Mailgun
 */
Configure::write('mailgun_test', [
	'domain' => 'sandbox44928ae2ff8d45f487fb7a76e071ea9e.mailgun.org',
	'apiKey' => '5c40744484bc29cf2e39273d756cba9f-9525e19d-d6152084',
	'apiBaseUrl' => 'https://api.mailgun.net/v3/sandbox44928ae2ff8d45f487fb7a76e071ea9e.mailgun.org',
]);

Configure::write('mailgun', [
	'domain' => 'mail.wowmua.com',
	'apiKey' => '5c40744484bc29cf2e39273d756cba9f-9525e19d-d6152084',
	'apiBaseUrl' => 'https://api.mailgun.net/v3/mail.wowmua.com',
]);

Configure::write('cc_mail', 'wowmua.info@gmail.com');