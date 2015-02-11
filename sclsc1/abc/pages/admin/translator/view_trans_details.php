<?php 
	session_start();
	//error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	
	$msg = '';
	$errmsg = '';
	$abc=0;
	require_once $_SESSION['base_url'].'/classes/Connection/Connection.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Translator/Fetch.php';
	
	use classes\Connection as Conn;
	use classes\Implementation\Translator as impTranslator;
	
	$fetchTranslator = new impTranslator\Fetch();

	 $transDetails     = $fetchTranslator->singleTranslatorDetails($_GET['translatorId']);
	$periodDetails  = $fetchTranslator->translatorPeriod($_GET['translatorId']);
	//print_r($periodDetails);
	//exit;
	$address_line1=$address_line2=$city=$state_name=$pincode=$contact_no1=$contact_no2='';

	

	
	if(isset($transDetails[0]['contactno1']) && $transDetails[0]['contactno1']!='')
	{
		$contact_no1 =	$transDetails[0]['contactno1'];
	}
	
	if(isset($transDetails[0]['contactno2']) && $transDetails[0]['contactno2']!=0)
	{
		$contact_no2 =	"/".$transDetails[0]['contactno2'];
	}
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<link href="../../../css/pagination.css" rel="stylesheet">
		<script type="text/javascript" src="../../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../../js/masking/jquery.js"></script>
		
		<script type="text/javascript">
		    $(document).ready(function() {
		        $(".flip").click(function() {
		            $(".panel").slideToggle("slow");
		        });
		    });
		</script>
 <script>
	function showAdvocate(str)
		{	
				
			document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'
		if (str.length==0)
		  {
		  document.getElementById("light").innerHTML="";
		  return;
		  }
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    document.getElementById("light").innerHTML=xmlhttp.responseText;
		    }
		  }
		xmlhttp.open("GET","advocateDetails.php?q="+str,true);
		xmlhttp.send();
		}	
	</script>
		
		
