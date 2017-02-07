<?php

/*
Hyper Menu Code
Author - Abhin Sharma 
Version - 1.4
*/



class ioa_Menu_Frontend extends Walker_Nav_Menu  {
	/**
	 * @see Walker::$tree_type
	 * @since 3.0.0
	 * @var string
	 */
	var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
  	 var $isMegaMenu = false;
	var $rowcount = 0;
	var $rowlimit = 5;
	var $menutype = "none";
	var $widgetflag = true;
	var $widget_id = "";
	var $isTextBox = false;
	var $metatext = '';
	/**
	 * @see Walker::$db_fields
	 * @since 3.0.0
	 * @todo Decouple this.
	 * @var array
	 */
	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl(&$output, $depth =0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$element = 'ul'; $widget_class = '  ';
		$this->rowcount = 0; $top_Data ='';
		
		if($depth==0&&$this->isMegaMenu)
		{
			$element = 'div';
		    $top_Data = "";
			if($this->menutype=="widget")
			$widget_class = 'widget_menu';
		}
	    
		if($depth>0&&$this->isMegaMenu) $widget_class = '  ';
		
	    if($depth==1  && $this->menutype=="widget")
		$output .= "$indent \n";
		else
		$output .= "\n$indent<{$element} class=\"sub-menu  clearfix  $widget_class \"> $top_Data \n";
	}

