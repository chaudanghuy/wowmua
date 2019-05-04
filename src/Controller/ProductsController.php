<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		// defined variables
		$this->set('from_location', Configure::read('from_location'));
		$this->set('from_en_location', Configure::read('from_en_location'));
		$this->set('to_location', Configure::read('to_location'));

		// Get action name
		$this->set('actionName', $this->request->getParam('action'));
		$this->Auth->allow(['index', 'request', 'requestProduct', 'finishOrder', 'aboutUs', 'resources', 'tos', 'privacy', 'instruct', 'sendOrder']);
	}

	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index() {
		// Featured products
		$this->loadModel('Purchases');
		$purchases = $this->Purchases->find('all', [
			'conditions' => ['Products.position' => 'HOME'],
			'contain' => ['Products', 'Orders'],
		])
			->order(['Purchases.created' => 'DESC'])
			->limit(4);
		$this->set('purchases', $purchases);
		$this->set('is_frontend', 1);
	}

	/**
	 * Request
	 * @return [type] [description]
	 */
	public function request() {
		try {
			$from = $this->request->query('from_location');
			$to = $this->request->query('to_location');
			$date = $this->request->query('needed_by');

			$currency = "";

			$currencyByCountries = Configure::read('currency_countries');

			foreach ($currencyByCountries as $cur => $countries) {
				if (in_array($from, $countries)) {
					$currency = $cur;
				}
			}

			// No country in the list. Should exit !
			if (empty($currency)) {
				exit("Sorry we are not supporting this route right now. Please come back to <a href='/'>Homepage</a> for other search.");
			}
			$this->set('currency', $currency);

			$this->set(compact('from', 'to', 'date'));
		} catch (Exception $e) {

		}
	}

	public function requestProduct() {
		$this->autoRender = false;

		try {
			$error = false;
			$vars = ['from', 'to', 'subject', 'edit_price', 'buyer_name', 'buyer_mail', 'buyer_address', 'buyer_phone'];
			foreach ($vars as $va) {
				if (empty($this->request->getData($va))) {
					$error .= "Field $va không hợp lệ";
				}
				$$va = $this->request->getData($va);
			}

			// Edit quantity
			$edit_quantity = $this->request->getData('edit_quantity') ? $this->request->getData('edit_quantity') : 1;

			$needed_date = $this->request->getData('needed_date') ? date("Y-m-d", $this->request->getData('needed_date')) : date("Y-m-d");

			if ($error) {
				throw new Exception("Error Processing Request", 1);
			}

			if (empty($this->request->data['my_file'])) {
				throw new Exception("Error Processing Request", 1);
			}

			// Image
			$image = $this->saveProdImage($this->request->data['my_file']['tmp_name']);

			// User
			$this->loadModel('Users');
			$userId = $this->Users->createUser($buyer_mail, null, $buyer_name, $buyer_address, $buyer_phone, $to);
			if (is_object($userId)) {
				throw new Exception("Error Processing Request", 1);
			}

			// Save product
			$weight = $this->request->getData('manual_weight') ? $this->request->getData('manual_weight') : 0;
			$localShip = $this->request->getData('manual_local_ship') ? $this->request->getData('manual_local_ship') : 0;
			$properties = $this->request->getData('manual_properties') ? $this->request->getData('manual_properties') : 'n/a';
			$totalAmount = $this->request->getData('total_amount') ? $this->request->getData('total_amount') : $this->calcPrice($price, $from_location, $local_ship, $weight, $qty);

			$slug = $this->to_slug($subject);

			$this->loadModel('Products');
			$productId = $this->Products->createProduct($subject, $edit_price, $image, $slug, $weight, $localShip, $properties, $from, $edit_quantity, $totalAmount);

			if (is_object($productId)) {
				throw new Exception("Error Processing Request", 1);
			}

			// Generate random code
			$orderCode = $this->makeRandomCode();

			// Order
			$request_url = !empty($this->request->getData('request_url')) ? $this->request->getData('request_url') : "na";
			$this->loadModel('Orders');
			$orderId = $this->Orders->createOrder($userId, "n/a", $orderCode, $from, $to, $needed_date, $request_url);

			if (is_object($orderId)) {
				throw new Exception("Error Processing Request", 1);
			}

			// Purchases
			$this->loadModel('Purchases');
			$purchaseId = $this->Purchases->createPurchase($orderId, $productId, $edit_price, $edit_quantity);

			if (!$purchaseId) {
				throw new Exception("Error Processing Request", 1);
			}

			if (intval($orderId) && intval($purchaseId)) {
				return $this->redirect('products/sendOrder/' . $orderCode);
			} else {
				$query = [
					'from_location' => $from,
					'to_location' => $to,
					'needed_by' => $date,
				];
				return $this->redirect('request?' . http_build_query($query));
			}
		} catch (Exception $e) {
			$query = [
				'from_location' => $from,
				'to_location' => $to,
				'needed_by' => $date,
				'error' => 'Đã có lỗi xảy ra ! Xin vui lòng kiểm tra đầy đủ thông tin',
			];
			return $this->redirect('request?' . http_build_query($query));
		}
	}

	public function sendOrder($code) {
		$this->loadModel('Orders');
		$query = $this->Orders->find('all')
			->where(['Orders.order_code' => $code])
			->contain(['Users', 'Purchases'])
			->order(['Orders.id' => 'desc']);
		$order = $query->first();

		// Already send mail, bypass it
		// if ($order->send_mail == 1) {
		// 	return $this->redirect('order/thanks/' . $order->order_code);
		// }

		//From
		$from = "Wowmua@mail.wowmua.com";
		$to = $order->user->email;
		// Subject
		if ($this->default_lang == 'en_US') {
			$subject = sprintf("Your booking %s is Waiting for payment", $order->order_code);
		} else {
			$subject = sprintf("Đơn hàng %s của bạn với Wowmua đang Chờ thanh toán", $order->order_code);
		}

		if ($result = $this->sendMail($from, $to, $subject, $order, 'UNPAID', ['order_id' => $order->id])) {
			$order->send_mail = 1;
			// Get default_lang
			$session = $this->getRequest()->getSession();
			if ($lang = $session->read('Web.LANG')) {
				$order->default_lang = $lang;
			} else {
				$order->default_lang = 'en_US';
			}

			$this->Orders->save($order);
		}

		return $this->redirect('order/thanks/' . $order->order_code);
	}

	public function finishOrder($code) {
		try {
			$this->loadModel('Orders');
			$query = $this->Orders->find('all')
				->where(['Orders.order_code' => $code])
				->contain(['Users', 'Purchases'])
				->order(['Orders.id' => 'desc']);
			$order = $query->first();

			if (!isset($order->id)) {
				throw new Exception("Mã đơn hàng không tìm thấy !");
			}

			$this->set('order', $order);
		} catch (Exception $e) {
			$this->autoRender = false;
			print_r("<h2>" . $e->getMessage() . "</h2>");
		}
	}

	public function aboutUs() {

	}

	public function resources() {

	}

	public function tos() {
		# code...
	}

	public function instruct() {
		# code...
	}

	public function privacy() {
		# code...
	}

	/**
	 * View method
	 *
	 * @param string|null $id Product id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view($id = null) {
		$product = $this->Products->get($id, [
			'contain' => ['Categories', 'SubCategories', 'Discounts' => function ($q) {
				return $q->where(['Discounts.start_at <' => date('Y-m-d H:i:s'), 'Discounts.end_at >' => date('Y-m-d H:i:s')])->limit(1);
			}],
		]);

		$this->set('product', $product);
		$this->set('_serialize', ['product']);
		// Related products
		$this->paginate = [
			'contain' => ['Categories', 'SubCategories'],
			'limit' => 4,
		];
		$this->set('products', $this->paginate($this->Products));
		$this->set('_serialize', ['products']);
	}

	public function show($slug = null) {
		$query = $this->Products->find("all", [
			'conditions' => [
				'Products.slug' => $slug,
			],
			'contain' => ['Categories', 'SubCategories', 'Discounts' => function ($q) {
				return $q
					->where(['Discounts.start_at <' => date('Y-m-d H:i:s'), 'Discounts.end_at >' => date('Y-m-d H:i:s')])
					->limit(1);
			}],
		]);

		$product = $query->first();

		// Metadata
		$keywords = "nhan, hang, ship, mua, ship hang, mua hang, viet nam";
		$description = "WowMua cung cấp dịch vụ mua hàng, ship hàng từ nước ngoài về Việt Nam. Với tiêu chí: mua hàng và ship hàng về Việt Nam  nhanh chóng, giá hợp lý, an toàn và dễ dàng.";

		$subject = $product['name'] . "- WowMua.com &copy;" . date("Y");
		$url = "https://www.wowmua.com/san-pham/" . $product['slug'];
		$image = $product['thumb'];

		$this->set('product', $product);
		$this->set('_serialize', ['product']);
		// Related products
		$this->paginate = [
			'conditions' => ['Products.category_id' => $product['category_id']],
			'contain' => ['Categories', 'SubCategories'],
			'order' => ['rand()'],
			'limit' => 4,
		];
		$this->set('products', $this->paginate($this->Products));
		$this->set('_serialize', ['products']);
		$this->set(compact('keywords', 'description', 'subject', 'url', 'image'));
	}

	public function search() {
		// Set leftmenu
		$this->loadModel('Categories');
		$query = $this->Categories->find('all', [
			'contain' => ['SubCategories'],
		]);
		$this->set('categories', $query);
		$this->set('is_frontend', 1);
		$q = $this->request->query('q');
		$this->set('q', $q);

		// Conditions
		$conditions = array();
		$conditions['Products.name LIKE'] = "%$q%";

		$price = $this->request->query('price');
		if ($price == '300-500') {
			$conditions['Products.sell_price >'] = "300000";
			$conditions['Products.sell_price <'] = "500000";
		} else if ($price == '500-1000') {
			$conditions['Products.sell_price >'] = "500000";
			$conditions['Products.sell_price <'] = "1000000";
		} else if ($price == '1000-3000') {
			$conditions['Products.sell_price >'] = "1000000";
			$conditions['Products.sell_price <'] = "3000000";
		}

		// Danh sach san pham theo danh muc
		$this->paginate = [
			'limit' => 20,
			'conditions' => $conditions,
			"joins" => [
				[
					"alias" => "TM",
					"table" => "trademarks",
					"type" => "LEFT",
					"conditions" => [
						"TM.id" => "Products.trademark_id",
						"TM.name LIKE" => "%$q%",
					],
				],
			],
			'order' => ['Products.id' => 'desc'],
		];
		$this->set('products', $this->paginate($this->Products));
		$this->set('_serialize', ['products']);
	}

}
