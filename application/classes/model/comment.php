<?php defined('SYSPATH') or die('No direct script access.');

class Model_Comment extends Model_Takara {
		
	/**
	 * Define belongs-to relationships
	 * 
	 * @var array
	 */
	protected $_belongs_to = array(
		'post' => array('model' => 'post')
	);
	
	/**
	 * Configure custom meta data
	 * 
	 * @var array
	 */
	protected $_meta_data = array(
		'display_type' => 'table',
		'fields' => array('name', 'email', 'website', 'text'),
		'list_columns' => array(
			'name' => 'name',
			'text' => 'text',
			'date_created' => 'date_created',
		),
		'sort_columns' => array('approved', 'date_created', 'name'),
		'items_per_page' => 20,
		'sortable' => FALSE,
	);
	
	/**
	 * Define validation rules
	 * 
	 * @var array
	 */
	protected $_rules = array(
		'name' => array(
			'not_empty'  => NULL,
			'min_length' => array(2),
			'max_length' => array(254),
		),
		'email' => array(
			'not_empty'  => NULL,
			'email' => NULL
		),	
		'website' => array(
			'url'		=> NULL
		),	
		'text' => array(
			'not_empty'	 => NULL,
			'min_length' => array(4),
			'max_length' => array(15000),	
		)
	);
	
	/**
	 * Define field labels
	 * 
	 * @var array
	 */
	protected $_labels = array(
		'name'	   			=> 'Name',
		'email'				=> 'Email',
		'website'			=> 'Website (optional)',
		'text'				=> 'Comment'
	);
	
	/**
	 * Define custom fields data
	 * 
	 * @var array
	 */
	protected $_fields = array(
		'text' => array(
			'column_name' => 'text',
	        'form_element' => array(
				'type' => 'textarea',
			),
		)
	);
	
	/**
	 * Retrieves the newest record based on date published
	 * 
	 * @return 	Result
	 */
	public function get_newest() 
	{
		return $this->order_by('date_published', 'DESC')
			->where('date_published', '<=', time())
			->find();
	}
}