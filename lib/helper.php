<?php

	class Helper{

		public function validation($data, $field){
			if(strlen($data) == 0)
			{
				echo "<div style='color:red;text-align:center;'><b>Please Input $field !</b></div>";
				return 0;
			}
			$data = trim($data);
			$data = stripcslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		public function validateEmail($data, $field)
		{
            if ($this->validation($data, $field)) {
                if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
                    return $data;
                } else {
                    return 0;
                }
			}
			else{
				$data = '';
				return $data;
			}
		}

		public function matchPassword($password, $password_confirm)
		{
			if($password=='' || $password_confirm == '')
			{
				return 0;
			}
			if($password === $password_confirm)
			{
				return true;
			}
			return 0;
		}

		public function hashPassword($password)
		{
			return md5($password);
		}

	}
?>