<?php header('X-Content-Type-Options: nosniff'); ?>
<?php require 'controller/db_config.php'; ?>
<?php 
if(isset($check_auth) && $check_auth == true){
	$find_user_sql = "SELECT * FROM `users` WHERE (`email`='".$_SESSION['user']."' OR `username`='".$_SESSION['user']."') AND is_active='y' AND is_deleted='n'";
	$find_user_result = $conn->query($find_user_sql);
	if ($find_user_result->num_rows > 0) {
	  while ($find_user_row = $find_user_result->fetch_assoc()) {
	    $customer_id = $find_user_row['id'];
	    $user_logo = $find_user_row['logo'];
	  }
	}else{
		header('location: '.SITEURL);
	}
}
// find out the domain:
$domain = $_SERVER['HTTP_HOST'];
$url = "https://" . $domain . $_SERVER['REQUEST_URI'];

if(isset($url)){
  if (isset($_GET['type']) && $_GET['type'] == 'product') {
    if (isset($_GET['main'])) {
      $find_meta_information_sql = "SELECT * FROM `meta_information` WHERE `status`='active' AND `page_name` LIKE '%/".$_GET['main']."/%' LIMIT 1";
    }
  }else{
    $find_meta_information_sql = "SELECT * FROM `meta_information` WHERE `status`='active' AND `page_name`='".$url."'";
  }
  $find_meta_information_result = $conn->query($find_meta_information_sql);
  if ($find_meta_information_result->num_rows > 0) {
      while ($find_meta_information_row = $find_meta_information_result->fetch_assoc()) {
          $meta_title = ($find_meta_information_row['title'] ? $find_meta_information_row['title'] : '');
          $page_description = ($find_meta_information_row['description'] ? $find_meta_information_row['description'] : '');
          $page_keywords = ($find_meta_information_row['keywords'] ? $find_meta_information_row['keywords'] : '');
          $is_index = ($find_meta_information_row['is_index'] ? $find_meta_information_row['is_index'] : 'y');
          $is_follow = ($find_meta_information_row['is_follow'] ? $find_meta_information_row['is_follow'] : 'y');
          $in_head = ($find_meta_information_row['in_head'] ? $find_meta_information_row['in_head'] : '');
          $in_body = ($find_meta_information_row['in_body'] ? $find_meta_information_row['in_body'] : '');
          $before_body = ($find_meta_information_row['before_body'] ? $find_meta_information_row['before_body'] : '');
      }
  }else{
  	$meta_title = 'Global Wholesale Parts';
    $page_description = 'Buy heavy duty parts and heavy construction equipment parts at wholesale prices from the trusted and the largest supplier of heavy duty parts for the construction industry.';
    $page_keywords = '';
    $is_index = 'y';
    $is_follow = 'y';
    $in_head = '<link rel="canonical" href="'.$url.'" />';
    $in_body = '';
    $before_body = '';
  }
}

