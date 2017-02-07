<?php

function bbpress_subsedot ($args = array() ) {
$args['before'] = '&nbsp';
 
 return $args;
} 

add_filter('bbp_before_get_user_subscribe_link_parse_args', 'bbpress_subsedot');



function aq_custom_bbp_roles( $role, $user_id ) {
	

	if( $role == 'Keymaster' )
		return 'Admin';
 	
 	if( $role == 'Participant' )
 		return 'Member';
 	
	return $role;
}
 
add_filter( 'bbp_get_user_display_role', 'aq_custom_bbp_roles', 10, 2 );

remove_filter( 'bbp_get_reply_content', 'bbp_reply_content_append_revisions',  1,  2 );
remove_filter( 'bbp_get_topic_content', 'bbp_topic_content_append_revisions',  1,  2 );


/*
function ioa_bbp_support_options($id)
{
	$status =  get_post_meta($id,'topic_status',true);
	$ar = array("progress" => "Progress" , "unresolved" => "Unresolved" , "resolved" => "Resolved" , "not_support" => "Not Supported" , "kb" => "resolved & Add to KB" );
	?>
	
	<div class="clearfix support-status">
		<select name="" class='thread-status' id="">
			<?php foreach ($ar as $key => $item) {
				
				if($key == $status)
				  echo '<option value="'.$key.'" selected="selected">'.$item.'</option>';	
				else
				  echo '<option value="'.$key.'">'.$item.'</option>';	

			} ?>
		</select>
		<a href="" data-id='<?php echo $id; ?>' class="set-status">Set Status</a>
	</div>

	<?php

}

function ioa_bbp_status($id)
{
	$status =  get_post_meta($id,'topic_status',true);

	$ts = '';

		if( bbp_is_topic_sticky( $id, false ) ==  'sticky' ) $ts .= "<i class='ioa-front-icon topic-sticky pin-2icon-'></i>";
	//	if( bbp_is_topic_super_sticky( $id) ==  'super-sticky' ) $ts = '';
		
	if( bbp_is_topic_closed($id) ) $ts .= "<i class='ioa-front-icon topic-closed lock-2icon-'></i>";


	if($status == "") return $ts;

	if($status == "kb") $status = 'resolved';
	$ar = array("progress" => "Progress" , "unresolved" => "Unresolved" , "resolved" => "Resolved" , "not_support" => "Not Supported" , "kb" => "Resolved" );
	if(isset($ar[$status]))
	{
		return $ts."<span class='topic-$status'>".$ar[$status]."</span>";
	}

}
*/


new IOAMetaBox(array(
			"id" => "ioa_bbp_forum_image",
			"title" => __("Add Image for Forum",'ioa'),
			"inputs" => array(
										
							 array(	"label" => __("Set Image",'ioa') , "name" => "image" , "length" => "small",	"default" => "" , "type" => "upload",	"description" => "" ), 
							
							 ),
			"post_type" => "forum",
			"context" => "side",
			"priority" => "low"
			));


// BBPress Declarations
		

		 add_filter('bbp_get_topic_class','add_clearfix_bb');
		 add_filter('bbp_get_reply_class','add_clearfix_bb');

		

		 function add_clearfix_bb($ar)
		 {
		 	$ar[] = 'clearfix';
		 	return $ar;
		 }

