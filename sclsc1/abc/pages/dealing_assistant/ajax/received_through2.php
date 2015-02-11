<?php 
    session_start();

	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThroughType/Fetch.php';
	
	use classes\Implementation\RecievedThroughType as impRecievedThroughType;
	
	$fetchThrough = new impRecievedThroughType\Fetch();
	
	$msg = '';

	    $results         = $fetchThrough->getReceivedThrough($_GET['q']);
		$throughTypeName = $fetchThrough->getThroughTypeName($_GET['q']);
		 
		?>
		<div class="left"><?php echo $throughTypeName; ?></div>
		<div class="right">
		<?php 
		if(count($results) != 0)
		{
		?>
			<select name="received_through" id="received_through">
				<option value="">Select</option>
				<?php 
				
				for($i=0;$i<count($results);$i++)
				{
				?>
				<option value="<?php echo $results[$i]['id']?>" <?php if($results[$i]['id']==$_GET['y']) { echo "selected=selected"; } ?> ><?php echo $results[$i]['appli_through_name']?></option>
				<?php 
					
				}
			?>
			</select>	
		</div>
		<?php 
		}
		else 
		{	
		?>
		<select name="received_through" id="received_through">	
			<option value="">Select</option>
		</select>
		<?php 
		}
		?>
		
