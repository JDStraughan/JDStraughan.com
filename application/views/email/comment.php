<p>New Comment:</p>


	<p><strong>Post: </strong><?= HTML::chars($comment->post->title); ?></p>
	<br />
	<p><strong>Name: </strong><?=  HTML::chars($comment->name); ?></p>
	<p><strong>Email: </strong><?= HTML::email($comment->email); ?></p>
	<p><strong>Message: </strong><?= nl2br(HTML::chars($comment->text)); ?></p>
	
<p>To approve this comment visit: <?= url::site("comment/approve/{$comment->id}"); ?></p>