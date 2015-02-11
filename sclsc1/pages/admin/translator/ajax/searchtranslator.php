
<?php

session_start();
//echo $_GET['reg_date'];exit;
//error_reporting(0);
if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
   require_once $_SESSION['base_url'].'/classes/Implementation/Translator/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';

	use classes\Implementation\Translator as impTranslator;
	use classes\Pagination as impPage;

	$fetchTranslator = new impTranslator\Fetch();
	$fetchPage     = new impPage\Pagination();
	

	$msg='';
	$errmsg='';
	$targetpage = 'searchtranslator.php';
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

if(isset($_GET['reg_date']))
{
	//echo $_GET['reg_date'];exit;
	$alltranslator= $fetchTranslator->getAllSearchTranslator($_GET['reg_date'],$limit,$start);
	$Records = $fetchTranslator->getAllSearchTranslatorCount($_GET['reg_date']);	
	$url='';
	$pagination = $fetchPage->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
}

?>
<?php if(isset($alltranslator) && count($alltranslator)>0) { ?>
					<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
                               <tr width="100%">
			     					<th width="2%">S/N</th>
			     					<th width="8%">Name</th>
			     					<th width="12%">Email Id</th>
			     					<th width="10%">Mobile No</th>
			     					<th width="13%">Registration Date</th>		     					
			     					
			     				</tr>
			     				
			     				<?php			     				
	     							for($i =0;$i<count($alltranslator);$i++)
									{
																				
										$class = ($i % 2 == 0) ? 'even' : 'odd';
										$startDate=$alltranslator[$i]['start_date'];
								 		$begin=strtotime($startDate);
								 		$end =strtotime(date('Y-m-d'));
										$diff = $end - $begin;
								 		$days= round($diff / 86400);
								 		if($days>=730)
								 	   { 
										
								?>
				     		<tr class="<?php echo $class; ?>">
				     		 <td><?php echo $i+1; ?></td>
				     		 <td><?php echo $alltranslator[$i]['translator_name']; ?></td>
	     					 <td><?php echo $alltranslator[$i]['email_id']; ?></td>
	     					 <td><?php echo $alltranslator[$i]['contactno1']; ?></td>
	     					 <td><?php if ($alltranslator[$i]['start_date']!='') echo date("d-m-Y", strtotime($alltranslator[$i]['start_date'])); ?></td>
                            </tr>
				     	<?php 
								}
									}
										echo $pagination;
		     					?>
		     					
		     				</table>
		     				<?php }else{ echo 'No Records found..';}?>
