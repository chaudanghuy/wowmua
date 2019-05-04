<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{
    private $positions = [
        'NONE' => 'Không',
        'HOME' => 'Trang home',
        'REQUEST' => 'Trang request'
    ];

    private $statuses = [
        'REQUEST' => 'Yêu cầu',
        'VERIFY' => 'Xác thực',
        'PRICE_CHANGE' => 'Giá thay đổi',
        'INCOMPLETE' => 'Chưa hoàn thành',
        'UNPAID' => 'Chưa thanh toán',
        'PAID' => 'Đã thanh toán',
        'PROCESS' => 'Xử lý',
        'ASSIGNEE' => 'Chọn NV lấy hàng',
        'TRANSPORT' => 'Đang vận chuyển',
        'COMPLETE' => 'Hàng về',
        'DELIVERY' => 'Đang giao hàng',
        'SUCCESS' => 'Giao thành công'
    ];

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->set('positions', $this->positions);
        $this->set('statuses', $this->statuses);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories', 'SubCategories'],
            'conditions' => ['Products.position' => 'HOME'],
            'order' => ['Products.id' => 'DESC']
        ];
        $this->set('products', $this->paginate($this->Products));
        $this->set('_serialize', ['products']);
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Categories', 'SubCategories', 'Carts', 'Discounts', 'Purchases']
        ]);
        $this->set('product', $product);
        $this->set('_serialize', ['product']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->data);
            // Save prod image
            $product->thumb = $this->saveProdImage($this->request->data['thumb']['tmp_name']);
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->autoRender = false;
                echo "<pre>";
                print_r($product);
                echo "</pre>";

                exit();
                // $this->Flash->error(__('The product could not be saved. Please, try again.'));
            }
        }

        $this->loadModel('Categories');
        $categories = $this->Categories->find('all', [
            'order' => ['Categories.id' => 'DESC']
        ]);
        $this->set('category_id', $categories->first()->id);

        $this->loadModel('SubCategories');
        $subCategories = $this->SubCategories->find('all', [
            'order' => ['SubCategories.id' => 'DESC']
        ]);
        $this->set('sub_category_id', $subCategories->first()->id);

        $this->loadModel('Trademarks');
        $trademark = $this->Trademarks->find('all', [
            'order' => ['Trademarks.id' => 'DESC']
        ]);
        $this->set('trademark_id', $trademark->first()->id);

        $categories = $this->Products->Categories->find('list', ['limit' => 200]);
        $subCategories = $this->Products->SubCategories->find('list', ['limit' => 200]);
        $this->set(compact('product', 'categories', 'subCategories'));
        $this->set('_serialize', ['product']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => []
        ]);

        $tmpThumb = $product->thumb;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->data);
            // Save image
            $image = $this->saveProdImage($this->request->data['thumb']['tmp_name']);
            $product->thumb = $image ? $image : $tmpThumb;
            // Save product
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Products->Categories->find('list', ['limit' => 200]);
        $subCategories = $this->Products->SubCategories->find('list', ['limit' => 200]);
        $this->set(compact('product', 'categories', 'subCategories'));
        $this->set('_serialize', ['product']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
