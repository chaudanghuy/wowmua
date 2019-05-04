<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Ajax Requests Handler
 */
class AjaxController extends AppController {

	public function beforeFilter(Event $event)
	{
		$this->autoRender = false;
		parent::beforeFilter($event);
		$this->Auth->allow(['setLang']);
	}

	public function setLang()
	{
		if ($this->request->is('ajax')) {
			$lang = $this->request->getData('lang');

			$lang = ($lang == 'en') ? 'en_US' : 'vi_VN';
			$this->session->write('Web.LANG', $lang);
		}

		echo "OK";
	}
}