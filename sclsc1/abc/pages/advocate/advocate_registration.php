<?php 
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['user']['user_name']))
		header('location:../../index.php');
	$msg = '';
	$errmsg = '';	
	$reg_advocate='';
	
	require_once $_SESSION['base_url'].'/classes/Implementation/Advocate/Add.php';
	require_once $_SESSION['base_url'].'/classes/Implementation/State/Fetch.php';
	
	use classes\Implementation\Advocate as impAdvocate;
	use classes\Implementation\State as impState;
	
	$addAdvocate = new impAdvocate\Add();
	$fetchState  = new impState\Fetch();
	
	if (isset ( $_POST ['submitAdvocate'] ) && $_POST ['submitAdvocate']=='Submit') 
	{
//	print_r($_POST); exit;
		$title         = trim ( $_POST ['title'] );
		$full_name     = trim ( $_POST ['full_name'] );
		$gender        = trim ( $_POST ['gender'] );
		$lang          = trim ( $_POST ['lang'] );
		$email_id      = trim ( $_POST ['email_id'] );
		$mobile_no     = trim ( $_POST ['mobile_no'] );
		$mobile_no2    = trim ( $_POST ['mobile_no2'] );
		$date_of_reg   = trim ( date("m-d-Y", strtotime($_POST ['date_of_reg'])) );
		$date_of_enrol = trim ( date("m-d-Y", strtotime($_POST ['date_of_enrol'])) );
		$name_of_bar   = trim ( $_POST ['name_of_bar'] );
		$date_of_scba  = trim ( date("m-d-Y", strtotime($_POST ['date_of_scba'] )));

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
	
	
		$aor           = trim ( date("m-d-Y", strtotime($_POST ['aor'])) );
		$advocate_code = trim ( $_POST ['advocate_code'] );
		$is_on_panel   = trim ( $_POST ['is_on_panel'] );
		$is_aor        = trim ( $_POST ['is_aor'] );
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
		
		if($full_name=='' && strlen($full_name) > 50)
			$errMsg[] = "Please Enter Full Name less than 50 charactor".'<br/>';		

		if(!empty($lang) && strlen($lang) > 50)
			$errMsg[] = "Please Enter Languages less than 50 charactor".'<br/>';
		
		if(!empty($mailId) && !filter_var($mailId, FILTER_VALIDATE_EMAIL))
			$errMsg[] = "Invalid Mail Id".'<br/>';
		
		if(!empty($mobile_no) && (!is_numeric($mobile_no) || strlen($mobile_no) > 10))
			$errMsg[] = "Please Enter Contact Number less than 10 charactor".'<br/>';
		
		if(!empty($mobile_no2) && (!is_numeric($mobile_no2) || strlen($mobile_no2) > 12))
			$errMsg[] = "Please Enter Contact Number less than 12 charactor".'<br/>';
		
		if($date_of_scba < $date_of_enrol)
			$errMsg[] = "Invalid Enrolment Date(SCBA)".'<br/>';
		
		if($date_of_scba < $aor)
			$errMsg[] = "Invalid Registration Date".'<br/>';
		
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
		
		if($is_aor=="")
			$is_aor="f";
		if($is_on_panel=="")
			$is_on_panel="f";
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
			$reg_advocate = $addAdvocate->reg_advocate ( 
					$full_name, 
					$gender, 
					$lang, 
					$email_id, 
					$mobile_no, 
					$mobile_no2, 
					$date_of_reg, 
					$date_of_enrol, 
					$name_of_bar, 
					$date_of_scba, 
					$aor, 
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
					$is_on_panel, 
					$is_aor,
					$advocate_code, 
					$start_date1,
					$end_date1, 
					$hiddenData );
	
			if ($reg_advocate == 1)
			{
				$msg = "Adovcate Record Has been Registered successfully.";
			header("Location:index.php?msg=$msg");
			}
			else
			{
				 $errmsg = "Adovcate Registration failed ?? Please try again Later";
				header("Location:index.php?errmsg=$errmsg");
			}
		}
	}
}
	
