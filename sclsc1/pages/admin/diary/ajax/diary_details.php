<?php 
	session_start();
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Fetch.php';
	use classes\Implementation\Diary as impDiary;
	$fetchDiary = new impDiary\Fetch();
	$diaryDetails = $fetchDiary->getDiaryDetails($_GET['q']);
	
	
	
?><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a>
	
	
		<div style="font-size:24px;color:#4b8df8;text-align:center;width:100%;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee">Diary Details</div>
		     		<div style="clear:both"></div>
		     		<div style="float:left;width:50%">
		     			<div class="left-content">
		     				Diary No. : 
		     			</div>
		     			<div class="right-content">
		     				<?php echo $diaryDetails[0]['diary_no']; ?>
		     			</div>
		     		</div>
		     		<div style="float:right;width:50%">
		     			<div class="left-content">
		     				Letter No :
		     			</div>
		     			<div style="float:right;width:50%;">
		     				<?php echo $diaryDetails[0]['letter_no']; ?>
		     			</div>
		     		</div>
		     		<div style="clear:both"></div>
		     		<div style="float:left;width:50%">
		     			<div class="left-content">
		     				Recieved Date : 
		     			</div>
		     			<div class="right-content">
		     				<?php echo $diaryDetails[0]['recieved_date']; ?>
		     			</div>
		     		</div>
		     		<div style="float:right;width:50%">
		     			<div class="left-content">
		     				Letter Date :
		     			</div>
		     			<div style="float:right;width:50%;">
		     				<?php echo $diaryDetails[0]['date_of_letter']; ?>
		     			</div>
		     		</div>
		     		<div style="clear:both"></div>
		     		<div style="float:left;width:50%">
		     			<div class="left-content">
		     				Recieved Through : 
		     			</div>
		     			<div class="right-content">
		     				<?php echo $diaryDetails[0]['appli_through_name']; ?>
		     			</div>
		     		</div>
		     		<div style="float:right;width:50%">
		     			<div class="left-content">
		     				Mark To :
		     			</div>
		     			<div style="float:right;width:50%;">
		     				<?php 
		     					
		     					echo $diaryDetails[0]['user_name'];
		     				?>
		     			</div>
		     		</div>
		     		<div style="clear:both"></div>
		     		<div style="float:left;width:50%">
		     			<div class="left-content">
		     				Applicant : 
		     			</div>
		     			<div class="right-content">
		     				<?php echo (!empty($diaryDetails[0]['father_name']))?
		     							$diaryDetails[0]['applicant'].'<br />'.$diaryDetails[0]['father_name']:
		     							$diaryDetails[0]['applicant']; ?>
		     			</div>
		     		</div>
		     		<div style="float:right;width:50%">
		     			<div class="left-content">
		     				Address : 
		     			</div>
		     			<div style="float:right;width:50%;">
		     				<?php echo $diaryDetails[0]['sender_address1'].', '.$diaryDetails[0]['sender_address2']; ?>
		     			</div>
		     		</div>
		     		<div style="clear:both"></div>
		     		<div style="float:left;width:50%">
		     			<div class="left-content">
		     				Subject :
		     			</div>
		     			<div class="right-content">
		     				<?php echo $diaryDetails[0]['subject']; ?>
		     			</div>
		     		</div>
		     		<div style="float:right;width:50%">
		     			<div class="left-content">
		     				
		     			</div>
		     			<div style="float:right;width:50%;">
		     				<?php 
		     				
		     				echo (!empty($diaryDetails[0]['pincode']))?
		     				$diaryDetails[0]['sender_city'].', '.$diaryDetails[0]['pincode']:
		     						     							$diaryDetails[0]['sender_city']; 
		     				?>
		     			</div>
		     		</div>
		     		<div style="clear:both"></div>
		     		<div style="float:left;width:50%">
		     			<div class="left-content">
		     				Description : 
		     			</div>
		     			<div class="right-content">
		     				<?php echo $diaryDetails[0]['subject_desc']; ?>
		     			</div>
		     		</div>
		     		<div style="float:right;width:50%">
		     			<div style="float:left;width:50%;">
		     				
		     			</div>
		     			<div style="float:right;width:50%;">
		     				<?php echo $diaryDetails[0]['state_name']; ?>
		     			</div>
		     		</div>
		     		<div style="clear:both"></div>
		     				