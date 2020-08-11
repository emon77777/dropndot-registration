<?php

	Class Database{
		public $host   = DB_HOST;
		public $user   = DB_USER;
		public $pass   = DB_PASS;
		public $dbname = DB_NAME;

		public $link;
		public $error;

		function __construct(){
			$this->connectDB();
		}

		private function connectDB(){
			$this->link = new mysqli($this->host,$this->user,$this->pass,$this->dbname);
			if(! $this->link){
				$this->error="Connection Failed".$this->link->connect_error;
				return false;
			}
		}


		//to read a data from database

		public function select($query){
			$result=$this->link->query($query) or die($this->link->error.__LINE__);
			if($result->num_rows>0)
			{
				return $result;
			}
			else{
				return false;
			}
		}

		//to insert a data into database

		public function insert($query)
		{
			$insert_row=$this->link->query($query) or die($this->link->error.__LINE__);
			if($insert_row)
			{
				return $insert_row;
			}
			else
			{	
				return false;
			}
		}

		//to update a data into database

		public function update($query)
		{
			$update_row=$this->link->query($query) or die($this->link->error.__LINE__);
			if($update_row)
			{
				return $update_row;
			}
			else
			{	
				return false;
			}
		}

		
	}


?>