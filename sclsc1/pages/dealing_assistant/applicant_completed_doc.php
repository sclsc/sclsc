<?php 
	session_start();
	//error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
	
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Diary/Fetch.php';
    require_once $_SESSION['base_url'].'/classes/Implementation/DocInAppliType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
		
	use classes\implementation\Diary as impDiary;
	use classes\implementation\DocInAppliType as impApplication;
	use classes\Pagination as impPage;
	
	$fetchAppli  = new impDiary\Fetch();
	$fetchDoc  = new impApplication\Fetch();
	
	$fetchPage = new impPage\Pagination();
	
	$msg='';
	$errmsg='';
	
   if(isset($_POST['submit']))
	{
		//print_r($_POST); exit;
		if(isset($_POST['isActive']))
		{
			$isActive=1;
		}
		else
		{
			$isActive=0;
		}

			$flag = $addDoc->addDocRequestType($_POST['application_name'],$_POST['doc_name'],$isActive);
			if($flag == 1)
			{
				$msg = "Request has been added successfully.";
				header("location:docs_in_appli_type.php?msg=$msg&alert=success");
			}
			else 
			{
				$errmsg = "Some error occured";
				header("location:docs_in_appli_type.php?msg=$errmsg");
			}
		}

		/*


	if(isset($_GET['status'])){
		
		
		if($_GET['status']=='active')
		{
			$flag = $editDoc->updateDocumentStatus($_GET['id'],0);
		}
		if($_GET['status']=='deactive')
		{
			
			$flag = $editDoc->updateDocumentStatus($_GET['id'],1);
			
		}
	}
	
	if(isset($_GET['action']) && $_GET['action']=='del'){
		$flag = $deleteDoc->deleteDocument($_GET['id']);
		if($flag == 1)
		{
			$msg = "Document has been Deleted successfully.";
			header("location:addDocument.php?msg=$msg&alert=success");
		}
		else
		{
			$errmsg = "Some error occured";
			header("location:addDocument.php?msg=$errmsg");
		}
	}
	*/
	


/*	$targetpage = 'addDocument.php';
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
	
		$documents = $fetchDoc->getAllDocuments($limit,$start);
		$Records   = $fetchDoc->getAllDocumentsCount();
		$url='';
		$pagination = $fetchPage->paginations($page, $Records, $limit, $targetpage, $adjacents, $url);
	}

	*/

		//$requestType = $fetchAppli->getApplicationDoc(); 
	//	print_r($requestType);
		$singleApplication = $fetchAppli->getSingleApplicationDoc($_GET['appliId']);
		$docType = $fetchDoc->getAllmatchingData($singleApplication[0]['appli_type_id']);
		$applicants = $fetchAppli->getApplicants($_GET['appliId']);
		
		//echo	count($applicants);
		//print_r($docType);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Dashboard</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<script type="text/javascript" src="../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../js/masking/jquery.js"></script>
		<link href="../../css/pagination.css" rel="stylesheet">
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
	     				<li><a href="index.php">Dashboard &nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="doc_completion.php">Document Completion &nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="application_doc.php">Document Request Type&nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="#">Applicant Completed Document</a></li>
	     			</ul>
	     		</div>
	     	   	<div class="clear"></div>
	     	   	
	     	<?php if(isset($_GET['msg']) && !isset($_GET['alert'])) {	?>		     	
	     	   	<div id="breadcrumb-red">	     	   	
	       <?php echo $_GET['msg'];?>		     			
	     		</div>	     		
	       <?php } if(isset($_GET['msg']) && isset($_GET['alert'])) {	 ?>	     		
	     	    <div id="breadcrumb-green">	     	   
	       <?php echo $_GET['msg']; ?>	     			
	     		</div>	     		
	       <?php } ?>
	       	
		     		<div class="clear"></div>
	     			<div class="clear"></div>
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Application Doc</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
	     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     				 	<th width="2%" >Sr.No.</th>			     				 	
			     					<th width="25%">Applicant Name </th>
			     					<th width="25%">Document Type</th>			     					
			     			 		<th style="width:7%;">Edit</th>			     					
			     				</tr>
			     				<?php									     					
								
								for($i = 0; $i < count ( $applicants ); $i ++)
								 {							 
								 						
								$applicantDocType = $fetchAppli->getApplicantDoc($_GET['appliId'], $applicants[$i]['id']);
								
								$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
     											
     						<tr class="<?php echo $class; ?>" >
     						<td align="center"><?php echo $i+1; ?></td>     					
                            <td><?php echo $applicants[$i]['applicant_name'];?></td>
				     		<td>
				     		 <?php for($j=0;$j<count($docType);$j++)
			                    {
			                    	if (in_array($docType[$j]['doc_type_id'], $applicantDocType))
			                    	{
				                      echo $docType[$j]['doc_name']."<br />";		
			                    	}		
			                    }
			                     ?>
			                  </td>
				     		<td><a href="edit_applicant_doc.php?appliId=<?php echo $_GET['appliId']; ?>&applicantId=<?php echo $applicants[$i]['id']; ?>">Edit</a> 				     			
					     	</td>
     					</tr>
	     				<?php 
							}
							//echo $pagination;
     					?>
		     				</table>
		     			
			     		</div>
	     			
		     		</div>
	     		</div>
	     		<script>
					function validate(){
							var appele=document.getElementById('application_name');
							var docele=document.getElementById('doc_name');
							if(appele.value=='')
							{
								alert('Please Select Application Type');
								appele.focus();
								return false;
							}	
						/*	if(docele.checked==false)						
							{
								alert('Select Document Type');
								docele.focus();
								return false;
							}	*/						
						}
					function init(){
							document.getElementById('application_name').focus();
					}
					window.onload=init;
	     		</script>
	
	</body>
</html>