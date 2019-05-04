<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\I18n;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->set('statuses', Configure::read('order_statuses'));
	}

	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index() {
		$query = $this->Orders->find('all')
			->contain(['Users', 'Purchases'])
			->order(['Orders.id' => 'desc']);

		if ($this->request->query('search')) {
			$search = $this->stripUnicode($this->request->query('search'));
			$query->where(['OR' => [
				'Orders.order_code LIKE' => "%{$search}%",
				'Orders.from_location LIKE' => "%{$search}%",
				'Orders.to_location LIKE' => "%{$search}%",
				'Orders.needed_date LIKE' => "%{$search}%",
				'Orders.request_url LIKE' => "%{$search}%",
				'Orders.status LIKE' => "%{$search}%",
				'Users.email LIKE' => "%{$search}%",
				'Users.first_name LIKE' => "%{$search}%",
				'Users.last_name LIKE' => "%{$search}%",
				'Users.address LIKE' => "%{$search}%",
			]]);
		}

		$this->set('orders', $this->paginate($query));
		$this->set('_serialize', ['orders']);
	}

	/**
	 * View method
	 *
	 * @param string|null $id Order id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view($id = null) {
		$order = $this->Orders->get($id, [
			'contain' => ['Users', 'Purchases'],
		]);
		$this->set('order', $order);
		$this->set('_serialize', ['order']);
	}

	/**
	 * Add method
	 *
	 * @return void Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$order = $this->Orders->newEntity();
		if ($this->request->is('post')) {
			$error = false;
			$vars = ['from', 'to', 'needed_date', 'name', 'buy_price', 'crawl_url', 'customer', 'email', 'address', 'phone', 'photo', 'qty'];
			foreach ($vars as $va) {
				if (empty($this->request->getData($va))) {
					$error = true;
				}
				$$va = $this->request->getData($va);
			}

			if ($error) {
				$this->Flash->error(__("Đã có lỗi xảy ra"));
				return $this->redirect('/admin/orders');
			}

			$date = $this->request->data['needed_date'];
			$needed_date = sprintf("%d-%d-%d", $date['year'], $date['month'], $date['day']);

			// Image
			$image = $this->saveProdImage($this->request->data['photo']['tmp_name']);

			// Load Models
			$this->loadModel('Users', 'Products', 'Orders', 'Purchases');

			// Create user
			$this->loadModel('Users');
			$userId = $this->Users->createUser($email, null, $customer, $address, $phone, $to);
			if (is_object($userId)) {
				$errors = $this->showErrors($userId->errors);
				$this->Flash->error(__($errors));
				return $this->redirect('/admin/orders');
			}

			// Save product
			$this->loadModel('Products');
			$slug = $this->to_slug($subject);
			$productId = $this->Products->createProduct($name, $buy_price, $image, $slug);

			if (is_object($productId)) {
				$errors = $this->showErrors($productId->errors);
				$this->Flash->error(__($errors));
				return $this->redirect('/admin/orders');
			}

			// Generate random code
			$orderCode = $this->makeRandomCode();

			// Save order
			$orderId = $this->Orders->createOrder($userId, "n/a", $orderCode, $from, $to, $needed_date, $crawl_url);

			if (is_object($orderId)) {
				$errors = $this->showErrors($orderId->errors);
				$this->Flash->error(__($errors));
				return $this->redirect('/admin/orders');
			}

			// Purchases
			$this->loadModel('Purchases');
			$purchaseId = $this->Purchases->createPurchase($orderId, $productId, $buy_price, $qty);

			if (!$purchaseId) {
				$errors = $this->showErrors($purchaseId->errors);
				$this->Flash->error(__($errors));
				return $this->redirect('/admin/orders');
			}

			return $this->redirect('/admin/orders');
		}
		$users = $this->Orders->Users->find('list', ['limit' => 200]);
		$this->set(compact('order', 'users'));
		$this->set('_serialize', ['order']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Order id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$order = $this->Orders->get($id, [
			'contain' => ['purchases', 'users'],
		]);

		$productId = $order->purchases[0]->product_id;
		$userId = $order->user_id;
		$orderId = $order->id;
		$purchaseId = $order->purchases[0]->id;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$error = false;
			$vars = ['from_location', 'to_location', 'needed_date', 'product_name', 'buy_price', 'crawl_url', 'first_name', 'email', 'address', 'phone', 'photo', 'quantity'];

			foreach ($vars as $va) {
				if (empty($this->request->getData($va))) {
					$error = true;
				}
				$$va = $this->request->getData($va);
			}

			if ($error) {
				$this->Flash->error(__("Đã có lỗi xảy ra"));
				return $this->redirect('/admin/orders');
			}

			$date = $this->request->data['needed_date'];
			$needed_date = sprintf("%d-%d-%d", $date['year'], $date['month'], $date['day']);

			// Image
			$image = $this->saveProdImage($this->request->data['photo']['tmp_name']);

			// Update user
			$this->loadModel('Users');
			$userId = $this->Users->updateUser($userId, $email, $first_name, $address, $phone, $to_location);
			if (is_object($userId)) {
				$errors = $this->showErrors($userId->errors);
				$this->Flash->error(__($errors));
				return $this->redirect('/admin/orders');
			}

			// Update product
			$productSlug = $this->to_slug($product_name);
			$this->loadModel('Products');
			$productId = $this->Products->updateProduct($productId, $product_name, $buy_price, $image, $productSlug);
			if (is_object($productId)) {
				$errors = $this->showErrors($productId->errors);
				$this->Flash->error(__($errors));
				return $this->redirect('/admin/orders');
			}

			// Update Order
			$orderId = $this->Orders->updateOrder($orderId, $userId, "n/a", $from_location, $to_location, $needed_date, $crawl_url);

			if (is_object($orderId)) {
				$errors = $this->showErrors($orderId->errors);
				$this->Flash->error(__($errors));
				return $this->redirect('/admin/orders');
			}

			// Update Purchases
			$this->loadModel('Purchases');
			$purchaseId = $this->Purchases->updatePurchase($purchaseId, $orderId, $productId, $buy_price, $quantity);

			if (!$purchaseId) {
				$errors = $this->showErrors($purchaseId->errors);
				$this->Flash->error(__($errors));
				return $this->redirect('/admin/orders');
			}

			return $this->redirect('/admin/orders');
		}

		$this->loadModel('Products');
		$productInfo = $this->Products->get($productId);

		$this->set('product_name', $productInfo->name);
		$this->set('buy_price', $productInfo->buy_price);
		$this->set('crawl_url', $productInfo->crawl_url);
		$this->set('first_name', $order->Users['first_name']);
		$this->set('quantity', $order->purchases[0]->quantity);
		$this->set('email', $order->Users['email']);
		$this->set('address', $order->Users['address']);
		$this->set('phone', $order->Users['phone']);

		$users = $this->Orders->Users->find('list', ['limit' => 200]);
		$this->set(compact('order', 'users'));
		$this->set('_serialize', ['order']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Order id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$order = $this->Orders->get($id);
		if ($this->Orders->delete($order)) {
			$this->Flash->success(__('The order has been deleted.'));
		} else {
			$this->Flash->error(__('The order could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}

	/**
	 * AJAX update status
	 *
	 */
	public function updateStatus() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$query = $this->Orders->find('all')
				->where(['Orders.id' => $this->request->data['id']])
				->contain(['Users', 'Purchases'])
				->order(['Orders.id' => 'desc']);
			$order = $query->first();
			$order->status = $this->request->getData('status');

			if ($order->id) {
				// Send mail
				$from = "Wowmua@mail.wowmua.com";
				$to = $order->user->email;

				if ($order->default_lang == 'en_US') {
					$statuses = Configure::read('order_statuses_en');
				} else {
					$statuses = Configure::read('order_statuses');
				}

				// Subject
				if ($order->default_lang == 'en_US') {
					$subject = sprintf("Your booking %s is " . $statuses[$order->status], $order->order_code);
				} else {
					$subject = sprintf("Đơn hàng %s của bạn với Wowmua đang " . $statuses[$order->status], $order->order_code);
				}

				// Set default lang
				I18n::setLocale($order->default_lang);

				if ($result = $this->sendMail($from, $to, $subject, $order, $order->status, ['order_id' => $order->id])) {
					$order->send_mail = 1;
				}

				if ($this->Orders->save($order)) {
					echo sprintf("Order #%s update with <strong>%s</strong>!", $order->order_code, $statuses[$order->status]);
				} else {
					header('HTTP/1.1 500 Internal Server');
					header('Content-Type: application/json; charset=UTF-8');
					die("Đơn hàng cập nhật thất bại !");
				}
			} else {
				header('HTTP/1.1 500 Internal Server');
				header('Content-Type: application/json; charset=UTF-8');
				die("Update failed !");
			}
		} else {
			echo "Access not authorized";
		}
	}

	public function updateTraveller() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$order = $this->Orders->get($this->request->getData('order'));

			if ($order->id) {
				if ($this->request->getData('traveller')) {
					$order->traveller = $this->request->getData('traveller');
				}
				if ($this->request->getData('date')) {
					$order->delivery_date = $this->request->getData('date');
				}
				if ($this->Orders->save($order)) {
					echo sprintf("Đơn hàng #%s cập nhật !", $order->order_code);
				} else {
					header('HTTP/1.1 500 Internal Server');
					header('Content-Type: application/json; charset=UTF-8');
					die("Đơn hàng cập nhật thất bại !");
				}
			} else {
				header('HTTP/1.1 500 Internal Server');
				header('Content-Type: application/json; charset=UTF-8');
				die("Update failed !");
			}
		} else {
			echo "Access not authorized";
		}
	}

}
