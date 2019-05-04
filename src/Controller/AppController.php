<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Log\Log;
use Mailgun\Mailgun;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $userId;
	public $testLink = 'https://wowmua.com';
	public $session;
	public $helpers = [
		'Html' => [
			'className' => 'Bootstrap.BootstrapHtml',
		],
		'Form' => [
			'className' => 'Bootstrap.BootstrapForm',
		],
		'Paginator' => [
			'templates' => 'paginator-templates',
		],
		'Modal' => [
			'className' => 'Bootstrap.BootstrapModal',
		],
	];

	public $isProduction = true;
	public $default_lang = '';

	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * e.g. `$this->loadComponent('Security');`
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
		$this->loadComponent('Auth', [
			//'authorize'=> 'Controller',//added this line
			'authenticate' => [
				'Form' => [
					'fields' => [
						'username' => 'email',
						'password' => 'password',
					],
				],
			],
			'loginAction' => [
				'controller' => 'Users',
				'action' => 'login',
			],
			'logoutRedirect' => [
				'controller' => 'Products',
				'action' => 'index',
			],
			//'unauthorizedRedirect' => $this->referer()
		]);

		// Cookie
		$this->loadComponent('Cookie');

		// Session
		$this->session = $this->getRequest()->getSession();

		// Check language
		$default_lang = "vi_VN";

		if ($lang = $this->request->query('lang')) {
			$default_lang = ($lang == 'en') ? 'en_US' : 'vi_VN';
			$this->session->write('Web.LANG', $default_lang);
		} else if ($lang = $this->session->read('Web.LANG')) {
			$default_lang = $lang;
		}

		$this->default_lang = $default_lang;

		// Set lang
		if ($default_lang == 'en_US') {
			$this->set('lang_flag', 'us');
			$this->set('lang_text', 'English');
			$this->set('img_prefix', 'h');
		} else {
			$this->set('lang_flag', 'vietnam');
			$this->set('lang_text', 'Tiếng Việt');
			$this->set('img_prefix', 'v');
		}

		I18n::setLocale($default_lang);

		if (($_SERVER['SERVER_NAME'] == 'test.wowmua.com' || $_SERVER['SERVER_NAME'] == 'wowmua.com')) {
			$this->isProduction = true;
		} else {
			$this->isProduction = false;
		}
	}

	/**
	 * Before render callback.
	 *
	 * @param \Cake\Event\Event $event The beforeRender event.
	 * @return void
	 */
	public function beforeRender(Event $event) {
		if (!array_key_exists('_serialize', $this->viewVars) &&
			in_array($this->response->type(), ['application/json', 'application/xml'])
		) {
			$this->set('_serialize', true);
		}
	}

	public function beforeFilter(Event $event) {
		if (isset($this->request->params['prefix']) == 'admin') {
			$authUser = $this->Auth->user();
			$this->viewBuilder()->layout('admin');
			$this->userId = $authUser['id'];
			// if ($authUser = $this->Auth->user()) {
			// 	$this->viewBuilder()->layout('admin');
			// }
		} else {
			$authUser = $this->Auth->user();
			// Cookie
			$this->Cookie->configKey('cookieUserId', 'encryption', false);
			$cookieUserId = $this->Cookie->read('cookieUserId');
			if (!$cookieUserId) {
				// Create user
				$this->loadModel('Users');
				$user = $this->Users->newEntity();
				$user->email = rand() . "@wowmua.com";
				$user->password = rand();
				$user->first_name = "ABC";
				$user->last_name = "DEF";
				$user->address = "162 Pasteur Q1, HCMC";
				$user->city = "HCMC";
				$user->phone = "123456789";
				$user->created = $user->modified = date("Y-m-d H:i:s", strtotime('now'));
				$user->zip = 9000;
				$user->status = 0;

				if ($this->Users->save($user)) {
					$cookieUserId = $user->id;
				}

				$this->Cookie->write('cookieUserId', $cookieUserId);
			}
			$this->set('userId', $cookieUserId);
			$this->userId = $cookieUserId;
			$this->viewBuilder()->layout('frontend');
		}

		$this->loadModel('Categories');
		$query = $this->Categories->find('all', [
			'contain' => ['SubCategories'],
		]);
		$this->set('categories', $query);

		// Set metadata
		$keywords = "nhan, hang, ship, mua, ship hang, mua hang, viet nam";
		$description = "WowMua cung cấp dịch vụ mua hàng, ship hàng từ nước ngoài về Việt Nam. Với tiêu chí: mua hàng và ship hàng về Việt Nam  nhanh chóng, giá hợp lý, an toàn và dễ dàng.";

		$subject = "Mua hàng từ nước ngoài ship về Việt nam giá rẻ nhất " . date("Y") . " - WowMua.com";
		$url = "https://www.wowmua.com/";
		$image = "https://www.wowmua.com/image/wowmua.png";

		$brand = "WowMua";

		// Facebook
		$fbAppId = "";

		$this->Auth->allow(['login', 'account', 'add']);
		$this->set(compact('authUser', 'keywords', 'description', 'subject', 'url', 'image', 'fbAppId', 'brand'));
	}

	public function createFolder() {
		if ($this->isProduction) {
			$folderPath = "/var/www/html/wowmua.com";
		} else {
			$folderPath = '/Applications/MAMP/htdocs/wowmua';
		}

		$today = date('Y') . DS . date('m') . DS . date('d');

		$todayDir = $folderPath . DS . 'webroot' . DS . 'img' . DS . 'news' . DS . $today;

		if (!file_exists($todayDir)) {
			if (!mkdir($todayDir, 0777, true)) {
				echo $todayDir;
				die('Cant create folder');
			}
		}

		return $todayDir;
	}

	public function saveProdImage($link) {
		$todayDir = $this->createFolder();
		$fileName = rand() . '.jpg';
		$target_file = $todayDir . DS . $fileName;

		if (move_uploaded_file($link, $target_file)) {
			return $this->testLink . DS . 'img' . DS . 'news' . DS . date('Y') . DS . date('m') . DS . date('d') . DS . $fileName;
		} else {
			return false;
		}
	}

	public function to_slug($str) {
		$str = trim(mb_strtolower($str, "utf8"));
		$str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
		$str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
		$str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
		$str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
		$str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
		$str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
		$str = preg_replace('/(đ)/', 'd', $str);
		$str = preg_replace('/[^a-z0-9-\s]/', '', $str);
		$str = str_replace(' - ', ' ', $str);
		$str = preg_replace('/([\s]+)/', '-', $str);
		return $str;
	}

	/**
	 * Tạo mã ĐH
	 */
	public function makeRandomCode($length = 2) {
		$randstr = "";
		//our array add all letters and numbers if you wish
		$chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p',
			'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
			'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

		for ($rand = 0; $rand <= $length; $rand++) {
			$random = rand(0, count($chars) - 1);
			$randstr .= $chars[$random];
		}
		$digits = 3;
		$randstr .= str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

		// Upper case
		$randstr = strtoupper($randstr);
		return $randstr;
	}

	public function showErrors($errors) {
		$msg = "";
		foreach ($errors as $error) {
			$msg .= "$error \n";
		}
		return $msg;
	}

	/**
	 * Bỏ dấu tiếng việt
	 */
	function stripUnicode($str) {
		if (!$str) {
			return false;
		}

		$unicode = array(
			'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
			'd' => 'đ',
			'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
			'i' => 'í|ì|ỉ|ĩ|ị',
			'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
			'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
			'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
		);
		foreach ($unicode as $nonUnicode => $uni) {
			$str = preg_replace("/($uni)/i", $nonUnicode, $str);
		}
		return $str;
	}

	public function calcPrice($price, $from_location, $local_ship, $weight, $qty = 1) {
		$currency = 0;

		if ($from_location == "ÚC") {
			$currency = 18000;
		} else if ($from_location == "NHẬT BẢN") {
			$currency = 220;
		} else if ($from_location == "HÀN QUỐC") {
			$currency = 22;
		}

		if ($currency = 0) {
			return false;
		}

		// Giá SP
		$itemPrice = $price * $currency;

		// Ship nội địa
		$localShip = $local_ship * $currency;

		// Service fee
		$serviceFee = 30000;

		$totalPrice = 0;
		// $weight = (!$weight) ? 1 : $weight;

		$transportFee = 0;
		if ($from_location == "ÚC") {
			// Tiền mua hộ & vận chuyển
			$transportFee = ($weight + 0.2) * 250000;
			if ($transportFee < 100000) {
				$transportFee = 100000;
			}
		} else if ($from_location == "NHẬT BẢN") {
			// Tiền mua hộ & vận chuyển
			$transportFee = ($weight + 0.2) * 230000;
			if ($transportFee < 100000) {
				$transportFee = 100000;
			}
		} else if ($from_location == "HÀN QUỐC") {
			// Tiền mua hộ & vận chuyển
			$transportFee = ($weight + 0.2) * 200000;
			if ($transportFee < 80000) {
				$transportFee = 80000;
			}
		}

		$totalPrice = ($itemPrice + $localShip + $transportFee) * 1.08 + $serviceFee;
		$totalPrice = $totalPrice * $qty;

		return $totalPrice;
	}

	public function stopProcess() {
		echo "<pre>";
		echo "<h2>Đã có lỗi xảy ra trong quá trình xử lý đơn hàng. Xin vui lòng thử lại sau ít phút</h2>";
		echo "</pre>";
		exit();
	}

	public function prepareMailContent($order, $type) {
		$builder = $this->viewBuilder();

		// Configure as needed
		$builder->setLayout('/Email/html/mailgun');

		if ($type == 'UNPAID'
			|| $type == 'PROCESS'
			|| $type == 'ASSIGNEE'
			|| $type == 'TRANSPORT'
			|| $type == 'DELIVERY') {
			$builder->setTemplate('/Email/html/mailgun');
		} else if ($type == 'INCOMPLETE'
			|| $type == 'PRICE_CHANGE'
		) {
			$builder->setTemplate('/Email/html/mailgun_cancel');
		}

		$builder->helpers(['Html']);

		$total = 0;
		foreach ($order->purchases as $purchase) {
			$product = $this->getProductInfoByProductId($purchase->product_id);
			if (!empty($product['calc_price'])) {
				$total += $product['calc_price'];
			}
		}
		$order->total = number_format($total);
		if ($this->default_lang == 'en_US') {
			$order->statuses = Configure::read('order_statuses_en');
		} else {
			$order->statuses = Configure::read('order_statuses');
		}

		$view = $builder->build(compact('order'));

		$output = $view->render();

		return $output;
	}

	public function sendMail($from, $to, $subject, $content, $type, $extraFields = array()) {
		try {
			$mgConfig = Configure::read('mailgun');

			$mgClient = new Mailgun($mgConfig['apiKey']);
			$response = $mgClient->sendMessage($mgConfig['domain'], [
				'from' => $from,
				'to' => $to,
				'cc' => Configure::read('cc_mail'),
				'subject' => $subject,
				'text' => 'Your email not support html',
				'html' => $this->prepareMailContent($content, $type),
			]);

			$result = '';
			if (isset($response->http_response_code)) {
				$result = $response->http_response_body;
			} else {
				Log::error('Mailgun has problem. need check');
			}

			// Save mailgun log
			$this->loadModel('Mailguns');
			if (!$mgDb = $this->Mailguns->createLog($extraFields['order_id'], $result)) {
				Log::error('Mailgun db has problem. need check');
			}
			return true;
		} catch (Exception $e) {
			Log::error('Send mail has problem. need check');
			return false;
		}
	}

	public function getProductInfoByProductId($id) {
		$this->loadModel('Products');
		$product = $this->Products->find('all', [
			'conditions' => ['Products.id' => $id],
		]);

		return $product->first();
	}

}
