<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Site extends Controller_Template {

	public $template = 'default/template';
	
	public $session;
	
	public $errors;
	
	public $form_error;
	
	public $messages;
	
	public function before() 
	{
		parent::before();

		$this->session = Session::instance('database');
		
		$this->errors = $this->session->get('errors');
		if ($this->errors) {
			$this->session->delete('errors');
			$this->session->write();
		}
		
		$this->form_error = $this->session->get('form_error');
		if ($this->form_error) {
			$this->session->delete('form_error');
			$this->session->write();
		}
		
		$this->messages = $this->session->get('messages');
		if ($this->messages) {
			$this->session->delete('messages');
			$this->session->write();
		}
		
		$this->template->messages = $this->messages;
		$this->template->form_error = $this->form_error;
		
		if ($this->auto_render)	
		{
			// Initialize empty values
			$this->template->title   = '';
			$this->template->description = 'Jason D. Straughan is a web developer, author, and consultant living in San Antonio, Texas. Specializing in LAMP development, PHP, and the Kohana framework.';
			$this->template->content = '';
			$this->template->right_column = '';
			$this->template->styles = array(
				'media/css/reset.css',
				'media/css/base.css',
				'media/css/shCore.css',
				'media/css/shThemeDefault.css'
			);
			$this->template->scripts = array(
				'media/js/jquery-1.4.2.min.js',
				'media/js/jquery.ui.core.js',
				'media/js/jquery-ui-1.8.2.custom.min.js',
				'media/js/shCore.js',
				'media/js/shBrushPhp.js',
				'media/js/site.js',
			);   
		}
		
		$settings = ORM::factory('setting')->find(1);
		
		$site_name = $settings->site_name;
		
		$tag_line = $settings->tag_line;
		
		$blog_user = ORM::factory('user')->where('id', '=', 1)->find(1);
		
		View::bind_global('blog_user', $blog_user);
		
		View::bind_global('site_name', $site_name);
		
		View::bind_global('tag_line', $tag_line);
		
		$this->template->header = View::factory('default/assets/header');
		
		$this->template->title = 'San Antonio Web Developer and Consultant';
		
		$this->template->header->page_nav = View::factory('default/assets/page_nav')
			->bind('pages', $pages);
			
		$page = new Model_Page;
		$pages = $page->get_nav_pages();
		
		$this->template->right_column = View::factory('default/assets/right_column')
			->bind('posts', $posts);
			
		$posts = new Model_Post;
		
		$this->template->footer = View::factory('default/assets/footer');
	}

}