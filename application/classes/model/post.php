<?php defined('SYSPATH') or die('No direct script access.');

class Model_Post extends Model_Takara {
		
	/**
	 * Define belongs-to relationships
	 * 
	 * @var array
	 */
	protected $_belongs_to = array(
		'user' => array('model' => 'user'),
		'category' => array('model' => 'category')
	);
	
	/**
	 * Define has-many relationships
	 * 
	 * @var array
	 */
	protected $_has_many = array(
		'comments'	=> array()
	);
	
	/**
	 * Configure custom meta data
	 * 
	 * @var array
	 */
	protected $_meta_data = array(
		'display_type' => 'table',
		'fields' => array('status', 'date_published', 'category_id', 'title', 'link_title', 'content', 'summary', 'description'),
		'list_columns' => array(
			'title' => 'title',
			'status' => 'status',
			'date_published' => 'data',
		),
		'sort_columns' => array('title', 'status', 'date_published'),
		'items_per_page' => 10,
		'draggable' => FALSE,
	);
	
	/**
	 * Define validation rules
	 * 
	 * @var array
	 */
	protected $_rules = array(
		'title' => array(
			'not_empty'  => NULL,
			'min_length' => array(2),
			'max_length' => array(254),
		),
		'category_id' => array(
		),
		'summary' => array(
			'not_empty'  => NULL,
			'min_length' => array(3),
			'max_length' => array(1500),
		),
		'description' => array(
			'not_empty'  => NULL,
			'min_length' => array(15),
			'max_length' => array(160),
		),	
		'status' => array(
			'not_empty' => NULL,
		),	
		'link_title' => array(
			'min_length' => array(4),
			'max_length' => array(1500),	
		),
		'content' => array(
			'not_empty'  => NULL,
			'min_length' => array(4),
			'max_length' => array(25000),
		),
		'date_published' => array(
			'not_empty'  => NULL,
			'min_length' => array(9),
			'max_length' => array(11),
		),
	);
	
	/**
	 * Define field labels
	 * 
	 * @var array
	 */
	protected $_labels = array(
		'title'	   			=> 'Full Title',
		'link_title'		=> 'Short Title',
		'summary'			=> 'Summary',
		'description'		=> 'Meta Description',
		'content'			=> 'Content',
		'status'			=> 'Status',
		'sticky'			=> 'Sticky?',
		'date_published'	=> 'Publish Date',
		'category_id'		=> 'Category',
	);
	
	/**
	 * Define custom fields data
	 * 
	 * @var array
	 */
	protected $_fields = array(
		'summary' => array(
			'column_name' => 'summary',
	        'form_element' => array(
				'type' => 'textarea',
			),
		),
		'content' => array(
			'column_name' => 'content',
	        'form_element' => array(
				'type' => 'textarea',
				'attributes' => array(
					'id' => 'wysiwyg',
					'name' => 'wysiwyg',
				),
			)
		),
		'category_id' => array(
			'column_name' => 'category',
			'form_element' => array(
				'type' => 'select',
				'options' => array(
				)
			),
		),
		'status' => array(
			'column_name' => 'status',
			'form_element' => array(
				'type' => 'select',
				'options' => array(
					'draft' => 'Draft', 
					'published' => 'Published'
				),
			),
		),
		'date_published' => array(
			'column_name' => 'date_published',
	        'form_element' => array(
				'type' => 'date',
			)
		),
	);
	
	/**
	 * Define validation callbacks
	 * 
	 * @var array
	 */
	protected $_callbacks = array(
		'title' => 'generate_title_slug',
		'date_published' => 'convert_to_timestamp',
	);
	
	/**
	 * Psuedo constructor
	 * 
	 * @return 	void
	 */
	protected function _init() 
	{
		$cats = new Model_Category;
		foreach ($cats->find_all() as $cat) 
		{
			$options[$cat->id] = $cat->name;
		}
		$this->_fields['category_id']['form_element']['options'] = $options;
	}
	
