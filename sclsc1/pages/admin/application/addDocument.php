<?php 
	session_start();
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../login.php');
	
	
	require_once $_SESSION['base_url'].'/classes/Implementation/DocumentTypes/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/DocumentTypes/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/DocumentTypes/Edit.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/DocumentTypes/Delete.php';
	require_once $_SESSION['base_url'].'/classes/Pagination/Pagination.php';
		
	use classes\implementation\DocumentTypes as impDocumentTypes;
	use classes\Pagination as impPage;
	
	$fetchDoc  = new impDocumentTypes\Fetch();
	$addDoc    = new impDocumentTypes\Add();
	$deleteDoc = new impDocumentTypes\Delete();
	$editDoc   = new impDocumentTypes\Edit();
	$fetchPage = new impPage\Pagination();
	
	$msg='';
	$errmsg='';
	
   if(isset($_POST['submit']))
	{
/*		if(isset($_POST['isActive']))
		{
			$isActive=1;
		}
		else
		{
			$isActive=0;
		}
	*/	
		
		$duplicateFlag = $fetchDoc->checkDocument($_POST['doc_name']);
		if($duplicateFlag != 1)
		{
			$flag = $addDoc->addDocument($_POST['doc_name']);
			if($flag == 1)
			{
				$msg = "Document has been added successfully.";
				header("location:addDocument.php?msg=$msg&alert=success");
			}
			else 
			{
				$errmsg = "Some error occured";
				header("location:addDocument.php?msg=$errmsg");
			}
		}
		else
		{
			$msg = "Document Already exist";
			header("location:addDocument.php?msg=$msg");
		}
		
	}

	if(isset($_POST['update']))
	{
		$duplicateFlag = $fetchDoc->checkDocument($_POST['edit_doc_name']);
		if($duplicateFlag != 1)
		{
			$flag = $editDoc->updateDocument($_POST['doc_id'],$_POST['edit_doc_name']);
			if($flag == 1)
			{
				$msg = "Document has been Updated successfully.";
				//$_SESSION['msg']="Diary Already Exist";
				header("location:addDocument.php?msg=$msg&alert=success");
			}
			else
			{
				$errmsg = "Some error occured";
				header("location:addDocument.php?msg=$errmsg");
			}
		}
		else
		{
			$msg = "Document Already exist";
			header("location:addDocument.php?msg=$msg");
		}
	
	}
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

	$targetpage = 'addDocument.php';
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
	     				<li><a href="#">Document</a></li>
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
	     				<div id="left-title">Add Document</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;height:150px;padding:7px ">
		     			<div style="width:60.0%;margin-left:10%">
		     				<form name="addDocument" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validate();">
								<div class="clear"></div>
								<div class="left">Document Name <span class="red">*</span></div>
								<div class="right">
								<?php //if(isset($_GET['applicationId']) && $_GET['action']=='edit'){?>
									<input type="text" id="doc_name" placeholder=" Enter Document Name" name="doc_name" />
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
	     				<div id="left-title">Document List</div>
	     				<div id="right-title"></div>
	     			</div>
	     			<div style="border:2px solid #4b8df8;padding:7px;">
	     			<form name="editDocument" id="editDocument" method="POST">
	     			
		     				<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
			     				<tr width="100%">
			     					<th width="2%" >Sr.No.</th>
			     					<th width="25%">Document Name</th>
			     					<th width="10%"> Activate / Deactivate </th>
			     					<th style="width:7%;">Edit</th>
			     					<th style="width:7%;">Delete</th>
			     				</tr>
			     				<?php
	     						
	     							for($i =0;$i<count($documents);$i++)
									{
										$class = ($i % 2 == 0) ? 'even' : 'odd';
								?>
				     				<tr class="<?php echo $class; ?>">
				     					<td><?php echo $i+1; ?></td>
				     					<td>
				     					<?php if(isset($_GET['action']) && $_GET['action']=='edit' && $documents[$i]['id']==$_GET['id']){?>
				     					<input type="hidden" name="doc_id" id="doc_id" value="<?php echo $documents[$i]['id']; ?>" />
				     					<input type="text" name="edit_doc_name" id="edit_doc_name" value="<?php echo $documents[$i]['doc_name']; ?>"/>
				     					<?php } else echo $documents[$i]['doc_name'];?>
				     					</td>
				     					
				     					<td><?php 	if($documents[$i]['is_active']){?>
				     						<a href="addDocument.php?id=<?php echo $documents[$i]['id']; ?>&doc_name=<?php echo $documents[$i]['doc_name'];?>&status=active">Deactivate</a>
				     						<?php 		}else{ ?>
				     									<a href="addDocument.php?id=<?php echo $documents[$i]['id']; ?>&doc_name=<?php echo $documents[$i]['doc_name'];?>&status=deactive">Activate</a>
										<?php }?></td>
				     					<td>
				     					<?php 
				     					if(isset($_GET['action']) && $_GET['action']=='edit' && $documents[$i]['id']==$_GET['id']){
										?>
										<input type="submit" name="update" value="Update" />&nbsp;/&nbsp;<a href="addDocument.php">Cancel</a> 
										<?php } else {?>
				     					<a href="addDocument.php?id=<?php echo $documents[$i]['id']; ?>&action=edit">Edit</a>
					     				<?php } ?>
					     				</td>
					     				<td>
					     				<a href="addDocument.php?id=<?php echo $documents[$i]['id']; ?>&action=del">Delete</a>
					     				</td>
				     				</tr>
	     						<?php 
									}
									echo $pagination;
		     					?>
		     				</table>
		     				</form>
			     		</div>
	     			
		     		</div>
	     		</div>
	     		<script>
					function validate(){
							var ele=document.getElementById('doc_name');
							if(ele.value=='')
							{
								alert('Enter Document Name');
								ele.focus();
								return false;
							}
						}
					function init(){
							document.getElementById('doc_name').focus();
					}
					window.onload=init;
	     		</script>
	
	</body>
</html>