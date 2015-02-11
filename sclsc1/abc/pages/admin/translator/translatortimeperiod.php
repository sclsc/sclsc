<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');

	$msg = '';
	$errmsg = '';
	$abc=0;
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Translator/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
	
	
	use classes\Implementation\Translator as impTranslator;
	use classes\Pagination as impPage;
	
	
	$fetchTranslator = new impTranslator\Fetch();
	$fetchPage     = new impPage\Pagination();
	
	$targetpage = 'translatortimeperiod.php';
	$adjacents = 2;
	$limit = 10;
	$start = 0;
	$page = 0;
	
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
		if($page){
			$start = ($page - 1) * $limit;
			$recordCounter=$start;
		}
		else
			$start = 0;
	}
	
	
	$alltranslator = $fetchTranslator->TranslatortimePeriod();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<link rel="stylesheet" href="../../../css/styles.css">
		<script src="../../../js/jquery.min.js"></script>
		<script src="../../../js/masking/jquery-1.js"></script>
		<script src="../../../js/masking/jquery.js"></script>
		<script src="../../../js/advocateValidation.js"></script>
		<link href="../../../css/pagination.css" rel="stylesheet">
		<script type="text/javascript">
		$(document).ready(function(){
		
			$('#registrationdate').keyup(function(){		
				//var a=$('#registrationdate').val();
				//alert(a);		
				$.ajax({
					    type: "POST",
					    url: "ajax/searchtranslator.php?reg_date="+$('#registrationdate').val(),
					    success: function(result){						   
						    $('#records').html(result);
					      }
					});
				});
			});	
		</script> 

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
	     				<li><a href="#">Home </a></li>
	     				<li><div class="right-title" style="color:#1D8CD6"><?php echo date('l jS \of F Y h:i:s A'); ?></div></li>
	     				
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     			     		
	     		<div class="clear"></div>
	     		<?php if(isset($_GET['msg']) && $_GET['msg']!='')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green" align="center">
	     			<?php echo $_GET['msg'];?>	
	     		</div>
	     		<?php 
	     		}
	     		if(isset($_GET['errmsg']) && $_GET['errmsg']!='')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red" align="center">
	     			<?php echo $_GET['errmsg'];?>	
	     		</div>
	     		<?php 
	     		}
	     										
				if ($errmsg != "")
					echo '<div class="errmsg" align="center">' . $errmsg . '</div>';
				
				elseif ($msg != "")
					echo '<div class="msg" align="center">' . $msg . '</div>';
				?>
	     		<div class="clear"></div>
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Translator List</div>
     					<div id="right-title" style="text-align: right;width:300px;float:right;align:middle;">
	     			   <input type="text"  placeholder="DD-MM-YYYY"  name="registrationdate" id="registrationdate"  value=""/>
	     		</div>
	     		</div>				
	  		<div class="clear"></div>	
	     			<div id="records" style="border:2px solid #4b8df8;padding:7px;">
		     			<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     			<tr width="100%">
	     					<th width="6%">Sr. No.</th>
	     					<th width="15%"> Name</th>
	     				
	     					<th width="15%">Email Id</th>
	     					<th width="15%">Mobile No</th>	     					
	     					<th width="15%">Registration Date </th>  					
	     					
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
						 	{  ?>
				     		<tr class="<?php echo $class; ?>" align="center">
	     					<td><?php echo $i+1; ?></td>	     					
	     					 <td><a href="view_trans_details.php?translatorId=<?php echo $alltranslator[$i]['translator_id']; ?>" ><?php echo $alltranslator[$i]['translator_name']; ?></a></td>
	     					<td><?php echo $alltranslator[$i]['email_id']; ?></td>
	     					<td><?php echo $alltranslator[$i]['contactno1']; ?></td>
	     					<td><?php if ($alltranslator[$i]['start_date']!='') echo date("d-m-Y", strtotime($alltranslator[$i]['start_date'])); ?></td>
                                 
	     				</tr>    						
		     					
		     			     	<?php 
									}
		}									
									
		     					?>
		     					
		     				</table>
			     		</div>
			     		
		     		</div>
	     		</div>
			<script type="text/javascript">
					jQuery(function($){
						
                   $("#registrationdate").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
					});
					$(document).ready(function() {
					    $('form:first *:input[type!=hidden]:first').focus();
					});
				</script>
		   <script type="text/javascript" src="../../js/masking/ga.js"></script>
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
