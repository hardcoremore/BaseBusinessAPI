<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Business Manager Installation</title>
        <link rel="stylesheet" href="resources/css/main.css" media="all" type="text/css" />
        
        <style type="text/css">

			metadata *
			{
				color:#FF0000;
				display:block;
			}
			
			data
			{
				width:600px;
				border:medium solid #006;
				display:block;
				padding:10px;
				margin-top:10px;
			}
			
			data *
			{
				color:#09F;
				display:block;	
			}
			row
			{
				padding-left:10px;
				font-size: 18px;
			}
			
		</style>
		
    </head>
    
    <body>
    
    	<?php include_once 'system/application/views/main_menu_link.php';?>
    	
    	<h3 style="color:blue;">Application install status:</h3>
    	
        <div id="content-all">
        
        <?php 
        
        	// $data is instance of IDataHolder 
        	if( isset( $data ) )
        	{        		
        		$m = $data->metadata()->getRawMetadata();	
        		$d = $data->data()->getRawData();
        		
        		if( is_array( $m ) )
        		{
	        		foreach( $m  as $k => $meta )
	        		{
	        			echo '<h2 style="color:red;">'.$k.'</h2>';
	        			echo '<row>'.$meta.'</row>';
	        		}
        		}
        		
        		if( is_array( $d ) )
        		{
	        		foreach( $d  as $k => $data_row )
	        		{
	        			echo '<h2>'.$k.'</h2>';
	        			
	        			if( is_array( $data_row ) )
	        			{
	        				echo '<pre>';
	        				print_r( $data_row );
	        				echo '</pre>';
	        			}
	        			else 
	        			{
	        				echo '<row>'.$data_row.'</row>';
	        			}
	        		}
        		}
        		
        	}
        
        ?>
              
        </div>
    </body>
</html>
