New Comment:

	Name: <?=  HTML::chars($form['name']); ?>
	Email: <?= HTML::email($form['email']); ?>
	Post: <?= HTML::chars($form['post']); ?>
	Message: <?= nl2br(HTML::chars($form['comment'])); ?>
	
To approve this comment visit: <?= $form['approve']; ?>