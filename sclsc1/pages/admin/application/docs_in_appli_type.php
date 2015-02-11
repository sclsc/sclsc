<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
	
	
	require_once $_SESSION['base_url'].'/classes/Implementation/DocInAppliType/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/DocInAppliType/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/DocInAppliType/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/DocInAppliType/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
		
	use classes\implementation\DocInAppliType as impApplication;
	use classes\Pagination as impPage;
	
	$fetchDoc  = new impApplication\Fetch();
	$addDoc    = new impApplication\Add();
	$deleteDoc = new impApplication\Delete();
	$editDoc   = new impApplication\Edit();
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
	else
	{
		$documents = $fetchDoc->getAllDocuments($limit,$start);
		$Records   = $fetchDoc->getAllDocumentsCount();
		$url='';
		$pagination = $fetchPage->paginations($page, $Records, $limit, $targetpage, $adjacents, $url);
	}
	*/
		
		$applicationTypes = $fetchDoc->getAllApplicationType(Null,Null);
		$documents        = $fetchDoc->getAllDocuments(Null,Null);
		//$docRequestType   = $fetchDoc->getAllDocRequest();
		$requestType = $fetchDoc->getAllDocRequestIds();
	//	print_r($requestType);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Dashboard</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<script type="text/javascript" src="../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../js/masking/jquery.js"></script>
		<link href="../../../css/pagination.css" rel="stylesheet">
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
	     				<li><a href="index.php">Home &nbsp;&nbsp;&nbsp;/</a></li>
	     				<li><a href="#">Document Request Type</a></li>
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
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Document Request Type</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;height:250px;padding:7px ">
		     			<div style="width:60.0%;margin-left:10%">
		     				<form name="addDocument" action="#" method="post" onsubmit="return validate();">
								<div class="clear"></div>
								<div class="left">Application Type <span class="red">*</span></div>
								<div class="right">							
									<select name="application_name" id="application_name">
									<option value=''>Select</option>
									<?php
									for($i = 0; $i < count ( $applicationTypes ); $i ++) {
										?>
										<option value="<?php echo $applicationTypes[$i]['id']; ?>"><?php echo $applicationTypes[$i]['appli_type_name']; ?></option>
									<?php
									}
									?>
									</select>
								</div>
									<div class="clear"></div>
								<div class="left">Document Name <span class="red">*</span></div>
								<div class="right">						
								<div style="margin:auto;width:90%">
								<div class="clear"></div>										
										<?php									
										 for($i =0;$i<count($documents);$i++)
										 {										
										 ?>
										 <div class="right">
										 <input	type="checkbox" name="doc_name[]" id="doc_name" value="<?php echo $documents[$i]['id']; ?>" />
										 <?php echo $documents[$i]['doc_name']; ?>
										 </div> 
										<?php } ?>
								    </div>
								</div>
								
								
								<!-- <div class="clear"></div>
									<div class="left"> Is Active</div>
									<div class="right">
										<input type="checkbox" name="isActive" id="isActive" />
									</div> -->
								
								<div class="clear"></div>
								<div class="left"></div>
								<div class="right">
									<input type="submit" class="form-button" name="submit" value="Submit" />
								</div>
							</form>
							</div>
						</div>
					
		     		</div>
		     		<div class="clear"></div>
	     			<div class="clear"></div>
	     			<div class="title1" style="height:20px;">
	     				<div id="left-title">Request Type List</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
	     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     				 	<th width="2%" >Sr.No.</th>
			     					<th width="25%">Application Type </th>
			     					<th width="25%">Document Type</th>			     					
			     			 		<th style="width:7%;">Edit</th>
			     					
			     				</tr>
			     				<?php
									     					
								for($i =0;$i<count($requestType);$i++)
								{								
								$docType = $fetchDoc->getAllmatchingData($requestType[$i]['request_type_id']);
								
								$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
     											
     						<tr class="<?php echo $class; ?>" >
     						<td align="center"><?php echo $i+1; ?></td>
                            <td><?php echo $requestType[$i]['appli_type_name'];?></td>
				     		<td>
				     		 <?php for($j=0;$j<count($docType);$j++)
			                    {
				                  echo $docType[$j]['doc_name']."<br />";				
			                    }
			                     ?>
			                  </td>
				     		<td><a href="edit_docs_in_appli_type.php?appliId=<?php echo $requestType[$i]['request_type_id']; ?>&action=edit">Edit</a>				     			
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