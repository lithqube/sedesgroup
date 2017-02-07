<?php 

if(!isset($_GET["font"]))
die("Cannot Be accessed directly");

$font = trim($_GET["font"]);
$script_font = str_replace(" ","+",$font);

$fsize = ( isset($_GET["fontsize"])) ? $_GET["fontsize"] : 13 ;
$import_style = ''; $code ='';

if($_GET["font"]!="") : 
	$import_style = "<link href='http://fonts.googleapis.com/css?family={$script_font}&v2' rel='stylesheet' type='text/css'>";
	
endif;

$code = "<style> #inject-font h3 { margin:0 0; padding:0; color:#777777;} #inject-font p { color:#777777; padding-top: 0; margin-top: 0; } #inject-font { line-height:1.6; color:#777777; font-size:{$fsize}px; font-family: '".$font."', Arial, sans-serif; } </style>" ;

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Google Font Preview</title>
<?php echo $import_style; ?>
<?php echo $code;?>

</head>

<body>




<div id="inject-font">
	<h3>Heading</h3>
<p> <strong>This is preview text </strong>Grumpy wizards make toxic brew for the evil Queen and Jack. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. </p>
</div>

</body>
</html>