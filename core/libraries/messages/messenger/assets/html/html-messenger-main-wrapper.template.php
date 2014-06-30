<?php
/**
 * This is the wrapper template for the html messenger
 *
 * Template Tags:
 * @type string $page_title 	The title for the page.
 * @type string $base_css 	This is the base css url for a page (should not be changed).
 * @type string $print_css 	This is the css url for print copy.
 * @type string $main_css	This is the main css file for the page.
 * @type string $main_body 	This is the content generated by the message type templates.
 *
 * @since 4.5.0
 * @package Event Espresso
 * @subpackage messages
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?php echo $page_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- Base Stylesheet do not change or remove -->
<link rel="stylesheet" type="text/css" href="<?php echo $base_css; ?>" media="screen" />
<!-- Print Style Sheet -->
<link rel="stylesheet" type="text/css" href="<?php echo $print_css; ?>" media="print" />
<!-- Primary Style Sheet -->
<link rel="stylesheet" type="text/css" href="<?php echo $main_css; ?>" />
<!-- Make sure the buttons don't print -->
<style type="text/css">
@media print{ .noPrint{display:none !important;height:0!important; width:0!important;} }
@page { width:100%!important; margin:0!important; padding:0!important; }
</style>
</head>
<body>
	<?php echo $main_body; ?>
</body>
</html>
