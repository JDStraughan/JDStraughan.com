<p>New Contact Us Submission:</p>

<p>
	<strong>Name: </strong><?=  HTML::chars($contact->name); ?><br />
	<strong>Email: </strong><?= HTML::chars($contact->email); ?><br />
	<strong>Phone: </strong><?= HTML::email($contact->phone); ?><br />
	<strong>Message: </strong><br /><?= nl2br(HTML::chars($contact->content)); ?>
</p>