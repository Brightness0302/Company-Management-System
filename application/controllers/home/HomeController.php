<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	// RECURSIVE FUNCTION
	public function factory($num)
	{
		if($num == 1)
			return $num;
		else
			return $num * $this->factory($num-1);
	}
	public function recursive()
	{
		// RECURSIVE FUNCTION
		$result = $this->factory(5);
		// EXPECTED OUTPUT : (int) 120
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('main_page/head');
		$this->load->view('main_page/body');
		$this->load->view('main_page/foot');
		$this->load->view('footer');
	}
	
	public function view()
	{
		$this->load->view('header');
		$this->load->view('signview/head');
		$this->load->view('signview/body');
		$this->load->view('signview/foot');
		$this->load->view('footer');
	}
}
