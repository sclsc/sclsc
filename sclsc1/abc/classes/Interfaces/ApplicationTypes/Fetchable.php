<?php	namespace classes\Interfaces\ApplicationTypes;		interface Fetchable	{				/**		 * This function returns all Application Type as an array which are enabled 		 * 		 * @param integer $limit		 * @param integer $start		 * @return array		 * 		 */				public function getAllApplicationType($limit,$start);							/**		 * This function returns all Application Type count which are enabled		 * @return count		 */				public function getAllApplicationCount();				/**		 * This function returns TRUE IF alredy exit		 *		 * @param integer $limit		 * @param integer $start		 * @return array		 *		 */			   public function checkApplicationType($application_name);						}?>