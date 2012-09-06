<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Business Manager Installation</title>
        <script type="text/javascript">


        	var module_post_name = '<?php echo $module_post_name;?>';
			var post_array_delimiter = '<?php echo $post_array_delimiter?>';
            
        	function on_module_select(target)
        	{
			
				var c = document.getElementById( target.id );

				console.log( module_post_name + c.id + post_array_delimiter + 'template' );
				
				var template	= document.getElementById( module_post_name + c.id + post_array_delimiter + 'template' );
				var name 		= document.getElementById( module_post_name + c.id + post_array_delimiter + 'name' );
				var action 		= document.getElementById( module_post_name + c.id + post_array_delimiter + 'action' );
				var active 		= document.getElementById( module_post_name + c.id + post_array_delimiter + 'active' );

				
				if( c.value == 'off' )
				{
					c.value = 'on';

					
					template.removeAttribute("disabled");
					name.removeAttribute("disabled");
					action.removeAttribute("disabled");
					active.removeAttribute("disabled");
				}
				else
				{
					c.value = 'off';
					template.disabled = true;
					name.disabled = true;
					action.disabled = true;
					active.disabled = true;
				}


        	}
	        	
            	
        </script>
    </head>
    
    <body>
    
    	<?php include_once 'system/application/views/main_menu_link.php';?>
    	
    	<h3 style="color:blue;">Business Manager Installation Form. <br />Please provide installation key, administrator details and select modules you wish to install:</h3>
        <div id="content-all">
        
        <?php if( isset( $error ) ) echo '<h3 style="color:red">'.$error.'</h3>'; ?>
         
           <form action="<?php echo $action ?>" method="post" enctype="application/x-www-form-urlencoded">
           
	           <table>
	          
	          	<tr>
	          		<td><h3>Installation key:</h3></td>
	          	</tr>
	           	
	           	<tr>
		           	<td>Install Key: </td>
		           	<td><input type="password""  name="install_key" size="30"/></td>
		        </tr>
		        
		        
		        </table>
		        <?php 
		        		require_once 'system/application/views/create_admin.php';
						
							
		        ?>
		        
							
	          <table>	
	       		<tr>
	       			<td valign="top"><h3>Application modules to install:</h3></td>
	       		</tr>
	       		
	       		
	       		<tr>
	       			<td>
		       			<table>
							
							
				       		<tr>
				       			<td align="left" width="300"><h4>Module name</h4></td>
				       			<td align="left" width="300"><h4>Module template</h4></td>
				       		</tr>
	       		
							<?php
							
								if( isset( $modules ) && count( $modules ) > 0 )
								{
									$c = 0;
									foreach( $modules as $k => $m )
									{
										echo '<tr>
												<td>
													<input type="checkbox" value="on" checked="true" id="'.$c.'" onchange="on_module_select(this)"/>
													'.$k.'
												</td>
												<td style="padding-left:20px;">
													<select id="'.$module_post_name . $c . $post_array_delimiter.'template" name="'.$module_post_name . $c . $post_array_delimiter.'template">';

										foreach( $m as $t )
										{
											echo '<option value="'.$t.'">'.$t.'</option>';
										}
										
										echo '</select>';
										
										echo '<input id="'.$module_post_name . $c . $post_array_delimiter.'name" type="hidden" name="'.$module_post_name . $c . $post_array_delimiter.'name" value="'.$k.'" />';
										echo '<input id="'.$module_post_name . $c . $post_array_delimiter.'action" type="hidden" name="'.$module_post_name . $c . $post_array_delimiter.'action" value="create" />';
										echo '<input id="'.$module_post_name . $c . $post_array_delimiter.'active" type="hidden" name="'.$module_post_name . $c . $post_array_delimiter.'active" value="true" />';
										echo '</td></tr>';
										$c++;
									}
								}
								
			        		?>
			        		
			        	</table>
			        		
		    		</td>
    			</tr>
    			
    			<tr><td><br /><br /></td></tr>
    			
    			<tr>
		       	<td><input type="submit"" name="install" value="Install Application" /></td>
		       	</tr>
		       		
    			</table>
           </form>
              
        </div>
        
    </body>
</html>
