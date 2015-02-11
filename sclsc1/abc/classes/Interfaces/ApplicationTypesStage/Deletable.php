<?php
	namespace classes\Interfaces\ApplicationTypesStage;
	
	interface Deletable
	{	
		
	/**
	 * this fuction will delete all recards of Document from database
	 * @param integer $advocateId
	 */
	
	public function deleteApplicationStage($applicationstage_id);
		
	}
?>