	public function get_summaries($limit = 3) 
	{
		return $this->order_by('date_published', 'DESC')
			->where('status', '=', 'published')
			->limit($limit)
			->find_all();
	}
	
	/**
	 * Retreives the newest record based on date published
	 * 
	 * @return 	Result
	 */
	public function get_newest() 
	{
		return $this->order_by('date_published', 'DESC')
			->where('status', '=', 'published')
			->where('date_published', '<=', time())
			->find();
	}
	
	/**
	 * Get all records ordered by date_published
	 * 
	 * @param 	int 	Limit
	 * @return 	array	Validate
	 */
	public function get_all_available($limit = 5) 
	{
		$this->clear();
		$available =  $this->where('date_published', '<=', time())
			->where('status', '=', 'published')
			->order_by('date_published', 'DESC');
		if ($limit) 
		{	
			$this->limit($limit);
		}
		return $this->find_all();
	}
	
	/**
	 * Creates an array of archived posts
	 * 
	 * @param int $limit
	 * @return array
	 */
	public function get_archive_array($limit = NULL)
	{
		$available = $this->get_all_available($limit);
		$archive = array();
		foreach ($available as $post)
		{
			$year = date('Y', $post->date_published);
			$month = date('m', $post->date_published);
			$day = date('d', $post->date_published);
			$archive[$year][$month][$day][$post->slug] = $post->title;
		}
		return $archive;
	}
	
	/**
	 * Creates a nest unordered list of archive posts and links
	 * 
	 * @param int $limit
	 * @return string
	 */
	public function get_archive_html($limit = NULL)
	{
		$archives = $this->get_archive_array($limit, $class='post-archive');
		$html = sprintf('<ul class="%s">', $class);
		foreach ($archives as $year => $archive) 
		{
			$current = $year == date('Y', time()) ? ' current' : '';
			$span = sprintf('<span class="year-click">%s</span>', $year);
			$html .= sprintf('<li>%s<ul class="year year-%s%s">', $span, $year, $current);
			
			$html .= $this->_get_months_html($archive, $current);
			$html .= '</ul></li>';
		}
		$html .= '</ul>';
		return $html;
	}
	
	/**
	 * Creates nested uls for months/days in archive array
	 * 
	 * @param array archive
	 * @parm string|bool current
	 * @return @string
	 */
	protected function _get_months_html(array $archive, $current = FALSE) 
	{
		$html = '';
		foreach ($archive as $month => $archive) 
		{
			$current = $month == date('m', time()) && $current ? ' current' : '';
			$month = $this->_convert_to_month($month);
			$span = sprintf('<span class="month-click">%s <span class="count">(%s)</span></span>', 
				$month, 
				count($archive, 1) - count($archive)
			);
			$html .= sprintf('<li>%s<ul class="month month-%s%s">', $span, strtolower($month), $current);
			
			foreach ($archive as $day => $posts) 
			{
				foreach ($posts as $slug => $title)
				{
					$html .= sprintf('<li>%s</li>', HTML::anchor(url::site("post/$slug"), $title));
				}
			}
			$html .= sprintf('</ul></li>', $archive);
		}
		return $html;
	}
	
	/**
	 * Converts a number into the text for the month
	 * 
	 * @param int $number
	 * @throws Exception
	 * @return string
	 */
	protected function _convert_to_month($number)
	{
		$months = array(
			'01'	=> 	'January',
			'02'	=> 	'February',
			'03'	=> 	'March',
			'04'	=> 	'April',
			'05'	=> 	'May',
			'06'	=> 	'June',
			'07'	=> 	'July',
			'08'	=> 	'August',
			'09'	=> 	'September',
			'10'	=> 	'October',
			'11'	=> 	'November',
			'12'	=> 	'December'
		);
		if (!array_key_exists($number, $months))
		{
			throw new Exception('Invalid number given for date conversion');
		}
		return $months[$number];
	}
	
}