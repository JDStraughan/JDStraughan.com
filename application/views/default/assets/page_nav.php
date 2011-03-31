<ul id="page-nav">
	<li><?= HTML::anchor(url::site(), 'Home'); ?></li>
	<?php foreach ($pages as $page) : ?>
		<? if ($page->slug != 'contact') : ?>
			<li><?= HTML::anchor(url::site("page/{$page->slug}"), $page->title); ?></li>
		<? endif; ?>
	<?php endforeach; ?>
	<li><?= HTML::anchor(url::site('faqs'), 'FAQ'); ?></li>
	<li><?= HTML::anchor(url::site('contact'), 'Contact'); ?></li>
</ul>