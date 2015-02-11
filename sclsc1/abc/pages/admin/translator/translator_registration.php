<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	$msg = '';
	$errmsg = '';

	$reg_advocate='';
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Translator/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/State/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Language/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Translator/Fetch.php';
	//require_once $_SESSION['base_url'].'/classes/Implementation/Advocate/Fetch.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/Translator/Edit.php';
	
	use classes\Implementation\Translator as impTranslator;
	use classes\Implementation\State as impState;
	use classes\Implementation\Language as impLanguage;
	
	$addTranslator = new impTranslator\Add();
	$fetchState  = new impState\Fetch();
	$fetchlang   = new impLanguage\Fetch();
	$fetchTranslator = new impTranslator\Fetch();
	$editTranslator  = new impTranslator\Edit();

	if (isset ( $_POST ['submitTranslator'] ) && $_POST ['submitTranslator']=='Submit') 
	{
        //	print_r($_POST); exit;
		$title         = trim ( $_POST ['title'] );
		$full_name     = trim ( $_POST ['full_name'] );
		$lang          = (int)trim ( $_POST ['lang'] );
		$gender        = trim ( $_POST ['gender'] );
		
		$email_id      = trim ( $_POST ['email_id'] );
		$createtime    = date('Y-m-d H:i:s');
		$mobile_no     = trim ( $_POST ['mobile_no'] );
		$mobile_no2    = trim ( $_POST ['mobile_no2'] );
		$date_of_reg   = trim ( date("m-d-Y", strtotime($_POST ['date_of_reg'])) );
		
		
		$hiddenData = $_POST ['heddinData']+1;
		for($i = 0; $i <= $hiddenData; $i ++) {
			$start_date [] = $_POST ["start_date"] [$i];
			$end_date [] = $_POST ["end_date"] [$i];
		}
	
		$start_date_p = array_values(array_filter($start_date));
		$end_date_p = array_values(array_filter($end_date));
	
		$start_count=count($start_date_p);
		for($j = 0; $j < $start_count; $j ++) {
			$start_date1[]  = date("m-d-Y", strtotime($start_date_p[$j]));
			$end_date1[] = date("m-d-Y", strtotime($end_date_p[$j]));
		}
		//print_r($start_date1);
		//echo "<br>*****";
		//	print_r($end_date1);
	
		
		$address1      = trim ( $_POST ['address1'] );
		$address2      = trim ( $_POST ['address2'] );
		$city          = trim ( $_POST ['city'] );
		$state         = (int)trim ( $_POST ['state'] );
		$pincode       = (int)trim ( $_POST ['pincode'] );
		$comm_add      = trim ( $_POST ['comm_add'] );
	 
		$c_name        = trim ( $_POST ['c_name'] );
		$c_address1    = trim ( $_POST ['c_address1'] );
		$c_address2    = trim ( $_POST ['c_address2'] );
		$c_city        = trim ( $_POST ['c_city'] );
		$c_state       = (int)trim ( $_POST ['c_state'] );
		$c_pincode     = (int)trim ( $_POST ['c_pincode'] );
		
		if($full_name=='' || strlen($full_name) > 50)
			$errMsg[] = "Please Enter Full Name less than 50 charactor".'<br/>';		

		if(!empty($mailId) && !filter_var($mailId, FILTER_VALIDATE_EMAIL))
			$errMsg[] = "Invalid Mail Id".'<br/>';
		
		if(!empty($mobile_no) && (!is_numeric($mobile_no) || strlen($mobile_no) > 10))
			$errMsg[] = "Please Enter Contact Number less than 10 charactor".'<br/>';
		
		if(!empty($mobile_no2) && (!is_numeric($mobile_no2) || strlen($mobile_no2) > 12))
			$errMsg[] = "Please Enter Contact Number less than 12 charactor".'<br/>';
		
		
		if($address1=='' && strlen($address1) > 50)
			$errMsg[] = "Please Enter Address1 less than 50 charactor".'<br/>';	
		
		if($address2!='' && strlen($address2) > 50)
			$errMsg[] = "Please Enter Address2 less than 50 charactor".'<br/>';
		
		if($city=='' && strlen($city) > 20)
			$errMsg[] = "Please Enter City less than 20 charactor".'<br/>';
		
		if($state=='')
			$errMsg[] = "Please Select State".'<br/>';
		
		if(!empty($pincode) && strlen($pincode) > 6)
			$errMsg[] = "Invalid Languages".'<br/>';
		
		if ($comm_add==1)
		{
			
		if($c_name=='' && strlen($c_name) > 50)
			$errMsg[] = "Please Enter Communication Full Name less than 50 charactor".'<br/>';
		
		if($c_address1=='' && strlen($c_address1) > 50)
			$errMsg[] = "Please Enter Communication Address1 less than 50 charactor".'<br/>';
		
		if($c_address2!='' && strlen($c_address2) > 50)
			$errMsg[] = "Please Enter Communication Address2 less than 50 charactor".'<br/>';
		
		if($c_city=='' && strlen($c_city) > 20)
			$errMsg[] = "Please Enter Communication City less than 20 charactor".'<br/>';
		
		if($c_state=='')
			$errMsg[] = "Please Select Communication State".'<br/>';
		
		if(!empty($pincode) && strlen($pincode) > 6)
			$errMsg[] = "Invalid Languages".'<br/>';
		
		}
		
	if(count($errMsg) == 0)
	{			
		
		
		if ($comm_add == "") {
			$comm_add = "f";
			$flag = 1;
		} else {
			if ($c_name == "" || $c_address1 == "" ||  $c_city == "" ||  $c_state == "")
				echo $errmsg = " Please Enter All Communication Address field  ";
			else
				$flag = 1;
		}
	
		if ($title == "" || $full_name == "" || $gender == "" || $flag != 1)
			echo $errmsg = " Please Enter All filed ";
		else {
	
			$rplc = array (
					'<' => '',
					'>' => '',
					'=' => '',
					'%' => '',
					'(' => '',
					')' => ''
			);
			$full_name = htmlentities ( strtr ( trim ( $full_name ), $rplc ) );
			$full_name = $title . ' ' . $full_name;
			// print_r($end_date);
			$reg_translator = $addTranslator->reg_translator ( 
					$full_name, 
					$gender, 
					$lang, 
					$email_id,
					$createtime,
					$mobile_no, 
					$mobile_no2,
					$date_of_reg,
					$address1, 
					$address2, 
					$city, 
					$state,
					$pincode, 
					$c_name,
					$c_address1, 
					$c_address2, 
					$c_city,  
					$c_state, 
					$c_pincode,
					$comm_add, 
					$start_date1,
					$end_date1, 
					$hiddenData );
	
			if($reg_translator == 1)
			{
				$msg = "Translator Has been Registered successfully.";
			header("Location:index.php?msg=$msg");
			}
			else
			{
				 $errmsg = "Translator Registration failed ?? Please try again Later";
				header("Location:index.php?errmsg=$errmsg");
			}
		}
	}
}

	if(isset($_POST['update']))
	{
		$translatorId=(int)$_POST['translatorId'];
		//echo $translatorId;die;
		//$date_of_reg=trim ( date("m-d-Y", strtotime($_POST ['date_of_scba'] )));
		//echo $date_of_reg;exit;
		 //print_r($_POST);exit;
		$title  = trim ( $_POST ['title'] );
		$full_name=$_POST ['full_name'];
		//$a=explode(' ',$full_name);
		//$b=array_splice($a, 0, 1);
		//print_r($b);
		//print_r($a);exit;
		$full_name = $title . ' ' . $full_name;
		$gender        = trim ( $_POST ['gender'] );
		$lang          = trim ( $_POST ['lang'] );
		$email_id      = trim ( $_POST ['email_id'] );
		$mobile_no     = trim ( $_POST ['mobile_no'] );
		$mobile_no2    = trim ( $_POST ['mobile_no2'] );
		
		
		
		
		$address1      = trim ( $_POST ['address1'] );
		$address2      = trim ( $_POST ['address2'] );
		$city          = trim ( $_POST ['city'] );
		$state         = trim ( $_POST ['state'] );
		$pincode       = trim ( $_POST ['pincode'] );
		$comm_add      = trim ( $_POST ['comm_add'] );
		
		$c_name        = trim ( $_POST ['c_name'] );
		$c_address1    = trim ( $_POST ['c_address1'] );
		$c_address2    = trim ( $_POST ['c_address2'] );
		$c_city        = trim ( $_POST ['c_city'] );
		$c_state       = trim ( $_POST ['c_state'] );
		$c_pincode     = trim ( $_POST ['c_pincode'] );
		
		$hiddenData = $_POST ['heddinData']+1;
		for($i = 0; $i <= $hiddenData; $i ++) {
			$start_date [] = $_POST ["start_date"] [$i];
			$end_date [] = $_POST ["end_date"] [$i];
		}
		
		$start_date_p = array_values(array_filter($start_date));
		$end_date_p = array_values(array_filter($end_date));
		
		$start_count=count($start_date_p);
		for($j = 0; $j < $start_count; $j ++) {
			$start_date1[]  = date("m-d-Y", strtotime($start_date_p[$j]));
			$end_date1[] = date("m-d-Y", strtotime($end_date_p[$j]));
		}
		$date_of_reg   = trim ( date("m-d-Y", strtotime($_POST ['date_of_reg'])) );
		/*$abc = $editAdvocate->upAvocateStatus($advocateId,$full_name,$_POST ['gender'],$_POST ['lang'],$_POST ['email_id'],$_POST ['mobile_no'],$_POST ['mobile_no2'],$date_of_reg,$date_of_enrol,$name_of_bar,$date_of_scba,
			                                   $aor,$_POST ['advocate_code'],$_POST ['is_on_panel'],$_POST ['address1'],$_POST ['address2'],$_POST ['city'],
			                                    $_POST ['state'],$_POST ['pincode'],$_POST ['comm_add'],$_POST ['c_name'],
												$_POST ['c_address1'],$_POST ['c_address2'],$_POST ['c_city'],$_POST ['c_state'],$_POST ['c_pincode']);
			*/
		$abc = $editTranslator->upTranslatorStatus($translatorId,$full_name,$_POST ['gender'],(int)$_POST ['lang'],$_POST ['email_id'],
				(int)$_POST ['mobile_no'],$_POST ['mobile_no2'],
				$_POST ['address1'],$_POST ['address2'],$_POST ['city'],
			    (int)$_POST ['state'],(int)$_POST ['pincode'],$_POST ['c_name'],
			    $_POST ['c_address1'],$_POST ['c_address2'],$_POST ['c_city'],(int)$_POST ['c_state'],(int)$_POST ['c_pincode'],$start_date1,
			    $end_date1,$hiddenData,$date_of_reg);
		
		if ($abc==1)
		{
			$msg = "Translator Has been Updated successfully.";
		    header("location:index.php?msg=$msg");
		}
		else
		{
			$errmsg- 'update faild';
			header("location:index.php?msg=$errmsg");
		}
	}
	if(isset($_POST['cancel']) && $_POST['cancel']=="Cancel")
	{
		header('Location:index.php');
	}
