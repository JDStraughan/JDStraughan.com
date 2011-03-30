<? if ($page) : ?>
	<h1><?= $page->title; ?></h1>
	<?= $page->content; ?>
<br />
<? endif; ?>
<?php if ($form_error): ?>
	<?php foreach ($form_error as $error): ?>
		<div class="message ui-corner-all ui-state-error" style="clear: both;">
			<span class="ui-icon ui-icon-alert"></span><strong><?= $error; ?></strong>
			<br />
			<?= HTML::errors($errors); ?>	
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<?= Form::open(); ?>
<?= Form::generate($contact, $fields); ?>
<?= Form::submit('contact', 'Send Message'); ?>
<?= Form::close(); ?>