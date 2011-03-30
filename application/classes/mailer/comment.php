<?php defined('SYSPATH') or die('No direct script access.');

class Mailer_Comment extends Mailer {

  public function form($args)
  {
  	$this->type = 'html';
    $this->to       = array('jdstraughan@gmail.com' => 'JDStraughan.com');
    $this->from     = array(HTML::chars($args['data']['form']['email']));
    $this->subject    = 'New Comment on JDStraughan.com';
    $this->body_data   = $args['data'];
  }

}