if (isset($brand_detail) && $brand_detail == 'inventory_brand') {
	if (isset($_GET) && isset($_GET['main_brand']) && $_GET['main_brand'] != '') {
	  $brand_sql = "SELECT * FROM `inventory_makes` WHERE `slug` = '".$_GET['main_brand']."' AND status='active'";
	  $brand_result = $conn->query($brand_sql);
	  if ($brand_result->num_rows > 0) {
	    while ($brand_array = $brand_result->fetch_assoc()) {
	      $main_makes_id = $brand_array['id'];
	      $main_makes = $brand_array['makes'];
	      $main_makes_h1 = $brand_array['makes_h1'];
	      $main_makes_h2 = $brand_array['makes_h2'];
	      $main_description = $brand_array['description'];
	      $main_makes_slug = $brand_array['slug'];
	      $main_makes = $brand_array['makes'];
	    }
	  }
	}else{
		header('location: '.SITEURL);
	}
}
?>
<!DOCTYPE html>
<html lang="en-US" class="js fontawesome-i2svg-active fontawesome-i2svg-complete">
<head>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KJKL5LG8');</script>
	<!-- End Google Tag Manager -->
	<!-- Google tag (gtag.js) -->

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-FPBPXS2E6R"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-FPBPXS2E6R');
	</script>
	
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-299499973"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'AW-299499973');
	</script>
	<meta http-equiv="Content-Type" content="charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="google-site-verification" content="3pfpxNc1WraMOmja6IohDsPJmZD2hn5HXHjhK6gjXQA" />
	<link rel="icon" href="<?= SITEURL; ?>assets/logos/favicon.ico">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= SITEURL; ?>assets/css/fonts.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css"></link>

	<?php if (isset($is_index) && isset($is_follow)) { ?>
    <?php if ($is_index == 'y' && $is_follow == 'y') { ?>
      <meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large"/>
    <?php }elseif ($is_index == 'y' && $is_follow == 'n') { ?>
      <meta name="robots" content="nofollow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large"/>
    <?php }elseif ($is_index == 'n' && $is_follow == 'y') { ?>
      <meta name="robots" content="follow, noindex"/>
    <?php }elseif ($is_index == 'n' && $is_follow == 'n') { ?>
      <meta name="robots" content="nofollow, noindex"/>
    <?php } ?>
  <?php }else { ?>
    <meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large"/>
  <?php } ?>
       
  <?php if (isset($meta_title) && $meta_title != '') { ?>
  	<title><?= $meta_title; ?></title>
		<meta property="og:title" content="<?= $meta_title; ?>">
		<meta name="twitter:title" content="<?= $meta_title; ?>">
  <?php }else { ?>
  	<title>Heavy Duty Parts | Construction Equipment Parts at Wholesale Prices</title>
		<meta property="og:title" content="Heavy Duty Parts | Construction Equipment Parts at Wholesale Prices">
		<meta name="twitter:title" content="Heavy Duty Parts | Construction Equipment Parts at Wholesale Prices">
  <?php } ?>

  <?php if (isset($page_description) && $page_description != '') { ?>
  	<meta name="description" content="<?= $page_description; ?>" />            
		<meta property="og:description" content="<?= $page_description; ?>">
		<meta name="twitter:description" content="<?= $page_description; ?>">
  <?php } ?>

  <?php if (isset($page_keywords) && $page_keywords != '') { ?>
  	<meta name="keywords" content="<?= $page_keywords; ?>" />            
  <?php } ?>

	<meta property="og:locale" content="en_US">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?= $url; ?>">
	<meta property="og:site_name" content="Global Wholesale Parts">
	<meta property="og:updated_time" content="2022-03-18T17:59:24+00:00">
	<meta name="twitter:card" content="summary_large_image">
	<script src="https://www.paypalobjects.com/api/checkout.js"></script>
	<?php if (isset($brand_detail) && $brand_detail == 'inventory_brand') { ?>
	<?php }else{ ?>
	<script type="application/ld+json" class="rank-math-schema">
	  {
	    "@context": "https://schema.org",
	    "@graph": [{
	      "@type": "Organization",
	      "@id": "https://globalwholesaleparts.com/#organization",
	      "name": "Global Wholesale Parts"
	    }, {
	      "@type": "WebSite",
	      "@id": "https://globalwholesaleparts.com/#website",
	      "url": "https://globalwholesaleparts.com",
	      "name": "Global Wholesale Parts",
	      "publisher": {
	        "@id": "https://globalwholesaleparts.com/#organization"
	      },
	      "inLanguage": "en-US",
	      "potentialAction": {
	        "@type": "SearchAction",
	        "target": "https://globalwholesaleparts.com/?s={search_term_string}",
	        "query-input": "required name=search_term_string"
	      }
	    }, {
	      "@type": "ImageObject",
	      "@id": "https://globalwholesaleparts.com/assets/images/Group-66.webp",
	      "url": "https://globalwholesaleparts.com/assets/images/Group-66.webp",
	      "width": "200",
	      "height": "200",
	      "inLanguage": "en-US"
	    }, {
	      "@type": "Person",
	      "@id": "https://globalwholesaleparts.com/",
	      "name": "gp_admin",
	      "url": "https://globalwholesaleparts.com/",
	      "image": {
	        "@type": "ImageObject",
	        "@id": "https://secure.gravatar.com/avatar/fa7f79356b1d219d396d50c2385b2dd1?s=96&amp;d=mm&amp;r=g",
	        "url": "https://secure.gravatar.com/avatar/fa7f79356b1d219d396d50c2385b2dd1?s=96&amp;d=mm&amp;r=g",
	        "caption": "gp_admin",
	        "inLanguage": "en-US"
	      },
	      "sameAs": ["http://global_parts.ping"],
	      "worksFor": {
	        "@id": "https://globalwholesaleparts.com/#organization"
	      }
	    }, {
	      "@type": "WebPage",
	      "@id": "https://globalwholesaleparts.com/#webpage",
	      "url": "https://globalwholesaleparts.com/",
	      "name": "Heavy Duty Parts | Construction Equipment Parts at Wholesale Prices",
	      "datePublished": "2021-08-20T05:35:32+00:00",
	      "dateModified": "2022-03-18T17:59:24+00:00",
	      "author": {
	        "@id": "https://globalwholesaleparts.com/"
	      },
	      "isPartOf": {
	        "@id": "https://globalwholesaleparts.com/#website"
	      },
	      "primaryImageOfPage": {
	        "@id": "https://globalwholesaleparts.com/assets/images/Group-66.webp"
	      },
	      "inLanguage": "en-US"
	    }, {
	      "@type": "Article",
	      "headline": "Heavy Duty Parts | Construction Equipment Parts at Wholesale Prices",
	      "datePublished": "2021-08-20T05:35:32+00:00",
	      "dateModified": "2022-03-18T17:59:24+00:00",
	      "author": {
	        "@id": "https://globalwholesaleparts.com/"
	      },
	      "publisher": {
	        "@id": "https://globalwholesaleparts.com/#organization"
	      },
	      "description": "Buy heavy duty parts and heavy construction equipment parts at wholesale prices from the trusted and the largest supplier of heavy duty parts for the construction industry.",
	      "name": "Heavy Duty Parts | Construction Equipment Parts at Wholesale Prices",
	      "@id": "https://globalwholesaleparts.com/#richSnippet",
	      "isPartOf": {
	        "@id": "https://globalwholesaleparts.com/#webpage"
	      },
	      "image": {
	        "@id": "https://globalwholesaleparts.com/assets/images/Group-66.webp"
	      },
	      "inLanguage": "en-US",
	      "mainEntityOfPage": {
	        "@id": "https://globalwholesaleparts.com/#webpage"
	      }
	    }]
	  }
	</script>
	<?php } ?>

	<link rel="icon" type="image/png" href="<?= SITEURL; ?>assets/images/glob-logo.png" />

	<link rel="stylesheet" href="<?= SITEURL; ?>assets/css/woocommerce-layout.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?= SITEURL; ?>assets/css/woocommerce.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?= SITEURL; ?>assets/css/ubermenu.min.css" type="text/css" media="all">
	<link rel="stylesheet" id="ubermenu-font-awesome-all-css" href="<?= SITEURL; ?>assets/css/all.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?= SITEURL; ?>assets/css/style-static.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?= SITEURL; ?>assets/css/style_old.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?= SITEURL; ?>assets/css/blackwhite.css" type="text/css" media="all">

	<!-- <link href="<?= SITEURL; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/> -->
	<link href="<?= SITEURL; ?>assets/css/fontawesome.css" rel="stylesheet" type="text/css"/>
	<link href="<?= SITEURL; ?>assets/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css"/>
	<link href="<?= SITEURL; ?>assets/css/owl.carousel.css" rel="stylesheet" type="text/css"/>
  <link href="<?= SITEURL; ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <link href='<?= SITEURL; ?>assets/css/slick.css' rel="stylesheet">
  <link href='<?= SITEURL; ?>assets/css/lightgallery.min.css' rel="stylesheet">
	<link href="<?= SITEURL; ?>assets/css/style.css?v=0.0.1" rel="stylesheet" type="text/css"/>
	<link href="<?= SITEURL; ?>assets/css/responsive.css?v=0.0.1" rel="stylesheet" type="text/css"/>

	<link rel="stylesheet" id="wc-blocks-vendors-style-css" href="<?= SITEURL; ?>assets/css/wc-blocks-vendors-style.css" type="text/css" media="all">
	<link rel="stylesheet" id="wc-blocks-style-css" href="<?= SITEURL; ?>assets/css/wc-blocks-style.css" type="text/css" media="all">
	<link rel="stylesheet" id="classic-theme-styles-css" href="<?= SITEURL; ?>assets/css/classic-themes.min.css" type="text/css" media="all">

	<link rel="stylesheet" id="woocommerce-smallscreen-css" href="<?= SITEURL; ?>assets/css/woocommerce-smallscreen.css" type="text/css" media="only screen and (max-width: 768px)">

	<link href="<?= SITEURL; ?>assets/css/ubermenu_custom.css" rel="stylesheet" type="text/css"/>
	
	<noscript>
		<style>
			.woocommerce-product-gallery{ 
				opacity: 1 !important;
			}
		</style>
	</noscript>

	<?php if ($page_name == 'home') { ?>
  	<link href="<?= SITEURL; ?>assets/css/home_page.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'heavy_duty_parts' || $page_name == 'main-parts') { ?>
		<link href="<?= SITEURL; ?>assets/css/heavy_duty_parts.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'main-parts') { ?>
		<link href="<?= SITEURL; ?>assets/css/bstreeview.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'about_us') { ?>
		<link href="<?= SITEURL; ?>assets/css/about_us.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'brochures') { ?>
		<link href="<?= SITEURL; ?>assets/css/brochures.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'warranties') { ?>
		<link href="<?= SITEURL; ?>assets/css/warranties.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'contact_us') { ?>
		<link href="<?= SITEURL; ?>assets/css/contact.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'component_rebuild_services') { ?>
		<link href="<?= SITEURL; ?>assets/css/component_rebuild_services.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'component_rebuild_service') { ?>
		<link href="<?= SITEURL; ?>assets/css/component_rebuild_service.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'sign-in' || $page_name == 'sign-up') { ?>
		<link href="<?= SITEURL; ?>assets/css/sign-in.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<link href="<?= SITEURL; ?>assets/css/hubspot.css" rel="stylesheet" type="text/css"/>
	<link href="<?= SITEURL; ?>assets/css/new-style.css?v=0.0.1" rel="stylesheet" type="text/css"/>
	<style type="text/css">
	  .et_pb_toggle_title:before {
	  	font-family: "Font Awesome 5 Free";
  		font-weight: 900;
	  	content: "\f056";
	  }
	  .et-pb-arrow-prev:before {
	  	font-family: "Font Awesome 5 Free";
  		font-weight: 900;
	  	content: "\f060";
	  }
	  .et-pb-arrow-next:before {
	  	font-family: "Font Awesome 5 Free";
  		font-weight: 900;
	  	content: "\f061";
	  }
	  .et-phone-icon:before {
	  	font-family: "Font Awesome 5 Free";
  		font-weight: 900;
	  	content: "\f095";
	  	color: #fff;
	  }
	  .morelink{
	  	color: #bd2939;
	  }
	  .cta-link{
	  	color: #bd2939;
	  }
	  .small-yellow-btn, .big-yellow-btn{
	  	border-width: 1px !important;
    	border: 1px solid #bd2939;
	  }
	  .big-white-btn{
		  border: 1px solid #fff;
		}
	  .small-yellow-btn:hover, .big-yellow-btn:hover{
	  	background-color: transparent;
    	color: #000;
	  }
	  .big-yellow-btn-hover-white:hover{
	  	color: #fff;
	  }
	  .footer-about {
	  	line-height: 1.7em;
    	font-size: 16px;
	  }
	  .big-black-btn{
	  	border: 1px solid #000;
	  }
	  .big-black-btn:hover{
	  	color: #fff;
	  	border: 1px solid #fff;
	  }
	  .nav-tabs{
	  	border-bottom: none !important;
	  	padding: 0px !important;
	  }
	  .tab-pane {
	  	padding: 5px 5px 0 5px;
	  }
	  .header-cart a {
	    color: #666666;
	    position: relative;
	    text-decoration: none;
		}
		.header-cart a span {
		    background: #bd2939;
		    width: 1.5rem;
		    height: 1.5rem;
		    border-radius: 50%;
		    color: #FFF;
		    text-align: center;
		    line-height: 24px;
		    position: absolute;
		    font-size: 12px;
		    top: -12px;
		    left: 12px;
		}
	</style>
	<?php if ($page_name == 'home') { ?>
  	<link href="<?= SITEURL; ?>assets/css/home_page_defer.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'heavy_duty_parts' || $page_name == 'main-parts') { ?>
		<link href="<?= SITEURL; ?>assets/css/heavy_duty_parts_defer.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'about_us') { ?>
		<link href="<?= SITEURL; ?>assets/css/about_us_defer.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'brochures') { ?>
		<link href="<?= SITEURL; ?>assets/css/brochures_defer.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'warranties') { ?>
		<link href="<?= SITEURL; ?>assets/css/warranties_defer.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'contact_us') { ?>
		<link href="<?= SITEURL; ?>assets/css/contact_defer.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'component_rebuild_services') { ?>
		<link href="<?= SITEURL; ?>assets/css/component_rebuild_services_defer.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'component_rebuild_service') { ?>
		<link href="<?= SITEURL; ?>assets/css/component_rebuild_service_defer.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'sign-in' || $page_name == 'sign-up') { ?>
		<link href="<?= SITEURL; ?>assets/css/sign-in_defer.css" rel="stylesheet" type="text/css"/>
	<?php } ?>

	<?php if (isset($in_head)) { ?>
      <?= html_entity_decode($in_head); ?>           
  <?php } ?>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style type="text/css">
  	.ui-autocomplete-loading {
       	background: white url(/assets/images/main-loader-1.gif) right center no-repeat;
		    background-size: 35px;
		    background-position: right 10px center;
    }
  </style>
</head>
<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/44607887.js"></script>
<!-- End of HubSpot Embed Code -->
<body class="">
	<?php if (isset($in_body)) { ?>
	    <?= html_entity_decode($in_body); ?>           
	<?php } ?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KJKL5LG8"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<div id="" class="">
		<header>
			<div class="top-block">
				<div class="container">
					<div class="w-100 d-flex align-items-center justify-content-between gap-md-4 flex-lg-row flex-column">
            <div class="mb-2 mb-md-0 flex-md-row flex-column align-items-center d-flex">
              <span class="me-3 mb-3 mb-md-0"><i class="fa-solid fa-phone"></i><a href="tel:+1-780-670-2009">+1-780-670-2009</a></span>
              <span><i class="fa fa-envelope me-2"></i><a href="mailto:parts@globalwholesaleparts.com">parts@globalwholesaleparts.com</a></span>
            </div>
						<div class="w-auto mobile-center">
							<?php if (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName'])) { ?>
								<div class="header-login ms-sm-auto ms-xl-4 text-end">
	                <a class="btn dropdown-toggle text-white" id="AccountDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? '' : 'style="display: none;"'); ?>><i class="fa-solid fa-user me-1"></i> <span class="welcome-user"><?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? ' Welcome '.$_SESSION['firstName'] : ''); ?></span> </a>
	                <ul class="login-form p-0 dropdown-menu dropdown-menu-end border-0 rounded-0 mt-2 dropdown-menu-right shadow-lg" aria-labelledby="AccountDropdown">
	                  <li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>dashboard/"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a></li> 
                    <li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>profile/"><i class="fa-solid fa-circle-user me-2"></i> Profile</a></li> 
                    <li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>orders/"><i class="fa-solid fa-box me-2"></i> My Orders</a></li>
                    <li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>fleet-list/"><i class="fa-solid fa-warehouse me-2"></i> <?= (isset($user_id) && $user_id==214 ? 'Engine List' : 'Fleet List'); ?></a></li>
                    <li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>support-tickets/"><i class="fa-solid fa-comments me-2"></i> Support Tickets</a></li>
                    <li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>change-password/"><i class="fa-solid fa-key me-2"></i> Change Password</a></li>
	                  <li class="border-top"><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>controller/logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout</a></li>
	                </ul>
								</div>
							<?php } ?>
								<div class="header-login ms-sm-auto ms-xl-4 text-end">
                  <a class="btn dropdown-toggle text-white" id="dealerloginDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"  aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? 'style="display: none;"' : ''); ?>><i class="fa-solid fa-user me-1"></i> GQP Dealer Sign In / Register</a>
				     
                  <div class="login-form shadow-lg p-0 dropdown-menu dropdown-menu-end border-0 rounded-0 dealerloginDropdown-modal" aria-labelledby="dealerloginDropdown">
					<!-- <ul class="nav nav-tabs login-tab" id="myTab" role="tablist">
						<li class="nav-item w-33" role="presentation">
							<button class="nav-link active p-3 w-100 border-0 rounded-0" id="dealerlogin-tab" data-bs-toggle="tab" data-bs-target="#dealerlogin" type="button" role="tab" aria-controls="dealerlogin" aria-selected="true">Dealer</button>
						</li>
					</ul> -->
					<div class="tab-content p-4 pb-2" id="myTabContent">
						<div class="tab-pane fade show active" id="dealerlogin" role="tabpanel" aria-labelledby="dealerlogin-tab">
							<form class="header-login mb-2">
								<p class="mb-3"><strong>Dealer Sign in</strong></p>
								<div class="alert dealer-alert" style="display: none; max-width: 300px;"></div>
								<div class="mb-3">
								<input type="text" class="form-control" id="dealer-email" aria-describedby="emailHelp" placeholder="Email address" name="email">
								<div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
								</div>
								<div class="mb-3">
								<input type="password" class="form-control" id="dealer-password" placeholder="Password" name="password">
								</div>
								<div class="d-flex justify-content-between align-items-center mb-3">
								<div class="form-check  mt-0 mb-0">
									<input type="checkbox" class="form-check-input mt-0" id="dealer-remember-me-header">
									<label class="form-check-label" for="dealer-remember-me-header">Remember me</label>
								</div>
								<a href="<?= SITEURL; ?>forgot-password/" class="fp-text">Forgot Password?</a>
								</div>
								<input type="hidden" name="role" value="dealer">
								<button type="submit" class="w-100 primary-btn" name="login" value="login">Submit</button>
							</form>
							<small class="d-block p-4 pt-2 text-center">
							Don't have an account? <a href="<?= SITEURL; ?>dealer-sign-up/" class="reg-text">Register Now</a>
							</small>
						</div>
					</div>
				  </div>
				
				   <a class="btn dropdown-toggle text-white" id="loginDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? 'style="display: none;"' : ''); ?>> <i class="fa-solid fa-user me-1"></i> VIP Customer Sign In / Register</a>

				  <div class="login-form shadow-lg p-0 dropdown-menu dropdown-menu-end border-0 rounded-0 loginDropdown-modal" aria-labelledby="loginDropdown">
					<div class="tab-content p-4 pb-2" id="myTabContent">
						<div class="tab-pane fade show active" id="customerLogin" role="tabpanel" aria-labelledby="customerLogin-tab">
							<form class="header-login mb-2">
								<p class="mb-3"><strong>Customer Sign in</strong></p>
								<div class="alert user-alert" style="display: none; max-width: 300px;"></div>
								<div class="mb-3">
								<input type="text" class="form-control" id="user-email" aria-describedby="emailHelp" placeholder="Email address" name="email">
								<div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
								</div>
								<div class="mb-3">
								<input type="password" class="form-control" id="user-password" placeholder="Password" name="password">
								</div>
								<div class="d-flex justify-content-between align-items-center mb-3">
								<div class="form-check mt-0 mb-0">
									<input type="checkbox" class="form-check-input mt-0" id="user-remember-me-header">
									<label class="form-check-label" for="user-remember-me-header">Remember me</label>
								</div>
								<a href="<?= SITEURL; ?>forgot-password/" class="fp-text">Forgot Password?</a>
								</div>
								<input type="hidden" name="role" value="customer">
								<button type="submit" class="w-100 primary-btn" name="login" value="login">Submit</button>
							</form>
							<small class="d-block p-4 pt-2 text-center">
							Don't have an account? <a href="<?= SITEURL; ?>customer-sign-up/" class="reg-text">Register Now</a>
							</small>
						</div>
					</div>
				  </div>

                </div>
	            <?php //} ?>
	          </div>
					</div>
				</div>
			</div>
			<div class="logo-block">
				<div class="container">
					 <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
						 	<div class="logo row justify-content-center align-items-center">
	              <div class="col-xs-3 mb-3 mb-lg-0 align-items-center">
	                <a href="<?= SITEURL; ?>" title="Global Wholesale Machinery"><img src="<?= SITEURL; ?>assets/logos/GWP.png" alt="Global Wholesale Parts"></a>
	              </div>
	              <div class="col-xs-3 mb-3 mb-lg-0 align-items-center">
	                <a href="https://globalwholesalemachinery.com/" target="_blank" title="Global Wholesale Parts"><img src="<?= SITEURL; ?>assets/logos/GWM.png" alt="Global Wholesale Machinery"></a>
	              </div>
	              <div class="col-xs-3 mb-3 mb-lg-0 align-items-center">
	                <a href="https://globalwholesaletires.com/" target="_blank" title="Global Wholesale Tires"><img src="<?= SITEURL; ?>assets/logos/GWT.png" alt="Global Wholesale Tires"></a>
	              </div>
	              <div class="col-xs-3 mb-3 mb-lg-0 align-items-center">
	                <a href="https://globalmachineryauctions.com/" target="_blank" title="Global Machinery Auctions"><img src="<?= SITEURL; ?>assets/logos/GMA.png" alt="Global Machinery Auctions"></a>
	              </div>
	            </div>
							<div class="right-search d-sm-flex gap-3">
              	<a href="<?= SITEURL; ?>#get-a-quote" class="primary-btn">GET A PART QUOTE</a>
              	<div class="d-flex align-items-center pt-4 pt-sm-0 justify-content-center">
                	<?php $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
	                <!-- <div class="header-cart header-icons">
	                    <a href="#"><i class="fa-solid fa-bookmark"></i><span class="cart-counter"><?= $num_items_in_cart; ?></span></a>
	                </div> -->
                	<?php $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
	                <div class="header-cart header-icons">
	                    <a href="<?= SITEURL; ?>cart/"><i class="fa-solid fa-cart-shopping"></i><span class="cart-counter"><?= $num_items_in_cart; ?></span></a>
	                </div>
	              </div>
            	</div>
					 </div>
				</div>
			</div>
			<div class="et_pb_with_background et_section_regular navbar navbar-expand-lg">
				<div class="container container justify-content-center">
					<div class="et_pb_column et_pb_column_4_4 et_pb_column_5_tb_header	et_pb_css_mix_blend_mode_passthrough et-last-child mb-0">
						<div class="et_pb_module et_pb_code et_pb_code_0_tb_header mb-0">
							<div class="et_pb_code_inner">
								<div class="search-bar mb-2 mb-sm-0">
                  	<div class="row mb-3">
											<div class="col-md-8 d-md-flex align-items-center">
												<div class="or-text me-3" style="min-width: 95px;">Select Any One:</div>
												<form action="" method="get" class="search-engine-1 w-100" id="search-engine-1">
													<div class="row funkyradio">
														<div class="col-md-6 d-flex funkyradio-default">
															<input type="radio" class="btn-check search-filter active" name="search_by" id="by_machine" autocomplete="off" checked>
															<label class="btn search-btn" for="by_machine">Parts By Machine</label>
														</div>
														<div class="col-md-6 d-flex funkyradio-default">
															<input type="radio" class="btn-check search-filter" name="search_by" id="by_component" autocomplete="off">
															<label class="btn search-btn" for="by_component">Parts By Component</label>
														</div>
													</div>
												</form>
											</div>
											<div class="col-md-4 d-md-flex align-items-center search-parts">
												<div class="or-text me-3 hide-in-mobile">OR</div>
	                    	<div class="position-relative">
                  				<form action="<?= SITEURL; ?>advance-search/" method="get" class="advance-search w-100" id="advance-search">
		                    		<input type="search" name="keyword" class="form-control" id="keyword" placeholder="Seach Model OR Part #" value="<?= (isset($_GET['keyword']) && $_GET['keyword'] != '' ? $_GET['keyword'] : '' ); ?>">
		                    		<button type="submit" class="src-btn" id=advance_search_submit><i class="fa fa-search"></i></button>
                  				</form>
	                    	</div>
											</div>
										</div>
                </div>
                <div class="mb-2 mb-sm-0 parts-by-machine">
										<div class="row">
											<div class="col-md-12">
												<form action="" method="get" class="search-engine-2 w-100" id="search-engine-2">
													<div class="row justify-content-center">
														<div class="col-md-2 search-dropdowns">
															<input type="search" name="machine_type" class="form-control form-select" id="machine_type" placeholder="Machine Type" value="<?= (isset($_GET['machine_type']) && $_GET['machine_type'] != '' ? $_GET['machine_type'] : '' ); ?>">
														</div>
														<div class="col-md-1 search-dropdowns">
															<input type="search" name="machine_make" class="form-control form-select" id="machine_make" placeholder="Machine Make" value="<?= (isset($_GET['machine_make']) && $_GET['machine_make'] != '' ? $_GET['machine_make'] : '' ); ?>" disabled>
														</div>
														<div class="col-md-1 search-dropdowns">
															<input type="search" name="machine_model" class="form-control form-select" id="machine_model" placeholder="Machine Model" value="<?= (isset($_GET['machine_model']) && $_GET['machine_model'] != '' ? $_GET['machine_model'] : '' ); ?>" disabled>
														</div>
														<div class="col-md-3 search-dropdowns">
															<input type="search" name="systems_component_groups" class="form-control form-select" id="systems_component_groups" placeholder="Systems & Component Groups" value="<?= (isset($_GET['systems_component_groups']) && $_GET['systems_component_groups'] != '' ? $_GET['systems_component_groups'] : '' ); ?>" disabled>
														</div>
														<div class="col-md-3 search-dropdowns">
															<input type="search" name="component_model_series_arrangement" class="form-control form-select" id="component_model_series_arrangement" placeholder="Model / Arrangement #" value="<?= (isset($_GET['component_model_series_arrangement']) && $_GET['component_model_series_arrangement'] != '' ? $_GET['component_model_series_arrangement'] : '' ); ?>" disabled>
														</div>
														<div class="col-md-2 search-dropdowns">
															<input type="search" name="product_type" class="form-control form-select" id="product_type" placeholder="Part / Product Type" value="<?= (isset($_GET['product_type']) && $_GET['product_type'] != '' ? $_GET['product_type'] : '' ); ?>" disabled>
														</div>
													</div>
												</form>
											</div>
										</div>
                </div>
                <div class="mb-2 mb-sm-0 parts-by-component" style="display: none;">
										<div class="row justify-content-center">
											<div class="col-md-12">
												<form action="" method="get" class="search-engine-2 w-100" id="search-engine-2">
													<div class="row justify-content-center parts-by-component-row">
														<div class="col-md-1 search-dropdowns">
															<input type="search" name="component_make_comp" class="form-control form-select" id="component_make_comp" placeholder="Component Make" value="<?= (isset($_GET['component_make_comp']) && $_GET['component_make_comp'] != '' ? $_GET['component_make_comp'] : '' ); ?>" disabled>
														</div>
														<div class="col-md-3 search-dropdowns">
															<input type="search" name="systems_component_groups_comp" class="form-control form-select" id="systems_component_groups_comp" placeholder="Systems & Component Groups" value="<?= (isset($_GET['systems_component_groups_comp']) && $_GET['systems_component_groups_comp'] != '' ? $_GET['systems_component_groups_comp'] : '' ); ?>" disabled>
														</div>
														<div class="col-md-2 search-dropdowns">
															<input type="search" name="component_model_series_arrangement_comp" class="form-control form-select" id="component_model_series_arrangement_comp" placeholder="Model / Arrangement #" value="<?= (isset($_GET['component_model_series_arrangement_comp']) && $_GET['component_model_series_arrangement_comp'] != '' ? $_GET['component_model_series_arrangement_comp'] : '' ); ?>" disabled>
														</div>
														<div class="col-md-2 search-dropdowns">
															<input type="search" name="product_type_comp" class="form-control form-select" id="product_type_comp" placeholder="Part / Product Type" value="<?= (isset($_GET['product_type_comp']) && $_GET['product_type_comp'] != '' ? $_GET['product_type_comp'] : '' ); ?>" disabled>
														</div>
													</div>
												</form>
											</div>
										</div>
                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="et_pb_with_background et_section_regular navbar navbar-expand-lg navbar-light bg-light">
				<div class="container container justify-content-center">
					<div class="et_pb_column et_pb_column_4_4 et_pb_column_5_tb_header	et_pb_css_mix_blend_mode_passthrough et-last-child mb-0">
						<div class="et_pb_module et_pb_code et_pb_code_0_tb_header mb-0">
							<div class="et_pb_code_inner">
								<button class="ubermenu-responsive-toggle ubermenu-responsive-toggle-main ubermenu-skin-grey-white ubermenu-loc- ubermenu-responsive-toggle-content-align-left ubermenu-responsive-toggle-align-full justify-content-center align-items-center text-center" tabindex="0" data-ubermenu-target="ubermenu-main-17">
									<svg class="svg-inline--fa fa-bars fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
										<path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path>
									</svg> Menu 
								</button>
								<nav id="ubermenu-main-17" class="ubermenu ubermenu-main ubermenu-menu-17 ubermenu-responsive ubermenu-responsive-single-column ubermenu-responsive-single-column-subs ubermenu-responsive-default ubermenu-mobile-accordion ubermenu-responsive-collapse ubermenu-horizontal ubermenu-transition-shift ubermenu-trigger-hover ubermenu-skin-grey-white ubermenu-bar-align-full ubermenu-items-align-auto ubermenu-bound ubermenu-disable-submenu-scroll ubermenu-sub-indicators ubermenu-retractors-responsive ubermenu-submenu-indicator-closes ubermenu-notouch ubermenu-desktop-view">
									<ul id="ubermenu-nav-main-17" class="ubermenu-nav" data-title="Main Menu">
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text"><i class="fa-solid fa-house"></i></span>
											</a>
										</li>
										<li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-1787 ubermenu-item-level-0 ubermenu-column ubermenu-column-natural ubermenu-has-submenu-drop ubermenu-has-submenu-mega">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" tabindex="0">
												<span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Parts</span>
												<i class="ubermenu-sub-indicator fas fa-angle-down"></i>
											</a>
											<ul class="ubermenu-submenu ubermenu-submenu-id-1787 ubermenu-submenu-type-mega ubermenu-submenu-drop ubermenu-submenu-align-full_width hd-menu">
												<li class="	ubermenu-item ubermenu-item-type-custom ubermenu-item-object-ubermenu-custom ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-column ubermenu-column-1-4 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788">
													<ul class="ubermenu-submenu ubermenu-submenu-id-1788 ubermenu-submenu-type-stack">
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-569 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-engine-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Engine rebuild kits</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-580 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-turbocharger-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Turbocharger</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-580 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-injector-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Injectors</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-571 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-filters/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Filters</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-580 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-cylinder-head-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Cylinder Heads</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-580 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-crankshaft-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Crankshaft</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-580 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-batteries/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Batteries</span>
															</a>
														</li>
													</ul>
												</li>
												<li class="	ubermenu-item ubermenu-item-type-custom ubermenu-item-object-ubermenu-custom ubermenu-item-has-children ubermenu-item-498 ubermenu-item-level-1 ubermenu-column ubermenu-column-1-4 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-498">
													<ul class="ubermenu-submenu ubermenu-submenu-id-498 ubermenu-submenu-type-stack">
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-581 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-valves/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Valves</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-580 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-camshaft-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Camshaft & Connecting Rod</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-564 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-ac-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD AC Compressors & Parts</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-568 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-electrical-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Electrical parts</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-579 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-transmission-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Transmission Parts</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-567 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-differential-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Differential Parts</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-580 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-ground-engaging-tools/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD GET Parts</span>
															</a>
														</li>
													</ul>
												</li>
												<li class="	ubermenu-item ubermenu-item-type-custom ubermenu-item-object-ubermenu-custom ubermenu-item-has-children ubermenu-item-499 ubermenu-item-level-1 ubermenu-column ubermenu-column-1-4 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-499">
													<ul class="ubermenu-submenu ubermenu-submenu-id-499 ubermenu-submenu-type-stack">
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-580 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-undercarriage-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">GQP Undercarriage</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-582 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-tires/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Tires</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-570 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-final-drive-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">Final Drive Parts</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-573 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-seats/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Seats</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-574 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-pumps/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD hydraulic Pumps Parts</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-576 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-swing-drive-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Excavator Swing Drive motor parts</span>
															</a>
														</li>
													</ul>
												</li>
												<li class="	ubermenu-item ubermenu-item-type-custom ubermenu-item-object-ubermenu-custom ubermenu-item-has-children ubermenu-item-583 ubermenu-item-level-1 ubermenu-column ubermenu-column-1-4 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-583">
													<ul class="ubermenu-submenu ubermenu-submenu-id-583 ubermenu-submenu-type-stack">
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-565 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-attachments/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">Attachments</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-577 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-torque-converter-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Torque Converter Parts</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-578 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left last" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-track-springs/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">Rubber Tracks</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-572 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left last" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-floor-mats/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Floor Mats</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-575 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left last" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-slewing-rings/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">Excavator Slewing Rings</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-1817 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left last" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-swing-motor/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">Swing Motor</span>
															</a>
														</li>
													</ul>
												</li>
											</ul>
										</li>
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-drop ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>component-rebuild-services/" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Component Rebuilds</span>
											  <i class="ubermenu-sub-indicator fas fa-angle-down"></i>
											</a>
											<ul class="ubermenu-submenu ubermenu-submenu-id-29 ubermenu-submenu-type-flyout ubermenu-submenu-drop ubermenu-submenu-align-left_edge_item ubermenu-top-bottom-padding" aria-hidden="true">
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/differential-rebuild-services/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Differential Rebuild Services</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/hydraulic-pumps-rebuild-services/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Hydraulic Pumps Rebuild Services</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/undercarriage-rebuild-services/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Undercarriage Rebuild Services</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/engine-rebuild-services/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Engine Rebuild Services</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/final-drive-rebuild-services/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Final Drive Rebuild Services</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/torque-converter-rebuild-services/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Torque Converter Rebuild Services</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/transmission-rebuild-services/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Transmission Rebuild Services</span>
											    </a>
											  </li>
											</ul>
										</li>
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-drop ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="javascript:void(0);" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">GQP</span>
											  <i class="ubermenu-sub-indicator fas fa-angle-down"></i>
											</a>
											<ul class="ubermenu-submenu ubermenu-submenu-id-29 ubermenu-submenu-type-flyout ubermenu-submenu-drop ubermenu-submenu-align-left_edge_item ubermenu-top-bottom-padding" aria-hidden="true">
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>gqp-genuine-product-line/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">GQP Genuine Product Line</span>
											    </a>
											  </li>
											  <!-- <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>gqp-bulk-order/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Become a GQP VIP Dealer</span>
											    </a>
											  </li> -->
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>gqp-certified-dealer-program/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Become a GQP Certified Dealer</span>
											    </a>
											  </li>
											</ul>
										</li>
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>gqp-vip-fleet-solutions/" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">GQP VIP FLEET SOLUTIONS</span>
											</a>
										</li>
										<!-- <li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-drop ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>parts/" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">Buy Parts</span>
											  <i class="ubermenu-sub-indicator fas fa-angle-down"></i>
											</a>
											<ul class="ubermenu-submenu ubermenu-submenu-id-29 ubermenu-submenu-type-flyout ubermenu-submenu-drop ubermenu-submenu-align-left_edge_item ubermenu-top-bottom-padding" aria-hidden="true">
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout ubermenu-has-submenu-drop ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>parts-by-make/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Parts by Make</span>
											    </a>
											    <ul class="ubermenu-submenu ubermenu-submenu-id-29 ubermenu-submenu-type-flyout ubermenu-submenu-drop ubermenu-submenu-align-left_edge_item ubermenu-top-bottom-padding" aria-hidden="true">
											    	<?php 
                              $brand_sql = "SELECT * FROM makes WHERE `status`='active' AND `is_featured`='y' ORDER BY `id` ASC";
                              $brand_result = $conn->query($brand_sql);
                              if ($brand_result->num_rows > 0) {
                                while ($brand = $brand_result->fetch_assoc()) {
                                  ?>
                                  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
																    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL.'parts/'.$brand['slug'].'/'; ?>" aria-expanded="false">
																      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																      <span class="ubermenu-target-title ubermenu-target-text"><?= $brand['makes']; ?></span>
																    </a>
																  </li>
                                  <?php
                                }
                              }
                            ?>
													</ul>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout ubermenu-has-submenu-drop ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>parts-by-equipment/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Parts by Equipment</span>
											    </a>
											    <ul class="ubermenu-submenu ubermenu-submenu-id-29 ubermenu-submenu-type-flyout ubermenu-submenu-drop ubermenu-submenu-align-left_edge_item ubermenu-top-bottom-padding" aria-hidden="true">
											    	<?php 
						                  $component_sql = "SELECT * FROM component WHERE `status`='active' ORDER BY `id` ASC";
						                  $component_result = $conn->query($component_sql);
						                  if ($component_result->num_rows > 0) {
						                    while ($component = $component_result->fetch_assoc()) {
                                  ?>
                                  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
																    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL.'parts-by-equipment/'.$component['slug'].'/'; ?>" aria-expanded="false">
																      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																      <span class="ubermenu-target-title ubermenu-target-text"><?= $component['component']; ?></span>
																    </a>
																  </li>
                                  <?php
                                }
                              }
                            ?>
													</ul>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout ubermenu-has-submenu-drop ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>parts-by-component/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Parts by Component</span>
											    </a>
											    <ul class="ubermenu-submenu ubermenu-submenu-id-29 ubermenu-submenu-type-flyout ubermenu-submenu-drop ubermenu-submenu-align-left_edge_item ubermenu-top-bottom-padding" aria-hidden="true">
											    	<?php 
                              $category_sql = "SELECT * FROM category WHERE `status`='active' ORDER BY `id` ASC";
					                    $category_result = $conn->query($category_sql);
					                    if ($category_result->num_rows > 0) {
					                      while ($category = $category_result->fetch_assoc()) {
                                  ?>
                                  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
																    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL.'parts-by-component/'.$category['slug'].'/'; ?>" aria-expanded="false">
																      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																      <span class="ubermenu-target-title ubermenu-target-text"><?= $category['category']; ?></span>
																    </a>
																  </li>
                                  <?php
                                }
                              }
                            ?>
													</ul>
											  </li>
											</ul>
										</li> -->
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-drop ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>about-us/" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">About us</span>
											  <i class="ubermenu-sub-indicator fas fa-angle-down"></i>
											</a>
											<ul class="ubermenu-submenu ubermenu-submenu-id-29 ubermenu-submenu-type-flyout ubermenu-submenu-drop ubermenu-submenu-align-left_edge_item ubermenu-top-bottom-padding" aria-hidden="true">
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>about-us/brochures/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Brochures</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>about-us/warranties/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Warranties</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>global-quality-parts/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Global Quality Parts</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>global-quality-undercarriage/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Global Quality Undercarriage</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>global-quality-rubber-tracks/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Global Quality Rubber Tracks</span>
											    </a>
											  </li>
											</ul>
										</li>
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>contact-us/" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">Contact Us</span>
											</a>
										</li>
										<!-- <li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="https://globaldealerlogin.com/vendor/login.php" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">Become a Vendor</span>
											</a>
										</li> -->
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>inventory/" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">Inventory</span>
											</a>
										</li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div id="et-main-area">
		<?php 
			// Function to get the client IP address
			function get_client_ip() {
			    $ipaddress = '';
			    if (getenv('HTTP_CLIENT_IP'))
			        $ipaddress = getenv('HTTP_CLIENT_IP');
			    else if(getenv('HTTP_X_FORWARDED_FOR'))
			        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			    else if(getenv('HTTP_X_FORWARDED'))
			        $ipaddress = getenv('HTTP_X_FORWARDED');
			    else if(getenv('HTTP_FORWARDED_FOR'))
			        $ipaddress = getenv('HTTP_FORWARDED_FOR');
			    else if(getenv('HTTP_FORWARDED'))
			       $ipaddress = getenv('HTTP_FORWARDED');
			    else if(getenv('REMOTE_ADDR'))
			        $ipaddress = getenv('REMOTE_ADDR');
			    else
			        $ipaddress = 'UNKNOWN';
			    return $ipaddress;
			}
		?>
<script>
//   const login1 = document.getElementById('dealerloginDropdown');
//   console.log(login1);
//   const login2 = document.getElementById('loginDropdown');

//   login1.addEventListener('click', function() {
//     login2.classList.remove('show'); // Hide the other modal
//   });

//   login2.addEventListener('click', function() {
//     login1.classList.remove('show'); // Hide the other modal
//   });
</script>