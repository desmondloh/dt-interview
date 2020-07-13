<?php
//use Cake\Datasource\ConnectionManager;
class Migration extends AppModel {

	//$useTable = 'members';
	//$this->table('members');

	public function save_mbr_records($date,$year,$month,$refno,$mbrName,$mbrType,$mbrNo,$mbrPayType,$mbrCompany,$payBy,$batchNo,$recNo,$chequeNo,$payDesc,$renewalYear,$subtotal,$totaltax,$total)
	{
		$db = ConnectionManager::getDataSource('default');

		$sql = "select * from members where name='".$mbrName."'";
		$myData = $db->query($sql);
		$count = count($myData);

		//This is how to get the data value from db.
		//echo $myData[0]['members']['id'];
		
		//We will insert into members if no existing records is found.
		if($count == 0)
		{
			//Insert the records into members table first
			$sql2 = "insert into members (type,no,name,company,created,modified) values ('".$mbrType."','".$mbrNo."','".$mbrName."','".$mbrCompany."',now(),now())";
			$db->query($sql2);

			//Retrieve the id and member name from the member table
			// $sql3 = "select * from members where name='".$mbrName."'";
			// $myData3 = $db->query($sql3);

			// var_dump($myData3);

			// echo $myData3[0]['members']['id'];
			// $mbr_id = $myData3[0]['members']['id'];

			//insert the records into transaction table
			$sql4 = "insert into transactions (member_id,member_name,member_paytype,member_company,date,year,month,ref_no,receipt_no,payment_method,batch_no,cheque_no,payment_type,renewal_year,subtotal,tax,total,created,modified) values ((select id from members where name='".$mbrName."'),'".$mbrName."','".$mbrPayType."','".$mbrCompany."','".$date."','".$year."','".$month."','".$refno."','".$recNo."','".$payBy."','".$batchNo."','".$chequeNo."','".$payDesc."','".$renewalYear."','".$subtotal."','".$totaltax."','".$total."',now(),now())";
			$db->query($sql4);

			//Retrieve the id of transaction from transaction table
			// $sql5 = "SELECT * FROM transactions WHERE member_name='".$mbrName."' and receipt_no='".$recNo."'";
			// $myData5 = $db->query($sql5);

			// $tid = $myData5[0]['transactions']['id'];

			//check the if the transaction id exist in transaction_items table
			// $sql6 = "select * from transaction_items where transaction_id='".$tid."'";
			// $myData6 = $db->query($sql6);
			// $count6 = count($myData6);

			// //if 0, then insert, otherwise, skip it.
			// if($count6 == 0)
			// {
				$sql7 = "insert into transaction_items (transaction_id,description,quantity,unit_price,sum,created,modified,`table`,table_id) values ((select id from transactions where member_name='".$mbrName."' and receipt_no='".$recNo."'),'Being Payment for : ".$payDesc." : ".$renewalYear."','1','".$subtotal."','".$subtotal."',now(),now(),'Member',(select id from members where name='".$mbrName."'))";
				$db->query($sql7);
			//}

			echo "This Member & Transaction Records is successfully saved: ".$mbrName."<br/>";
		}
		else
		{
			echo "This Member & Transaction Records exist: ".$mbrName."<br/>";
		}

	}
}