<style type="text/css">
.container {
    width: 300px;
}
.leftDiv {
    max-width: 100%;
  //  background:red;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    -ms-text-overflow:ellipsis;
    float: left;
    padding-left:10px;
    width: 550px;
    
}
.rightDiv {
 //   background:yellow;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    -ms-text-overflow:ellipsis;
    text-align: left;
     padding-left:0px;
}
</style>
	</head>
	<body >
	<?php include_once 'include/header.php';?>
	    <div class="wrapper" >
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			
			<div id="right-wrapper">
				<div id="breadcrumb">
	     			<ul>
	     				<li><a href="index.php">Dashboard /</a></li>
	     				<li><a href="#">View Translator</a></li>
	     			</ul>
	     		</div>
	     	   	
	     		<?php if($msg != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green">
	     			<?php echo $msg;?>	
	     		</div>
	     		<?php 
	     		}
	     		?>
	     		<?php if($errmsg != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red">
	     			<?php echo $errmsg;?>	
	     		</div>
	     		<?php } if(count($transDetails[0])>0) { ?>		
	     		<div class="clear"></div>
	 	   		<div id="breadcrumb">
	 	   		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Translator Details</div>
     				<div class="right-title" >&nbsp;</div>
	     		</div>
	     			
	     	<div style="border:2px solid #4b8df8;padding:7px;height:350px;">
  
	<div class="clear"></div> 
	  	
	   <div class=".container">

	     		<div class="leftDiv">    		
								
									<div class="clear"></div>
									<div class=""><b>Translator Name : </b> <?php echo $transDetails[0]['translator_name'];?>
									
									<?php if (isset($transDetails[0]['is_aor']) && $transDetails[0]['is_aor']==TRUE)  { ?>
						
									 	( <?php echo  $transDetails[0]['advocate_code']; ?>) 
								
									<?php } ?>
									
									</div>
					                <div class="clear"></div>
									
	     		        
									<div class="clear"></div>
									<div class=""><b> Language :</b> <?php echo $transDetails[0]['lang_name'];?></div>									
									<div class="clear"></div>	
									
									<div class="clear"></div>
									<div class=""><b> Mobile/Contact No. :</b> <?php echo $contact_no1.$contact_no2;?></div>									
									<div class="clear"></div>	
									
														
											
	     		
	     		</div>
	     		
	     		           <div class="rightDiv">  		  
	     		        
									<div class="clear"></div>
									<div class=""><b>Gender : </b> 	<?php echo  $transDetails[0]['gender']; ?>	</div>
									<div class="clear"></div>	

									<div class="clear"></div>
									<div class=""> <b>E- Mail :</b> <?php echo $transDetails[0]['email_id'];?></div>									
									<div class="clear"></div>	
									
						<?php if (isset($transDetails[0]['is_aor']) && $transDetails[0]['is_aor']==TRUE)  { ?>								

									<div class="clear"></div>
									<div class=""> <b>AOR Designate Date :</b> <?php echo date("d-m-Y", strtotime($transDetails[0]['aor_desig_date'])); ?></div>									
									<div class="clear"></div>		
																
									<?php } ?>
									
							</div>	    
	     		
	   
	
 
 	<div class="clear"></div>			
	   <hr>   
	<div class="clear"></div> 
	
		      <div class=".container">
	     			
	     			      <div class="leftDiv"> 
	     			                
									<div class="clear"></div>								
									<div class="clear"></div>
									<div class=""><b> Registration Date  : </b>  
									<?php for($i=0;$i<count($periodDetails);$i++)
									  { 
									 	if($periodDetails[$i]['end_date']==NULL && $periodDetails[$i]['is_active']==TRUE) 
									 	{									 		
									 		echo date("d-m-Y", strtotime($periodDetails[$i]['start_date']));
									 	}
									  }
									?> 
									 </div>
								
									<div class="clear"></div>								
									<div class="clear"></div>				
									
							</div>
							
							 <div class="rightDiv">  		  
	     		        
									<div class="clear"></div>
									<div class=""> <b>Period on Panel :</b>  
									
									<?php for($i=0;$i<count($periodDetails);$i++)
									  { 
									 	if($periodDetails[$i]['start_date']!=NULL && $periodDetails[$i]['end_date']!=NULL) 
									 	{
									 		
									 		echo date("d-m-Y", strtotime($periodDetails[$i]['start_date'])).' To '. date("d-m-Y", strtotime($periodDetails[$i]['end_date'])).'<br/>';
									 	}
									  }
									?> 
									</div>									
									<div class="clear"></div>	
					
							</div>	    

 	<div class="clear"></div>			
	   <hr>   
	<div class="clear"></div> 
	     	<div class=".container">
			
	     			      <div class="leftDiv">  
	     			                <div class="clear"></div>
									<div class=""><b> Address :</b>  
						<?php 
						$address1=$address2=$city=$state_name=$pincode='';
		     				if(isset($transDetails[0]['address1']) && $transDetails[0]['address1']!='')
		     				{
		     					$address1=$transDetails[0]['address1'].', ';
		     				}
		     				if(isset($transDetails[0]['address2']) && $transDetails[0]['address2']!='')
		     				{
		     					$address2=$transDetails[0]['address2'].', ';
		     				}
		     				if(isset($transDetails[0]['city']) && $transDetails[0]['city']!='')
		     				{
		     					$city=$transDetails[0]['city'].', ';
		     				}
		     					if(isset($transDetails[0]['state']) && $transDetails[0]['state']!='')
		     				 {
		     					$state=$transDetails[0]['state'];
		     					$applicant_state=$state;
		     					$con = Conn\Connection::getConnection();
		     					$query = "SELECT state_name FROM tbl_states WHERE id = :state_id";
		     					$stmt = $con->prepare($query);
		     					$stmt->bindParam(':state_id', $state, PDO::PARAM_INT);
		     					$stmt->execute();
		     					while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
		     						$state_name = $row['state_name'];
		     					
		     					$con =NULL;
		     					
		     				}
		     				if(isset($transDetails[0]['pincode']) && $transDetails[0]['pincode']!='')
		     				{
		     					$pincode=', '.$transDetails[0]['pincode'];
		     				}   				
		     				
		     				 echo $address1.$address2.$city.$state_name.$pincode; 
		     				
		     		 ?> 
		     				</div>					
								
								<?php if (isset($transDetails[1]['is_commun_address']) && $transDetails[1]['is_commun_address']==TRUE && $transDetails[1]['is_commun_address']!='') { ?>
									<div class="clear"></div>
									<div class="clear"></div>
									<div class=""><b>Com. Address : </b>
									
							<?php 
							 $caddress1=$caddress2=$ccity=$cstate_name=$cpincode=''; 
		     				if(isset($transDetails[1]['address1']) && $transDetails[1]['address1']!='')
		     				{
		     					$caddress1=$transDetails[1]['address1'].', ';
		     				}
		     				if(isset($transDetails[1]['address2']) && $transDetails[1]['address2']!='')
		     				{
		     					$caddress2=$transDetails[1]['address2'].', ';
		     				}
		     				if(isset($transDetails[1]['city']) && $transDetails[1]['city']!='')
		     				{
		     					$ccity=$transDetails[1]['city'].', ';
		     				}
		     					if(isset($transDetails[1]['state']) && $transDetails[1]['state']!='')
		     				 {
		     					$state=$transDetails[1]['state'];
		     					$applicant_state=$state;
		     					$con = Conn\Connection::getConnection();
		     					$query = "SELECT state_name FROM tbl_states WHERE id = :state_id";
		     					$stmt = $con->prepare($query);
		     					$stmt->bindParam(':state_id', $state, PDO::PARAM_INT);
		     					$stmt->execute();
		     					while($row = $stmt->fetch(\PDO::FETCH_ORI_NEXT))
		     						$cstate_name = $row['state_name'];
		     					
		     					$con =NULL;
		     					
		     				}
		     				if(isset($transDetails[1]['pincode']) && $transDetails[1]['pincode']!='')
		     				{
		     					$cpincode=', '.$transDetails[1]['pincode'];
		     				}   				
		     				
		     				 echo $caddress1.$caddress2.$ccity.$cstate_name.$cpincode; 
		     				
		     		 ?> 
									
									</div>
								<?php } ?>	
									
							</div>				
								
								
			<?php } else {  ?>
     		                         	
     		     <div id="breadcrumb-red">
     			<?php echo "Advocate Details Not Found"; ?> </div>	    		                         	
     		                         
      <?php } ?>  		                         
	     		                   
	     				</div> 	     						
	     		</div> 
	     			
	     	  </div> 
	     	 	    
	     	  	</div>
	     	  	
	     	</div>	     	
     		 <div class="right-title" ><button onclick="goBack()">Go Back</button></div>		
	     		
	   </div>
	   </div>
			<script>
			function goBack() {
			    window.history.back()
			}
			</script>	
	     	<script type="text/javascript">
				jQuery(function($){
					$("#pincode").mask("999999", {placeholder: 'XXXXXX'});
					$("#contact_number").mask("999-999-9999", {placeholder: 'XXX/XXX/XXXX'});
				});
			</script>
	   <script type="text/javascript" src="js/masking/ga.js"></script>
		<script type="text/javascript">
		    if (typeof(_gat)=='object')
		        setTimeout(function(){
		            try {
		                var pageTracker=_gat._getTracker("UA-10112390-1");
		                pageTracker._trackPageview()
		            } catch(err) {}
		        }, 1500);
		</script>
	</body>
</html>
			     	