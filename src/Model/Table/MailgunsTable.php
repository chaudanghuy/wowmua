<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Mailguns Model
 *
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\Mailgun get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mailgun newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Mailgun[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mailgun|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mailgun|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mailgun patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mailgun[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mailgun findOrCreate($search, callable $callback = null, $options = [])
 */
class MailgunsTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->setTable('mailguns');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->belongsTo('Orders', [
			'foreignKey' => 'order_id',
			'joinType' => 'INNER',
		]);
		$this->hasMany('Orders', [
			'foreignKey' => 'mailgun_id',
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
			->integer('id')
			->allowEmpty('id', 'create');

		$validator
			->scalar('log')
			->requirePresence('log', 'create')
			->notEmpty('log');

		$validator
			->dateTime('created_date')
			->requirePresence('created_date', 'create')
			->notEmpty('created_date');

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
		$rules->add($rules->existsIn(['order_id'], 'Orders'));

		return $rules;
	}

	public function createLog($orderId, $apiResponse) {
		try {
			$mgTable = TableRegistry::get('Mailguns');
			$mg = $mgTable->newEntity();
			$mg->order_id = $orderId;
			$mg->created_date = date("Y-m-d H:i:s");
			$mg->log = json_encode($apiResponse);

			if ($mgTable->save($mg)) {
				return $mg->id;
			} else {
				return $mg;
			}
		} catch (Exception $e) {
			return false;
		}
	}
}
