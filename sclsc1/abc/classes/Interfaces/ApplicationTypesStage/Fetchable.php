<?php
	namespace classes\Interfaces\ApplicationTypesStage;
	
	interface Fetchable
	{
		
		/**
		 * This function returns all LetterType as an array which are enabled
		 *		
		 *
		 */
		
		public function getApplicationStage();
		
		public function getApplicationTypeStage($id);
		
		
	
		
		
	}
?>