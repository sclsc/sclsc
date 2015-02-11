<?php 
session_start();
	require_once $_SESSION['base_url'].'/classes/Implementation/Misc/Fetch.php';
	
	use classes\implementation\Misc as impMisc;
	
	$fetchMisc  = new impMisc\Fetch();

	    $results   = $fetchMisc->getSubStages($_GET['q']);
		$StageName = $fetchMisc->getStageName($_GET['q']);
		 
		?>
		<div class="left" style="width:25%;"><?php echo $StageName; ?></div>
		<div class="right" style="width:70%;">
		<?php 
		if(count($results) != 0)
		{
		?>
			<select name="sub_stages" id="sub_stages">
				<option value="">Select</option>
				<?php 
				
				for($i=0;$i<count($results);$i++)
				{
				?>
				<option value="<?php echo $results[$i]['id']?>" ><?php echo $results[$i]['stage_name']?></option>
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
		<select name="sub_stage" id="sub_stage">	
			<option value="">Select</option>
		</select>
		<?php 
		}
		?>
		
