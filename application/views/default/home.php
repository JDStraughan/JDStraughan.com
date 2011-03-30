<div id="summaries">
	<?php foreach ($posts as $post) : ?>
		<h1><?= $post->title; ?></h1>
		<? $comments = count($post->comments->where('approved', '=', '1')->find_all()); ?>
		<p class="date"><?= Date::fuzzy_span($post->date_published); ?> | <?= $comments; ?> Comment<?= $comments == 1 ? '' : 's'; ?></p>
		<p><?= nl2br($post->summary); ?></p>
		<?= HTML::anchor("post/{$post->slug}", '[read more]', array('class' => 'readmore')); ?>
	<?php endforeach; ?>
</div>