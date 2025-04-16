<?php header('X-Content-Type-Options: nosniff'); ?>
<?php require 'controller/db_config.php'; ?>
<?php 
// find out the domain:
$domain = $_SERVER['HTTP_HOST'];
$url = "https://" . $domain . $_SERVER['REQUEST_URI'];

if(isset($url)){
  if (isset($_GET['type']) && $_GET['type'] == 'product') {
    if (isset($_GET['main'])) {
      $find_meta_information_sql = "SELECT * FROM `meta_information` WHERE `status`='active' AND `page_name` = '%/".$_GET['main']."/%' LIMIT 1";
    }
  }else{
    $find_meta_information_sql = "SELECT * FROM `meta_information` WHERE `status`='active' AND `page_name`='".$url."' LIMIT 1";
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
	  $brand_sql = "SELECT * FROM `makes` WHERE `slug` = '".$_GET['main_brand']."' AND status='active'";
	  $brand_result = $conn->query($brand_sql);
	  if ($brand_result->num_rows > 0) {
	    while ($brand_array = $brand_result->fetch_assoc()) {
	      $main_makes_id = $brand_array['id'];
	      $main_makes = $brand_array['makes'];
	      $main_makes_h1 = $brand_array['title'];
	      $main_makes_h2 = $brand_array['sub_title'];
	      $main_description = $brand_array['description'];
	      $main_makes_slug = $brand_array['slug'];
	      $main_is_oem = $brand_array['is_oem'];

	      $bread_make_id = $brand_array['id'];
	      $bread_make = $brand_array['makes'];
	      $bread_make_slug = $brand_array['slug'];
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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet">
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KJKL5LG8');</script>
	<!-- End Google Tag Manager -->

	<!-- Google tag (gtag.js) -->
	<script defer src="//www.googletagmanager.com/gtag/js?id=G-FPBPXS2E6R"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-FPBPXS2E6R');
	</script>
	
	<script defer src="//www.googletagmanager.com/gtag/js?id=AW-299499973"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'AW-299499973');
	</script>
	<!-- Google tag (gtag.js) -->

	<meta http-equiv="Content-Type" content="charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="google-site-verification" content="3pfpxNc1WraMOmja6IohDsPJmZD2hn5HXHjhK6gjXQA" />

	<!-- <link rel="icon" href="<?= SITEURL; ?>assets/logos/favicon.ico" type="image/x-icon" /> -->
	<link rel="shortcut icon" href="<?= SITEURL; ?>assets/logos/favicon.ico" type="image/x-icon" />

	<link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<!-- <link href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"> -->
	<!-- <link rel="stylesheet" href="<?= CDN_SITEURL; ?>assets/css/fonts.css" type="text/css"> -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css"></link>

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
	<script defer src="//www.paypalobjects.com/api/checkout.js"></script>
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

	<link rel="stylesheet" href="<?= CDN_SITEURL; ?>assets/css/woocommerce-layout.css" type="text/css" media="all">
	<!-- <link rel="stylesheet" href="<?= CDN_SITEURL; ?>assets/css/woocommerce.css" type="text/css" media="all"> -->
	<link rel="stylesheet" href="<?= CDN_SITEURL; ?>assets/css/ubermenu.min.css" type="text/css" media="all">
	<!-- <link rel="stylesheet" id="ubermenu-font-awesome-all-css" href="<?= CDN_SITEURL; ?>assets/css/all.min.css" type="text/css" media="all"> -->
	<link rel="stylesheet" href="<?= CDN_SITEURL; ?>assets/css/style-static.min.css" type="text/css" media="all">

	<!-- <link href="<?= CDN_SITEURL; ?>assets/css/fontawesome.css" rel="stylesheet" type="text/css"/> -->
	<!-- <link href="<?= CDN_SITEURL; ?>assets/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css"/> -->
	<link href="<?= CDN_SITEURL; ?>assets/css/owl.carousel.css" rel="stylesheet" type="text/css"/>
  <link href="<?= CDN_SITEURL; ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <!-- <link href='<?= CDN_SITEURL; ?>assets/css/lightgallery.min.css' rel="stylesheet"> -->
	<link href="<?= CDN_SITEURL; ?>assets/css/style.css?v=0.0.6" rel="stylesheet" type="text/css"/>
	<link href="<?= CDN_SITEURL; ?>assets/css/responsive.css?v=0.0.6" rel="stylesheet" type="text/css"/>

	<!-- <link rel="stylesheet" id="wc-blocks-vendors-style-css" href="<?= CDN_SITEURL; ?>assets/css/wc-blocks-vendors-style.css" type="text/css" media="all"> -->
	<!-- <link rel="stylesheet" id="wc-blocks-style-css" href="<?= CDN_SITEURL; ?>assets/css/wc-blocks-style.css" type="text/css" media="all"> -->

	<!-- <link rel="stylesheet" id="woocommerce-smallscreen-css" href="<?= CDN_SITEURL; ?>assets/css/woocommerce-smallscreen.css" type="text/css" media="only screen and (max-width: 768px)"> -->

	<!-- <link href="<?= CDN_SITEURL; ?>assets/css/ubermenu_custom.css" rel="stylesheet" type="text/css"/> -->

	<?php if ($page_name == 'home') { ?>
  	<link href="<?= CDN_SITEURL; ?>assets/css/home_page.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'heavy_duty_parts' || $page_name == 'main-parts') { ?>
		<link href="<?= CDN_SITEURL; ?>assets/css/heavy_duty_parts.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'main-parts') { ?>
		<link href="<?= CDN_SITEURL; ?>assets/css/bstreeview.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'about_us') { ?>
		<link href="<?= CDN_SITEURL; ?>assets/css/about_us.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'brochures') { ?>
		<link href="<?= CDN_SITEURL; ?>assets/css/brochures.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'warranties') { ?>
		<link href="<?= CDN_SITEURL; ?>assets/css/warranties.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'contact_us') { ?>
		<link href="<?= CDN_SITEURL; ?>assets/css/contact.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'component_rebuild_services') { ?>
		<link href="<?= CDN_SITEURL; ?>assets/css/component_rebuild_services.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'component_rebuild_service') { ?>
		<link href="<?= CDN_SITEURL; ?>assets/css/component_rebuild_service.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
	<?php if ($page_name == 'sign-in' || $page_name == 'sign-up') { ?>
		<link href="<?= CDN_SITEURL; ?>assets/css/sign-in.css" rel="stylesheet" type="text/css"/>
	<?php } ?>
  <!-- <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

	<?php if (isset($in_head)) { ?>
      <?= html_entity_decode($in_head); ?>           
  <?php } ?>
</head>
<!-- Start of HubSpot Embed Code -->
<!-- <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/44607887.js"></script> -->
<!-- End of HubSpot Embed Code -->
<body class="">
	<?php if (isset($in_body)) { ?>
	    <?= html_entity_decode($in_body); ?>           
	<?php } ?>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KJKL5LG8"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php 
	if (!isset($addClass)) {
    $addClass = '';  // Set a default class (empty string or any fallback class)
	}
	?>
	<div id="" class="<?php echo $addClass; ?> main-body-wrapper">
		<header>
		<div class="top-section mobile-view">
			<div class="container">
				<div class="row mx-0 justify-content-between">
					<div class="col-auto text-start logo-block">
						<div class="logo row gap-1 mx-0 align-items-center">
              <div class="col-auto mb-0 align-items-center mobile_gwm_logo">
                <a href="<?= SITEURL; ?>" title="Global Wholesale Machinery"><img src="<?= SITEURL; ?>assets/logos/GWP.webp" alt="Global Wholesale Parts"></a>
              </div>
            </div>
					</div>
					<div class="col-auto text-center d-flex flex-column flex-md-row align-items-center justify-content-center header-phone-email">
			      <div class="me-md-3 me-2 me-md-0 detailed-email-phone">
			        <a class="phone" href="tel:+1(780) 670-2010"><i class="fa-solid fa-phone me-1 phone-icon"></i> +1 (780) 670-2010</a>
			      </div>
			      <div class="detailed-email-phone">
			      	<a class="email" href="mailto:parts@globalwholesaleparts.com"><i class="fa-solid fa-envelope me-1 email-icon"></i> parts@globalwholesaleparts.com</a>
			      </div>
			      <div class="me-md-3 me-2 me-md-0 icon-for-email-phone mobile_phone_header">
            	<a href="tel:+1(780) 670-2010" class="btn primary-btn"><i class="fa-solid fa-phone"></i></a>
            </div>
            <div class="icon-for-email-phone mobile_email_header">
            	<a href="mailto:parts@globalwholesaleparts.com" class="btn primary-btn"><i class="fa-solid fa-envelope"></i></a>
            </div>
			    </div>
					<div class="col-auto text-end d-flex align-items-center justify-content-end top-section-area login-buttons">
						<div class="w-auto mobile-center">
							<div class="header-login login-button ms-sm-auto text-end">
								<?php if (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName'])) { ?>
									<div class="header-login ms-sm-auto ms-xxl-4 text-end">
										<a class="btn dropdown-toggle primary-btn" id="AccountDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? '' : 'style="display: none;"'); ?>><i class="fa-solid fa-user me-1"></i> <span class="welcome-user me-1"><?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? ' Welcome '.$_SESSION['firstName'] : ''); ?></span> <i class="fa-solid fa-angle-down"></i></a>
										<ul class="login-form p-0 dropdown-menu dropdown-menu-end mt-2 dropdown-menu-right shadow-lg" aria-labelledby="AccountDropdown">
										<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>dashboard/"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a></li> 
										<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>profile/"><i class="fa-solid fa-circle-user me-2"></i> Profile</a></li> 
										<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>orders/"><i class="fa-solid fa-box me-2"></i> My Orders</a></li>
										<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>fleet-list/"><i class="fa-solid fa-warehouse me-2"></i> <?= (isset($user_id) && $user_id==214 ? 'Engine List' : 'Fleet List'); ?></a></li>
										<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>support-tickets/"><i class="fa-solid fa-comments me-2"></i> Support Tickets</a></li>
										<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>change-password/"><i class="fa-solid fa-key me-2"></i> Change Password</a></li>
										<li class="border-top"><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>controller/logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout</a></li>
										</ul>
									</div>
								<?php }else{ ?>
									<span class="m-auto GQPLogin_signin_label pe-2">Sign In:</span>

									<a class="btn dropdown-toggle primary-btn" id="GWPCustomer" style="margin:5px" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? 'style="display: none;"' : ''); ?>>GWP Customer <i class="fa-solid fa-angle-down ms-1"></i></a>
				     
	                <div class="login-form shadow-lg p-0 dropdown-menu dropdown-menu-end border-0 rounded-0 GWPCustomer-modal" aria-labelledby="GWPCustomer">
										<div class="tab-content p-4 pb-2" id="myTabContent">
											<div class="tab-pane fade show active" id="dealerlogin" role="tabpanel" aria-labelledby="dealerlogin-tab">
												<form class="header-login mb-2">
													<p class="mb-3"><strong>GWP Customer Sign in</strong></p>
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
													<input type="hidden" name="role" value="gqp_customer">
													<button type="submit" class="w-100 primary-btn" name="login" value="login">Submit</button>
												</form>
												<small class="d-block p-4 pt-2 text-center">
												Don't have an account? <a href="<?= SITEURL; ?>gwp-customer-sign-up/" class="reg-text">Register Now</a>
												</small>
											</div>
										</div>
				  				</div>

									<a class="btn dropdown-toggle primary-btn" id="dealerloginDropdown" style="margin:5px" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? 'style="display: none;"' : ''); ?>>GQP Dealer <i class="fa-solid fa-angle-down ms-1"></i></a>
				     
	                <div class="login-form shadow-lg p-0 dropdown-menu dropdown-menu-end border-0 rounded-0 dealerloginDropdown-modal" aria-labelledby="dealerloginDropdown">
										<div class="tab-content p-4 pb-2" id="myTabContent">
											<div class="tab-pane fade show active" id="dealerlogin" role="tabpanel" aria-labelledby="dealerlogin-tab">
												<form class="header-login mb-2">
													<p class="mb-3"><strong>GQP Dealer Sign in</strong></p>
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
				
				   				<a class="btn dropdown-toggle primary-btn customer-login-btn" style="margin:5px" id="loginDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? 'style="display: none;"' : ''); ?>>VIP Customer <i class="fa-solid fa-angle-down ms-1"></i></a>

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
												Don't have an account? <a href="<?= SITEURL; ?>gqp-vip-exclusive-membership/" class="reg-text">Register Now</a>
												</small>
											</div>
										</div>
								  </div>

									<!-- <a class="btn dropdown-toggle primary-btn gqp-customer-login-btn" style="margin:5px" id="GQPLoginDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? 'style="display: none;"' : ''); ?>> <i class="fa-solid fa-user me-1"></i> Sign In / Register <i class="fa-solid fa-angle-down ms-1"></i></a>

								  <div class="login-form shadow-lg p-0 dropdown-menu dropdown-menu-end GQPLoginDropdown-modal" aria-labelledby="GQPLoginDropdown">
										<div class="tab-content" id="myTabContent" style="margin: 0px !important;">
											<div class="tab-pane fade show active" id="customerLogin" role="tabpanel" aria-labelledby="customerLogin-tab">
												<ul class="nav nav-tabs login-tab" id="myTab" role="tablist">
													<li class="nav-item border-bottom border-white w-100" role="presentation">
                        		<div class="nav-link  p-3 pb-4 pt-1 w-100 border-0 rounded-0 text-center GQPLogin_signin_label">Sign <sub>in</sub></div>
                      		</li>
		                      <li class="nav-item" role="presentation" style="width:33%;">
		                        <button class="nav-link <?= (isset($_SESSION['dealer_error']) || isset($_SESSION['affiliate_error']) || isset($_SESSION['customer_error']) ? '' : 'active'); ?> p-3 w-100 border-0 rounded-0" id="gqpcustomerLogin-tab1" data-bs-toggle="tab" data-bs-target="#gqpcustomerLogin1" type="button" role="tab" aria-controls="gqpcustomerLogin1" <?= (isset($_SESSION['dealer_error']) || isset($_SESSION['affiliate_error']) || isset($_SESSION['customer_error']) ? 'aria-selected="false"' : 'aria-selected="true"'); ?>>GWP Customer</button>
		                      </li>
		                      <li class="nav-item center-tab-btn" role="presentation" style="width:33%;">
		                        <button class="nav-link <?= (isset($_SESSION['dealer_error']) ? 'active' : ''); ?> p-3 w-100 border-0 rounded-0" id="dealerlogin-tab1" data-bs-toggle="tab" data-bs-target="#vipdealerlogin1" type="button" role="tab" aria-controls="vipdealerlogin1" <?= (isset($_SESSION['dealer_error']) ? 'aria-selected="true"' : 'aria-selected="false"'); ?>>GQP Dealer</button>
		                      </li>
		                      <li class="nav-item" role="presentation" style="width:33%;">
		                        <button class="nav-link <?= (isset($_SESSION['customer_error']) ? 'active' : ''); ?> p-3 w-100 border-0 rounded-0" id="vipcustomerLogin-tab1" data-bs-toggle="tab" data-bs-target="#vipcustomerLogin1" type="button" role="tab" aria-controls="vipcustomerLogin1" <?= (isset($_SESSION['dealer_error']) || isset($_SESSION['affiliate_error']) ? 'aria-selected="false"' : 'aria-selected="true"'); ?>>VIP Customer</button>
		                      </li>
		                    </ul>
		                    <div class="p-4" id="myTabContent1">
		                      <div class="tab-pane fade <?= (isset($_SESSION['dealer_error']) || isset($_SESSION['affiliate_error']) || isset($_SESSION['customer_error']) ? '' : 'show active'); ?>" id="gqpcustomerLogin1" role="tabpanel" aria-labelledby="gqpcustomerLogin-tab1">
		                        <form class="" id="main-gqp-user-login" action="<?= SITEURL; ?>sign-in/gqp-user-submit.php" method="POST">
		                          <h5 class="mb-3">GQP Customer Sign in</h5>
		                          <?php if(isset($_SESSION['gqp_customer_error'])) {
		                            if($_SESSION['gqp_customer_error'] == 'something_went_wrong'){
		                              echo '<div class="alert alert-danger">Something went wrong, Please try again!</div>';
		                            }elseif ($_SESSION['gqp_customer_error'] == 'empty_email'){
		                              echo '<div class="alert alert-danger">Pleaser enter Email.</div>';
		                            }
		                            elseif ($_SESSION['gqp_customer_error'] == 'empty_password'){
		                              echo '<div class="alert alert-danger">Pleaser enter Password.</div>';
		                            }elseif ($_SESSION['gqp_customer_error'] == 'incorrect_email_or_password'){
		                              echo '<div class="alert alert-danger">Email or Password is Incorrect.</div>';
		                            }
		                            unset($_SESSION['gqp_customer_error']);
		                          } ?>
		                          <div class="mb-4">
		                            <input type="text" class="form-control" id="gqp-user-email-main" aria-describedby="emailHelp" placeholder="Email address" name="email">
		                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
		                          </div>
		                          <div class="mb-4">
		                            <input type="password" class="form-control" id="gqp-user-password-main" placeholder="Password" name="password">
		                          </div>
		                          <div class="d-flex justify-content-between align-items-center mb-3">
		                            <div class="form-check">
		                              <input type="checkbox" class="form-check-input" id="gqp-user-remember-me-main">
		                              <label class="form-check-label" for="user-remember-me-main">Remember me</label>
		                            </div>
		                            <a class="red-text" href="<?= SITEURL; ?>forgot-password/">Forgot Password?</a>
		                          </div>
		                          <input type="hidden" name="role" value="gqp_customer">
		                          <input type="hidden" name="page" value="login">
		                          <button type="submit" name="login" value="login" class="primary-btn w-100">Submit</button>
		                        </form>
		                        <small class="d-block mt-3 text-center">
		                          Don't have an account? <a class="red-text" href="<?= SITEURL; ?>gwp-customer-sign-up/">Register Now</a>
		                        </small>
		                      </div>
		                      <div class="tab-pane fade <?= (isset($_SESSION['customer_error']) ? 'show active' : ''); ?>" id="vipcustomerLogin1" role="tabpanel" aria-labelledby="vipcustomerLogin-tab1">
		                          <form class="" id="main-user-login" action="<?= SITEURL; ?>sign-in/user-submit.php" method="POST">
		                              <h5 class="mb-3">VIP Customer Sign in</h5>
		                              <?php if(isset($_SESSION['customer_error'])) {
		                                if($_SESSION['customer_error'] == 'something_went_wrong'){
		                                  echo '<div class="alert alert-danger">Something went wrong, Please try again!</div>';
		                                }elseif ($_SESSION['customer_error'] == 'empty_email'){
		                                  echo '<div class="alert alert-danger">Pleaser enter Email.</div>';
		                                }
		                                elseif ($_SESSION['customer_error'] == 'empty_password'){
		                                  echo '<div class="alert alert-danger">Pleaser enter Password.</div>';
		                                }elseif ($_SESSION['customer_error'] == 'incorrect_email_or_password'){
		                                  echo '<div class="alert alert-danger">Email or Password is Incorrect.</div>';
		                                }
		                                unset($_SESSION['customer_error']);
		                              } ?>
		                              <div class="mb-4">
		                                  <input type="text" class="form-control" id="user-email-main" aria-describedby="emailHelp" placeholder="Email address" name="email">
		                                  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
		                              </div>
		                              <div class="mb-4">
		                                  <input type="password" class="form-control" id="user-password-main" placeholder="Password" name="password">
		                              </div>
		                              <div class="d-flex justify-content-between align-items-center mb-3">
		                                  <div class="form-check">
		                                      <input type="checkbox" class="form-check-input" id="user-remember-me-main">
		                                      <label class="form-check-label" for="user-remember-me-main">Remember me</label>
		                                  </div>
		                                  <a class="red-text" href="<?= SITEURL; ?>forgot-password/">Forgot Password?</a>
		                              </div>
		                              <input type="hidden" name="role" value="customer">
		                              <input type="hidden" name="page" value="login">
		                              <button type="submit" name="login" value="login" class="primary-btn w-100">Submit</button>
		                          </form>
		                          <small class="d-block mt-3 text-center">
		                              Don't have an account? <a class="red-text" href="<?= SITEURL; ?>gqp-vip-exclusive-membership/">Register Now</a>
		                          </small>
		                      </div>
		                      <div class="tab-pane fade <?= (isset($_SESSION['dealer_error']) ? 'show active' : ''); ?>" id="vipdealerlogin1" role="tabpanel" aria-labelledby="vipdealerlogin1-tab">
		                          <form class="" id="main-dealer-login" action="<?= SITEURL; ?>sign-in/dealer-submit.php" method="POST">
		                              <h5 class="mb-3">GQP Dealer Sign in</h5>
		                              <?php if(isset($_SESSION['dealer_error'])) {
		                                if($_SESSION['dealer_error'] == 'something_went_wrong'){
		                                  echo '<div class="alert alert-danger">Something went wrong, Please try again!</div>';
		                                }elseif ($_SESSION['dealer_error'] == 'empty_email'){
		                                  echo '<div class="alert alert-danger">Pleaser enter Email.</div>';
		                                }
		                                elseif ($_SESSION['dealer_error'] == 'empty_password'){
		                                  echo '<div class="alert alert-danger">Pleaser enter Password.</div>';
		                                }elseif ($_SESSION['dealer_error'] == 'incorrect_email_or_password'){
		                                  echo '<div class="alert alert-danger">Email or Password is Incorrect.</div>';
		                                }elseif ($_SESSION['dealer_error'] == 'inactive_user'){
		                                  echo '<div class="alert alert-danger">Your account is under review, once the review is completed you will be notified through an email for login.</div>';
		                                }
		                                unset($_SESSION['dealer_error']);
		                              } ?>
		                              <div class="mb-4">
		                                  <input type="text" class="form-control" id="dealer-email-main" aria-describedby="emailHelp" placeholder="Email address" name="email">
		                                  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
		                              </div>
		                              <div class="mb-4">
		                                  <input type="password" class="form-control" id="dealer-password-main" placeholder="Password" name="password">
		                              </div>
		                              <div class="d-flex justify-content-between align-items-center mb-3">
		                                  <div class="form-check">
		                                      <input type="checkbox" class="form-check-input" id="dealer-remember-me-main">
		                                      <label class="form-check-label" for="dealer-remember-me-main">Remember me</label>
		                                  </div>
		                                  <a class="red-text" href="<?= SITEURL; ?>forgot-password/">Forgot Password?</a>
		                              </div>
		                              <input type="hidden" name="role" value="dealer">
		                              <input type="hidden" name="page" value="login">
		                              <button type="submit" name="login" value="login" class="primary-btn w-100">Submit</button>
		                          </form>
		                          <small class="d-block mt-3 text-center">
		                              Don't have an account? <a class="red-text" href="<?= SITEURL; ?>dealer-sign-up/">Register Now</a>
		                          </small>
		                      </div>
		                    </div>
											</div>
										</div>
								  </div> -->
								<?php } ?>
              </div>
	          </div>
					</div>
				</div>
			</div>
		</div>		
			<div class="search-engine-section-header bg-transparent" id="dealer_login_sec">
				<div class="w-auto mobile-center">
					<div class="header-login login-button">
						<?php if (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName'])) { ?>
							<div class="header-login ms-sm-auto ms-xxl-4 text-end">
								<a class="btn dropdown-toggle primary-btn" id="AccountDropdown-mobile" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? '' : 'style="display: none;"'); ?>><i class="fa-solid fa-user me-1"></i> <span class="welcome-user me-1"><?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? ' Welcome '.$_SESSION['firstName'] : ''); ?></span> <i class="fa-solid fa-angle-down"></i></a>
								<ul class="login-form p-0 dropdown-menu dropdown-menu-end mt-2 dropdown-menu-right shadow-lg" aria-labelledby="AccountDropdown-mobile">
								<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>dashboard/"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a></li> 
								<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>profile/"><i class="fa-solid fa-circle-user me-2"></i> Profile</a></li> 
								<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>orders/"><i class="fa-solid fa-box me-2"></i> My Orders</a></li>
								<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>fleet-list/"><i class="fa-solid fa-warehouse me-2"></i> <?= (isset($user_id) && $user_id==214 ? 'Engine List' : 'Fleet List'); ?></a></li>
								<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>support-tickets/"><i class="fa-solid fa-comments me-2"></i> Support Tickets</a></li>
								<li><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>change-password/"><i class="fa-solid fa-key me-2"></i> Change Password</a></li>
								<li class="border-top"><a class="dropdown-item py-2 px-4" href="<?= SITEURL; ?>controller/logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout</a></li>
								</ul>
							</div>
						<?php }else{ ?>
							<a class="btn dropdown-toggle primary-btn gqp-customer-login-btn" id="GWPCustomer-mobile" style="margin:5px" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? 'style="display: none;"' : ''); ?>><i class="fa-solid fa-user me-1"></i> GWP Customer Sign-In <i class="fa-solid fa-angle-down ms-1"></i></a>
		     
              <div class="login-form shadow-lg p-0 dropdown-menu dropdown-menu-end border-0 rounded-0 GWPCustomer-mobile-modal" aria-labelledby="GWPCustomer-mobile">
								<div class="tab-content p-4 pb-2" id="myTabContent">
									<div class="tab-pane fade show active" id="dealerlogin" role="tabpanel" aria-labelledby="dealerlogin-tab">
										<form class="header-login mb-2">
											<p class="mb-3"><strong>GWP Customer Sign in</strong></p>
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
											<input type="hidden" name="role" value="gqp_customer">
											<button type="submit" class="w-100 primary-btn" name="login" value="login">Submit</button>
										</form>
										<small class="d-block p-4 pt-2 text-center">
										Don't have an account? <a href="<?= SITEURL; ?>gwp-customer-sign-up/" class="reg-text">Register Now</a>
										</small>
									</div>
								</div>
		  				</div>

							<a class="btn dropdown-toggle primary-btn gqp-customer-login-btn" id="dealerloginDropdown-mobile" style="margin:5px" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? 'style="display: none;"' : ''); ?>><i class="fa-solid fa-user me-1"></i> GQP Dealer Sign-In <i class="fa-solid fa-angle-down ms-1"></i></a>
		     
              <div class="login-form shadow-lg p-0 dropdown-menu dropdown-menu-end border-0 rounded-0 dealerloginDropdown-mobile-modal" aria-labelledby="dealerloginDropdown-mobile">
								<div class="tab-content p-4 pb-2" id="myTabContent">
									<div class="tab-pane fade show active" id="dealerlogin" role="tabpanel" aria-labelledby="dealerlogin-tab">
										<form class="header-login mb-2">
											<p class="mb-3"><strong>GQP Dealer Sign in</strong></p>
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
		
		   				<a class="btn dropdown-toggle primary-btn gqp-customer-login-btn" style="margin:5px" id="loginDropdown-mobile" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" <?= (isset($_SESSION['user']) && isset($_SESSION['token']) && isset($_SESSION['firstName']) ? 'style="display: none;"' : ''); ?>><i class="fa-solid fa-user me-1"></i> VIP Customer Sign-In <i class="fa-solid fa-angle-down ms-1"></i></a>

						  <div class="login-form shadow-lg p-0 dropdown-menu dropdown-menu-end border-0 rounded-0 loginDropdown-mobile" aria-labelledby="loginDropdown-mobile">
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
										Don't have an account? <a href="<?= SITEURL; ?>gqp-vip-exclusive-membership/" class="reg-text">Register Now</a>
										</small>
									</div>
								</div>
						  </div>
						<?php } ?>
          </div>
        </div>
			</div>
			<div class="et_pb_with_background et_section_regular navbar navbar-expand-lg search-engine-section-header" id="search-engine-section-header">
				<div class="container container justify-content-center">
					<div class="et_pb_column et_pb_column_4_4 et_pb_column_5_tb_header	et_pb_css_mix_blend_mode_passthrough et-last-child mb-0">
						<div class="et_pb_module et_pb_code et_pb_code_0_tb_header mb-0">
							<div class="et_pb_code_inner">
								<?php if ($page_name == 'home') { ?>
									<div class="search-bar mb-2 mb-sm-0">
	                	<div class="row mobile_search_bar">
											<div class="col-lg-6 mb-lg-0 mb-md-3 d-md-flex align-items-center justify-content-center two_type_filter">
												<div class="or-text" style="min-width: 95px;">Select One:</div>
												<form action="" method="get" class="search-engine-1" id="search-engine-1">
													<div class="row funkyradio justify-content-md-start justify-content-center mx-0">
														<div class="col-lg-6 col-auto d-flex funkyradio-default first-search-btn">
															<input type="radio" class="btn-check search-filter <?= ($page_name == 'heavy_duty_parts' ? '' : 'active'); ?>" name="search_by" id="by_machine" autocomplete="off" <?= ($page_name == 'heavy_duty_parts' ? '' : 'checked'); ?>>
															<label class="btn search-btn" for="by_machine">Parts By Machine</label>
														</div>
														<div class="col-lg-6 col-auto d-flex funkyradio-default second-search-btn">
															<input type="radio" class="btn-check search-filter <?= ($page_name == 'heavy_duty_parts' ? 'active' : ''); ?>" name="search_by" id="by_component" autocomplete="off" <?= ($page_name == 'heavy_duty_parts' ? 'checked' : ''); ?>>
															<label class="btn search-btn" for="by_component">Parts By Engine</label>
														</div>
													</div>
												</form>
											</div>
											<div class="col-lg-6 mb-lg-0 d-md-flex align-items-center search-parts justify-content-center">
												<div class="or-text me-3 hide-in-mobile">OR</div>
	                    	<div class="position-relative me-md-3 main-search">
	                				<form action="<?= SITEURL; ?>advance-search/" method="get" class="advance-search w-100" id="advance-search">
		                    		<input type="search" name="keyword" class="form-control header-search-input" id="keyword" placeholder="Search Part#, Arrangement#, Model" value="<?= (isset($_GET['keyword']) && $_GET['keyword'] != '' ? $_GET['keyword'] : '' ); ?>">
		                    		<button type="submit" class="src-btn" id=advance_search_submit><i class="fa fa-search"></i></button>
	                				</form>
	                    	</div>
	                    	<a href="https://aicamera.globalwholesaleparts.com/" class="primary-btn" id="ai-camera" target="_blank" style=""><i class="fa fa-camera"></i></a>
	                    	<a href="<?= SITEURL; ?>#get-a-quote" class="primary-btn get-a-quote-header-btn">GET A FREE QUOTE</a>
	                    	<a href="<?= SITEURL; ?>#get-a-quote" class="primary-btn get-a-quote-header-btn-mobile">GET A FREE QUOTE</a>
	                    	<div class="mobile_filter_header_search" id="mobile_filter_header">
	                    			<i class="fa-solid fa-filter" style="font-size: 20px;color: #bd2939;"></i>
	                    	</div>
											</div>
										</div>
	                </div>
	                <div class="parts_by_machine_component mt-0">
		                <div class="mb-2 mb-sm-0 parts-by-machine">
											<div class="row mx-0">
												<div class="col-md-12">
													<form action="" method="get" class="search-engine-2 w-100" id="search-engine-2">
														<div class="row justify-content-center">
															<div class="col-md-2 search-dropdowns" id="machine_type-section">
																<input type="search" name="machine_type" class="form-control form-select" id="machine_type" placeholder="Machine Type" value="<?= (isset($_GET['machine_type']) && $_GET['machine_type'] != '' ? $_GET['machine_type'] : '' ); ?>">
															</div>
															<div class="col-md-1 search-dropdowns" id="machine_make-section">
																<input type="search" name="machine_make" class="form-control form-select" id="machine_make" placeholder="Machine Make" value="<?= (isset($_GET['machine_make']) && $_GET['machine_make'] != '' ? $_GET['machine_make'] : '' ); ?>" disabled>
															</div>
															<div class="col-md-1 search-dropdowns" id="machine_model-section">
																<input type="search" name="machine_model" class="form-control form-select" id="machine_model" placeholder="Machine Model" value="<?= (isset($_GET['machine_model']) && $_GET['machine_model'] != '' ? $_GET['machine_model'] : '' ); ?>" disabled>
															</div>
															<div class="col-md-3 search-dropdowns" id="systems_component_groups-section">
																<input type="search" name="systems_component_groups" class="form-control form-select" id="systems_component_groups" placeholder="Systems & Component Groups" value="<?= (isset($_GET['systems_component_groups']) && $_GET['systems_component_groups'] != '' ? $_GET['systems_component_groups'] : '' ); ?>" disabled>
															</div>
															<div class="col-md-3 search-dropdowns" id="component_model_series_arrangement-section">
																<input type="search" name="component_model_series_arrangement" class="form-control form-select" id="component_model_series_arrangement" placeholder="Model / Arrangement #" value="<?= (isset($_GET['component_model_series_arrangement']) && $_GET['component_model_series_arrangement'] != '' ? $_GET['component_model_series_arrangement'] : '' ); ?>" disabled>
															</div>
															<div class="col-md-2 search-dropdowns" id="product_type-section">
																<input type="search" name="product_type" class="form-control form-select" id="product_type" placeholder="Part / Product Type" value="<?= (isset($_GET['product_type']) && $_GET['product_type'] != '' ? $_GET['product_type'] : '' ); ?>" disabled>
															</div>
														</div>
													</form>
												</div>
											</div>
		                </div>
		                <div class="mb-2 mb-sm-0 parts-by-component" style="display: none;">
		                	<div class="row">
												<div class="col-md-12">
													<form action="" method="get" class="search-engine-2 w-100" id="search-engine-3">
														<div class="row justify-content-center">
															<div class="col-md-1 search-dropdowns" id="component_make-section">
																<input type="search" name="component_make_comp" class="form-control form-select" id="component_make_comp" placeholder="Component Make" value="<?= (isset($_GET['component_make_comp']) && $_GET['component_make_comp'] != '' ? $_GET['component_make_comp'] : '' ); ?>" disabled>
															</div>
															<div class="col-md-1 search-dropdowns" id="component_type-section">
																<input type="search" name="component_type_comp" class="form-control form-select" id="component_type_comp" placeholder=" Engine or Component Type" value="<?= (isset($_GET['component_type_comp']) && $_GET['component_type_comp'] != '' ? $_GET['component_type_comp'] : '' ); ?>">
															</div>
															<div class="col-md-1 search-dropdowns" id="component_model-section">
																<input type="search" name="component_model_comp" class="form-control form-select" id="component_model_comp" placeholder="Component Model" value="<?= (isset($_GET['component_model_comp']) && $_GET['component_model_comp'] != '' ? $_GET['component_model_comp'] : '' ); ?>" disabled>
															</div>
															<div class="col-md-3 search-dropdowns" id="systems_component_groups_comp-section">
																<input type="search" name="systems_component_groups_comp" class="form-control form-select" id="systems_component_groups_comp" placeholder="Systems & Component Groups" value="<?= (isset($_GET['systems_component_groups_comp']) && $_GET['systems_component_groups_comp'] != '' ? $_GET['systems_component_groups_comp'] : '' ); ?>" disabled>
															</div>
															<div class="col-md-2 search-dropdowns" id="component_model_series_arrangement_comp-section">
																<input type="search" name="component_model_series_arrangement_comp" class="form-control form-select" id="component_model_series_arrangement_comp" placeholder="Model / Arrangement #" value="<?= (isset($_GET['component_model_series_arrangement_comp']) && $_GET['component_model_series_arrangement_comp'] != '' ? $_GET['component_model_series_arrangement_comp'] : '' ); ?>" disabled>
															</div>
															<div class="col-md-1 search-dropdowns" id="product_type_comp-section">
																<input type="search" name="product_type_comp" class="form-control form-select" id="product_type_comp" placeholder="Part / Product Type" value="<?= (isset($_GET['product_type_comp']) && $_GET['product_type_comp'] != '' ? $_GET['product_type_comp'] : '' ); ?>" disabled>
															</div>
														</div>
													</form>
												</div>
											</div>
		                </div>
	              	</div>
	              <?php }else{ ?>
	              	<div class="search-bar mb-2 mb-sm-0">
	                	<div class="row mobile_search_bar">
											<div class="col-lg-12 mb-lg-0 d-md-flex align-items-center search-parts justify-content-center">
	                    	<div class="position-relative me-md-3 main-search">
	                				<form action="<?= SITEURL; ?>advance-search/" method="get" class="advance-search w-100" id="advance-search">
		                    		<input type="search" name="keyword" class="form-control header-search-input" id="keyword" placeholder="Search Part#, Arrangement#, Model" value="<?= (isset($_GET['keyword']) && $_GET['keyword'] != '' ? $_GET['keyword'] : '' ); ?>">
		                    		<button type="submit" class="src-btn" id=advance_search_submit><i class="fa fa-search"></i></button>
	                				</form>
	                    	</div>
	                    	<a href="https://aicamera.globalwholesaleparts.com/" class="primary-btn" id="ai-camera" target="_blank" style=""><i class="fa fa-camera"></i></a>
	                    	<a href="<?= SITEURL; ?>#get-a-quote" class="primary-btn get-a-quote-header-btn">GET A FREE QUOTE</a>
	                    	<a href="<?= SITEURL; ?>#get-a-quote" class="primary-btn get-a-quote-header-btn-mobile">GET A FREE QUOTE</a>
											</div>
										</div>
	                </div>
	              <?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="et_pb_with_background et_section_regular navbar navbar-expand-lg navbar-light bg-light">
				<div class="container container justify-content-center">
					<div class="et_pb_column et_pb_column_4_4 et_pb_column_5_tb_header	et_pb_css_mix_blend_mode_passthrough et-last-child mb-0 zindex_menu">
						<div class="et_pb_module et_pb_code et_pb_code_0_tb_header mb-0">
							<div class="et_pb_code_inner">
								<div class="mobile_phone_header">
	              	<a href="tel:+1(780) 670-2010" class="btn primary-btn"><i class="fa-solid fa-phone"></i></a>
	              </div>
	              <div class="mobile_email_header">
	              	<a href="mailto:parts@globalwholesaleparts.com" class="btn primary-btn"><i class="fa-solid fa-envelope"></i></a>
	              </div>
								<button class="ubermenu-responsive-toggle inventory_menu_icon ubermenu-responsive-toggle-main ubermenu-skin-grey-white ubermenu-loc- ubermenu-responsive-toggle-content-align-left ubermenu-responsive-toggle-align-full justify-content-center align-items-center text-center" tabindex="0" data-ubermenu-target="ubermenu-main-17">
									<svg class="svg-inline--fa fa-bars fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
										<path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path>
									</svg> <span>Menu</span>
								</button>
								<nav id="ubermenu-main-17" class="ubermenu ubermenu-main ubermenu-menu-17 ubermenu-responsive ubermenu-responsive-single-column ubermenu-responsive-single-column-subs ubermenu-responsive-default ubermenu-mobile-accordion ubermenu-responsive-collapse ubermenu-horizontal ubermenu-transition-shift ubermenu-trigger-hover ubermenu-skin-grey-white ubermenu-bar-align-full ubermenu-items-align-auto ubermenu-bound ubermenu-disable-submenu-scroll ubermenu-sub-indicators ubermenu-retractors-responsive ubermenu-submenu-indicator-closes ubermenu-notouch ubermenu-desktop-view">
									<ul id="ubermenu-nav-main-17" class="ubermenu-nav" data-title="Main Menu">
										<li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-1787 ubermenu-item-level-0 ubermenu-column ubermenu-column-natural ubermenu-has-submenu-drop ubermenu-has-submenu-mega b">
										  <a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only ubermenu-noindicator" tabindex="0">
										    <i class="fa-solid fa-bars me-2"></i><span class="ubermenu-target-title ubermenu-target-text">Shop</span>
										    <i class="ubermenu-sub-indicator fas fa-angle-down shop-indicators"></i>
										  </a>
										  <ul class="ubermenu-submenu ubermenu-submenu-id-7 ubermenu-submenu-type-auto ubermenu-submenu-type-mega ubermenu-submenu-drop ubermenu-submenu-align-full_width hd-menu" aria-hidden="true" aria-expanded="false">
										    <li id="menu-item-185" class="ubermenu-item ubermenu-tabs ubermenu-item-185 ubermenu-item-level-1 ubermenu-column ubermenu-column-full ubermenu-tab-layout-left ubermenu-tabs-show-default ubermenu-tabs-show-current">
										      <ul class="ubermenu-tabs-group ubermenu-tabs-group--trigger-mouseover ubermenu-column ubermenu-column-1-5 ubermenu-submenu ubermenu-submenu-id-185 ubermenu-submenu-type-auto ubermenu-submenu-type-tabs-group" style="min-height: 325.938px;">
										        <li id="menu-item-183" class="ubermenu-tab ubermenu-item ubermenu-item-type-taxonomy ubermenu-item-object-menu-cats ubermenu-item-has-children ubermenu-item-183 ubermenu-item-auto ubermenu-column ubermenu-column-full ubermenu-has-submenu-drop" data-ubermenu-trigger="mouseover">
										          <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" aria-expanded="false">
										            <span class="ubermenu-target-title ubermenu-target-text">HD Engine Parts</span>
										            <i class="ubermenu-sub-indicator fas fa-angle-left"></i>
										            <i class="ubermenu-sub-indicator fas fa-angle-down shop-indicators"></i>
										          </a>
										          <ul class="ubermenu-tab-content-panel ubermenu-column ubermenu-column-4-5 ubermenu-submenu ubermenu-submenu-id-183 ubermenu-submenu-type-tab-content-panel ubermenu-submenu-bkg-img" aria-hidden="true" style="min-height: 325.938px;" aria-expanded="false">
										            <li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-250 ubermenu-item-auto ubermenu-item-header ubermenu-item-level-5 ubermenu-column ubermenu-column-1-3 ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788">
										              <ul class="ubermenu-submenu ubermenu-submenu-id-189 ubermenu-submenu-type-auto ubermenu-submenu-type-stack">
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-engine-rebuild-kits/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Engine Rebuild Kits</span>
										                  </a>
										                </li>
										                <li id="menu-item-198" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-198 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-long-block-parts/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Long Block</span>
										                  </a>
										                </li>
										                <li id="menu-item-197" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-197 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-short-block-parts/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Short Block</span>
										                  </a>
										                </li>
										                <li id="menu-item-196" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-196 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-turbocharger-parts/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Turbocharger</span>
										                  </a>
										                </li>
										                <li id="menu-item-196" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-196 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-injector-parts/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Injectors</span>
										                  </a>
										                </li>
										              </ul>
										            </li>
										            <li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-250 ubermenu-item-auto ubermenu-item-header ubermenu-item-level-5 ubermenu-column ubermenu-column-1-3 ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788">
										              <ul class="ubermenu-submenu ubermenu-submenu-id-189 ubermenu-submenu-type-auto ubermenu-submenu-type-stack">
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-filters/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Filters</span>
										                  </a>
										                </li>
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-cylinder-head-parts/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Cylinder Heads</span>
										                  </a>
										                </li>
										                <li id="menu-item-198" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-198 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-crankshaft-parts/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Crankshaft</span>
										                  </a>
										                </li>
										                <li id="menu-item-198" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-198 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-batteries/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Batteries</span>
										                  </a>
										                </li>
										                <li id="menu-item-197" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-197 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-camshaft-parts/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Camshaft</span>
										                  </a>
										                </li>
										              </ul>
										            </li>
										            <li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-250 ubermenu-item-auto ubermenu-item-header ubermenu-item-level-5 ubermenu-column ubermenu-column-1-3 ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788">
										              <ul class="ubermenu-submenu ubermenu-submenu-id-189 ubermenu-submenu-type-auto ubermenu-submenu-type-stack">
										                <li id="menu-item-196" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-196 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-connecting-rod-parts/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Connecting Rod</span>
										                  </a>
										                </li>
										                <li id="menu-item-196" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-196 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-ac-parts-ac-compressor/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty AC Compressors & Parts</span>
										                  </a>
										                </li>
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-electrical-parts/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Electrical parts</span>
										                  </a>
										                </li>
										                <li id="menu-item-198" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-198 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left last" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-slewing-rings/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Excavator Slewing Rings</span>
										                  </a>
										                </li>
										              </ul>
										            </li>
										          </ul>
										        </li>
										        <li id="menu-item-183" class="ubermenu-tab ubermenu-item ubermenu-item-type-taxonomy ubermenu-item-object-menu-cats ubermenu-item-has-children ubermenu-item-183 ubermenu-item-auto ubermenu-column ubermenu-column-full ubermenu-has-submenu-drop" data-ubermenu-trigger="mouseover">
										          <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/" aria-expanded="false">
										            <span class="ubermenu-target-title ubermenu-target-text">HD Component Reman</span>
										            <i class="ubermenu-sub-indicator fas fa-angle-left"></i>
										            <i class="ubermenu-sub-indicator fas fa-angle-down shop-indicators"></i>
										          </a>
										          <ul class="ubermenu-tab-content-panel ubermenu-column ubermenu-column-4-5 ubermenu-submenu ubermenu-submenu-id-183 ubermenu-submenu-type-tab-content-panel ubermenu-submenu-bkg-img" aria-hidden="true" style="min-height: 325.938px;" aria-expanded="false">
										          	<li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-250 ubermenu-item-auto ubermenu-item-header ubermenu-item-level-5 ubermenu-column ubermenu-column-1 ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788 shop-menu-inner-title">
										              <ul class="ubermenu-submenu ubermenu-submenu-id-189 ubermenu-submenu-type-auto ubermenu-submenu-type-stack">
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/">
										                  <span class="ubermenu-target-title ubermenu-target-text">Heavy Duty Component Reman</span>
										                  </a>
										                </li>
										              </ul>
										            </li>
										            <li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-250 ubermenu-item-auto ubermenu-item-header ubermenu-item-level-5 ubermenu-column ubermenu-column-1-3 ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788">
										              <ul class="ubermenu-submenu ubermenu-submenu-id-189 ubermenu-submenu-type-auto ubermenu-submenu-type-stack">
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/differential-rebuild-services/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Differential Rebuild Services</span>
										                  </a>
										                </li>
										                <li id="menu-item-198" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-198 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/hydraulic-pumps-rebuild-services/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Hydraulic Pumps Rebuild Services</span>
										                  </a>
										                </li>
										                <li id="menu-item-197" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-197 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/undercarriage-rebuild-services/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Undercarriage Rebuild Services</span>
										                  </a>
										                </li>
										              </ul>
										            </li>
										            <li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-250 ubermenu-item-auto ubermenu-item-header ubermenu-item-level-5 ubermenu-column ubermenu-column-1-3 ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788">
										              <ul class="ubermenu-submenu ubermenu-submenu-id-189 ubermenu-submenu-type-auto ubermenu-submenu-type-stack">
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/engine-rebuild-services/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Engine Rebuild Services</span>
										                  </a>
										                </li>
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/final-drive-rebuild-services/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Final Drive Rebuild Services</span>
										                  </a>
										                </li>
										                <li id="menu-item-198" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-198 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/torque-converter-rebuild-services/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Torque Converter Rebuild Services</span>
										                  </a>
										                </li>
										              </ul>
										            </li>
										            <li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-250 ubermenu-item-auto ubermenu-item-header ubermenu-item-level-5 ubermenu-column ubermenu-column-1-3 ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788">
										              <ul class="ubermenu-submenu ubermenu-submenu-id-189 ubermenu-submenu-type-auto ubermenu-submenu-type-stack">
										                <li id="menu-item-196" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-196 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/transmission-rebuild-services/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Transmission Rebuild Services</span>
										                  </a>
										                </li>
										                <li id="menu-item-196" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-196 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/swing-motors-rebuild-services/">
										                  <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
										                  <span class="ubermenu-target-title ubermenu-target-text">Swing Motors Rebuild Services</span>
										                  </a>
										                </li>
										              </ul>
										            </li>
										          </ul>
										        </li>
										        <li id="menu-item-183" class="ubermenu-tab ubermenu-item ubermenu-item-type-taxonomy ubermenu-item-object-menu-cats ubermenu-item-has-children ubermenu-item-183 ubermenu-item-auto ubermenu-column ubermenu-column-full ubermenu-has-submenu-drop" data-ubermenu-trigger="mouseover">
										          <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-undercarriage-parts/" aria-expanded="false">
										            <span class="ubermenu-target-title ubermenu-target-text">GQP Undercarriage</span>
										            <i class="ubermenu-sub-indicator fas fa-angle-down shop-indicators"></i>
										          </a>
										          <ul class="ubermenu-tab-content-panel ubermenu-column ubermenu-column-4-5 ubermenu-submenu ubermenu-submenu-id-183 ubermenu-submenu-type-tab-content-panel ubermenu-submenu-bkg-img" aria-hidden="true" style="min-height: 325.938px;" aria-expanded="false">
										          	<li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-250 ubermenu-item-auto ubermenu-item-header ubermenu-item-level-5 ubermenu-column ubermenu-column-1 ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788 shop-menu-inner-title-display">
										              <ul class="ubermenu-submenu ubermenu-submenu-id-189 ubermenu-submenu-type-auto ubermenu-submenu-type-stack">
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-undercarriage-parts/">
										                  <span class="ubermenu-target-title ubermenu-target-text">GQP Undercarriage</span>
										                  </a>
										                </li>
										              </ul>
										            </li>
										          </ul>
										        </li>
										        <li id="menu-item-183" class="ubermenu-tab ubermenu-item ubermenu-item-type-taxonomy ubermenu-item-object-menu-cats ubermenu-item-has-children ubermenu-item-183 ubermenu-item-auto ubermenu-column ubermenu-column-full ubermenu-has-submenu-drop" data-ubermenu-trigger="mouseover">
										          <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-ground-engaging-tools/" aria-expanded="false">
										            <span class="ubermenu-target-title ubermenu-target-text">GET / Wear Parts</span>
										            <i class="ubermenu-sub-indicator fas fa-angle-down shop-indicators"></i>
										          </a>
										          <ul class="ubermenu-tab-content-panel ubermenu-column ubermenu-column-4-5 ubermenu-submenu ubermenu-submenu-id-183 ubermenu-submenu-type-tab-content-panel ubermenu-submenu-bkg-img" aria-hidden="true" style="min-height: 325.938px;" aria-expanded="false">
										          	<li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-250 ubermenu-item-auto ubermenu-item-header ubermenu-item-level-5 ubermenu-column ubermenu-column-1 ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788 shop-menu-inner-title-display">
										              <ul class="ubermenu-submenu ubermenu-submenu-id-189 ubermenu-submenu-type-auto ubermenu-submenu-type-stack">
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-ground-engaging-tools/">
										                  <span class="ubermenu-target-title ubermenu-target-text">GET / Wear Parts</span>
										                  </a>
										                </li>
										              </ul>
										            </li>
										          </ul>
										        </li>
										        <li id="menu-item-183" class="ubermenu-tab ubermenu-item ubermenu-item-type-taxonomy ubermenu-item-object-menu-cats ubermenu-item-has-children ubermenu-item-183 ubermenu-item-auto ubermenu-column ubermenu-column-full ubermenu-has-submenu-drop" data-ubermenu-trigger="mouseover">
										          <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="https://globalwholesaletires.com/" aria-expanded="false" target="_blank">
										            <span class="ubermenu-target-title ubermenu-target-text">Tires</span>
										            <i class="ubermenu-sub-indicator fas fa-angle-down shop-indicators"></i>
										          </a>
										          <ul class="ubermenu-tab-content-panel ubermenu-column ubermenu-column-4-5 ubermenu-submenu ubermenu-submenu-id-183 ubermenu-submenu-type-tab-content-panel ubermenu-submenu-bkg-img" aria-hidden="true" style="min-height: 325.938px;" aria-expanded="false">
										          	<li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-250 ubermenu-item-auto ubermenu-item-header ubermenu-item-level-5 ubermenu-column ubermenu-column-1 ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788 shop-menu-inner-title-display">
										              <ul class="ubermenu-submenu ubermenu-submenu-id-189 ubermenu-submenu-type-auto ubermenu-submenu-type-stack">
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="https://globalwholesaletires.com/" target="_blank">
										                  <span class="ubermenu-target-title ubermenu-target-text">Tires</span>
										                  </a>
										                </li>
										              </ul>
										            </li>
										          </ul>
										        </li>
										        <li id="menu-item-183" class="ubermenu-tab ubermenu-item ubermenu-item-type-taxonomy ubermenu-item-object-menu-cats ubermenu-item-has-children ubermenu-item-183 ubermenu-item-auto ubermenu-column ubermenu-column-full ubermenu-has-submenu-drop" data-ubermenu-trigger="mouseover">
										          <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-attachments/" aria-expanded="false">
										            <span class="ubermenu-target-title ubermenu-target-text">Attachments</span>
										            <i class="ubermenu-sub-indicator fas fa-angle-down shop-indicators"></i>
										          </a>
										          <ul class="ubermenu-tab-content-panel ubermenu-column ubermenu-column-4-5 ubermenu-submenu ubermenu-submenu-id-183 ubermenu-submenu-type-tab-content-panel ubermenu-submenu-bkg-img" aria-hidden="true" style="min-height: 325.938px;" aria-expanded="false">
										          	<li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-250 ubermenu-item-auto ubermenu-item-header ubermenu-item-level-5 ubermenu-column ubermenu-column-1 ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788 shop-menu-inner-title-display">
										              <ul class="ubermenu-submenu ubermenu-submenu-id-189 ubermenu-submenu-type-auto ubermenu-submenu-type-stack">
										                <li id="menu-item-199" class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-mega-menu ubermenu-item-199 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-9 ubermenu-column ubermenu-column-auto">
										                  <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-attachments/">
										                  <span class="ubermenu-target-title ubermenu-target-text">Attachments</span>
										                  </a>
										                </li>
										              </ul>
										            </li>
										          </ul>
										        </li>
										      </ul>
										    </li>
										  </ul>
										</li>
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text"><i class="fa-solid fa-house"></i></span>
											</a>
										</li>
										<li class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-1787 ubermenu-item-level-0 ubermenu-column ubermenu-column-natural ubermenu-has-submenu-drop ubermenu-has-submenu-mega">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" tabindex="0">
												<span class="ubermenu-target-title ubermenu-target-text">Engine Parts</span>
												<i class="ubermenu-sub-indicator fas fa-angle-down"></i>
											</a>
											<ul class="ubermenu-submenu ubermenu-submenu-id-1787 ubermenu-submenu-type-mega ubermenu-submenu-drop ubermenu-submenu-align-full_width hd-menu">
												<li class="	ubermenu-item ubermenu-item-type-custom ubermenu-item-object-ubermenu-custom ubermenu-item-has-children ubermenu-item-1788 ubermenu-item-level-1 ubermenu-column ubermenu-column-1-4 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-1788">
													<ul class="ubermenu-submenu ubermenu-submenu-id-1788 ubermenu-submenu-type-stack">
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-569 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-engine-rebuild-kits/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Engine Rebuild Kits</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-569 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-long-block-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Long Block</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-569 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-short-block-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Short Block</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-580 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-turbocharger-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Turbocharger</span>
															</a>
														</li>
													</ul>
												</li>
												<li class="	ubermenu-item ubermenu-item-type-custom ubermenu-item-object-ubermenu-custom ubermenu-item-has-children ubermenu-item-498 ubermenu-item-level-1 ubermenu-column ubermenu-column-1-4 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-498">
													<ul class="ubermenu-submenu ubermenu-submenu-id-498 ubermenu-submenu-type-stack">
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
													</ul>
												</li>
												<li class="	ubermenu-item ubermenu-item-type-custom ubermenu-item-object-ubermenu-custom ubermenu-item-has-children ubermenu-item-499 ubermenu-item-level-1 ubermenu-column ubermenu-column-1-4 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-499">
													<ul class="ubermenu-submenu ubermenu-submenu-id-499 ubermenu-submenu-type-stack">
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-580 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-batteries/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Batteries</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-581 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-camshaft-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Camshaft</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-580 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-connecting-rod-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Connecting Rod</span>
															</a>
														</li>
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-564 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-ac-parts-ac-compressor/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD AC Compressors & Parts</span>
															</a>
														</li>
													</ul>
												</li>
												<li class="	ubermenu-item ubermenu-item-type-custom ubermenu-item-object-ubermenu-custom ubermenu-item-has-children ubermenu-item-583 ubermenu-item-level-1 ubermenu-column ubermenu-column-1-4 ubermenu-has-submenu-stack ubermenu-item-type-column ubermenu-column-id-583">
													<ul class="ubermenu-submenu ubermenu-submenu-id-583 ubermenu-submenu-type-stack">
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-568 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-electrical-parts/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Electrical parts</span>
															</a>
														</li>
														<!-- <li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-573 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-seats/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">HD Seats</span>
															</a>
														</li> -->
														<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-product ubermenu-item-575 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-2 ubermenu-column ubermenu-column-auto">
															<a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left last" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-slewing-rings/">
																<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
																<span class="ubermenu-target-title ubermenu-target-text">Excavator Slewing Rings</span>
															</a>
														</li>
													</ul>
												</li>
											</ul>
										</li>
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-drop ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>component-rebuild-services/" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">Component Reman</span>
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
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>component-rebuild-services/swing-motors-rebuild-services/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Swing Motors Rebuild Services</span>
											    </a>
											  </li>
											</ul>
										</li>
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-drop ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="javascript:void(0);" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">GQP Fleet Solutions</span>
											  <i class="ubermenu-sub-indicator fas fa-angle-down"></i>
											</a>
											<ul class="ubermenu-submenu ubermenu-submenu-id-29 ubermenu-submenu-type-flyout ubermenu-submenu-drop ubermenu-submenu-align-left_edge_item ubermenu-top-bottom-padding hierarchy-menu-main-section" aria-hidden="true" >
											  <li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-1 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-drop ubermenu-has-submenu-flyout">
													<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only ubermenu-item-layout-icon_left" href="javascript:void(0);" tabindex="0">
														<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
													  <span class="ubermenu-target-title ubermenu-target-text">GQP</span>
													  <i class="ubermenu-sub-indicator fas fa-angle-right ms-2"></i>
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
												<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-1 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-flyout">
													<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>gqp-vip-fleet-solutions/" tabindex="0">
														<i class="ubermenu-sub-indicator fas fa-angle-right"></i>
													  <span class="ubermenu-target-title ubermenu-target-text">GQP VIP FLEET SOLUTIONS</span>
													</a>
												</li>
											</ul>
										</li>
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>heavy-duty-parts-for-sale/heavy-duty-undercarriage-parts/" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">Undercarriage</span>
											</a>
										</li>
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-drop ubermenu-has-submenu-flyout">
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>about-us/" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text">About us</span>
											  <i class="ubermenu-sub-indicator fas fa-angle-down"></i>
											</a>
											<ul class="ubermenu-submenu ubermenu-submenu-id-29 ubermenu-submenu-type-flyout ubermenu-submenu-drop ubermenu-submenu-align-left_edge_item ubermenu-top-bottom-padding" aria-hidden="true">
												<li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>blogs/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Blogs</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>about-us/brochures/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Brochures</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>about-us/warranties/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Warranty</span>
											    </a>
											  </li>
											  <li id="menu-item-399" class="ubermenu-item ubermenu-item-type-custom ubermenu-item-object-custom ubermenu-item-has-children ubermenu-item-399 ubermenu-item-auto ubermenu-item-normal ubermenu-item-level-1 ubermenu-has-submenu-flyout">
											    <a class="ubermenu-target ubermenu-target-with-icon ubermenu-item-layout-default ubermenu-item-layout-icon_left" href="<?= SITEURL; ?>gwp-customer-sign-up/" aria-expanded="false">
											      <i class="ubermenu-sub-indicator fas fa-angle-right"></i>
											      <span class="ubermenu-target-title ubermenu-target-text">Become a Member</span>
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
										<?php if (isset($user_id) && ($user_id == 1 || $user_id == 213 || $user_id == 23261)) { ?>
											<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-flyout">
												<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>inventory/" tabindex="0">
												  <span class="ubermenu-target-title ubermenu-target-text">Inventory</span>
												</a>
											</li>
										<?php } ?>
										<li class="ubermenu-item ubermenu-item-type-post_type ubermenu-item-object-page ubermenu-item-has-children ubermenu-item-29 ubermenu-item-level-0 ubermenu-column ubermenu-column-auto ubermenu-has-submenu-flyout header-cart header-icons">
											<?php $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
											<a class="ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only" href="<?= SITEURL; ?>cart/" tabindex="0">
											  <span class="ubermenu-target-title ubermenu-target-text"><i class="fa-solid fa-cart-shopping"></i><span class="cart-counter"><?= $num_items_in_cart; ?></span></span>
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
	const filterButton = document.getElementById('mobile_filter_header');
	const filterBox = document.getElementById('search-engine-section-header');

	// Add click event listener to toggle the class
	filterButton.addEventListener('click', () => {
	  filterBox.classList.toggle('mobile_filter_header_search_active');
	});
</script>