$states = $fetchState->getAllStates();	
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  	<meta charset="utf-8">
	    <title>Welcome to SCLSC</title>
		<link href="../../css/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="../../css/styles.css">
		<script src="../../js/jquery.min.js"></script>
        <script src="../../js/masking/jquery-1.js"></script>
		<script src="../../js/masking/jquery.js"></script>
		<script src="../../js/advocateValidation.js"></script>
   
        <script src="../../js-mash/jquery-ui.min.js" type="text/javascript"></script>
      
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
<script type="text/javascript" src="../../js-mash/ui_002.js"></script>
<script type="text/javascript" src="../../js-mash/ui.js"></script>


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
	     				<li><a href="index.php">Advocate Registration</a></li>
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
     				<div id="left-title">Advocate Registration</div>
     				
	     		</div>  		
 
     		       <div style="height:auto;border:1px solid #4b8df8;">
     		       
     		    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="advo_regis" id="advo_regis"
     		     method="post" onsubmit="return validateAdvocateForm()">
     		       
						<h3> Advocate Details </h3>
						<p align="right"><input type="checkbox" name="is_aor" id="is_aor" value="1" checked="checked" onclick="showAor('divAor')"/>
						 Is AOR &nbsp; &nbsp;<input type="checkbox" name="is_on_panel" value="1" checked="checked"/> Is On Pannel &nbsp; &nbsp;</p>
     				<div style="width:80%;margin-left:1%">
					
					<div class="left">
							<div class="left"> Title <span class="red">*</span></div>
							<div class="right">
							<select name="title">
							<option value="">Title</option>
							<option value="Mr">Mr</option>
							<option value="Ms">Ms</option>
							<option value="Dr">Dr</option>
						</select>								
							</div>
							
							<div class="clear"></div>
							<div class="left">Advocate Name <span class="red">*</span></div>
							<div class="right">
								<input type="text" placeholder="Full Name" name="full_name"  maxlength="50"/>
							</div>			
							
							<div class="clear"></div>
							<div class="left">Languages </div>
							<div class="right">
								<input type="text" placeholder="Lanhuages " name="lang"	maxlength="50"
								onKeyPress="return alphadot_hyphendigit_No_Limited(event)" />
							</div>
							<div id="divAor">
							<div class="clear"></div>
							<div class="left" >Advocate Code </div>
							<div class="right">
								<input type="text" placeholder="Advocate Code" name="advocate_code" maxlength="10"/>
							</div>
							
							<div class="clear"></div>
							<div class="left">AOR Designate Date </div>
							<div class="right">
								<input type="text" placeholder="DD-MM-YYYY" name="aor" class="date1" id="aor" onblur="aorDate(advo_regis)"/>
							</div>
							</div>
					</div>					
					
					<div class="right">							
							<div class="clear"></div>
							<div class="left">Gender <span class="red">*</span></div>
							<div class="right">
								<input type="radio" name="gender" value="Male" /> Male 
								<input type="radio" name="gender" value="Female" /> Female																
							</div>
							
							<div class="clear"></div>
							<div class="left">E-mail ID </div>
							<div class="right">	
							<input type="text" placeholder="Email Id" name="email_id" id="email_id" />
							</div>
							
							<div class="clear"></div>
							<div class="left">Mobile No. </div>
							<div class="right">
								<input type="text" placeholder="Only 10 Digit Number" maxlength="10" 
								onKeyPress="return number(event)" name="mobile_no" id="mobile_no"  />
							</div>
							<div class="clear"></div>
							<div class="left">Other Contact No.</div>
							<div class="right">
								<input type="text" placeholder=" Alternative number "  maxlength="12" 
								onKeyPress="return number(event)" name="mobile_no2" id="mobile_no2"/>
							</div>							
					</div>					
				</div>
				
								
				<div class="clear"></div>
					<h3>Enrollment Details </h3>
					<div class="clear"></div>
     				<div style="width:80%;margin-left:1%">
					<div class="clear"></div>
					<div class="left">
							<div class="left">Enrolment Date as Advocate<span class="red">*</span></div>
							<div class="right">
							<input type="text" placeholder="DD-MM-YYYY"	 class="date1" name="date_of_enrol" id="date_of_enrol" onblur="enrolDate(advo_regis)"/>							
							</div>
							
							<div class="clear"></div>
							<div class="left">Enrolment Date(SCBA) <span class="red">*</span></div>
							<div class="right">
								<input type="text" placeholder="DD-MM-YYYY" name="date_of_scba" class="date1" id="date_of_scba" id="date_of_scba" onblur="enrolScbaDate(advo_regis)"/>
							</div>
							
							<div class="clear"></div>
							<div class="left">Registration Date <span class="red">*</span> </div>
							<div class="right">
								<input type="text" placeholder="DD-MM-YYYY"	name="date_of_reg" id="date_of_reg" class="date1" onblur="regDate(advo_regis)"/>
							</div>							
					</div>					
					
					<div class="right">
							<div class="clear"></div>
							<div class="left">Enrolled Bar Council <span class="red">*</span></div>
							<div class="right">
								<input type="text" placeholder="Enrolled Bar Council"	name="name_of_bar" />
							</div>
							
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
							<input type="text" name="address1" id="address1" placeholder="Address Line 1" maxlength="50"/>							
							</div>
							
							<div class="clear"></div>
							<div class="left">Address Line 2</div>
							<div class="right">
								<input type="text" name="address2" id="address2" placeholder="Address Line 2" maxlength="50"/>
							</div>
							
							<div class="clear"></div>
							<div class="left">City <span class="red">*</span></div>
							<div class="right">
								<input type="text" placeholder="City" name="city" id="city" 
								onKeyPress="return alphadot_hyphendigit_No_Limited(event)" />
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
										<option value="<?php echo $states[$i]['id']; ?>"><?php echo $states[$i]['state_name']; ?></option>
									<?php
									}
									?>
									</select>
								
							</div>						
								<div class="clear"></div>
							<div class="left">Pin  </div>
							<div class="right">
								<input type="text" placeholder="Pin Code" name="pincode" id="pincode" maxlength="6"
									onKeyPress="return number(event)" />
							</div>	
					</div>
					
					
				</div>
				
				<div class="clear"></div>
					<h3><input type="checkbox" name="comm_add" id="comm_add" style="height: 30px;" class="first" value="1" onclick="showMe('hide', this)" />  
					Communication Address </h3>
					<div class="clear"></div>
     				<div style="width:80%;margin-left:1%" id="hide">
					<div class="clear"></div>
					<div class="left">
							<div class="left">Full Name <span class="red">*</span></div>
							<div class="right">
							<input type="text" name="c_name" id="c_name" placeholder="Full Name" maxlength="50"/>							
							</div>
							
							<div class="clear"></div>
							<div class="left">Address Line 1 <span class="red">*</span></div>
							<div class="right">
							<input type="text" name="c_address1" id="c_address1" placeholder="Address Line 1" maxlength="50"/>							
							</div>
							
							<div class="clear"></div>
							<div class="left">Address Line 2</div>
							<div class="right">
								<input type="text" name="c_address2" placeholder="Address Line 2" maxlength="50"/>
							</div>
													
					</div>					
					
					<div class="right">
							
							<div class="clear"></div>
							<div class="left">City <span class="red">*</span></div>
							<div class="right">
								<input type="text" placeholder="City" name="c_city" maxlength="50"
										onKeyPress="return alphadot_hyphendigit_No_Limited(event)" />
							</div>								
							
							<div class="clear"></div>
							<div class="left">State <span class="red">*</span> </div>
							<div class="right">
							<select name="c_state" id="c_state">
									<option value=''>Select</option>
									<?php
									for($i = 0; $i < count ( $states ); $i ++) {
										?>
										<option value="<?php echo $states[$i]['id']; ?>"><?php echo $states[$i]['state_name']; ?></option>
									<?php
									}
									?>
									</select>								
							</div>	
												
							<div class="clear"></div>
							<div class="left">Pin </div>
							<div class="right">
								<input type="text" placeholder="Pin Code" name="c_pincode" id="c_pincode" maxlength="6"
									onKeyPress="return number(event)" />
							</div>
							
					</div>					
					
				</div>
				
			<div class="clear"></div>			
	     			<div style="text-align:center;padding:10px 0;">						
						<input class="form-button" type="submit" name="submitAdvocate" value="Submit" />
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
</script>
 
	</body>
</html>
