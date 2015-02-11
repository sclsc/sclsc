<?php 
	session_start();
	require_once $_SESSION['base_url'].'/classes/Implementation/RecievedThrough/Fetch.php';
	
	use classes\Implementation\RecievedThrough as impThrough;
	
	$fetchThrough = new impThrough\Fetch();
	
	$msg = '';

	$results = $fetchThrough->getReceivedThrough($_GET['q']);
		$throughTypeName = $fetchThrough->getThroughTypeName($_GET['q']);
		 
		?>
		<div class="left"><?php echo $throughTypeName; ?></div>
		<div class="right">
		<?php 
		if(count($results) != 0)
		{
		?>
			<select name="recieved_through" id="received_through">
				<option value="">Select</option>
				<?php 
				
				for($i=0;$i<count($results);$i++)
				{
				?>
				<option value="<?php echo $results[$i]['id']?>" ><?php echo $results[$i]['appli_through_name']?></option>
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
		
