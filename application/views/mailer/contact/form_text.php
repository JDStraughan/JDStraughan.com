New Contact Us Submission:

	Name: <?=  HTML::chars($form['name']); ?>
	Email: <?= HTML::chars($form['email']); ?>
	Phone: <?= HTML::email($form['phone']); ?>
	Message: <?= nl2br(HTML::chars($form['content'])); ?>