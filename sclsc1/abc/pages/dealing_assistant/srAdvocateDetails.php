<?php 
	session_start();
		require_once $_SESSION['base_url'].'/classes/Implementation/SeniorAdvocate/Fetch.php';
		
		use classes\Implementation\SeniorAdvocate as impSrAdvo;
		$fetchSrAdvo = new impSrAdvo\Fetch();
		$advocates = $fetchSrAdvo->singleSrAvocateDetails($_GET['q']);
	//echo $_GET['q'];
	//print_r($advocates);
	//echo "hello";
?>
		<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a>	
	
		<div style="font-size:24px;color:#4b8df8;text-align:center;width:100%;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee">Senior Advocate Details</div>
		     		
		     		<div class="left" style="border-right:1px solid #000; padding-right:10px;">
		     			<div class="right">
		     			<b>	Sr. Advocate Name : </b>
		     			</div>
		     			<div class="right" style="text-align: left;margin-left:10px;">
		     				 <?php echo $advocates[0]['advocate_name']; ?>
		     			</div>
		     			<div class="clear"></div>
		     			<div class="right">
		     			<b>	Enrolment Date : </b>
		     			</div>
		     			<div class="right" style="text-align: left;margin-left:10px;">
		     				<?php echo date('d-m-Y',strtotime($advocates[0]['advocate_enrol_date'])); ?>
		     			</div>
		     			
		     		</div>     		
		     	
		     	
		     		<div class="left">
		     			<div class=right>
		     				<b>Is still Active : </b>
		     			</div>
		     			<div class="right" style="text-align:left; padding-left:10px;">
		     				<?php if($advocates[0]['advactive']==1) echo "Yes"; else echo "No"; ?>
		     			</div>
		     			<div class="clear"></div>
		     			<div class="right" >
		     			<b>	Is on Panel : </b>
		     			</div>
		     			<div class="right" style="text-align:left; padding-left:10px;">
		     			<?php if($advocates[0]['is_on_panel']==1) echo "Yes"; else echo "No"; ?>		     				
		     			</div>
		     		</div>
		     		
		     		
		     				