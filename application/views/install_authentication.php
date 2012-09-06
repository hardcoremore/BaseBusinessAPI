<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Application Installation</title>
        
    </head>
    
    <body>
    
    	<h3 style="color:red;" align="center"><?php if( isset( $info ) ) echo $info;?></h3>
    	<h3 style="color:blue;" align="center">Please Authenticate to modify the application:</h3>
    	
        <div id="content-all" align="center">
        
           <form action="<?php echo $action ?>" method="post" enctype="application/x-www-form-urlencoded">
           
	           <table align="center">

		          	<tr>
			           	<td>Auth Key: </td>
			           	<td><input type="password"" name="key" value="840f7c2a-37e4-42f1-b7bf-30a1d3e8444a" style="width:220px"/></td>
			        </tr>
			        <tr>   	
			           	<td>Username: </td>
			           	<td><input type="password"" name="username" value="35faa9e5-c8bb-4a3f-9bc7-1e879c5819e7" style="width:220px"/></td>
			        </tr>
			        <tr>
			           	<td>Password: </td>
			           	<td><input type="password"" name="password" value="d7ae289f-134f-4de4-9622-a6e45edccebd" style="width:220px"/></td>
			       	</tr>
			       	
			       	<tr>
			       		<td><input type="submit"" name="authenticate" value="Authenticate" /></td>
			       	</tr>
		       	
		       	</table>
	       	
           </form>
              
        </div>
        
    </body>
</html>
