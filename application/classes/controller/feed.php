<?php

class Controller_Feed extends Controller {
	
	public function before() 
	{
		$this->auto_render = FALSE;
	}
		
	public function action_main() {
		
		$info = array(
			'title' => 'JDStraughan.com Recent Posts',
			'pubDate' => date("D, d M Y H:i:s T"),
			'description' => 'My recent blog posts',
			'link' => url::site()); 
		
		$items = array();
		
		$post = new Model_Post();
		$posts = $post->get_summaries(15);

		foreach ($posts as $post)
		{
			$items[] = array(
				'title' => $post->title,
				'link' => url::site("post/{$post->slug}"),
				'description' => nl2br($post->summary),
				'pubDate' => date("D, d M Y H:i:s T", $post->date_published)
			);
		} 
		  
		$xml = Feed::create($info, $items, 'rss2');
		$this->request->response = $xml;
		
	}
	
	public function action_comments()
	{		
		$slug = Request::instance()->param('slug');	
		
		if ($slug) {
			$xml = $this->_commentsByPost($slug);
		} else {
			$xml = $this->_commentsAll();
		}

		$this->request->response = $xml;
	}
	
	protected function _commentsByPost($slug) 
	{
		$post = new Model_Post();
		$post = $post->get_by_slug($slug);

		if (!$post->title) 
		{
			Request::instance()->redirect('not-found');
		}
		
		$info = array(
			'title' => 'Recents Comments for post: ' . $post->title,
			'pubDate' => date("D, d M Y H:i:s T", $post->date_published),
			'description' => 'Comments for post: ' . $post->title,
			'link' => url::site("/post/$post->slug")); 
		
		$items = array();
		
		$comments = $post->comments
						->where('approved', '=', '1')
						->order_by('date_created', 'DESC')
						->find_all();

		foreach ($comments as $comment)
		{
			$items[] = array(
				'title' => "New comment by {$comment->name}",
				'link' => url::site("post/{$post->slug}#comments"),
				'description' =>  nl2br($comment->text),
				'pubDate' => date("D, d M Y H:i:s T", $comment->date_created)
			);
		} 
		  
		return Feed::create($info, $items, 'rss2');	
	}
	
	protected function _commentsAll() 
	{
		$comments = new Model_Comment;
		$comments = $comments->where('approved', '=', '1')
				->order_by('date_created', 'DESC')
				->limit(25)
				->find_all();

		$info = array(
			'title' => 'Recents Comments on JDStraughan.com',
			'pubDate' => date("D, d M Y H:i:s T"),
			'description' => 'Comments from all posts on JDStraughan.com',
			'link' => url::site()
		); 
		
		$items = array();
				
		foreach ($comments as $comment) 
		{
			$items[] = array(
				'title' => "New comment by {$comment->name} on post {$comment->post->title}",
				'link' => url::site("post/{$comment->post->slug}#comments"),
				'description' => nl2br($comment->text),
				'pubDate' => date("D, d M Y H:i:s T", $comment->date_created)
			);
		}
		
		return Feed::create($info, $items, 'rss2');
	}
}