<?php 
   namespace classes\Pagination;
	
	class Pagination
	{	
		public static function paginations($page,$Records,$limit,$targetpage,$adjacents,$url)
		{
			if ($page == 0)
				 $page = 1;
			$prev = $page - 1;
			$next = $page + 1;
			$lastpage = ceil($Records/$limit);
				
			$lpm1 = $lastpage - 1;
			$pagination = "";
			if($lastpage > 1)
			{
				$pagination .= "<div class='pagination'>";
				if ($page > 1)
					$pagination.= "<a href='$targetpage?page=$prev&$url'>Previous</a>";
				else
					$pagination.= "<span class='disabled'>Previous</span>";
					
				if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
				{
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
					if ($counter == $page)
						$pagination.= "<span class='current'>$counter</span>";
						else
							$pagination.= "<a href='$targetpage?page=$counter&$url'>$counter</a>";
					}
					}
					elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
					{
					if($page < 1 + ($adjacents * 2))
					{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
					if ($counter == $page)
						$pagination.= "<span class='current'>$counter</span>";
						else
						$pagination.= "<a href='$targetpage?page=$counter&$url'>$counter</a>";
					}
					$pagination.= "...";
					$pagination.= "<a href='$targetpage?page=$lpm1&$url'>$lpm1</a>";
					$pagination.= "<a href='$targetpage?page=$lastpage&$url'>$lastpage</a>";
					}
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
					$pagination.= "<a href='$targetpage?page=1&$url'>1</a>";
					$pagination.= "<a href='$targetpage?page=2&$url'>2</a>";
					$pagination.= "...";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
					if ($counter == $page)
						$pagination.= "<span class='current'>$counter</span>";
						else
							$pagination.= "<a href='$targetpage?page=$counter&$url'>$counter</a>";
					}
					$pagination.= "...";
					$pagination.= "<a href='$targetpage?page=$lpm1&$url'>$lpm1</a>";
					$pagination.= "<a href='$targetpage?page=$lastpage&$url'>$lastpage</a>";
					}
					else
						{
						$pagination.= "<a href='$targetpage?page=1&$url'>1</a>";
						$pagination.= "<a href='$targetpage?page=2&$url'>2</a>";
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
						if ($counter == $page)
							$pagination.= "<span class='current'>$counter</span>";
							else
								$pagination.= "<a href='$targetpage?page=$counter&$url'>$counter</a>";
							}
							}
							}
								
							if ($page < $counter - 1)
								$pagination.= "<a href='$targetpage?page=$next&$url'>Next</a>";
							else
								$pagination.= "<span class='disabled'>Next</span>";
								$pagination.= "</div>\n";
								return $pagination;
					}
				}
	}
?>