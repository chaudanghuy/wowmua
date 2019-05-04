<?php
namespace App\Model\Table;

use App\Model\Entity\Order;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Orders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $Purchases
 */
class OrdersTable extends Table
{
    private $requestStatus = "REQUEST";

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('orders');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Purchases', [
            'foreignKey' => 'order_id'
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
            ->allowEmpty('receiver_address');

        $validator
            ->allowEmpty('city');

        $validator
            ->add('zip', 'valid', ['rule' => 'numeric'])
            ->requirePresence('zip', 'create')
            ->notEmpty('zip');

        $validator
            ->allowEmpty('state');

        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }

    public function createOrder($userId, $address, $orderCode, $from, $to, $needed_date, $request_url) {
        try {
            // Create order
            $orderTable = TableRegistry::get('Orders');
            $order = $orderTable->newEntity();
            $order->user_id = $userId;
            $order->receiver_address = $address;
            $order->zip = "90000";
            $order->created = date("Y-m-d H:i:s", strtotime("now"));
            $order->modified = date("Y-m-d H:i:s", strtotime("now"));
            $order->from_location = $from;
            $order->to_location = $to;
            $order->needed_date = date("Y-m-d", strtotime($needed_date));
            $order->request_url = $request_url;
            $order->order_code = $orderCode;
            $order->status = "REQUEST";
            $order->traveller = 'Thong tin Traveller';
            if ($orderTable->save($order)) {
                return $order->id;
            } else {
                return $order;
                throw new Exception("Save order to db fail !");
            }
        } catch (Exception $e) {
            // log error
            return false;
        }

        return false;
    }

    /**
     * @param $id
     * @param $userId
     * @param $address
     * @param $orderCode
     * @param $from
     * @param $to
     * @param $needed_date
     * @param $request_url
     * @return array|bool|\Cake\Datasource\EntityInterface|mixed
     */
    public function updateOrder($id, $userId, $address, $from, $to, $needed_date, $request_url) {
        try {
            // Create order
            $orderTable = TableRegistry::get('Orders');
            $order = $orderTable->get($id);
            $order->user_id = $userId;
            $order->receiver_address = $address;
            $order->zip = "90000";
            $order->created = date("Y-m-d H:i:s", strtotime("now"));
            $order->modified = date("Y-m-d H:i:s", strtotime("now"));
            $order->from_location = $from;
            $order->to_location = $to;
            $order->needed_date = date("Y-m-d", strtotime($needed_date));
            $order->request_url = $request_url;
            $order->status = $this->requestStatus;
            if ($orderTable->save($order)) {
                return $order->id;
            } else {
                throw new Exception("Save order to db fail !");
            }
        } catch (Exception $e) {
            // log error
            return false;
        }

        return false;
    }
}