	/**
	 * @see Walker::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function end_lvl(&$output, $depth=0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		
		$element = 'ul';
		if($depth==0&&$this->isMegaMenu)
		$element = 'div';
		
	
		
		if($depth==1  && $this->menutype=="widget")
		$output .= "$indent \n";
		else
		$output .= "$indent</{$element}>\n";
		
		$this->isTextBox = false;
		
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';
        
		// IOA Mega menu custom values
		$value = $valueh = $hovercolor = $type = $textbox = $newrow = $value_sidebar = $menuicon = '';	
		$ioa_worker =   get_post_meta( $item->ID, 'menu-item-ioa-worker-'.$item->ID,true);

		if(isset($ioa_worker['megamenu'])) $value = $ioa_worker['megamenu'];
		if(isset($ioa_worker['megamenu-html'])) $valueh = $ioa_worker['megamenu-html'];
		if(isset($ioa_worker['megamenu-hovercolor'])) $hovercolor = $ioa_worker['megamenu-hovercolor']; 
		if(isset($ioa_worker['menuicon'])) $menuicon = $ioa_worker['menuicon']; 

		if($value=="widget") 
		{
			$this->menutype="widget";
			$value = "megamenu";
		}
		$value = ($value=="megamenu") ? true  : false ;
		

		if(isset($ioa_worker['megamenu-layout'])) $type = $ioa_worker['megamenu-layout'];
		if(isset($ioa_worker['textbox'])) $textbox = $ioa_worker['textbox'];  
		
		if(isset($ioa_worker['newrow'])) $newrow = $ioa_worker['newrow']; 
		$newrow = ($newrow=="on") ? true  : false;
		if(isset($ioa_worker['sidebar']))  $value_sidebar = $ioa_worker['sidebar'];  

		if( trim($value_sidebar) =="" ) $value_sidebar = "Blog Sidebar";

		if($valueh!="") $this->metatext = $valueh;
		
		if($depth==0)
		{
		
		
		$this->isMegaMenu = $value;
	
		if($this->isMegaMenu && $this->menutype!="widget") {  
			$this->menutype = "column";
		}
		
		
		
		}// End of Hades menu custom values
		
				
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
       $ex_class = '';
			if( ($this->rowcount>=$this->rowlimit&&$depth==1) || $newrow )
		    {
			$this->rowcount = 0;
			$ex_class = 'clearleft';
		    }
		$test_variable = '';
		if(!$this->isMegaMenu)
		$test_variable = 'rel ';
		else if($depth==0 )
		$test_variable = 'megamenu ';
			
			
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names )." $ex_class  $test_variable ". '   "';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
       
       if($menuicon!="") $menuicon = "<i class='ioa-front-icon $menuicon ioa-menu-icon'></i>";  
		 
	  if(!$this->isMegaMenu) {	 
		$output .= $indent . '<li ' . $id  . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>'.$menuicon.' ';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= ' <span class="spacer" style="border-color:'.$hovercolor.'"></span></a> <div class="hoverdir-wrap"><span  style="background:'.$hovercolor.'" class="hoverdir"></span></div> ';
		$item_output .= $args->after;
		
	  }
	  else if($this->menutype=="column")
	  {
		
		
			
		  
		if($depth==1)
		{
		
		
		$output = str_replace("{metadata}",  "<div class='megamenu-inner-html clearfix'>".wpautop($this->metatext)."</div>" , $output);
		
		$output .= $indent . '<div' . $id  . $class_names .'>';
			$this->rowcount++;
		}
		else  
		$output .= $indent . '<li data-hcolor="'.$hovercolor.'"' . $id .  $class_names .'>';
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		
		
		if($depth==1)
		{
			
			if($item->url!="http://no-title")
			$item_output .= '<h6 class="custom-font">'.'<a'. $attributes .'>';
		}
		else
		$item_output .= '<a'. $attributes .'>'.$menuicon.' ';
		
		if($item->url!="http://no-title")
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		
		if($depth==1)
		{
			if($item->url!="http://no-title")
			$item_output .= '</a></h6>';
		}
		else
		$item_output .= '<span class="spacer" style="border-color:'.$hovercolor.'"></span></a> <div class="hoverdir-wrap"><span  style="background:'.$hovercolor.'" class="hoverdir"></span></div>';
		
		$item_output .= $args->after;
		
		
		if($depth==1 && trim($textbox) !="" )
		{
			$item_output .= "<div class='megamenu-textbox'> ".wpautop($textbox)." </div>";
		}
		  
	  }
	  else if($this->menutype=="widget" )
	  {
	  
		if($depth==1 )
		{
			
		if($this->widgetflag)
			$output .= $indent . '<div' . $id  . $class_names .'>';
			
		}
		else if($depth==2 )
		{ 
		
		
		
		}
		else  
		$output .= $indent . '<li data-hcolor="'.$hovercolor.'"' . $id  . $class_names .'>';
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        
		
		 $item_output = '';
		if($depth<1) { 
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>'.$menuicon.' ';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '<span class="spacer" style="border-color:'.$hovercolor.'"></span></a> <div class="hoverdir-wrap"><span  style="background:'.$hovercolor.'" class="hoverdir"></span></div>';
		$item_output .=  '</a>';
		$item_output .= $args->after;
		}
		else if($depth==1 && $this->widgetflag)
		{
			
			
			ob_start();
			
			dynamic_sidebar($value_sidebar);
			$data = ob_get_contents();
			ob_end_clean();
			ob_end_flush();
			
			$item_output .= $data;
			
			
		}
		 $this->rowcount++;
		
	  }
        
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * @see Walker::end_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Page data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 */
	function end_el(&$output,  $item, $depth = 0, $args = array() ) {
		
		//if( $this->menutype=="widget" && $this->rowcount == 1 )  $output .= "</div>\n";
		//if( $this->menutype=="widget" && $this->rowcount  > 1 )  return;

		 if(!$this->isMegaMenu)
		$output .= "</li>\n";
		else
		{
			if($depth==1 )
			{
				if($this->widgetflag)
				$output .= "</div> \n";
			
			}

			else if($depth==2 && $this->menutype=="widget" )
			{
				$output .= "\n";
				$this->widgetflag = false;
			}
			else
			$output .= "</li>\n";
		}
	}
}


