<?php
namespace App\Model\Table;

use App\Model\Entity\Purchase;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Purchases Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Orders
 * @property \Cake\ORM\Association\BelongsTo $Products
 */
class PurchasesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('purchases');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('price', 'valid', ['rule' => 'numeric'])
            ->requirePresence('price', 'create')
            ->notEmpty('price');

        $validator
            ->add('quantity', 'valid', ['rule' => 'numeric'])
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['order_id'], 'Orders'));
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        return $rules;
    }

    public function createPurchase($orderId, $productId, $price, $quantity) {
        try {
            $purchaseTable = TableRegistry::get('Purchases');
            $purchase = $purchaseTable->newEntity();
            $purchase->order_id = $orderId;
            $purchase->product_id = $productId;
            $purchase->price = $price;
            $purchase->quantity = $quantity;
            $purchase->modified = $purchase->created = date("Y-m-d H:i:s", strtotime("now"));

            if ($purchaseTable->save($purchase)) {
                return $purchase->id;
            } else {
                return $purchase;
            }
        } catch (Exception $e) {
            // log error
            return false;
        }

        return false;
    }

    /**
     * @param $id
     * @param $orderId
     * @param $productId
     * @param $price
     * @param $quantity
     * @return bool
     */
    public function updatePurchase($id, $orderId, $productId, $price, $quantity) {
        try {
            $purchaseTable = TableRegistry::get('Purchases');
            $purchase = $purchaseTable->get($id);
            $purchase->order_id = $orderId;
            $purchase->product_id = $productId;
            $purchase->price = $price;
            $purchase->quantity = $quantity;
            $purchase->modified = $purchase->created = date("Y-m-d H:i:s", strtotime("now"));

            if ($purchaseTable->save($purchase)) {
                return $purchase->id;
            } else {
                throw new Exception("Save purchase to db fail !");
            }
        } catch (Exception $e) {
            // log error
            return false;
        }

        return false;
    }
}
