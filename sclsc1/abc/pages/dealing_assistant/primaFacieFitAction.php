 <script>		
	function submit(){		
		$('#form1').submit();
		$('#light').fade();
	
		}
 </script>
		<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a>	
		
		<div style="font-size:24px;color:#4b8df8;text-align:center;width:100%;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee">&nbsp;</div>
	
		<div style="font-size:24px;color:#4b8df8;width:100%;padding-bottom:15px;margin-bottom:15px;border-bottom:1px solid #eee"> You want to go to SLP OR Advocate (If Opinion Required) ?</div>
		     		
     	
     	<div align="center">
     	<form id="form1" action="generateOpinionLetter.php" method="POST">
     		<input type="radio" name="slpAction" value="LSC" onclick="submit()"> LSC &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     		<input type="radio" name="slpAction" value="Advocate"  onclick="submit()"> Advocate
     		<input type="hidden" name="application_id" value="<?php echo $_GET['q'];?>">     		
		</form>
		</div>
		     
		     	

		     		
		     		
		     				