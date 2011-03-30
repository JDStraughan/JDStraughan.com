<?php if ($page->slug != 'home') : ?>
<h1><?= $page->title; ?></h1>
<?php endif; ?>

<?= $page->content; ?>