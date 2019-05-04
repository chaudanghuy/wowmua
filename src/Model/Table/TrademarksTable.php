<?php
namespace App\Model\Table;

use App\Model\Entity\Trademark;
use Cake\ORM\Table;

/**
 * Trademarks Model
 */
class TrademarksTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->table('trademarks');
		$this->displayField('name');
		$this->primaryKey('id');

		$this->hasMany('Products', [
			'foreignKey' => 'trademark_id',
		]);
	}
}
