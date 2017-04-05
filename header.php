<!doctype html>  


<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><html <?php language_attributes(); ?> class="no-js"><![endif]-->
	
	<head>
		<meta charset="utf-8">


		<title><?php $x = get_the_title(); echo $x;?></title>
		
		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<!-- icons & favicons (for more: http://themble.com/support/adding-icons-favicons/) -->
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
				
  		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->
			
		<!-- drop Google Analytics Here -->
		<!-- end analytics -->
		
	</head>

<body <?php body_class(); ?>>

<div id="container">

<div id = "header_div" class = "">
	<div id="logo_image">
	</div>
	<div id="logo_words">
			<div id = "site_name"><h1><a href="http://nevadacathouse.biz" rel="nofollow">Nevada Cat House</a></h1></div>
<style>
.crg_li{float:left;vertical-align:middle;padding:13px;border-radius: 10px;
	border-color: #793d47;
	border-style: solid;
	border-width: 2px;
	background-color:yellow;

}
.crg_li_tl{border-top-right-radius:0px;
	float:left;vertical-align:middle;padding:13px;border-top-left-radius: 10px;border-bottom-left-radius: 10px;border-bottom-right-radius: 0px;
	border-color: #793d47;
	border-style: solid;
	border-width: 2px;
	background-color:yellow;
	border-right-width:0px;
	border-right-style:none;
}
.crg_li_tr{border-top-left-radius:0px;
	float:left;vertical-align:middle;padding:13px;border-top-right-radius: 10px;border-bottom-right-radius: 10px;border-bottom-left-radius: 0px;
	border-color: #793d47;
	border-style: solid;
	border-width: 2px;
	background-color:yellow;
	border-left-width:0px;
	border-left-style:none;
}
.crg_li_center{float:left;vertical-align:middle;padding:13px;
	border-color: #793d47;
	border-style: solid;
	border-width: 2px;
	background-color:yellow;
	border-right-width:0px;
	border-right-style:none;
	border-left-width:0px;
	border-left-style:none;
}
.crg_li a{text-decoration:none;}
#logo_words{padding-top:25px;}
#logo_words h1{font-size:3.5em;}
#header_div{margin:auto;width:1000px;}

</style>
				<ul class = "crg_ul">
				<li class = "crg_li_tl"><a href = "http://nevadacathouse.biz">Products</a></li>
				<li class = "crg_li_center"><a href = "/faq/">FAQ</a></li>
				<li class = "crg_li_center"><a href = "/blog/">Blog</a></li>
				<li class = "crg_li_tr"><a href = "<?php site_url();?>all-cats/">Cats!!</a></li>
				</ul>
		
	</div>
</div>
<div style = "width:100%; clear:both;">&nbsp;</div>
<!-- unclosed DIV!! container -->
<!-- end header -->
