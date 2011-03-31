<? if ($page) : ?>
	<h1><?= $page->title; ?></h1>
	<?= $page->content; ?>
<br />
<? endif; ?>
<?php if ($form_error): ?>
	<?php foreach ($form_error as $error): ?>
		<div class="message" style="clear: both;">
			<div class="alert"><span class="alert_icon"></span><?= $error; ?></div>
			<?= HTML::errors($errors); ?>	
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<?= Form::open(); ?>
<?= Form::generate($contact, $fields); ?>
<?= Form::submit('contact', 'Send Message'); ?>
<?= Form::close(); ?>