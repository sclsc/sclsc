<?php
session_start();
if(!isset($_SESSION['user_name']))
	header('location:../../login.php');

include_once 'include/session.php';
require_once '../../classes/implementation/diary/Fetch.php';
require_once '../../classes/implementation/diary/Delete.php';
require_once '../../classes/implementation/misc/Fetch.php';

use classes\implementation\diary as impDairy;
use classes\implementation\misc as impMisc;

$fetchMisc = new impMisc\Fetch();
$fetchApplicationAdvocate = new impDairy\Fetch();

$msg='';
$errmsg='';
$targetpage = 'applications.php';
$adjacents = 2;
$limit = 10;
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
	$applicationAdvocate= $fetchApplicationAdvocate->getApplicationAdvocateDetailsByDiaryNo($_GET['diary_no'],$limit,$start);
	$Records = $fetchApplicationAdvocate->getApplicationCount($_GET['diary_no']);
	
	$url='';
	$pagination = $fetchMisc->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
}
if(isset($_GET['diary_no']) && $_GET['diary_no']==''){
	$applicationAdvocate= $fetchApplicationAdvocate->getApplicationAdvocateDetails($limit,$start);
		$Records = $fetchApplicationAdvocate->getApplicationCount(Null);	
	$pagination = $fetchMisc->paginations($page,$Records,$limit,$targetpage,$adjacents,$url);
}
?>
<?php if(isset($applicationAdvocate) && count($applicationAdvocate)>0) {?>
					<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     					<th width="2%" >Sr.No.</th>	
			     					<th width="15%">Application Type</th>		     					
			     					<th width="15%">Application No.</th>
			     					<th width="25%">Applicant Name</th>
			     					<th width="15%">Received Date</th>
			     					<th width="20%">Last Complited Statge</th>
			     					
			     				<?php if ($_SESSION['role_id']==4 || $_SESSION['role_id']==3) { ?>
			     					
			     					<th width="10%">Edit</th>
			     					
			     				<?php } if ($_SESSION['role_id']==4) { ?>
			     					
			     					<th width="2%">Delete</th>
			     					
			     				<?php } ?>
			     					
			     				</tr>
			     				
			     				<?php
			     				$hc_address1='';
			     				$hc_address2='';
			                    $city='';
			     				$state_name='';
			     				$pincode='';
	     						
	     							for($i =0;$i<count($applicationAdvocate);$i++)
									{
																				
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>" align="center">
				     					<td><?php echo $i+1; ?></td>
				     					<td><?php echo $applicationAdvocate[$i]['appli_type_name']; ?></td>
				     					<td><a href="view_application.php?applicationId=<?php echo $applicationAdvocate[$i]['id'] ?>"><?php echo $applicationAdvocate[$i]['diary_no']; ?></a></td>
				     					<td><?php echo $applicationAdvocate[$i]['applicant_name']; ?></td>
				     					<td><?php echo date("d-m-Y", strtotime($applicationAdvocate[$i]['received_date'])); ?></td>
				     					<td><?php echo $applicationAdvocate[$i]['stage_name']; ?></td>
				     					
				     				<?php if ($_SESSION['role_id']==4 || $_SESSION['role_id']==3) { ?>
				     					
				     					<td><a href="editIndex.php?applicationId=<?php echo $applicationAdvocate[$i]['id'] ?>">Edit</a></td>
				     					
				     					<?php } if ($_SESSION['role_id']==4) { ?>
				     					
				     					<td><a href="applications.php?applicationId=<?php echo $applicationAdvocate[$i]['id'] ?>&action=del">Delete</a></td>
				     					
				     					<?php } ?>
				     					
				     				</tr>
				     				
	     						<?php 
									}
									
									echo $pagination;
		     					?>
		     					
		     				</table>
		     				<?php }else{ echo 'No Records found..';}?>