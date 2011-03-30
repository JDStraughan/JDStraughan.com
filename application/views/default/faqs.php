<h1>Frequently Asked Questions</h1>
<?php foreach ($faqs->find_all() as $faq) : ?>
<h2><?= $faq->name; ?></h2>
<p><?= nl2br($faq->value); ?></p>
<?php endforeach; ?>