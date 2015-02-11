<?php 
session_start();
		
	$diary = $_GET['q'];
	//print_r($diaryDetails);
	//echo "hello";

?>
 <script>		
	function submit(){
		alert('Test');
		$('#form1').submit();
		$('#light').fade();
	
		}
 </script>
		<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a>	
		
		<div style="font-size:24px;color:#4b8df8;text-align:center;width:100%;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee">&nbsp;</div>
	
		<div style="font-size:24px;color:#4b8df8;width:100%;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee">You want to go to SLP ?</div>
		     		
     	
     	<div align="center">
     	<form id="form1" action="conf.php" method="get">
     		<input type="radio" name="dAction" value="Yes" onclick="submit()"> Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     		<input type="radio" name="dAction" value="No"  onclick="submit()"> No
     		<input type="hidden" name="dairyNo" value="<?php echo $_GET['q'];?>">
		</form>
		</div>
		     
		     	

		     		
		     		
		     				