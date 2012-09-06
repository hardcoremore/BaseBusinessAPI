<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Business Manager Installation</title>
        <link rel="stylesheet" href="resources/css/main.css" media="all" type="text/css" />

    </head>
    
    <body>
    
    	<?php include_once 'system/application/views/main_menu_link.php';?>
    	
    	<h3 style="color:blue;">Administrator creation response:</h3>
    	
        <div id="content-all">
        
        <table>
        	<tr>
        		<td><h3 style="color:blue;">Status:</h3></td>
        		<td><?php echo $admin_data->metadata()->getStatus(); ?></td>
        	</tr>
        	<tr>
        		<td><h3 style="color:blue;">ErrorCode:</h3></td>
        		<td><?php echo $admin_data->metadata()->getErrorCode(); ?></td>
        	</tr>
        	<tr>
        		<td><h3 style="color:blue;">Message:</h3></td>
        		<td><?php echo $admin_data->metadata()->getMessage(); ?></td>
        	</tr>
        </table>
              
        </div>
    </body>
</html>
