<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		

	}
}


/**
* Extends Class Web
*
* @author Vicky Nitinegoro <pkpvicky@gmail.com>
*/
class Web extends MY_Controller
{
	public $user_login;

	public function __construct()
	{
		parent::__construct();

		$this->load->library(
			array('slug','session','template','breadcrumbs','meta_tags', 'content_parser', 'pagination','form_validation','cart')
		);
		
		$this->load->model(
			array('menus', 'options','themes', 'tags','posts','category','user','polling')
		);

		if($this->session->userdata('user_login') != FALSE)  
		{
			$this->user_login = $this->session->userdata('user');

			$this->polling->save_polling_session();
		}

		$this->load->helper(
			array('text', 'form', 'language')
		);

		$this->breadcrumbs->unshift(0, 'Home', "/");
	}

	/**
	 * User Sugmit Polling
	 *
	 * @return Header 503
	 **/
	public function set_polling()
	{
		if($this->user_login)
		{
			$this->polling->save_polling();
			
			$this->data = array(
				'status' => "success"
			);
		} else {
			$jumlalPolling = count($this->session->userdata('polling'));

			$polling = array(
				'id'      => $this->input->post('post'),
				'qty' => 1,
				'price' => 1,
				'name' => 'set-polling',
					'post' => $this->input->post('post'),
					'answer' => $this->input->post('answer')
			);
			
			$this->cart->insert($polling);

			$this->data = array(
				'status' => "failed",
				'redirectTo' => $this->input->post('backTo')
			);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */