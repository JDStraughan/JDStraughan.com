<?php

class Controller_Feed extends Controller {
	
	public function action_comments()
	{
		$this->auto_render = FALSE;
		
		$slug = Request::instance()->param('slug');	
		
		$post = new Model_Post();
		$post = $post->get_by_slug($slug);

		if (!$post->title) 
		{
			Request::instance()->redirect('not-found');
		}
		
		$info = array(
			'title' => 'Recents comments for post: ' . $post->title,
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
				'description' => $comment->text,
				'pubDate' => date("D, d M Y H:i:s T", $comment->date_created)
			);
		} 
		  
		$xml = Feed::create($info, $items, 'rss2');
		$this->request->response = $xml;
	}
}