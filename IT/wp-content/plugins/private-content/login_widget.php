<?php
// LOGIN WIDGET
 
class PrivateContentLogin extends WP_Widget {
	
  function PrivateContentLogin() {
    $widget_ops = array('classname' => 'PrivateContentLogin', 'description' => 'Displays a login form for PrivateContent users' );
    $this->WP_Widget('PrivateContentLogin', 'PrivateContent Login', $widget_ops);
  }
 
 
  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p>
  	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'pg_ml') ?>:</label> <br />
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
  </p>
<?php
  }
  
 
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
  
 
  function widget($args, $instance) {
	global $wpdb;
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 		
		// switch if is logged or not
		if(isset($GLOBALS['pg_user_id'])) :
			// get user data
			$user_data = $wpdb->get_row( $wpdb->prepare( 
				"SELECT username, name, surname FROM  ".PG_DB_TABLE." WHERE ID = %d",
				$GLOBALS['pg_user_id']
			) );
		
		?>
        	<p><?php _e('Welcome', 'pg_ml') ?> <?php echo (empty($user_data->name) && empty($user_data->surname)) ? $user_data->username : ucfirst($user_data->name).' '.ucfirst($user_data->surname); ?></p>
            
            <form class="pg_logout_widget PrivateContentLogin">
                <input type="button" name="pg_widget_logout" class="pg_logout_btn pg_trigger" value="<?php _e('Logout', 'pg_ml') ?>" />
                <span class="pg_loginform_loader"></span>
            </form>
        
        <?php else :
		  echo pg_login_form();

	  endif;
	  
	  echo $after_widget;
  }
 
}

add_action( 'widgets_init', create_function('', 'return register_widget("PrivateContentLogin");') );
