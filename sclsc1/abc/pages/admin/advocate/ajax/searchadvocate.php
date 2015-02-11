<?php

session_start();
error_reporting(0);
if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
require_once $_SESSION['base_url'].'/classes/Implementation/Advocate/Fetch.php';
require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';


use classes\Implementation\Advocate as impAdvocate;
use classes\Pagination as impPage;

$fetchAdvocate = new impAdvocate\Fetch();
$fetchPage  = new impPage\Pagination();

//echo $_GET['reg_date'];
$msg='';
$errmsg='';
$targetpage = 'advocatetimeperiod.php';
$adjacents = 10;
$limit = 2;
$start = 0;
$page = 0;

if(isset($_GET['page']))
{
	$page = $_GET['page'];
	if($page)
		$start = ($page - 1) * $limit;
	else
		$start = 0;
}
//echo  $_GET['reg_date']; exit;

if(isset($_GET['reg_date'])){
	
 	$alladvocates= $fetchAdvocate->getAllSearchAdvocate($_GET['reg_date'],$limit,$start);
	$Records = $fetchAdvocate->getAllSearchAdvocateCount($_GET['reg_date']);	
	$url='';
	$pagination = $fetchPage->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
}

/*
if(isset($_GET['reg_date']) && $_GET['reg_date']==''){
	
	$diary      = $fetchDiary->getAllDiary($limit,$start);
	$Records    = $fetchDiary->getAllDiaryCount();	
	$url='';
	$pagination = $fetchPage->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
}
*/
//$alladvocates = $fetchAdvocate->AdvocatetimePeriod();
//echo $alladvocates[$i]['start_date'];exit;
?>
<?php if(isset($alladvocates) && count($alladvocates)>0) { ?>
					<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
                               <tr width="100%">
			     					<th width="2%">S/N</th>
			     					<th width="8%">Name</th>
			     					<th width="25%">Code</th>
			     					<th width="12%">Email Id</th>
			     					<th width="10%">Mobile No</th>
			     					<th width="13%">Registration Date</th>		     					
			     					
			     				</tr>
			     				
			     				<?php			     				
	     							for($i =0;$i<count($alladvocates);$i++)
									{
																				
										$class = ($i % 2 == 0) ? 'even' : 'odd';
										$startDate=$alladvocates[$i]['start_date'];
	 									$begin=strtotime($startDate);
	 									$end =strtotime(date('Y-m-d'));
										$diff = $end - $begin;
	 									$days= round($diff / 86400);
	 	
	 									if($days>=730)
	 								  {
										
								?>
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php echo $i+1; ?></td>
				     					 <td><a href="view_adv_details.php?advocateId=<?php echo $alladvocates[$i]['id']; ?>"><?php echo $alladvocates[$i]['advocate_name']; ?></a></td>
			     					     <td><?php echo $alladvocates[$i]['advocate_code']; ?></td>
			     					     <td><?php echo $alladvocates[$i]['email_id']; ?></td>
			     					     <td><?php echo $alladvocates[$i]['contact_no1']; ?></td>
		                                 <td><?php if ($alladvocates[$i]['start_date']!='') echo date("d-m-Y", strtotime($alladvocates[$i]['start_date'])); ?></td>
		                          
				     				</tr>
				     				
	     						<?php 
	 								  }
										}
									echo $pagination;
		     					?>
		     					
		     				</table>
		     				<?php }else{ echo 'No Records found..';}?>