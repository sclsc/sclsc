<?php	namespace classes\Interfaces\Misc;		interface Fetchable	{		/*		* Start Function getAllStates()		* This function returns all stages as an array which are enabled 		* @return - state[][]		*/				public function getAllStages();				/*		 * 		* This function returns all Sub stages as an array which are enabled		* @return - stage[][]		*/				public function getSubStages($stage_id);						/*		 *		* This function returns a stages Name as an array which are enabled		* @return - state[][]		*/				public function getStageName($stage_id);							}?>