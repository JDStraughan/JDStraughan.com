<?php defined('SYSPATH') or die('No direct script access.');

class Mailer_Contact extends Mailer {

  public function form($args)
  {
  	$this->type = 'html';
    $this->to       = array('jdstraughan@gmail.com' => 'JDStraughan.com');
    $this->from     = array(HTML::chars($args['data']['form']['email']));
    $this->subject    = 'New Website Contact Message';
    $this->body_data   = $args['data'];
  }

}