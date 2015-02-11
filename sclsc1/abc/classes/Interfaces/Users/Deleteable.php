<?php
	namespace classes\Interfaces\Users;
	
	interface Deleteable
	{
		/**
		 * 
		 * @param unknown $applicationId
		 */
		public function delUser($UserId);
	}
?>