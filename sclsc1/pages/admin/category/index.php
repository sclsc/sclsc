<?php 
	session_start();	
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	  
	require_once $_SESSION['base_url'].'/classes/Implementation/Category/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Category/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Category/Edit.php';
	
	
	use classes\Implementation\Category as impCategory;
	
	$addCategory = new impCategory\Add();
 	$fetchCategory = new impCategory\Fetch();
	$editCategory=new impCategory\Edit();

	
	$msg ='';
	$errmsg= '';
	
	if(isset($_POST['addCategory']))
	{
		
		if(!empty($_POST['categoryName']) && strlen($_POST['categoryName']) > 50)
		{
			$err = "Please Enter Full Name less than 50 charactor".'<br/>';
			
		}
		else 
		{
			$checkFlag = $fetchCategory->checkCategory($_POST['categoryName']);
			if($checkFlag != 1)
			{
				$flag = $addCategory->addCategory($_POST['categoryName']);
				if($flag == 1)
				{
					$msg = "Category has been added successfully.";
					header("location:index.php?msg=$msg&alert=success");
				}
				else
				{
					$errmsg = "Some error occured";
					header("location:index.php?msg=$errmsg");
				}
			}
			else 
			{
				$errmsg = "Category Already Exist";
				header("location:index.php?msg=$errmsg");
			}
		}
	}
	
	
 	if(isset($_POST['updateCategory']) && $_POST['editcategoryName'] != '' && $_POST['editCategoryId'] != '' )
	{
		$flag=$fetchCategory->checkCategory($_POST['editcategoryName']);
		if($flag!=1){
		$updateCategory = $editCategory->updateCategoryName($_POST['editcategoryName'],$_POST['editCategoryId']);
		if($updateCategory == 1){
			$msg = "Category has been updated successfully";
			header("location:index.php?msg=$msg&alert=success");
		}
		else{ 
			$errmsg = "some error occured";
			header("location:index.php?msg=$errmsg");
		}
		}
		else{
			$errmsg='Category Alreay Exist';
			header("location:index.php?msg=$errmsg");
		}
			
	}
	
	
	if(isset($_GET['status']))
	{
		if($_GET['status']==0)
			$status=1;
		if($_GET['status']==1)
			$status=0;
		
		$editCategory->updateCategoryStatus($_GET['id'],$status);
	}
	$categories=$fetchCategory->getAllCategory();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to E-COMMITTEE SUPREME COURT OF INDIA</title>
	    	<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<link href="../../../css/pagination.css" rel="stylesheet">
		<script type="text/javascript" src="../../../js/masking/jquery-1.js"></script>
		<script type="text/javascript" src="../../../js/masking/jquery.js"></script>
		<link href="../../../css/style.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" media="all" href="../../../css/jsDatePick_ltr.min.css" />
		<script type="text/javascript" src="../../../js/jsDatePick.min.1.3.js"></script>
		<script type="text/javascript">
			function addCategory() {
			  $('#addCategory').show(500);
			};
		</script>
	</head>
	<body>
		<?php include_once $_SESSION['base_url'].'/include/header.php';?>
	    <div class="wrapper">
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			<div id="right-wrapper">
				<div id="breadcrumb">
	     			<ul>
	     				<li><a href="../index.php">Home /</a></li>
	     				<li><a href="#">Category</a></li>
	     			</ul>
	     		</div>
	     		<?php if(count($errmsg) != '')
	     			{	
	     		?>
	     		<div id="breadcrumb">
	     			<?php  echo $errmsg; ?>
	     		</div>
	     		<?php 
	     			}
	     		?>
	     		<?php if(isset($err) && $err != '')
	     			{	
	     		?>
	     		<div id="breadcrumb-red">
	     			<?php  echo $err; ?>
	     		</div>
	     		<?php 
	     			}
	     		?>
	     		<div class="clear"></div>
	     		
	     		
	     		
	     		<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
		     				<div id="left-title">Category List</div>
		     				<div id="right-title"></div>
		     			</div>
	     			<div style="border:2px solid #4b8df8;padding:0px 10px;">
		     			<div class="clear"></div>
		     			
     					<div id="addCategory">
     						<form action="index.php" method="post" onsubmit="return validate();">
     							<table>
     								<tr>
     									<td>Category Name &nbsp;&nbsp;</td>
     									<td><input type="text" name="categoryName" id="categoryName" /></td>
     									<td style="padding-left:20px;"><input class="form-button" type="submit" name="addCategory" value="Add" /></td>
     								</tr>
     							</table>
     						</form>
     					</div>
		     		</div>
	     		</div>
	     		 		
	     		
	     	<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
		     				<div id="left-title">Category List</div>
		     				<div id="right-title"></div>
		     			</div>
	     			<div style="border:2px solid #4b8df8;padding:0px 10px;">
		     			<div class="clear"></div>
		     			<form name="editCategory" id="editCategory" action="index.php" method="POST">
		     			<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
		     				<tr width="100%">
		     					<th width="6%">Sr. No.</th>
		     					<th width="34%">Category</th>
		     					<th width="34%">Status</th>
		     					<th width="20%">Action</th>
		     				</tr>	
		     				<?php
	     						for($i =0;$i<count($categories);$i++)
									{
										
											
								?>
		     				<tr class="even">
		     					<td><?php echo $i+1; ?></td>
		     					
		     					<td>
		     					<?php if(isset($_GET['action']) && $_GET['action']=='edit' && $categories[$i]['id']==$_GET['categoryId']){?>
		     					<input type="hidden" name="editCategoryId" value="<?php echo $categories[$i]['id'];?>" /> 
		     					<input type="text" name="editcategoryName" value="<?php echo $categories[$i]['category_name'];?>" />
		     					<?php }else{?>
		     					<?php echo $categories[$i]['category_name'];?>
		     					<?php }?>
		     					</td>
		     					<td><?php if($categories[$i]['is_active']){?>
									<a href="index.php?id=<?php echo $categories[$i]['id'];?>&status=1">Active</a>	
									<?php }else{ ?>
									<a href="index.php?id=<?php echo $categories[$i]['id'];?>&status=0">Deactive</a>
									<?php } ?>
		     						</td>
		     					<td>
		     					<?php if(isset($_GET['action']) && $_GET['action']=='edit' && $categories[$i]['id']==$_GET['categoryId']){?>
		     					<input type="submit" name="updateCategory" id="updateCategory" value="Update">/<a href="index.php">Cancel</a>
		     					<?php }else{?>
		     					<a href="index.php?categoryId=<?php echo $categories[$i]['id']; ?>&action=edit" class="action-edit">Edit</a>
		     					<?php }?>
		     					</td>
			     				</tr>	
								<?php 	
								
								}
		     				?>
		     			</table>
		     			</form>
		     		</div>
	     		</div>
	     	</div>
		</div>
	<script type="text/javascript">
		function validate(){
					if(document.getElementById('categoryName').value=='')
					{
						alert('Enter Category Name');
						return false;
					}
					
			}

	</script>
	</body>
</html>
