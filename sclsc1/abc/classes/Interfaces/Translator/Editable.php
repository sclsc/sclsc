<?php	namespace classes\Interfaces\Translator;		interface Editable	{		/*		* Start Function updateState()		* This function will update state name		* @param state_id - this is the id of state		* @param state_name - the state Name which will be updated 		* @return - return status of state updation		*/				public function upTranslatorStatus($translatorId,$fullname,$gender,$lang,$email_id,$mobile_no,$mobile_no2,				$address1,$address2,$city,$state,$pincode,$c_name,			    $c_address1,$c_address2,$c_city,$c_state,$c_pincode,$start_date1,			    $end_date1,$hiddenData,$date_of_reg);				/*		 * End Function updateState()		*/	}?>