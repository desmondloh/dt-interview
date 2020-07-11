<?php
	class TypesController extends AppController{

		public function radioPosts(){
			//echo "Hello World!";
			//$this->setFlash('This is the result from the previous page.');

			if ($this->request->is('post')) {
		       
		       $rp = $this->data['Type']['type'];
		       $this->setFlash("This is the result of your selection from the previous page: ".$rp);
		       //$this->set('result', $this->data['Type']['type']);
		    }
		}
		
	}