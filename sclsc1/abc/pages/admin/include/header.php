<div class="wrapper">
			<div id="header">
				<div id="logo">
					<img src="../../images/logo.png" alt="" width="90%" height="100%" />
				</div>
				<!-- <div id="right-header" style="background-image:url('images/bg_header.png')"> -->
					<div id="right-header">
					<div style="width:25%;float:right;padding-top:5px;height:100%;">
						<div style="height:30px;margin-bottom:5px;text-align:right">
							<?php if(!isset($_SESSION['user']['user_name']))
							{	
							?><a href="login.php" class="login-button">Login</a>
							<?php 
							}else 
							{	
							?>
							<a>Welcome <span style="color:blue"><?php echo $_SESSION['user']['user_name']; ?></span></a>&nbsp;<a href="../../logout.php"><span style="color:red">Logout</span></a>
							<?php 
							}
							?>
						</div>
						<input type="text" name="menuSearch" placeholder="Menu search" />
					</div>
					<div style="width:72%;float:right;height:100%;">
						<div style="padding-top:20px;;font-size:25px;color:#312f60;text-align:center">Supreme Court Legal Services Committee</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
	    </div>