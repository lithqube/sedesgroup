<?php 
/**
 * Portfolio Extra Information
 */ ?>

	
	<?php 
	$meta = '';
	global $super_options,$portfolio_taxonomy,$ioa_portfolio_slug;
	$portfolio_fields = $super_options[SN.'_single_portfolio_meta'];

		if($portfolio_fields!="")
		{
			$portfolio_fields = explode(';',$portfolio_fields);
			$inps = array();
			foreach($portfolio_fields as $field)
			{
				if(trim($field)!="") :
					$key = str_replace(' ','_',strtolower(trim($field)));
					$value = stripslashes(get_post_meta(get_the_ID(),$key,true));

					if(trim($value)!="")
						$meta .= "<div class='meta-item clearfix'><strong itemprop='name'>$field</strong> : <span itemprop='description'> $value </span></div> ";
				endif;
			}
			
		
		}


	 ?>					

<?php if($meta!="") : ?>
<div class="meta-info clearfix" itemscope itemtype="http://schema.org/ItemList">
	<?php echo $meta; ?>
</div>	
<?php endif; ?>