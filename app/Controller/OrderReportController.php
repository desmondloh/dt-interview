<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
			//debug($orders);exit;
			//debug($orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
			//debug($portions);exit;
			//debug($portions);

			$order_reports = array();
			$item_array = array();
			$in_array = array();

			//To loop through orders
			foreach ($orders as $o)
			{
				echo $o['Order']['name']."<br/>";
				$order_reports[$o['Order']['name']] = array();

				//To loop through order details
				foreach ($o['OrderDetail'] as $od)
				{
					echo "o ".$od['Item']['name']." - Qty: ".$od['quantity']."<br/>";

					$item_array = array($od['Item']['name']=>$od['quantity']);
					$order_reports[$o['Order']['name']] = array_merge($order_reports[$o['Order']['name']],$item_array);

					// To loop through portion
					foreach ($portions as $p)
					{
						//To find portion that belong to the order details above.
						if ($od['item_id'] == $p['Portion']['item_id']) {

				            //To loop through portion details
				            foreach ($p['PortionDetail'] as $pd)
				            {
				            	echo "-- Ingredient Name :".$pd['Part']['name']." - Qty: ".(int)$pd['value']."<br/>";
				            	$in_array = array($pd['Part']['name'] => $pd['value']);

				            	//I am not sure how to create this array and put into the array above.//

				            	//$item_array = array_merge($od['Item']['name'],$in_array);
				            }
				        }
					}
				}
			}

			//debug($order_reports);
			//debug($in_array);

			// To Do - write your own array in this format
			// $order_reports = array('Order 1' => array(
			// 							'Ingredient A' => 1,
			// 							'Ingredient B' => 12,
			// 							'Ingredient C' => 3,
			// 							'Ingredient G' => 5,
			// 							'Ingredient H' => 24,
			// 							'Ingredient J' => 22,
			// 							'Ingredient F' => 9,
			// 						),
			// 					  'Order 2' => array(
			// 					  		'Ingredient A' => 13,
			// 					  		'Ingredient B' => 2,
			// 					  		'Ingredient G' => 14,
			// 					  		'Ingredient I' => 2,
			// 					  		'Ingredient D' => 6,
			// 					  	),
			// 					);

			// ...

			$this->set('order_reports',$order_reports);

			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}