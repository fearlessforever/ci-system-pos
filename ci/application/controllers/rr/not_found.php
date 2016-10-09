<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Not_found extends CI_Controller {

	public function index()
	{
		$data=array();
		$data['assets']=base_url().'assets';
		$data['home']=base_url();
		$this->load->view('dashboard/404',$data);
	}
}

/* End of file Not_found.php */
/* Location: ./application/controllers/Not_found.php */