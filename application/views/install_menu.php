<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Business Manager Installation Menu</title>
        
    </head>
    
    <body>
    		<h3>Welcome Admin</h3>
    		
    		<div><h4>Main Menu</h4></div>
    		
    		
    		<?php
    			if( isset( $links )  && count( $links ) > 0 )
    			{
    				foreach( $links as $v )
    				{
    					echo '<a href="' . $v['link'] . '">' . $v['name'] . '</a><br /><br />';
    				}
    			}
    			 
    		?>
   			
    </body>
</html>
