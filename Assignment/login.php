<?php
include 'config/lf_info.php';
?>
<html>
<head>
	<title><?php echo COMPANY_CODE; ?></title>
</head>
<body>	

<div align="center">
<img src="images/logo.png" alt="<?php echo COMPANY_NAME ; ?>" width="820" height="250">
	<table border ='0'>	
	<form action="lf_login.php" method="post">	
	<tr>
	<td>
<div align="center">		
	<h2>Login</h2>		
</div>
	</td>
	</tr>
	<tr>
	<td>
<table border= '0'>
<tr>
<td>
User ID
</td>
<td>
:
</td>
<td>
	<input type="text" name="txtUserID" id="txtUserID" class="form-control">
	
	</td>
	</tr>
	<tr>
<td>
Password
</td>
<td>
:
</td>
<td>
	<input type="password" name="txtPassword" id="txtPassword" class="form-control">

	</td>
	</tr>
	<tr>
	<td>
	</td>
<td>
	</td>
	<td>	
<div align="right">						
	<input type="submit" value="Login" class="btn btn-primary">
</form>	
	<input type="button" value="Back" class="btn btn-primary" onClick="javascript:history.go(-1)">
	</div>	
	</td>
	</tr>
	</td>
	</tr>	


					
</table>
</div>
<!-- <div class="row copyright">
<div class="col-md-12 text-center" align="bottom">
			<p>
				<small class="block">All Rights Reserved.</small> <br>
				<small class="block">Designed by Kevin</small> <br>
				<small class="block">&copy, 2017 ~ Current</small>
			</p>
		</div>
	</div> -->
</body>

</html>

