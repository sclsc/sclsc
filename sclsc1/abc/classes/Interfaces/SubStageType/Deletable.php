<?php
	namespace classes\Interfaces\SubStageType;
	
	interface Deletable
	{	
		
	/**
	 * this fuction will delete all recards of Document from database
	 * @param integer $advocateId
	 */
	
	public function deleteSubStage($SubStage_id);
		
	}
?>