$translatorId=$_GET['translatorId'];
$states = $fetchState->getAllStates();	
$language = $fetchlang->getAllLanguage();
$translatordetails=$fetchTranslator->singleTranslatorDetails($translatorId);
$TranslatorRegistrationDate=$fetchTranslator->TranslatorRegPeriod($translatorId);
$fullName= $translatordetails[0]['translator_name'];
$a=explode(' ', $fullName);
//echo $a[0];
//print_r($a);
//echo substr($fullName,2);
//print_r($b);

//echo $advocatedetails[0]['advocate_id'];exit;
//echo '<pre>';
//print_r($states);
//print_r($translatordetails);exit;
 
 
 
 

//$aordate=strtotime($advocatedetails[0]['aor_desig_date']);

	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../../css/styles.css">
		<script src="../../../js/jquery.min.js"></script>
        <script src="../../../js/masking/jquery-1.js"></script>
		<script src="../../../js/masking/jquery.js"></script>
		<script src="../../../js/advocateValidation.js"></script>
   
        <script src="../../../js-mash/jquery-ui.min.js" type="text/javascript"></script>
      
<script type="text/javascript">
$(document).ready(function() {
 
 var myCounter = 0;
 $(".myDate").datepicker();
  
 $("#moreDates").click(function(){
   
  $('.myTemplate p')
   .clone()
   .removeClass("myTemplate")
   .addClass("additionalDate")
   .show()
   .appendTo('#importantDates');
  myCounter++;
  $('.additionalDate input[name=start_date]').each(function(index) {
	  $(this).addClass("date");
  // $(this).attr("name",$(this).attr("name") + myCounter);
   
  });
  $('.additionalDate input[name=end_date]').each(function(index) {
	  $(this).addClass("date");
   //$(this).attr("name",$(this).attr("name") + myCounter);
  });
// value(myCounter);
  $('#remNew').live('click', function() {
				//if( myCounter > 1 ) {
				if(myCounter > 0)
				{
				$(this).parents('p').remove();
				myCounter--;
				textvalue(myCounter);	
				}
				exit();
				return false;
				});
  		
  textvalue(myCounter);
  
  $.ui.mask.definitions['~'] = "[+-]";
	$(".date")
		.mask({mask: "##-##-####"});
	
});
  
});
function textvalue(id){
	//alert("new ID->"+id);
	document.advo_regis.heddinData.value=+id;
	
}

