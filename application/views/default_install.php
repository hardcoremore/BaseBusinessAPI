<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Business Manager Installation</title>
        
    </head>
    
    <body>
    
    	<h3 style="color:blue;">Business Manager Installation Form. Please provide install key to install application:</h3>
    	
    	<?php include_once 'system/application/views/main_menu_link.php';?>
        <div id="content-all">
        
           <form action="<?php echo $action ?>" method="post" enctype="application/x-www-form-urlencoded">
           
	           <table>
	           
	           
	           
	          
		       	<tr>
		       		<td><input type="submit"" name="install" value="Install" /></td>
		       	</tr>
		       	
		       	</table>
	       	
           </form>
              
        </div>
        
    </body>
</html>
