<?php

namespace App\Controller;

use App\Controller\AppController;
use Browser\Casper;
use Cake\Event\Event;
use Sunra\PhpSimple\HtmlDomParser;

class CronController extends AppController {

	private $testLink = 'https://wowmua.com';

	private $gmarketProdLink = 'http://item2.gmarket.co.kr/English/detailview/item.aspx?goodscode=';

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->autoRender = false;
		$this->Auth->allow(['index', 'scrapGmarket', 'scrapGmarketCategory', 'getCategories', 'scrapGmarketProd', 'scrapGmarketProdDetail', 'crawlProdsFromCategory', 'clearProductsDb', 'crawlProduct', 'crawlHotProducts', 'roundPrices']);
	}

	public function index() {
		echo "Scrapping..";
	}

	// dangeroous code : Clear all prods
	public function clearProductsDb() {
		// STOP ACCESS
		exit("Inalid access..");

		$this->loadModel('Products');
		return $this->Products->deleteAll();
	}

	// Cao tat ca san pham ve
	public function crawlProdsFromCategory() {
		// STOP ACCESS
		// exit("Inalid access..");

		$this->loadModel('Categories');
		$categories = $this->Categories->find('all')->contain(['SubCategories']);

		$datas = array();
		$categoryId = '';
		$hasCategory = false;
		foreach ($categories as $cate) {
			if (date("Y-m-d", strtotime($cate['crawl_date'])) != date("Y-m-d", strtotime("now"))) {
				// Skip this
				continue;
			}

			$hasCategory = true;

			// Category ID
			$categoryId = $cate['id'];

			// Start crawling this and break
			$subCategories = $cate['sub_categories'];

			if (!empty($subCategories)) {
				foreach ($subCategories as $subCat) {
					// Get sub_category_id
					$subCategoryId = $subCat['id'];

					$parts = parse_url(trim($subCat['description']));
					parse_str($parts['query'], $query);

					$GdscCd = !empty($query['GdscCd']) ? $query['GdscCd'] : null;

					$crawlDatas = $this->scrapGmarket($query['GdlcCd'], $query['GdmcCd'], $GdscCd, $subCategoryId, 1);
					$datas = array_merge($datas, $crawlDatas);
				}
			} else {
				$parts = parse_url(trim($cate['crawl_url']));
				parse_str($parts['query'], $query);

				$datas = $this->scrapGmarket($query['GdlcCd'], $query['GdmcCd'], null, null, 1);
			}

			$newCat = $this->Categories->newEntity();
			$newCat->id = $cate['id'];
			$newCat->crawl_date = date("Y-m-d", strtotime("+ 3 days"));

			$this->Categories->save($newCat);

			break;
		}

		if (!$hasCategory) {
			exit("No category..");
		}

		if (empty($datas)) {
			exit("No products");
		}

		$this->loadModel('Products');
		foreach ($datas as $data) {
			if (empty($data['origin_price']) || $data['origin_price'] == 0) {
				$data['orgin_price'] = $data['discount_price'];
			}

			$discount = $this->calculatePrice($data['discount_price'], 2500, 0.3);
			$originPrice = $this->calculatePrice($data['origin_price'], 2500, 0.3);

			// Format price
			$formatPrice = str_replace("￦", "", $data['discount_price']);
			$formatPrice = str_replace(",", "", $formatPrice);
			$formatPrice = preg_replace('/[^0-9]/', '', $formatPrice);

			// Ceil price
			$discount = ceil($discount / 1000) * 1000;
			$originPrice = ceil($originPrice / 1000) * 1000;
			$formatPrice = ceil($formatPrice / 1000) * 1000;

			// Search product in database
			$queryProduct = $this->Products->find('all', [
				'conditions' => ['Products.name' => $data['title']],
				'order' => ['Products.id' => 'desc'],
			]);

			$dbProduct = $queryProduct->first();

			$product = $this->Products->newEntity();
			if (!empty($dbProduct['id'])) {
				$product->id = $dbProduct['id'];
			}
			$product->category_id = $categoryId;
			$product->name = $data['title'];
			$product->model = $data['shipping'];
			$product->description = $data['title'];
			$product->buy_price = intval($originPrice);
			$product->sell_price = intval($discount);
			$product->discount_percent = $data['discount'];
			$product->units_in_stock = 999;
			$product->thumb = $this->saveImage($data['img']);
			$product->created = date("Y-m-d H:i:s", strtotime('now'));
			$product->modified = date("Y-m-d H:i:s", strtotime('now'));
			$product->crawl_url = $data['href'];
			$product->trademark_id = 1;
			$product->total_bought = 100;
			$product->calc_price = $formatPrice;
			$product->discount_endtime = date("Y-m-d", strtotime("+1 day"));
			$product->crawl_info_url = $data['link'];
			$product->crawl_detail_url = $data['detail'];
			$product->crawl_status = "INFO";
			$product->rating = rand(1, 5);
			$product->status = 1;
			$product->sub_category_id = $data['sub_category_id'];
			$product->slug = rand() . '-' . $data['slug'];
			$product->shipping = $data['ship_fee'];

			if ($this->Products->save($product)) {
				echo "{$product->name}:SUCCESS \n";
			} else {
				echo "FAIL \n";
			}
		}
	}

	public function crawlProduct() {
		$this->loadModel("Products");
		$query = $this->Products->find('all', [
			'conditions' => ['Products.crawl_status' => 'INFO'],
			'order' => ['Products.id' => 'desc'],
		]);

		$product = $query->first();

		if (empty($product['id'])) {
			exit("No product..");
		}

		$parts = parse_url(trim($product['crawl_url']));
		parse_str($parts['query'], $query);

		$goodsCode = !empty($query['goodscode']) ? $query['goodscode'] : null;

		$productInfo = $this->scrapGmarketProd($goodsCode);

		$editProduct = $this->Products->newEntity();

		$editProduct->id = $product['id'];
		// Update weight
		if (!empty($productInfo['weight'])) {
			$editProduct->weight = $productInfo['weight'];

			// Shipping fee extract
			preg_match("/(￦)([0-9\,]+)/", $product->shipping, $preg_match);

			$shippingFee = null;
			if (!empty($preg_match[0])) {
				$shippingFee = $preg_match[0];
			}

			// Re-calculate sell price
			$editProduct->sell_price = $this->calculatePrice($product->calc_price, $shippingFee, $productInfo['weight']);
		}

		$editProduct->description = $this->scrapGmarketProdDetail($goodsCode);

		$editProduct->crawl_status = 'DETAIL';

		$this->Products->save($editProduct);

		exit('Done..' . $editProduct->id);
	}

	/**
	 * Crawl hot products
	 *
	 * @return [type] [description]
	 */
	public function crawlHotProducts() {
		try {
			//May need to set more options due to ssl issues
			putenv("PHANTOMJS_EXECUTABLE=/usr/local/bin/phantomjs");
			$casper = new Casper();
			$casper->setOptions(array('ignore-ssl-errors' => 'yes'));
			$casper->start('http://gcorner.gmarket.co.kr/SuperDeals/?GroupNo=2');
			// $casper->wait(1000);
			$casper->waitForSelector('.img_list', 1000);
			$casper->run();
			$output = $casper->getOutput();
			$html = $casper->getHtml();

			$dom = HtmlDomParser::str_get_html($html);

			$results = array();
			foreach ($dom->find('ul[class=img_list] li') as $elem) {
				// $linkWithGoodcode = $elem->find('.item_name',0)->href;
				// $goodsCodeParts = parse_url($linkWithGoodcode);
				// parse_str($goodsCodeParts['query'], $query);

				// $goodsCode = $query['goodscode'];

				$results[] = [
					'title' => $elem->find(".item_name", 0)->innertext,
					'slug' => $this->to_slug($elem->find(".item_name", 0)->innertext),
					'origin_price' => !empty($elem->find(".orgin_price", 0)->innertext) ? $elem->find(".orgin_price", 0)->innertext : null,
					'discount' => !empty($elem->find(".discount", 0)->innertext) ? $elem->find(".discount", 0)->innertext : null,
					'discount_price' => $elem->find(".discount_price", 0)->innertext,
					'exchange_rate' => $elem->find(".exchange_rate", 0)->innertext,
					'img' => $elem->find('.thumb_nail', 0)->src,
					'href' => "http://gcorner.gmarket.co.kr/SuperDeals/?GroupNo=2",
					'link' => "empty",
					'detail' => 'empty',
				];
			}

			$this->loadModel('Products');
			foreach ($results as $data) {
				if (empty($data['origin_price']) || $data['origin_price'] == 0) {
					$data['orgin_price'] = $data['discount_price'];
				}

				$discount = $this->calculatePrice($data['discount_price'], 2500, 0.3);
				$originPrice = $this->calculatePrice($data['origin_price'], 2500, 0.3);

				// Format price
				$formatPrice = str_replace("￦", "", $data['discount_price']);
				$formatPrice = str_replace(",", "", $formatPrice);
				$formatPrice = preg_replace('/[^0-9]/', '', $formatPrice);

				// Ceil price
				$discount = ceil($discount / 1000) * 1000;
				$originPrice = ceil($originPrice / 1000) * 1000;
				$formatPrice = ceil($formatPrice / 1000) * 1000;

				$product = $this->Products->newEntity();
				$product->category_id = 22;
				$product->name = $data['title'];
				$product->model = !empty($data['shipping']) ? $data['shipping'] : "International Shipping";
				$product->description = $data['title'];
				$product->buy_price = intval($originPrice);
				$product->sell_price = intval($discount);
				$product->discount_percent = !empty($data['discount']) ? $data['discount'] : 0;
				$product->units_in_stock = 999;
				$product->thumb = $this->saveImage($data['img']);
				$product->created = date("Y-m-d H:i:s", strtotime('now'));
				$product->modified = date("Y-m-d H:i:s", strtotime('now'));
				$product->crawl_url = $data['href'];
				$product->trademark_id = 1;
				$product->total_bought = 100;
				$product->calc_price = $formatPrice;
				$product->discount_endtime = date("Y-m-d", strtotime("+1 day"));
				$product->crawl_info_url = $data['link'];
				$product->crawl_detail_url = $data['detail'];
				$product->crawl_status = "INFO";
				$product->status = 1;
				$product->rating = rand(1, 5);
				$product->sub_category_id = 10;
				$product->slug = rand() . '-' . $data['slug'];
				$product->shipping = 'Free';

				if ($this->Products->save($product)) {
					echo "{$product->name}:SUCCESS \n";
				} else {
					echo "FAIL \n";
					echo "<pre>";
					print_r($product);
					echo "</pre>";
				}
				//break;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Test Gmarket products
	 *
	 * How to run this cron
	 * CategoryId
	 * GdlcCd
	 * GdmcCd
	 */
	public function scrapGmarket($GdlcCd, $GdmcCd, $GdscCd = null, $subCategoryId = null, $page = 1) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "http://gcategory.gmarket.co.kr/SearchService/SeachListTemplateAjax");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "type=LIST&page={$page}&pageSize=60&keyword=&GdlcCd=$GdlcCd&GdmcCd=$GdmcCd&GdscCd=$GdscCd&priceStart=&priceEnd=&searchType=LIST&IsOversea=False&isDeliveryFeeFree=&isDiscount=False&isGmileage=False&isGStamp=False&isGmarketBest=&orderType=&listType=LIST&IsBookCash=False&IsGlobalSort=True&DelFee=&CurrPage=cpp&isGlobalSite=true");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

		$result = curl_exec($ch);

		$decode = json_decode($result);
		$dom = HtmlDomParser::str_get_html(trim($decode->message));

		$datas = array();
		foreach ($dom->find("tr") as $elem) {
			preg_match_all('/<a .*?>(.*?)<\/a>/', $elem->find('li[class=discount_price]', 0)->innertext, $matches);

			$datas[] = [
				'title' => $elem->find('.thumb_nail', 0)->alt,
				'img' => $elem->find('.thumb_nail', 0)->src,
				'shipping' => $elem->find('.cpp_icon', 0)->plaintext,
				'origin_price' => !empty($elem->find('.orgin_price', 0)->innertext) ? $elem->find('.orgin_price', 0)->innertext : 0,
				'href' => sprintf("%s%s", $this->gmarketProdLink, $elem->find('.item_name a', 0)->gdno),
				'ship_fee' => $elem->find('td[class=center]', 0)->plaintext,
				'discount_price' => $matches[1][0],
				'exchange_rate' => !empty($elem->find('.exchange_rate', 0)->innertext) ? $elem->find('.exchange_rate', 0)->innertext : 0,
				'discount' => !empty($elem->find('li[class=discount]', 0)->innertext) ? $elem->find('li[class=discount]', 0)->innertext : 0,
				'link' => 'https://wowmua.com/cron/scrapGmarketProd/' . $elem->find('.item_name a', 0)->gdno,
				'detail' => 'https://wowmua.com/cron/scrapGmarketProdDetail/' . $elem->find('.item_name a', 0)->gdno,
				// 'calculate_price' => $this->calculatePrice($matches[1][0], 2500, 0.3),
				'sub_category_id' => $subCategoryId,
				'slug' => $this->to_slug($elem->find('.thumb_nail', 0)->alt),
				'iframe_url' => 'http://mg.gmarket.co.kr/ItemDetail?GoodsCode=' . $elem->find('.item_name a', 0)->gdno,
			];
		}

		// Debug
		return $datas;
	}

	/**
	 * Cào chi tiết SP
	 *
	 */
	public function scrapGmarketProd($id = '') {
		try {
			//May need to set more options due to ssl issues
			putenv("PHANTOMJS_EXECUTABLE=/usr/local/bin/phantomjs");
			$casper = new Casper();
			$casper->setOptions(array('ignore-ssl-errors' => 'yes'));
			$casper->start('http://item2.gmarket.co.kr/English/detailview/item.aspx?goodscode=' . $id);
			// $casper->wait(1000);
			$casper->waitForSelector('.seller_goods', 1000);
			$casper->run();
			$output = $casper->getOutput();
			$html = $casper->getHtml();

			$dom = HtmlDomParser::str_get_html($html);

			$goodsInfo = $dom->find('table[class=goods-info]', 0)->innertext;

			preg_match("/[0-9]+(\.[0-9][0-9]?)?(KG|K|kg|Kg)/", $goodsInfo, $preg_match);

			$data = [
				'title' => $dom->find('.tit', 0)->innertext,
				'discount' => $dom->find('.numstyle', 0)->innertext,
				'weight' => $preg_match[0],
			];

			// Infos
			$infos = $dom->find("table[class=goods-info] tbody tr", 1);
			foreach ($infos as $info) {
				$data[$info->find('th', 0)->innertext] = html_escape($info->find('td', 0)->innertext);
			}

			return $data;
		} catch (Exception $e) {

		}
	}

	public function scrapGmarketProdDetail($id = '') {
		try {
			//May need to set more options due to ssl issues
			putenv("PHANTOMJS_EXECUTABLE=/usr/local/bin/phantomjs");
			$casper = new Casper();
			$casper->setOptions(array('ignore-ssl-errors' => 'yes'));
			$casper->start('http://mg.gmarket.co.kr/ItemDetail?GoodsCode=' . $id);
			// $casper->wait(1000);
			$casper->waitForSelector('.vip_detaile', 1000);
			$casper->run();
			$output = $casper->getOutput();
			$html = $casper->getHtml();

			$dom = HtmlDomParser::str_get_html($html);

			$data = array();
			foreach ($dom->find('img') as $elem) {
				if (strstr($elem->src, "doubleclick")) {
					continue;
				}

				$data[] = $elem->src;
			}

			$text = "";
			foreach ($data as $val) {
				// $imgProd = $this->saveImage($val);
				$text .= "<p><img src='{$val}' style='width:100%' /></p><br>";
			}

			return $text;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Test category
	 */
	public function scrapGmarketCategory() {
		exit();
		try {
			//May need to set more options due to ssl issues
			putenv("PHANTOMJS_EXECUTABLE=/usr/local/bin/phantomjs");
			$casper = new Casper();
			$casper->setOptions(array('ignore-ssl-errors' => 'yes'));
			$casper->start('http://gcategory.gmarket.co.kr/Listview/Category?GdlcCd=100000005');
			$casper->wait(2000);
			$casper->waitForSelector('#gnb', 5000);
			$casper->run();
			$output = $casper->getOutput();
			$html = $casper->getHtml();

			$dom = HtmlDomParser::str_get_html($html);
			$elements = $dom->find("ul[id=gnb] li");

			$data = [];
			foreach ($elements as $ele) {
				$data[] = $ele->find('a', 0)->innertext;
			}

			// Category insert
			$this->loadModel('Categories');
			foreach ($data as $cate) {
				$category = $this->Categories->newEntity();
				$category->name = trim($cate);
				$category->created = $category->modified = date("Y-m-d H:i:s", strtotime('now'));
				if ($this->Categories->save($category)) {
					echo "{$cate}:OK";
				} else {
					echo "{$cate}:FAIL";
				}
			}

			echo json_encode($data);
		} catch (Exception $e) {

		}
	}

	/**
	 * Convert all prices
	 */
	public function roundPrices() {
		exit("No access.");
		$this->loadModel('Products');
		$products = $this->Products->find('all', [
			'order' => ['Products.id' => 'asc'],
		]);

		foreach ($products as $pro) {
			$product = $this->Products->newEntity();
			$product->id = $pro->id;
			$product->buy_price = number_format(ceil($pro->buy_price / 1000) * 1000);
			$product->sell_price = number_format(ceil($pro->sell_price / 1000) * 1000);

			$this->Products->save($product);
		}

		echo "Done";
	}

	/**
	 * Lay danh sach categories voi id=>name
	 * Categories with [id => name]
	 */
	public function getCategories() {
		$this->loadModel('Categories');
		$categories = $this->Categories->find()
			->select(['id', 'name']);
		echo json_encode(array_column($categories->toList(), 'name', 'id'));
	}

	private function currencyRate() {
		# code...
	}

	private function saveImage($link) {
		// Replace middle_jpgimg2 with middle_jpgimg
		$link = str_replace("middle_jpgimg2", "middle_jpgimg", $link);

		$todayDir = $this->createFolder();
		$fileName = rand() . '.jpg';
		$target_file = $todayDir . DS . $fileName;

		$image = file_get_contents($link);
		file_put_contents($target_file, $image); //Where to save the image on your server
		return $this->testLink . DS . 'img' . DS . 'news' . DS . date('Y') . DS . date('m') . DS . date('d') . DS . $fileName;
	}

	private function convertCurrency($value = '', $replace_value = '') {
		if (empty($value)) {
			return $replace_value;
		}

		$price = str_replace("￦", "", $value);
		$price = str_replace(",", "", $price);
		$price = preg_replace('/[^0-9]/', '', $price);

		// KRW => VND
		$price = $price * 21.13;

		return $price;
	}

	//GIÁ MỸ PHẨM MUA TẠI WEB = [GIÁ SẢN PHẨM + TIỀN SHIP NỘI ĐỊA HÀN + TIỀN MUA HỘ VÀ VẬN CHUYỂN TỪ HÀN QUỐC VỀ VIỆT NAM] x TỶ GIÁ x 1.08 + TIỀN DỊCH VỤ
	private function calculatePrice($originPrice, $shipLocalPrice = 2500, $weight) {
		// Tinh gia san pham
		$price = str_replace("￦", "", $originPrice);
		$price = str_replace(",", "", $price);
		$price = preg_replace('/[^0-9]/', '', $price);
		$price = $price * 22;

		// Tien noi dia han
		$shipPrice = str_replace("￦", "", $shipLocalPrice);
		$shipPrice = str_replace(",", "", $shipPrice);
		$shipPrice = preg_replace('/[^0-9]/', '', $shipPrice);
		$shipPrice = $shipPrice * 22;

		// Tien mua ho va van chuyen
		if ($weight * 9000 * 22 < 80000) {
			$weight = 80000;
		} else {
			$weight = $weight * 9000 * 22;
		}

		return ($price + $shipPrice + $weight) * 1.08 + 30000;
	}

	/**
	 * Test
	 * @return [type] [description]
	 */
	public function test() {
		$this->autoRender = false;
		// echo "You are not authorized to access here";
		try {
			//May need to set more options due to ssl issues
			putenv("PHANTOMJS_EXECUTABLE=/usr/local/bin/phantomjs");
			$casper = new Casper();
			$casper->setOptions(array('ignore-ssl-errors' => 'yes'));
			$casper->start('http://gcategory.gmarket.co.kr/Listview/Category?GdlcCd=100000005');
			$casper->wait(2000);
			$casper->waitForSelector('.price_cont', 5000);
			$casper->run();
			$output = $casper->getOutput();
			$html = $casper->getHtml();
			$dom = HtmlDomParser::str_get_html($html);
			$elems = $dom->find("tbody[id=srplist] tr");
			$data = [];
			foreach ($dom->find("tbody[id=srplist] tr") as $e) {
				$data[] = [
					'title' => $e->find('div[class=produt_img]'),
				];
				break;
			}
			echo json_encode($data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Test Gmarket
	 */
	public function testGmarket() {
		$this->autoRender = false;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://gcategory.gmarket.co.kr/SearchService/SeachListTemplateAjax");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "type=LIST&page=1&pageSize=60&keyword=&GdlcCd=100000005&GdmcCd=&GdscCd=&priceStart=&priceEnd=&searchType=LIST&IsOversea=False&isDeliveryFeeFree=&isDiscount=False&isGmileage=False&isGStamp=False&isGmarketBest=&orderType=&listType=LIST&IsBookCash=False&IsGlobalSort=True&DelFee=&CurrPage=cpp&isGlobalSite=true");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		$result = curl_exec($ch);
		$decode = json_decode($result);
		$dom = HtmlDomParser::str_get_html(trim($decode->message));
		$data = array();
		foreach ($dom->find("tr") as $elem) {
			preg_match_all('/<a .*?>(.*?)<\/a>/', $elem->find('li[class=discount_price]', 0)->innertext, $matches);
			$data[] = [
				'title' => $elem->find('.thumb_nail', 0)->alt,
				'img' => $elem->find('.thumb_nail', 0)->src,
				'shipping' => $elem->find('.cpp_icon', 0)->plaintext,
				'origin_price' => !empty($elem->find('.orgin_price', 0)->innertext) ? $elem->find('.orgin_price', 0)->innertext : 0,
				'discount_price' => $matches[1][0],
				'exchange_rate' => !empty($elem->find('.exchange_rate', 0)->innertext) ? $elem->find('.exchange_rate', 0)->innertext : 0,
				'discount' => !empty($elem->find('li[class=discount]', 0)->innertext) ? $elem->find('li[class=discount]', 0)->innertext : 0,
			];
		}
		echo json_encode($data);
	}

	/**
	 * Test category
	 */
	public function testCategory() {
		$this->autoRender = false;
		try {
			//May need to set more options due to ssl issues
			putenv("PHANTOMJS_EXECUTABLE=/usr/local/bin/phantomjs");
			$casper = new Casper();
			$casper->setOptions(array('ignore-ssl-errors' => 'yes'));
			$casper->start('http://gcategory.gmarket.co.kr/Listview/Category?GdlcCd=100000005');
			$casper->wait(2000);
			$casper->waitForSelector('#gnb', 5000);
			$casper->run();
			$output = $casper->getOutput();
			$html = $casper->getHtml();
			$dom = HtmlDomParser::str_get_html($html);
			$elements = $dom->find("ul[id=gnb] li");
			$data = [];
			foreach ($elements as $ele) {
				$data[] = $ele->find('a', 0)->innertext;
			}
			echo json_encode($data);
		} catch (Exception $e) {
		}
	}
}