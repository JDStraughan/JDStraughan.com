<div id="summaries">
	<?php foreach ($posts as $post) : ?>
		<h1><?= HTML::anchor("post/{$post->slug}", $post->title); ?></h1>
		<? $comments = count($post->comments->where('approved', '=', '1')->find_all()); ?>
		<p class="date"><?= Date::fuzzy_span($post->date_published); ?> | <a href="<?= url::site("post/{$post->slug}#comments"); ?>" class="comments"><?= $comments; ?> Comment<?= $comments == 1 ? '' : 's'; ?></a></p>
		<p><?= nl2br($post->summary); ?></p>
		<?= HTML::anchor("post/{$post->slug}", '[read more]', array('class' => 'readmore')); ?>
	<?php endforeach; ?>
</div>