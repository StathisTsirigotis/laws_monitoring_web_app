<?php defined( '_JEXEC' ) or die( 'Restricted access' );

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" 
   xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >

	<head>
		<jdoc:include type="head" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/media/css/main.css" type="text/css" />
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/media/font-awesome-4.7.0/css/font-awesome.min.css">
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	</head>

	<body>
		<div class="laws-main-header">
			<div class="laws-main-header-inner">
					<p>Ceid Laws Monitoring!</p>
					<img src="/nomosxedia/templates/laws/media/images/law.png">
					<span class="welcome">Είσοδος</span>
			</div>
		</div>
		<jdoc:include type="component" />
		<div class="homepageWrapeer" style="display:none;">
			<?php if ( $this->countModules( 'header' )) : ?>
				<jdoc:include type="modules" name="header" />
			<?php endif; ?>
			<?php if ( $this->countModules( 'laws_table' )) : ?>
				<jdoc:include type="modules" name="laws_table" />
			<?php endif; ?>
		</div>
	</body>
	<script>
		jQuery(".welcome").click(function(){
			jQuery(".laws-main-header").css("display","none");
			jQuery(".homepageWrapeer").fadeIn(1000);
		});
	</script>
</html>