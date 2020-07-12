<?php

class FileUpload extends AppModel {

	public function save_email_records($name,$email)
	{
		return $this->query("INSERT INTO file_uploads (name,email,valid,created,modified) VALUES ('".$name."','".$email."',1,now(),now())");
	}
}