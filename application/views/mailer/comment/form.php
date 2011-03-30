<p>New Comment:</p>

	<p><strong>Name: </strong><?=  HTML::chars($form['name']); ?></p>
	<p><strong>Email: </strong><?= HTML::email($form['email']); ?></p>
	<p><strong>Post: </strong><?= HTML::chars($form['post']); ?></p>
	<p><strong>Message: </strong><?= nl2br(HTML::chars($form['comment'])); ?></p>
	
<p>To approve this comment visit: <?= $form['approve']; ?></p>