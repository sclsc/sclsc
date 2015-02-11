<?php 
	session_start();
	
	require_once $_SESSION['base_url'].'/classes/Implementation/LetterType/Fetch.php';
	
	use classes\Implementation\LetterType as impLetterType;
	
	$fetchLetter  = new impLetterType\Fetch();
	
	$msg = '';

		$results = $fetchLetter->getAllLetterSubject($_GET['q']);

//	print_r($results); 		 
		?>
		<div class="left">Subject <span class="red">*</span></div>
		<div class="right">
		<?php 
		if(count($results) != 0)
		{
		?>
				
		</div>
		<div class="right">
		<input type="text" placeholder="Subject" name="subject" id="subject"  value="<?php echo $results[0]['file_path']?>" maxlength="150" readonly/>											
		</div>
		<?php 
		}
		else 
		{	
		?>
		<div class="left">Subject <span class="red">*</span></div>
		<div class="right">
		<input type="text" placeholder="Subject" name="subject" id="subject" maxlength="150"/>											
		</div>
		
		<?php 
		}
		?>
		
