<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Carts
 * @property \Cake\ORM\Association\HasMany $Orders
 * @property \Cake\ORM\Association\HasMany $Reviews
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Carts', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'user_id'
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
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->allowEmpty('company_name');

        $validator
            ->allowEmpty('avatar');

        $validator
            ->add('birth_date', 'valid', ['rule' => 'date'])
            ->allowEmpty('birth_date');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->allowEmpty('address2');

        $validator
            ->requirePresence('city', 'create')
            ->notEmpty('city');

        $validator
            ->add('zip', 'valid', ['rule' => 'numeric'])
            ->requirePresence('zip', 'create')
            ->notEmpty('zip');

        $validator
            ->allowEmpty('country');

        $validator
            ->requirePresence('phone', 'create')
            ->notEmpty('phone');

        $validator
            ->add('role', 'valid', ['rule' => 'numeric'])
            ->requirePresence('role', 'create')
            ->notEmpty('role');

        $validator
            ->add('status', 'valid', ['rule' => 'boolean'])
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
        // $rules->add($rules->isUnique(['email']));
        return $rules;
    }

    /**
     * Create user
     *
     * @param  [type] $email       [description]
     * @param  [type] $password    [description]
     * @param  [type] $name        [description]
     * @param  [type] $address     [description]
     * @param  [type] $phone       [description]
     * @param  [type] $to_location [description]
     * @return [type]              [description]
     */
    public function createUser($email, $password, $name, $address, $phone, $to_location) {
        try {
            $userTable = TableRegistry::get('Users');
            $user = $userTable->newEntity();
            $user->email = $email;
            $user->password = "wowmuaGuest123";
            $user->first_name = $name;
            $user->last_name = "";
            $user->company_name = "WM";
            $user->avatar = "https://via.placeholder.com/100x100";
            $user->birth_date = "1970-01-01";
            $user->address = $address;
            $user->address2 = $address;
            $user->city = "n/a";
            $user->zip = "90000";
            $user->country = $to_location;
            $user->phone = $phone;
            $user->created = $user->modified = date("Y-m-d H:i:s", strtotime("now"));
            $user->role = $user->status = 1;

            if ($userTable->save($user)) {
                return $user->id;
            } else {
                return $user;
            }
        } catch (Exception $e) {
            return $user;
        }
    }

    /**
     * @param $id
     * @param $email
     * @param $name
     * @param $address
     * @param $phone
     * @param $to_location
     * @return mixed
     */
    public function updateUser($id, $email, $name, $address, $phone, $to_location) {
        try {
            $userTable = TableRegistry::get('Users');
            $user = $userTable->get($id);
            $user->email = $email;
            $user->first_name = $name;
            $user->last_name = "G";
            $user->company_name = "WM";
            $user->avatar = "https://via.placeholder.com/100x100";
            $user->birth_date = "1970-01-01";
            $user->address = $address;
            $user->address2 = $address;
            $user->city = "n/a";
            $user->zip = "90000";
            $user->country = $to_location;
            $user->phone = $phone;
            $user->created = $user->modified = date("Y-m-d H:i:s", strtotime("now"));
            $user->role = $user->status = 1;

            if ($userTable->save($user)) {
                return $user->id;
            } else {
                return $user;
            }
        } catch (Exception $e) {
            return $user;
        }
    }
}
