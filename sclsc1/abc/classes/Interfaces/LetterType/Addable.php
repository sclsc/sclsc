<?php	namespace classes\Interfaces\LetterType;		interface Addable	{			   /*	    *	   * This function will insert Document	   * @return - This function returns true if insertion query excute successfully	   */	   	public function addLetterType(				    $name,			 		$stage,				    $sub_stages,                    $filepath );	 	 	    			}?>