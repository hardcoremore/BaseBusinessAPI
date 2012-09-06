<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Business Manager Installation</title>
        
    </head>
    
    <body>
    
    	<?php include_once 'system/application/views/main_menu_link.php';?>
    	
    	<h3 style="color:blue;">Business Manager Installation Form. <br />Please provide installation key:</h3>
        <div id="content-all">
        
        <?php if( isset( $error ) ) echo '<h3 style="color:red">'.$error.'</h3>'; ?>
         
           <form action="<?php echo @$action ?>" method="post" enctype="application/x-www-form-urlencoded">

    			<table>
	    			<tr>
	    				<td>Key:</td>
	    				<td><input type="text" name="key" style="width:220px"/></td>
	    			</tr>
	    			<tr>
	    				<td height="10"></td></tr>
	    			<tr>
			       		<td colspan="2"><input type="submit"" name="install" value="Install Application" /></td>
			       	</tr>
    			</table>
           </form>
              
        </div>
        
    </body>
</html>
