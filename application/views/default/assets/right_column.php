<div id="author-profile">
	<div class="photo">
		<img width="180" src="<?= url::site('media/images/jason2.jpg'); ?>" alt="JDStraughan" />	
		<h3>Jason D. Straughan</h3>
	</div>
	<p class="bio">I live in the beautiful Texas hill country where I concentrate on building great web applications, writing, and enjoying time with my family. Recently I completed the first book on Kohana, <a href="http://www.packtpub.com/kohana-3-0-for-professional-web-applications-beginners-guide/book">"The Kohana 3.0 for Professional Applications Beginner’s Guide"</a> for Packt Publishing, scheduled for release in August.</p>
</div>

<div id="recent-posts">
	<h2>Recent Posts</h2>
	<ul>
	<? foreach($posts->get_all_available(5) as $post) : ?>
		<li><?= HTML::anchor(URL::site("post/{$post->slug}"), $post->title);?></li>
	<? endforeach; ?>
	</ul>
</div>

<div id="subscribe">
	<h2>Subscribe</h2>
	<ul>
		<li><?= HTML::anchor(URL::site("rss.xml"), 'Posts Feed');?></li>
		<li><?= HTML::anchor(URL::site("feed/comments/"), 'Comments Feed');?></li>
	</ul>
</div>

<div id="archive-posts">
	<h2>Post Archives</h2>
	<? echo $posts->get_archive_html(100); ?>
</div>