</script>
<script type="text/javascript">
  $(function() {
	  $(".date1").mask({mask: "##-##-####"});
  
 });
</script>
<script type="text/javascript" src="../../../js-mash/ui_002.js"></script>
<script type="text/javascript" src="../../../js-mash/ui.js"></script>


<style type="text/css">
.ui-datepicker {
	font-size: 12pt !important
}
</style>
	
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
	     				<li><a href="#">Home /</a></li>
	     				<li><a href="index.php">Translator Registration</a></li>
	     				<li><div class="right-title" style="color:#1D8CD6"><?php echo date('l jS \of F Y h:i:s A'); ?></div></li>
	     			</ul>
	     			
	     		</div>
	     		
	     		<div class="clear"></div>
	     		<?php if($msg != '')
	     		{	
	     		?>
	     	   	<div id="breadcrumb-green" align="center">
	     			<?php echo $msg;?>	
	     		</div>
	     		<?php 
	     		}
	     		?>
	     		<?php if($errmsg != '' || count($errMsg) > 0)
	     		{	
	     		?>
	     	   	<div id="breadcrumb-red" align="center">
	     			<?php echo $errmsg;
	     			
	     			 foreach($errMsg as $val) {
							echo $val;							
                         }
	     			?>	
	     			
	     		</div>
	     		<?php 
	     		}
	     		?>	
	     		<div class="clear"></div>     		
	     		<div class="title1" style="height:20px;">
     				<div id="left-title">Translator Registration</div>
     				
	     		</div>  		
 
     		       <div style="height:auto;border:1px solid #4b8df8;">
     		       
     		    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="advo_regis" id="advo_regis"
     		     method="post" onsubmit="return validateAdvocateForm()">
     		       
						<h3> Translator Details </h3>
						
     				<div style="width:80%;margin-left:1%">
					
					<div class="left">
							<div class="left"> Title <span class="red">*</span></div>
							<div class="right">
							<select name="title">
							<option value="">Title</option>
							<option value="Mr" <?php if($a[0]=='Mr') { echo "selected=selected";}?>>Mr</option>
							<option value="Ms" <?php if($a[0]=='Ms') { echo "selected=selected";}?>>Ms</option>
							<option value="Dr" <?php if($a[0]=='Dr') { echo "selected=selected";}?>>Dr</option>
						</select>								
							</div>
							
							<div class="clear"></div>
							<div class="left">Translator Name <span class="red">*</span></div>
							<div class="right">
								<input type="text" placeholder="Full Name" name="full_name"  maxlength="50" value="<?php if(isset($translatordetails[0]['translator_name'])) { echo substr($fullName,3); } else echo ''; ?>"/>
							</div>			
							
							<div class="clear"></div>
							<div class="left">Languages </div>
							<div class="right">
							<select name="lang">
							<option value=" ">select</option>
							<?php
									for($i = 0; $i < count ($language); $i ++) {
										?>
										<option value="<?php echo $language[$i]['id']; ?>" <?php if($translatordetails[0]['lang_id']==$language[$i]['id'])  echo "selected=selected"; ?>><?php echo $language[$i]['lang_name']; ?></option>
									<?php
									}
									?>
						</select>	
							</div>
							<div class="clear"></div>
							<div class="left">Other Contact No.</div>
							<div class="right">
								<input type="text" placeholder=" Alternative number "  maxlength="12" 
								onKeyPress="return number(event)" name="mobile_no2" id="mobile_no2" value="<?php if(isset($translatordetails[0]['contactno2'])) { echo $translatordetails[0]['contactno2']; } else echo ''; ?>"/>
							</div>	
							
					</div>					
					
					<div class="right">							
							<div class="clear"></div>
							<div class="left">Gender <span class="red">*</span></div>
							<div class="right">
								<input type="radio" name="gender" value="Male"   <?php if(isset($translatordetails[0]['gender'])) { echo 'checked'; } ?>/> Male 
								<input type="radio" name="gender" value="Female" <?php if(isset($translatordetails[0]['gender'])) { echo 'checked'; } ?>/> Female																
							</div>
							
							<div class="clear"></div>
							<div class="left">E-mail ID </div>
							<div class="right">	
							<input type="text" placeholder="Email Id" name="email_id" id="email_id" value="<?php if(isset($translatordetails[0]['email_id'])) { echo $translatordetails[0]['email_id']; } else echo ''; ?>"/>
							</div>
							
							<div class="clear"></div>
							<div class="left">Mobile No. </div>
							<div class="right">
								<input type="text" placeholder="Only 10 Digit Number" maxlength="10" 
								onKeyPress="return number(event)" name="mobile_no" id="mobile_no" value="<?php if(isset($translatordetails[0]['contactno1'])) { echo $translatordetails[0]['contactno1']; } else echo ''; ?>" />
							</div>
													
					</div>					
				</div>
				
								
				<div class="clear"></div>
					<h3>Enrollment Details </h3>
					<div class="clear"></div>
     				<div style="width:80%;margin-left:1%">
					<div class="clear"></div>
					<div class="left">
							
							
							<div class="clear"></div>
							<div class="left">Registration Date <span class="red">*</span> </div>
							<div class="right">
								<input type="text" placeholder="DD-MM-YYYY"	name="date_of_reg" id="date_of_reg" class="date1" onblur="regDate(advo_regis)" value="<?php if(isset($TranslatorRegistrationDate[0]['start_date'])) { $TranslatorRegistrationDate=  date("d-m-Y", strtotime($TranslatorRegistrationDate[0]['start_date']));echo $TranslatorRegistrationDate; } else echo ''; ?>"/>
							</div>							
					</div>					
					
					<div class="right">
							<div class="clear"></div>
							
							
							<div class="clear"></div>
							<div class="left">Period on Panel </div>
							<div class="right">
								<div style="width: 38%; float: left;">
									<input type="text" class="date1" placeholder="Start Date" name="start_date[]" id="txtFrom" onblur="startDate(advo_regis)"/>
								</div>
								<div style="width: 38%; float: left; margin-left: 10%">
									<input type="text" class="date1" placeholder="End Date"	name="end_date[]" id="txtTo" onblur="endDate(advo_regis)"/>
								</div>
								<div style="width: 10%; float: left;  margin-left: 10px;">
									<a href="#" id="moreDates" class="next">Add</a>
								</div>
							</div>	
							<div class="left"></div>
							<div class="right">
		<div id="importantDates">         
        <input type="hidden" name="heddinData" size="10" value=""/>
        <div class="myTemplate" style="display:none">
          <p>
            <input type="text" name="start_date[]"  placeholder="DD-MM-YYYY" 
            style="width:35%;float:left;margin-top:2%"  size="10" class="date" value="" />
            <input type="text" name="end_date[]" placeholder="DD-MM-YYYY" 
            style="width:35%;float:left;margin-left:1%; margin-top:2%" size="10"  class="date"  value="" />
            <a href="#"  class="remove" id="remNew">Remove</a> </p>
        </div>
      </div>
      </div>
	</div>					
