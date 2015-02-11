<?php 
	session_start();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="<?php echo $_SESSION['base_file_url']; ?>css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<link rel="stylesheet" href="../../css/pagination.css">
	</head>
	<body >
	<?php require_once $_SESSION['base_url'].'/include/header.php';?>
	    <div class="wrapper" >
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			<div id="right-wrapper">
				
			<div id="breadcrumb">
	     			<ul>
	     				<li><a href="index.php">Dashboard</a></li>
	     			</ul>
	     		</div>
	     		<div class="clear"></div>
	     		<?php if(isset($_GET['msg']))
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green">
	     			<?php echo $_GET['msg'];?>	
	     		</div>
	     		<?php 
	     		}
	     		?>
	     		<div class="clear"></div>
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Dashboard</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px">
		     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">			     					
			     					<th width="10%"><a href="dak.php" accesskey="a">Dak</a></th>
			     					<th width="10%"><a href="applications.php" accesskey="s">Applications</a></th>
			     					<th width="10%"><a href="doc_completion.php" accesskey="x">Document Completion</a></th>			     					
			     					<th width="10%"><a href="srAdvConsultation.php" accesskey="r">Sr. Advocate Consultation</a></th>
			     					<th width="10%"><a href="primaFacieFit.php" accesskey="g">Prima facie fit for filing </a></th>
			     					<th width="10%" ><a href="#">Certificate from 1-B </a></th>		     							     					
			     				</tr>
			     				
			     				<tr width="100%">			     				
			     				<th width="10%"><a href="advAppoinment.php">Advocate Appointment</a></th>			     					
			     				<th width="10%"><a href="intimationToApplicant.php">Intimation to applicant about granting of Legal Aid</a></th>
			     				<th width="10%"><a href="fitForFiling.php">Fit for filing(In Adv. Opinion)</a></th>
			     				<th width="10%"><a href="additionalDoc.php">Additional Doc. (Adv. Demands)</a></th>
			     				<th width="10%"><a href="translatorAppoinment.php">Translation of Doc.</a></th>
			     				<th width="10%"><a href="affidavitFiling.php">Affidavit for filing</a></th>			     						     					
			     				</tr>
			     				
			     				<tr width="100%">		     						     					
			     				<th width="10%"><a href="#">Court fee exemption Certificate/Stamped</a></th>
			     				<th width="10%"><a href="caseFiledSci.php">Case to be Filed in SCI</a></th>
			     				<th width="10%"><a href="intimationCaseNoToApplicant.php">Intimation of Case no. to applicants</a></th>
			     				<th width="10%"><a href="srAdvAppoinment.php">Sr. Advocate Appointment</a></th>
			     				<th width="10%"><a href="#">Matter follow-up</a></th>		
			     				<th width="10%"><a href="pendingCOF.php">Closing of file</a></th>	     						     					
			     				</tr>			     				
			     				
                     </table>

			     		</div>
			     		
		     		</div>
	     		</div>
	     	</div>
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
