<?php global $helper,$ioa_meta_data,$super_options; ?>

<div class="posts-tree clearfix">


<?php


$months = array( 
	"january" => __("January",'ioa') , 
	"february" => __("February",'ioa') , 
	"march" => __("March",'ioa') , 
	"april"  => __("April",'ioa') , 
	"may" => __("May",'ioa') , 
	"june" => __("June",'ioa') , 
	"july" => __("July",'ioa') , 
	"august" => __("August",'ioa') , 
	"september" => __("September",'ioa') , 
	"october" => __("October",'ioa') , 
	"november" => __("November",'ioa') , 
	"december" => __("December",'ioa') 
	); 


$opts = array_merge(array('posts_per_page' => $ioa_meta_data['posts_item_limit'] , 'paged' => $paged ,  'tax_query' =>  array(
                 array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                    'operator' => 'NOT IN'
                  )
              )) , $ioa_meta_data['query_filter']);

query_posts($opts);

$rs = array(); $count = 0;

if(have_posts()) :
while(have_posts()) : the_post();  
	$row = array();	
	
	$row["start_time"] = get_the_time();
	$row["start_date"] = get_the_date("d-n-Y");
	$row["ori_date"] = get_the_date();
	$f = get_the_date("d-n-Y");
	$row["factor"] = $f[2].$f[1].$f[0];
	$row["id"] = get_the_ID();


 $dbg = '' ; $dc = '';

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if(isset( $ioa_options['dominant_bg_color'] )) $dbg =  $ioa_options['dominant_bg_color'];
if(isset( $ioa_options['dominant_color'] )) $dc = $ioa_options['dominant_color'];

$row["bg"] =  $dbg;
$row["c"] = $dc;

	if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :

		$id = get_post_thumbnail_id();
		$ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		$row["image"] =	 $helper->imageDisplay(array( "crop" => "wproportional" , "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
		$row["image_url"] = $ar[0];
	endif;

	
	$row["title"] = get_the_title();
	$row["permalink"] =  get_permalink();
	$row["content"] =  $helper->getShortenContent($ioa_meta_data['posts_excerpt_limit'], strip_tags(strip_shortcodes(get_the_excerpt())) );
	$rs[] = $row;

	$count++;
endwhile;



$posts  = '<div class="posts-timeline " itemscope itemtype="http://schema.org/Blog" >';

$i=0;

$opts = explode("-",$rs[0]["start_date"]); 
$transmonth =  $months[strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2])))];

$month = $opts[1];		
$posts = $posts. " <h4 class='month-label' data-month='$month'>". $transmonth.' <span class="year">'.$opts[2]."</span></h4> ";

foreach($rs as $post)
{
	

	$opts = explode("-",$post["start_date"]); 
	$transmonth =  $months[strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2])))];

	if($opts[1]!=$month)
	{
		$month = $opts[1];	
		$posts = $posts. " <h4 class='month-label' data-month='$month'> ". $transmonth.' <span class="year">'.$opts[2]."</span></h4> ";
	}


$s_date =  $opts[0];
$s_date = str_replace(strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2]))),$transmonth,strtolower($s_date));

if($i%2==0) $clname = 'left-post'; else $clname = "right-post";                 

$posts  = $posts ." <div class=\"clearfix $clname timeline-post\" itemscope itemtype=\"http://schema.org/Article\"><span class=\"dot\" ></span><span  class=\"tip\"><span class=\"connector\"  ></span></span>
<h3 class=\"title\" itemprop='name'>  <a href=\"".$post['permalink']."\"> ".$post['title']." </h3>   </a><div class=\"image\"><span class='date'>". $s_date."</span>";

if(isset($post['image']))
$posts  = $posts.$post['image']; 

echo $posts;

 
 if($ioa_meta_data['enable_thumbnail']!="true"): 
              $helper->getHover( array('format' => 'link' , 'link' => $post['permalink'] , 'bg' => $post['bg'] , 'c' => $post['c'] )  ); 
           else:  
              $helper->getHover( array('format' => 'image' , 'image' => $post['image_url'], 'bg' => $post['bg'] , 'c' => $post['c'] )  );  
           endif;  
               

$posts  = "</div>
<div class=\"desc clearfix\">".$post['content']."
</div>  <a itemprop='url' href=\"".$post['permalink']."\" class=\"main-button\"> ".__('More','ioa')." </a>
</div>";



$i++;
} ?>

<?php echo $posts."</div>";?>


<span class="circle" data-post_type="post" data-id="<?php echo get_the_ID(); ?>" data-limit="<?php $p = wp_count_posts(); echo intval($p->publish) - intval(wp_count_terms('post_format')) ; ?>"></span>

<span class="line"></span>

<?php else: 
   								echo ' <h4 class="auto_align skeleton no-posts-found">'.__('Sorry no posts found','ioa').'</h4>';
 endif; ?>
</div>