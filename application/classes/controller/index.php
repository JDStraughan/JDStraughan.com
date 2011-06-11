<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller_Site {
	
	public function action_index() 
	{
		$this->template->content = View::factory('default/home')
			->bind('posts', $posts);
		
		$post = new Model_Post();
		$posts = $post->get_summaries(5);
		
	}

	public function action_page()
	{
		
		$slug = Request::instance()->param('slug');	
		if (!$slug) $slug = 'home';
		
		$page = new Model_Page();
		$page = $page->get_by_slug($slug);

		if (!$page->title) 
		{
			Request::instance()->redirect('not-found');
		}
		
		$this->template->content = View::factory('default/page')
				->set('page', $page);
		
		$this->template->title = $page->title;
	}
	
	public function action_newpost() 
	{
		$this->template->content = View::factory('default/post')
			->bind('post', $post);
		
		$post = new Model_Post();
		$post = $post->get_newest();
	}
	
	public function action_post()
	{		
		$slug = Request::instance()->param('slug');	
		
		$post = new Model_Post();
		$post = $post->get_by_slug($slug);

		if (!$post->title) 
		{
			Request::instance()->redirect('not-found');
		}
		
		$this->template->title = $post->title;
		
		$this->template->description = $post->description;
		
		$comment_form = new Model_Comment();
		
		if (array_key_exists('scheck', $_POST)) {
			$this->_process_comment($comment_form, $post);
		}
		elseif ($this->session->get('post')) 
		{
			$_POST = $this->session->get('post');
			$this->session->delete('post');
		}

		$this->template->content = View::factory('default/post')
			->bind('post', $post)
			->bind('comments', $comments)
			->bind('comment_form', $comment_form)
			->bind('fields', $fields)
			->bind('form_error', $this->form_error)
            ->bind('errors', $this->errors);
			
		
		$meta = $comment_form->get_meta_data();
		$fields = $meta['fields'];
		
		$comments = $post->comments->where('approved', '=', '1')->order_by('date_created')->find_all();
		
	}
	
	public function action_not_found() {
		$this->template->title = '404';
		$this->request->status = 404; 
		$this->template->content = View::factory('default/not-found');
	}
	
	protected function _process_comment(Model_Comment $comment, Model_Post $article) {
		if (isset($_POST['scheck']) && $_POST['scheck'] != null) {
			die('nospam');
		}
		
		$_POST['text'] = strip_tags($_POST['text']);
		if (array_key_exists('website', $_POST) && $_POST['website'] != '' && substr($_POST['website'], 0, 4) != 'http') {
			$_POST['website'] = 'http://' . $_POST['website'];
		}
		$post = $comment->validate_create($_POST);
		$comment->post = $article;
		
			if ($post->check())	
			{
				$comment->values($post);
				
				if ($comment->save()) 
				{
					
					Email::factory('New Comment Approval Request from JDStraughan.com',
							View::factory('email/comment')
								->set('comment', $comment), 
							'text/html'
						)
					    ->to('jdstraughan@gmail.com')
					    ->from('jdstraughan@gmail.com', 'JDStraughan.com')
					    ->send();
					    
					$this->session->set('messages', 'Your comment has been added (pending approval)');
					$this->session->set('post', array());
					Request::instance()->redirect(url::site('post/' . $article->slug));
				}			
			} 
			else 
			{	
				$this->session->set('form_error', array('Submission Failed.  Please see error messages below.'));
				$this->session->set('errors', $post->errors('contact'));
				$this->session->set('post', $_POST);
				Request::instance()->redirect(url::site("post/{$article->slug}#comment_error"));
			}
	}
	
	public function action_faqs()
	{
		$this->template->content = View::factory('default/faqs')
			->bind('faqs', $faqs);
			
		$this->template->title = 'FAQs';
			
		$faqs = ORM::factory('faq')->order_by('sort_order', 'ASC');
	}
	
	public function action_contact() 
	{
		$contact = new Model_Contact();
		
		$meta = $contact->get_meta_data();
		
		$this->template->title = 'Contact';
		
		$this->template->content = View::factory('default/contact')
			->bind('form_error', $this->form_error)
            ->bind('errors', $this->errors)
            ->bind('fields', $meta['fields'])
			->bind('page', $page)
            ->set('contact', $contact);
		
		$page = new Model_Page();
		$page = $page->get_by_slug('contact');

		if ($_POST) 
		{
			
			$post = $contact->validate_create($_POST);		
				
			if ($post->check())	
			{
				$contact->values($post);
				
				if ($contact->save()) 
				{

					Email::factory('New Contact from JDStraughan.com',
							View::factory('email/contact')
								->set('contact', $contact), 
							'text/html'
						)
					    ->to('jdstraughan@gmail.com')
					    ->from('jdstraughan@gmail.com', 'JDStraughan.com')
					    ->send();
										    
					$this->session->set('messages', 'Contact Sent!');
					Request::instance()->redirect(url::site('contact_success'));
				}			
			} 
			else 
			{	
				$this->session->set('form_error', array('Submission Failed.  Please see error messages below.'));
				$this->session->set('errors', $post->errors('contact'));
				$this->session->set('post', $_POST);
				Request::instance()->redirect(url::site('contact'));
			}		
		}
		elseif ($this->session->get('post')) 
		{
			$_POST = $this->session->get('post');
			$this->session->delete('post');
		}
	}
	
	public function action_contact_success() 
	{
		$this->template->title = 'Contact';
		$this->template->content = View::factory('default/contact_success');
	}
	
	/*
	 * Approves a comment
	 */
	public function action_approve() {
		$id = Request::instance()->param('id');
		$comment = new Model_Comment;
		$comment->find($id);
		$comment->approved = '1';
		$comment->save();
		Request::instance()->redirect(url::site("post/{$comment->post->slug}"));	
	}

}