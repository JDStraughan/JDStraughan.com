<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
<meta name="description" content="<?= $description; ?>" /> 
<meta name="author" content="JDStraughan" /> 
<meta name="copyright" content="Copyright 2010. JDStraughan.com" />
<meta name="language" content="en-us" />
<link href="<?= URL::site('rss.xml'); ?>" title="JDStraughan.com rss feed" type="application/rss+xml" rel="alternate" /> 
<?php	
	foreach ($styles as $style) 
	{
		echo HTML::style(url::base() . $style) . "\n";
	}
	
	foreach ($scripts as $script) 
	{
		echo HTML::script(url::base() . $script) . "\n";
	}
?>
<title><?= $title; ?> | <?= $site_name; ?></title> 
</head> 
<body>
	<div id="wrapper">
		<?= $header; ?>
		<div id="content-wrapper">
			
			<?php if ($messages) : ?>
			<div id="messages">
				<img src="<?= url::base() . 'media/images/info.png'; ?>" /> 
				<span class="message"><?= $messages; ?></span>
			</div>
			<?php endif; ?>
			
			<div id="content">
				<?= $content; ?>
			</div>
			<div id="right-column">
				<?= $right_column; ?>
			</div>
		</div>
		<?= $footer; ?>
	</div>
	<script src="//static.getclicky.com/js" type="text/javascript"></script>
	<script type="text/javascript">try{ clicky.init(66405120); }catch(e){}</script>
</body>
</html>