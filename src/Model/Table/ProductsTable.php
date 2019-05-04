<?php
namespace App\Model\Table;

use App\Model\Entity\Product;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Products Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Association\BelongsTo $SubCategories
 * @property \Cake\ORM\Association\HasMany $Carts
 * @property \Cake\ORM\Association\HasMany $Discounts
 * @property \Cake\ORM\Association\HasMany $ProductImages
 * @property \Cake\ORM\Association\HasMany $Purchases
 * @property \Cake\ORM\Association\HasMany $Reviews
 */
class ProductsTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->table('products');
		$this->displayField('name');
		$this->primaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Categories', [
			'foreignKey' => 'category_id',
		]);
		$this->belongsTo('Trademarks', [
			'foreignKey' => 'trademark_id',
		]);
		$this->belongsTo('SubCategories', [
			'foreignKey' => 'sub_category_id',
		]);
		$this->hasMany('Carts', [
			'foreignKey' => 'product_id',
		]);
		$this->hasMany('Discounts', [
			'foreignKey' => 'product_id',
		]);
		$this->hasMany('ProductImages', [
			'foreignKey' => 'product_id',
		]);
		$this->hasMany('Purchases', [
			'foreignKey' => 'product_id',
		]);
		$this->hasMany('Reviews', [
			'foreignKey' => 'product_id',
		]);
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator) {
		$validator
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create');

		$validator
			->allowEmpty('sku');

		$validator
			->allowEmpty('name');

		$validator
			->requirePresence('model', 'create')
			->notEmpty('model');

		$validator
			->allowEmpty('description');

		$validator
			->add('buy_price', 'valid', ['rule' => 'numeric'])
			->allowEmpty('buy_price');

		$validator
			->add('sell_price', 'valid', ['rule' => 'numeric'])
			->allowEmpty('sell_price');

		$validator
			->add('units_in_stock', 'valid', ['rule' => 'numeric'])
			->requirePresence('units_in_stock', 'create')
			->notEmpty('units_in_stock');

		$validator
			->allowEmpty('size');

		$validator
			->allowEmpty('color');

		$validator
			->add('weight', 'valid', ['rule' => 'numeric'])
			->allowEmpty('weight');

		$validator
			->add('rating', 'valid', ['rule' => 'numeric'])
			->allowEmpty('rating');

		$validator
			->allowEmpty('thumb');

		return $validator;
	}

	/**
	 * Returns a rules checker object that will be used for validating
	 * application integrity.
	 *
	 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
	 * @return \Cake\ORM\RulesChecker
	 */
	public function buildRules(RulesChecker $rules) {
		$rules->add($rules->existsIn(['category_id'], 'Categories'));
		$rules->add($rules->existsIn(['sub_category_id'], 'SubCategories'));
		return $rules;
	}

	public function createProduct($subject, $price, $image, $slug, $weight = false, $localShip = false, $properties = false, $from = false, $edit_quantity = false, $totalAmount = false) {
        try {
            $productTable = TableRegistry::get('Products');
            // Save product
            $product = $productTable->newEntity();
            $product->category_id = 5;
            $product->name = $subject;
            $product->model = $subject;
            $product->description = $subject;
            $product->calc_price = $product->sell_price = $product->buy_price = $price;
            $product->discount_percent = 0;
            $product->units_in_stock = 999;
            $product->thumb = $image;
            $product->created = $product->modified = date("Y-m-d H:i:s", strtotime('now'));
            $product->crawl_url = "n/a";
            $product->trademark_id = 1;
            $product->total_bought = 100;
            $product->discount_endtime = date("Y-m-d", strtotime("+1 day"));
            $product->crawl_info_url = "n/a";
            $product->crawl_detail_url = "n/a";
            $product->crawl_status = "INFO";
            $product->rating = rand(1,5);
            $product->status = 1;
            $product->sub_category_id = 10;
            $product->slug = $slug;
            $product->shipping = 100;
            $product->position = "NONE";
            $product->note = "empty";
            $product->calc_price = $totalAmount;
            if ($weight) {
                $product->weight = $weight;
            }
            if ($localShip) {
                $product->local_ship = $localShip;
            } else {
                $product->local_ship = 0;
            }
            $product->note = ($properties) ? $properties : 'empty';

            if ($productTable->save($product)) {
                // Get id
                return $product->id;
            }
        } catch (Exception $e) {
            return false;
        }

        return false;
    }

    /**
     * @param $id
     * @param $subject
     * @param $price
     * @param $image
     * @return bool
     */
    public function updateProduct($id, $subject, $price, $image, $slug) {
        try {
            $productTable = TableRegistry::get('Products');
            $product = $productTable->get($id, [
                'contain' => []
            ]);
            // Save product
            $product->category_id = 5;
            $product->name = $subject;
            $product->model = $subject;
            $product->description = $subject;
            $product->calc_price = $product->sell_price = $product->buy_price = $price;
            $product->discount_percent = 0;
            $product->units_in_stock = 999;
            if ($image) {
            	$product->thumb = $image;
            }
            $product->created = $product->modified = date("Y-m-d H:i:s", strtotime('now'));
            $product->crawl_url = "n/a";
            $product->trademark_id = 1;
            $product->total_bought = 100;
            $product->discount_endtime = date("Y-m-d", strtotime("+1 day"));
            $product->crawl_info_url = "n/a";
            $product->crawl_detail_url = "n/a";
            $product->crawl_status = "INFO";
            $product->rating = rand(1,5);
            $product->status = 1;
            $product->sub_category_id = 10;
            $product->slug = $slug;
            $product->shipping = 100;
            $product->position = "NONE";

            if ($productTable->save($product)) {
                // Get id
                return $product->id;
            }
        } catch (Exception $e) {
            return false;
        }

        return false;
    }
}
