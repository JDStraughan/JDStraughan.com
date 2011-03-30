<p>New Contact Us Submission:</p>

	<p><strong>Name: </strong><?=  HTML::chars($form['name']); ?></p>
	<p><strong>Email: </strong><?= HTML::chars($form['email']); ?></p>
	<p><strong>Phone: </strong><?= HTML::email($form['phone']); ?></p>
	<p><strong>Message: </strong><?= nl2br(HTML::chars($form['content'])); ?></p>