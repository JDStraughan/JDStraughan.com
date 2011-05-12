<h1 class="post"><?= $post->title; ?></h1>
<p class="date_published"><?= date('d M Y', $post->date_published); ?></p>
<div id="post">
	<?= $post->content; ?>
</div>
<div id="comments" class="clearfix">
	<? if (isset($comments)) : ?>
	
		<h3>Comments (<?= count($comments); ?>)</h3>
		
		<? foreach ($comments as $comment) : ?>
		<div class="comment clearfix <?= $comment->email == 'jdstraughan@gmail.com' ? 'author-comment' : ''; ?>">
			<p class="author">
				<?php $gravatar = md5(trim(strtolower($comment->email))); ?>
				<img src="http://www.gravatar.com/avatar/<?= $gravatar ?>" alt="gravatar" />
				<br /> 
				<?php if ($comment->website) : ?> 
					<?= HTML::anchor($comment->website, $comment->name); ?>
				<?php else: ?>
					<?= $comment->name; ?>
				<?php endif;?>
				<br /> 
				<span class="date_created">
					<?= Date::fuzzy_span($comment->date_created); ?>
				</span>
			</p>
			<p class="text">
				<?= nl2br($comment->text); ?>
			</p>
			
		</div>
		<? endforeach; ?>

	<? endif; ?>
	
</div>
<?php if (isset($comment_form)): ?>
	<h3>Use the form to add to the discussion!</h3>
	<p>Your email is required but will not be published or distributed in any way.</p>
	<?php if ($form_error): ?>
		<?php foreach ($form_error as $error): ?>
			<div id="comment_error" class="message ui-corner-all ui-state-error" style="clear: both;">
				<div class="alert"><span class="alert_icon"></span><?= $error; ?></div>
				<?= HTML::errors($errors); ?>	
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
	<div id="comment_form">
		<?= Form::open(); ?>
		<?= Form::generate($comment_form, $fields); ?>
		<input type="text" name="scheck" id="scheck" class="scheck" value="" autocomplete="off" />
		<?= Form::submit('comment', 'Add Comment'); ?>
		<?= Form::close(); ?>
	</div>
<?php endif; ?>