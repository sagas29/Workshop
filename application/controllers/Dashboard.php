<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
        $data = array(
            "page_title"=> "Pagina Principal",
            "page_icon"=> "fe-home",
        );
        template("dashboard",$data);
	}

}

/* End of file Dashboard.php */