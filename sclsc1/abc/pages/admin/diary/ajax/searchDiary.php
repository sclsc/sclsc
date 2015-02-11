<?php
session_start();
if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Fetch.php';
require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';


use classes\Implementation\Diary as impDiary;
use classes\Pagination as impPage;

$fetchDiary = new impDiary\Fetch();
$fetchPage  = new impPage\Pagination();


$msg='';
$errmsg='';
$targetpage = 'diary.php';
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

if(isset($_GET['diary_no'])){
	$diary= $fetchDiary->getAllSearchDiary($_GET['diary_no'],$limit,$start);
	$Records = $fetchDiary->getAllSearchDiaryCount($_GET['diary_no']);	
	$url='';
	$pagination = $fetchPage->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
}
if(isset($_GET['diary_no']) && $_GET['diary_no']==''){
	$diary      = $fetchDiary->getAllDiary($limit,$start);
	$Records    = $fetchDiary->getAllDiaryCount();	
	$url='';
	$pagination = $fetchPage->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
}
?>
<?php if(isset($diary) && count($diary)>0) { ?>
					<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
                               <tr width="100%">
			     					<th width="2%">S/N</th>
			     					<th width="8%">Diary No.</th>
			     					<th width="25%">Subject</th>
			     					<th width="12%">Applicant</th>
			     					<th width="10%">Mark To</th>
			     					<th width="13%">State</th>			     					
			     					<th width="2%">Recieved Date</th>
			     				</tr>
			     				
			     				<?php			     				
	     							for($i =0;$i<count($diary);$i++)
									{
																				
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php echo $i+1; ?></td>
				     					<td>
				     					<a href = "javascript:void(0)" onclick = "showDiaryDetails(<?php echo $diary[$i]['id']?>)"><?php echo $diary[$i]['diary_no']?></a>
        									<div id="light" class="white_content"></div>
        									<div id="fade" class="black_overlay"></div>
				     					<td><?php echo $diary[$i]['subject']; ?></td>
				     					<td><?php echo $diary[$i]['applicant']; ?></td>
				     					<td><?php echo $diary[$i]['user_name']; ?></td>
				     					<td><?php echo $diary[$i]['state_name']; ?></td>				     					
				     					<td><?php echo $diary[$i]['recieved_date']; ?></td>
				     				</tr>
				     				
	     						<?php 
									}									
									echo $pagination;
		     					?>
		     					
		     				</table>
		     				<?php }else{ echo 'No Records found..';}?>