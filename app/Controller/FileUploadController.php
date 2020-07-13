<?php

class FileUploadController extends AppController {
	public function index() {
		$this->set('title', __('File Upload Answer'));

		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));

		if(!empty($this->request->data['FileUpload']['file']))
		{
			$file = $this->request->data['FileUpload']['file'];
			$filename = explode('.',$this->request->data['FileUpload']['file']);
			//debug($filename);
			date_default_timezone_set('Asia/Singapore');
			if($filename[1]=='csv')
			{
				move_uploaded_file($file,  WWW_ROOT.'files/' . $file);
				$handle = fopen(WWW_ROOT.'files/'.$file, "r");
				
				while (($row = fgetcsv($handle,1000,",")) !== FALSE)
				{
					// $data = array(
					// 	'name'=>$row[0],
					// 	'email'=>$row[1],
					// 	'valid'=>1,
					// 	'created'=>date('d-m-Y H:i:s'),
					// 	'modified'=>date('d-m-Y H:i:s')
					// );
					//$FileUpload = $this->FileUpload->newEntity($data);
					$this->FileUpload->save_email_records($row[0],$row[1]);
					//echo 'Name: ' . $row[0] . '<br>';
    				//echo 'Email: ' . $row[1] . '<br>';
				}
				fclose($handle);
				return $this->redirect(['controller' => 'FileUpload', 'action' => 'index']); // cake3.X
			}
			else
			{
				//$this->setFlash->error('You did not upload the correct file format. Please upload only CSV File');
				$this->setFlash('You did not upload the correct file format. Please upload only CSV File');
				//$this->Flash->set('title',__('You did not upload the correct file format. Please upload only CSV File'));
				//$this->set('title',__('You did not upload the correct file format. Please upload only CSV File'));
			}
		}
		
	}
}