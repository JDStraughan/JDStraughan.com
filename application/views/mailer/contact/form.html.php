<p>New Contact Us Submission:</p>

<p>
	<strong>Name: </strong><?=  HTML::chars($form['name']); ?><br />
	<strong>Email: </strong><?= HTML::chars($form['email']); ?><br />
	<strong>Phone: </strong><?= HTML::email($form['phone']); ?><br />
	<strong>Message: </strong><br /><?= nl2br(HTML::chars($form['content'])); ?>
</p>
<br />
<p>Thanks!</p>
<p>TheZimCo.com</p>