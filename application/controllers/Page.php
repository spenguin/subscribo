<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function index()
	{
        $this->themes->view( 'welcome_message' );
	}
}
