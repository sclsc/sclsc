<?php 
	/* session_start();
	include_once 'include/config.php';
	include_once 'include/functions.php';
	$user = new Users();
	$errmsg = array();
	$msg = array();
	if(isset($_POST['submit']) && $_POST['categoryName'] != '' && $_POST['categoryId'] != '' )
	{
		$updateCategory = $user->updateCategoryName($_POST['categoryName'],$_POST['categoryId']);
		if($updateCategory == 1)
			$msg = "Category has been updated successfully";
		else 
			$errmsg = "some error occured";
	}
	$categoryIds = $user->getcategoryIds();
	if(count($categoryIds) == 0)
		$errmsg = "No Category Found"; */
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to E-COMMITTEE SUPREME COURT OF INDIA</title>
		<link href="css/style.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.min.css" />
		<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
		<script type="text/javascript">
			function addCategory() {
			  $('#addCategory').show(500);
			};
		</script>
	</head>
	<body>
		<?php include_once 'include/header.php';?>
	    <div class="wrapper">
			<div id="left-wrapper">	
				<?php include_once 'include/side-menu.php';?>
			</div>
			<div id="right-wrapper">
				<div id="breadcrumb">
	     			<ul>
	     				<li><a href="index.php">Dashboard /</a></li>
	     				<li><a href="category.php">Category</a></li>
	     			</ul>
	     		</div>
	     		<?php if(count($errmsg) != '')
	     			{	
	     		?>
	     		<div id="breadcrumb">
	     			<?php echo $errmsg; ?>
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
		     			<div class="form-button" onclick="addCategory();" >Add Category</div>
     					<div id="addCategory">
     						<form action="category.php" method="post">
     							<table>
     								<tr>
     									<td>Category Name &nbsp;&nbsp;</td>
     									<td><input type="text" name="categoryName" /></td>
     									<td><input class="form-button" type="submit" name="addCategory" value="Add" /></td>
     								</tr>
     							</table>
     						</form>
     					</div>
		     		</div>
	     		</div>
	     		 		
	     		
	     	<!-- >	<div id="breadcrumb">
	     			<div class="title1" style="height:20px;">
		     				<div id="left-title">Category List</div>
		     				<div id="right-title"></div>
		     			</div>
	     			<div style="border:2px solid #4b8df8;padding:0px 10px;">
		     			<div class="clear"></div>
		     			<table id="table-records" cellpadding="0px" cellspacing="0px" width="100%">
		     				<tr width="100%">
		     					<th width="6%">Sr. No.</th>
		     					<th width="34%">Category</th>
		     					<th width="20%">Action</th>
		     				</tr>	
		     				<?php
	     						for($i =0;$i<count($categoryIds);$i++)
									{
										if($i % 2 == 0)
										{
											
								?>
		     				<tr class="even">
		     					<td><?php echo $i+1; ?></td>
		     					<td><?php echo $categoryIds[$i]['category_name']; ?></td>
		     					<td><a href="edit-category.php?categoryId=<?php echo $categoryIds[$i]['id']; ?>" class="action-edit">Edit</a><a class="action-disable" href="category.php?categoryId=<?php echo $categoryIds[$i]['id']; ?>">Disable</a></td>
		     				</tr>
		     				<?php 
								}
								else 
								{
								?>
								<tr class="odd">
								<td><?php echo $i+1; ?></td>
		     					<td><?php echo $categoryIds[$i]['category_name']; ?></td>
		     					<td><a href="edit-category.php?categoryId=<?php echo $categoryIds[$i]['id']; ?>" class="action-edit">Edit</a><a class="action-disable" href="category.php?categoryId=<?php echo $categoryIds[$i]['id']; ?>">Disable</a></td>
			     				</tr>	
								<?php 	
								}
								}
		     				?>
		     			</table>
		     		</div>
	     		</div>-->
	     	</div>
		</div>
	</body>
</html>
