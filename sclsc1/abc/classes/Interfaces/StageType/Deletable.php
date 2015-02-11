<?php
	namespace classes\Interfaces\StageType;
	
	interface Deletable
	{	
		
	/**
	 * this fuction will delete all recards of Document from database
	 * @param integer $advocateId
	 */
	
	public function deleteStage($Stage_id);
		
	}
?>
