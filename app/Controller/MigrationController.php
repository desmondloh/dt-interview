<?php

//use SimpleXLSX;

	class MigrationController extends AppController{
		
		public function q1(){
			
			$this->setFlash('Migration of data to multiple DB table completed.');

			echo '<br/><br/><h1>Migration Sample 1.xslx</h1>';
			if ( $xlsx = SimpleXLSX::parse(WWW_ROOT.'files/migration_sample_1.xlsx') ) {
				//print_r( $xlsx->rows() );
				$header_values = $rows = [];

				foreach ( $xlsx->rows() as $k => $r ) {
					if ( $k === 0 ) {
						$header_values = $r;
						continue;
					}
					$rows[] = array_combine( $header_values, $r );
				}
				for($i=0;$i<count($rows);$i++)
				{
					$date = $rows[$i]['Date'];
					$year = date('Y',strtotime($date));
					$month = date('n',strtotime($date));
					$refno = $rows[$i]['Ref No.'];
					$mbrName = $rows[$i]['Member Name'];
					//$mbrNo = $rows[$i]['Member No'];
					$mbrNoSplit = explode(" ",$rows[$i]['Member No']);
					$mbrType = $mbrNoSplit[0];
					$mbrNo = (int)$mbrNoSplit[1];
					$mbrPayType = $rows[$i]['Member Pay Type'];
					$mbrCompany = $rows[$i]['Member Company'];
					$payBy = $rows[$i]['Payment By'];
					$batchNo = $rows[$i]['Batch No'];
					$recNo = $rows[$i]['Receipt No'];
					$chequeNo = $rows[$i]['Cheque No'];
					$payDesc = $rows[$i]['Payment Description'];
					$renewalYear = (int)$rows[$i]['Renewal Year'];
					$subtotal = $rows[$i]['subtotal'];
					$totaltax = $rows[$i]['totaltax'];
					$total = $rows[$i]['total'];
					
					$this->Migration->save_mbr_records($date,$year,$month,$refno,$mbrName,$mbrType,$mbrNo,$mbrPayType,$mbrCompany,$payBy,$batchNo,$recNo,$chequeNo,$payDesc,$renewalYear,$subtotal,$totaltax,$total);

				}
				//print_r( $rows );
			} else {
				echo SimpleXLSX::parseError();
			}
			//echo '<pre>';
				
		}
		
		public function q1_instruction(){

			$this->setFlash('Question: Migration of data to multiple DB table');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
	}