<?php

function rad_after_content()
{
	do_action('rad_after_content');
}

function rad_editor_scripts()
{
	do_action('rad_editor_scripts');
}

function is_rad_editable()
{
	global $ioa_meta_data,$super_options;

	if( IOA_WOO_EXISTS && is_woocommerce()  ) return false;
	if( IOA_WOO_EXISTS && is_cart()  ) return false;
	if( IOA_WOO_EXISTS && is_checkout()  ) return false;

	if(!isset($ioa_meta_data['ioa_custom_template']) || $ioa_meta_data['ioa_custom_template']=="") 
		$ioa_meta_data['ioa_custom_template'] = 'ioa-template-default';

	if( isset($super_options[SN.'_rad_live_edit']) && $super_options[SN.'_rad_live_edit'] == 'false' ) return false;
	
	if( ( is_singular('post') || is_page() ) && $ioa_meta_data['ioa_custom_template'] == 'ioa-template-default' && current_user_can('edit_pages') ) return true;

	return false;
}

add_filter('the_content','rad_appender', 10 );

function rad_appender( $content ) {
	
	global $ioa_super_options,$ioa_meta_data,$ioa_portfolio_slug,$post;

	if( isset($ioa_meta_data['rad_trigger']) && $ioa_meta_data['rad_trigger']) :


	$opts = get_post_meta(get_the_ID(),'ioa_options',true);
	$l ='skeleton auto_align'; // Container Classes
	if(isset($opts['page_layout']) && $opts['page_layout']!='full') $l = '  ';  

	$ioa_meta_data['rad_trigger'] = false;


		/**
		 * If Post Type is portfolio, add the meta area.
		 */
		
		


		if( get_post_meta( $post->ID, 'rad_version', true ) == "" )	 
		{

			if( $post->post_type == $ioa_portfolio_slug ) :
				ob_start();
				get_template_part( 'templates/single-portfolio-meta'); 
				$content = ob_get_contents(). $content;
				ob_end_clean();
			endif;	

			ob_start();
   			get_template_part('templates/rad/construct'); 
		   	 if($content!="")
				$content =  '<div class="page-content '.$l.' clearfix">'.$content.'</div>';

			$rad_data = ob_get_contents();  
			if(trim($rad_data)!="") 
				$content = $rad_data;   
	    
	   		ob_end_clean();

		}
		else
		{
			if(has_shortcode($post->post_content,'rad_page_section'))
				$content = '<div class="rad-holder  clearfix" data-id="'.$post->ID.'">'.do_shortcode( $content ).'</div>';
			else	
			{
				if( $post->post_type == $ioa_portfolio_slug ) :
						ob_start();
						get_template_part( 'templates/single-portfolio-meta'); 
						$content = ob_get_contents(). $content;
						ob_end_clean();
				endif;	
				$content =  '<div class="page-content  '.$l.' clearfix">'.$content.'</div>'. '<div class="rad-holder  clearfix" data-id="'.$post->ID.'"></div>';
	

			}	
		
		}


		endif;	
	
	                return $content;
	}