class ioa_MegaMenu_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int $depth Depth of page.
	 */
	function start_lvl(&$output, $depth = 0, $args = array()) {}

	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int $depth Depth of page.
	 */
	function end_lvl(&$output, $depth = 0, $args = array()) {
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = 'Not Exist';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			if($original_object)
			$original_title = $original_object->post_title;
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( '%s'.__('(Pending)','ioa'), $item->title );
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);


		if ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( '%s'.__('(Pending)','ioa'), $item->title );
		}

		$title = empty( $item->label ) ? $title : $item->label;

		$ioa_worker =   get_post_meta( $item_id, 'menu-item-ioa-worker-'.$item_id,true);

		$value = $valueh = $hovercolor = $type = $textbox = $newrow = $menuicon = $value_sidebar = '';

		if(isset($ioa_worker['megamenu']))  $value = $ioa_worker['megamenu'];
		if(isset($ioa_worker['megamenu-html'])) $valueh = $ioa_worker['megamenu-html'];
		if(isset($ioa_worker['megamenu-hovercolor'])) $hovercolor = $ioa_worker['megamenu-hovercolor']; 
		if(isset($ioa_worker['menuicon'])) $menuicon = $ioa_worker['menuicon']; 

		if(isset($ioa_worker['megamenu-layout'])) $type = $ioa_worker['megamenu-layout'];
		if(isset($ioa_worker['textbox'])) $textbox = $ioa_worker['textbox'];  
		
		if(isset($ioa_worker['newrow'])) $newrow = $ioa_worker['newrow']; 
		$newrow = ($newrow=="on") ? true  : false;
		if(isset($ioa_worker['sidebar'])) $value_sidebar = $ioa_worker['sidebar'];  

		?>
		<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title" <?php if($hovercolor!="") echo 'style="color:'.$hovercolor.'"' ?> ><?php echo esc_html( $title ); ?>
						<a class="ioa-front-icon cancel-2icon- ioa-test-deletion" href=""></a>
					</span>
                    	
					<span class="item-controls">
                    
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-type item-type-h-column"><?php _e('Column','ioa'); ?></span>
						<span class="item-type item-type-hmenu"><?php _e('(Hyper Menu)','ioa'); ?></span>
                        <span class="item-type item-type-h-widget"><?php _e('Widget','ioa'); ?></span>
                            
						<span class="item-order">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up','ioa'); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down','ioa'); ?>">&#8595;</abbr></a>
						</span>

						<a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php _e('Edit Menu Item','ioa'); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>"><?php _e( 'Edit Menu Item' ,'ioa'); ?></a>
					</span>
				</dt>
			</dl>

			<div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
             	<a href="" class="ioa-menu-custom-settings button-default"> Custom Settings <i class="ioa-front-icon plus-squared-1icon-"></i> </a>
             	<a href="" class="ioa-menu-reset-settings button-error"> Reset Custom Settings </a>
				
				<div class="ioa-custom-menu-settings clearfix">
					 <p class="description description-thin menu-colorpicker  clearfix">
				 	<a class='picker-delete' href=''></a>
					<label for="menu-item-megamenu-hovercolor-<?php echo $item_id; ?>">
						<?php _e( 'Hover & Active Color','ioa' ); ?><br />
						<input type="text" id="menu-item-megamenu-hovercolor-<?php echo $item_id; ?>" class="widefat minicolors menu-colorchooser" name="menu-item-megamenu-hovercolor-<?php echo $item_id; ?>" value="<?php echo esc_attr( $hovercolor ); ?>" />
					</label>
				</p>
				<p class="description description-thin clearfix menu-icon-area clearfix">
				 	<label for="menu-item-megamenu-menuicon-<?php echo $item_id; ?>">
						<?php _e( 'Set Menu Icon(empty it text field to remove it)','ioa' ); ?><br />
						<input type="text" id="menu-item-megamenu-menuicon-<?php echo $item_id; ?>" class="icon-field" name="menu-item-megamenu-menuicon-<?php echo $item_id; ?>" value="<?php echo esc_attr( $menuicon ); ?>" />
						<a href="" class="button icon-maker"><?php _e('Add Icon','ioa') ?></a>
					</label>
				</p>
				
				 <?php if($depth==0) : ?>
                  <textarea id="menu-item-megamenu-html-<?php echo $item_id; ?>" class="hyper-menu-top-text-holder"  name="menu-item-megamenu-html-<?php echo $item_id; ?>" cols="30" rows="10" placeholder="Add your html code here, It will appear on top of columns in hyper menu"><?php  echo $valueh; ?></textarea>
                   
                  <?php endif; ?>
				
				</div>	<div class="clearfix"></div>

				<?php if( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo $item_id; ?>">
							<?php _e( 'URL','ioa' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="edit-menu-item-title-<?php echo $item_id; ?>">
						<?php _e( 'Navigation Label','ioa' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="description description-thin">
					<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
						<?php _e( 'Title Attribute','ioa' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
						<?php _e( 'CSS Classes (optional)','ioa' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
						<?php _e( 'Link Relationship (XFN)','ioa' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo $item_id; ?>">
						<?php _e( 'Description','ioa' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); ?></textarea>
						<span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.','ioa'); ?></span>
					</label>
				</p>
				<p class="field-link-target description description-thin">
					<label for="edit-menu-item-target-<?php echo $item_id; ?>">
						<?php _e( 'Link Target','ioa' ); ?><br />
						<select id="edit-menu-item-target-<?php echo $item_id; ?>" class="widefat edit-menu-item-target" name="menu-item-target[<?php echo $item_id; ?>]">
							<option value="" <?php selected( $item->target, ''); ?>><?php _e('Same window or tab','ioa'); ?></option>
							<option value="_blank" <?php selected( $item->target, '_blank'); ?>><?php _e('New window or tab','ioa'); ?></option>
						</select>
					</label>
				</p>

				<div class="menu-item-actions description-wide submitbox">
					
					


                   <p class="ioa_megamenu_box clearfix">
                   <label for="menu-item-megamenu-<?php echo $item_id; ?>"><?php _e('Select Dropdown Type :','ioa') ?> </label>
                   
					<select id="menu-item-megamenu-<?php echo $item_id; ?>"  name="menu-item-megamenu-<?php echo $item_id; ?>">
					<?php 
					$vals = array("default" => __("Normal Menu",'ioa') , "megamenu" => __("Mega Menu",'ioa') /* , "widget" => __("Widget Mode",'ioa') */ );

					foreach($vals as $key => $val)
					{
						if($value==$key)
							echo "<option value='{$key}' selected='selected'>{$val}</option>";
						else
							echo "<option value='{$key}'>{$val}</option>";
					}

					 ?>
					</select>


                  
                    
                    <input type="hidden" name="menu-item-megamenu-layout-<?php echo $item_id; ?>" id="menu-item-megamenu-layout-<?php echo $item_id; ?>" value="column" />
                                       </p> 
					
				<?php if($depth==0) : ?>
					
					<!--
					<p class="ioa_megamenu_sidebar_box clearfix <?php if($value!="widget") echo 'hide'; ?>">
                    	<label for="menu-item-megamenu-sidebar-<?php echo $item_id; ?>"><?php _e('Select Sidebar:','ioa') ?> </label>
                   
						<select id="menu-item-megamenu-sidebar-<?php echo $item_id; ?>" class='menu-item-megamenu-sidebar' name="menu-item-megamenu-sidebar-<?php echo $item_id; ?>">
						<?php 
						$osidebars = array("Blog Sidebar");
						if( get_option(SN.'_custom_sidebars'))
						{
							$dys = explode(',',get_option(SN.'_custom_sidebars'));
							foreach($dys as $s)
									{
										if($s!="")
										{
											$osidebars[] = $s;
										}
									} 
						}

						foreach($osidebars as  $val)
						{
							if($value_sidebar==$val)
								echo "<option value='{$val}' selected='selected'>{$val}</option>";
							else
								echo "<option value='{$val}'>{$val}</option>";
						}

					 	?>
					</select>
					</p>
				-->
				<?php endif; ?>	
  					
  					                                    
                   <p class="ioa_megamenu_row_box hide clearfix">
                 	  <label for="menu-item-newrow-<?php echo $item_id; ?>"><?php _e('This should begin from a new row ','ioa') ?></label>
                  	  <input type="checkbox" id="menu-item-newrow-<?php echo $item_id; ?>"  name="menu-item-newrow-<?php echo $item_id; ?>" <?php  echo $newrow; ?> />
                   
                   	 <textarea name="menu-item-textbox-<?php echo $item_id; ?>" id="menu-item-textbox-<?php echo $item_id; ?>" class="textbox" > <?php echo $textbox; ?></textarea>
                     <span class="hmenu_info"> <?php _e('If you dont want any title on columns, add "no-title" . Dont leave it empty else wordpress will delete it.','ioa') ?> </span>
                   </p>
                   
					<?php if( 'custom' != $item->type ) : ?>
						<p class="link-to-original">
							<?php printf( __('Original:','ioa').' %s', '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
						),
						'delete-menu_item_' . $item_id
					); ?>"><?php _e('Remove','ioa'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php	echo add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) );
						?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel','ioa'); ?></a>
				</div>
<input type="hidden" name="menu-item-megamenu-label-<?php echo $item_id; ?>" value="<?php echo $item->title; ?>" />
				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	
	}

	/**
	 * @see Walker::end_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Page data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 */
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}
add_filter( 'wp_edit_nav_menu_walker', 'modify_backend_walker' , 100);
function modify_backend_walker($name)
		{
			return 'ioa_MegaMenu_Nav_Menu';
		}
		

function hmenu_scripts()
		{
			if(basename( $_SERVER['PHP_SELF']) == "nav-menus.php" )
			{	
			
				wp_enqueue_script( 'ioa_mega_menu' , HURL . '/js/hmega_menu.js',array('jquery', 'jquery-ui-sortable'), false, true ); 
			}
		}
add_action('admin_init', 'hmenu_scripts');
				

add_action( 'wp_update_nav_menu_item', 'update_menu', 100, 3);
function update_menu($menu_id, $menu_item_db)
	{	
		 
		 $ioa_menu_worker = array( 'menuicon' => '', 'megamenu' => '' , 'sidebar' => '' , 'megamenu-html' => '' , 'megamenu-newrow' => '' , 'megamenu-hovercolor' => '' , 'megamenu-layout' => '' , 'textbox' => '' );
			
			if(isset($_POST["menu-item-megamenu-".$menu_item_db]))
				$ioa_menu_worker['megamenu'] = $_POST['menu-item-megamenu-'.$menu_item_db];

			if(isset($_POST["menu-item-megamenu-menuicon-".$menu_item_db]))
				$ioa_menu_worker['menuicon'] = $_POST['menu-item-megamenu-menuicon-'.$menu_item_db];

			if(isset($_POST["menu-item-megamenu-sidebar-".$menu_item_db]))
				$ioa_menu_worker['sidebar'] = $_POST['menu-item-megamenu-sidebar-'.$menu_item_db];

			if(isset($_POST["menu-item-megamenu-html-".$menu_item_db]))
				$ioa_menu_worker['megamenu-html'] = $_POST['menu-item-megamenu-html-'.$menu_item_db];

			if(isset($_POST["menu-item-newrow-".$menu_item_db]))
				$ioa_menu_worker['newrow'] = $_POST['menu-item-newrow-'.$menu_item_db];

			if(isset($_POST["menu-item-megamenu-hovercolor-".$menu_item_db]))
				$ioa_menu_worker['megamenu-hovercolor'] = $_POST['menu-item-megamenu-hovercolor-'.$menu_item_db];
			
			if(isset($_POST["menu-item-megamenu-layout".$menu_item_db]))
				$ioa_menu_worker['megamenu-layout'] = $_POST['menu-item-megamenu-layout'.$menu_item_db];

			if(isset($_POST["menu-item-textbox-".$menu_item_db]))
				$ioa_menu_worker['textbox'] = $_POST['menu-item-textbox-'.$menu_item_db];
		
		
			update_post_meta( $menu_item_db, 'menu-item-ioa-worker-'.$menu_item_db, $ioa_menu_worker );
			
	
	}
	
	
	
function ioa_MegaMenu_AJAX_Menu()
	{	
		if ( ! current_user_can( 'edit_theme_options' ) )
		die('-1');

		check_ajax_referer( 'add-menu_item', 'menu-settings-column-nonce' );
	
		require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
	
		$item_ids = wp_save_nav_menu_items( 0, $_POST['menu-item'] );
		if ( is_wp_error( $item_ids ) )
			die('-1');
	
		foreach ( (array) $item_ids as $menu_item_id ) {
			$menu_obj = get_post( $menu_item_id );
			if ( ! empty( $menu_obj->ID ) ) {
				$menu_obj = wp_setup_nav_menu_item( $menu_obj );
				$menu_obj->label = $menu_obj->title; // don't show "(pending)" in ajax-added items
				$menu_items[] = $menu_obj;
			}
		}
	
		if ( ! empty( $menu_items ) ) {
			$args = array(
				'after' => '',
				'before' => '',
				'link_after' => '',
				'link_before' => '',
				'walker' => new ioa_MegaMenu_Nav_Menu,
			);
			echo walk_nav_menu_tree( $menu_items, 0, (object) $args );
		}
		
		die('');
	}
	
	//hook into wordpress admin.php
	add_action('wp_ajax_ioa_MegaMenu_AJAX_Menu', 'ioa_MegaMenu_AJAX_Menu');	