</div>
				
				
				
				<div class="clear"></div>
					<h3>Address Details</h3>
					<div class="clear"></div>
     				<div style="width:80%;margin-left:1%">
					<div class="clear"></div>
					<div class="left">
							<div class="left">Address Line 1 <span class="red">*</span></div>
							<div class="right">
							<input type="text" name="address1" id="address1" placeholder="Address Line 1" maxlength="50" value="<?php if(isset($translatordetails[0]['address1'])) { echo $translatordetails[0]['address1']; } else echo ''; ?>"/>							
							</div>
							
							<div class="clear"></div>
							<div class="left">Address Line 2</div>
							<div class="right">
								<input type="text" name="address2" id="address2" placeholder="Address Line 2" maxlength="50" value="<?php if(isset($translatordetails[0]['address2'])) { echo $translatordetails[0]['address2']; } else echo ''; ?>"/>
							</div>
							
							<div class="clear"></div>
							<div class="left">City <span class="red">*</span></div>
							<div class="right">
								<input type="text" placeholder="City" name="city" id="city" 
								onKeyPress="return alphadot_hyphendigit_No_Limited(event)" value="<?php if(isset($translatordetails[0]['city'])) { echo $translatordetails[0]['city']; } else echo ''; ?>"/>
							</div>
							
												
					</div>					
					
					<div class="right">
							
							<div class="clear"></div>
							<div class="left">State <span class="red">*</span> </div>
							<div class="right">
							<select name="state" id="state">
									<option value=''>Select</option>
									<?php
									for($i = 0; $i < count ( $states ); $i ++) {
										?>
										<option value="<?php echo $states[$i]['id']; ?>" <?php if($translatordetails[0]['state']==$states[$i]['id'])  echo "selected=selected"; ?>><?php echo $states[$i]['state_name']; ?></option>
									<?php
									}
									?>
									</select>
								
							</div>						
								<div class="clear"></div>
							<div class="left">Pin  </div>
							<div class="right">
								<input type="text" placeholder="Pin Code" name="pincode" id="pincode" maxlength="6"
									onKeyPress="return number(event)" value="<?php if(isset($translatordetails[0]['pincode'])) { echo $translatordetails[0]['pincode']; } else echo ''; ?>"/>
							</div>	
					</div>
					
					
				</div>
				
				<div class="clear"></div>
					<h3><input type="checkbox" name="comm_add" id="comm_add" style="height: 30px;" class="first" value="1" <?php if(isset($translatordetails[1]['is_commun_address'])=='1') { echo 'checked'; }?>  onclick="showMe('hide', this)" />  
					Communication Address </h3>
					<div class="clear"></div>
     				<div style="width:80%;margin-left:1%" id="hide">
					<div class="clear"></div>
					<div class="left">
							<div class="left">Full Name <span class="red">*</span></div>
							<div class="right">
							<input type="text" name="c_name" id="c_name" placeholder="Full Name" maxlength="50" value="<?php if(isset($translatordetails[1]['is_commun_address'])=='1') { echo $translatordetails[1]['commun_name']; } else echo ''; ?>"/>							
							</div>
							
							<div class="clear"></div>
							<div class="left">Address Line 1 <span class="red">*</span></div>
							<div class="right">
							<input type="text" name="c_address1" id="c_address1" placeholder="Address Line 1" maxlength="50" value="<?php if(isset($translatordetails[1]['is_commun_address'])=='1') { echo $translatordetails[1]['address1']; } else echo ''; ?>"/>							
							</div>
							
							<div class="clear"></div>
							<div class="left">Address Line 2</div>
							<div class="right">
								<input type="text" name="c_address2" placeholder="Address Line 2" maxlength="50" value="<?php if(isset($translatordetails[1]['is_commun_address'])=='1') { echo $translatordetails[1]['address2']; } else echo ''; ?>"/>
							</div>
													
					</div>					
					
					<div class="right">
							
							<div class="clear"></div>
							<div class="left">City <span class="red">*</span></div>
							<div class="right">
								<input type="text" placeholder="City" name="c_city" maxlength="50"
										onKeyPress="return alphadot_hyphendigit_No_Limited(event)" value="<?php if(isset($translatordetails[1]['is_commun_address'])=='1') { echo $translatordetails[1]['city']; } else echo ''; ?>" />
							</div>								
							
							<div class="clear"></div>
							<div class="left">State <span class="red">*</span> </div>
							<div class="right">
							<select name="c_state" id="c_state">
									<option value=''>Select</option>
									<?php
									for($i = 0; $i < count ($states); $i ++) {
                                                  // print_r($states);
										?>
										<option value="<?php echo $states[$i]['id']; ?>" <?php if($translatordetails[1]['state']==$states[$i]['id'])  echo "selected=selected";  ?> ><?php echo $states[$i]['state_name']; ?></option>
									<?php
									}
									?>
									</select>								
							</div>	
												
							<div class="clear"></div>
							<div class="left">Pin </div>
							<div class="right">
								<input type="text" placeholder="Pin Code" name="c_pincode" id="c_pincode" maxlength="6"
									onKeyPress="return number(event)" value="<?php if(isset($translatordetails[1]['pincode'])) { echo $translatordetails[1]['pincode']; } else echo ''; ?>" />
							</div>
							
					</div>					
					
				</div>
				
			<div class="clear"></div>			
	     			<div style="text-align:center;padding:10px 0;">		
	     			<?php if(isset($_GET['translatorId']) && $_GET['action']=="edit"){?>
				     					<input type="submit" name="update" value="Update" class="form-button" />
				     				<!-- 	<input type="submit" name="cancel" value="Cancel" class="form-button" /> -->
				     					<input type="hidden" id="translatorId" name="translatorId" 
				     					value="<?php echo $_GET['translatorId'];?>"/>	
				     					<?php }else {?>					
						<input class="form-button" type="submit" name="submitTranslator" value="Submit" />
						<?php } ?>
					</div>
				
			</form>						
							
		</div>
	</div>
	<div class="clear"></div>				
 </div> 
	<div class="clear"></div>			
 <script type="text/javascript">
					jQuery(function($){
						$("#mobile_no").mask("999-999-9999", {placeholder: 'XXX/XXX/XXXX'});
						$("#mobile_no2").mask("999-999-9999", {placeholder: 'XXX/XXX/XXXX'});
						 $("#pincode").mask("999999", {placeholder: 'XXXXXX'});
                        $("#c_pincode").mask("999999", {placeholder: 'XXXXXX'});
                        $("#date_of_reg").mask("99-99-9999", {placeholder: 'dd-mm-yyyy'});
					});
					$(document).ready(function() {
					    $('form:first *:input[type!=hidden]:first').focus();
					});
				</script>

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
  
  <script type="text/javascript"> 
	
	function showMe (it, box) { 
	  var vis = (box.checked) ? "block" : "none"; 
	  document.getElementById(it).style.display = vis;
	} 

	function showAor (box) {

	    var chboxs = document.getElementsByName("is_aor");
	    var vis = "none";
	    for(var i=0;i<chboxs.length;i++) { 
	        if(chboxs[i].checked){
	         vis = "block";
	            break;
	        }
	    }
	    document.getElementById(box).style.display = vis;


	}
	
	function comunicationaddress()
	{
		//alert('sdakdj');
		$("#hide").show();
    }
</script>
  <?php if(isset($translatordetails[1]['is_commun_address'])=='1') {?>
		    <script>window.onload=comunicationaddress;</script>

<?php }?>  
 
	</body>
</html>
