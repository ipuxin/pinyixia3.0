<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*** 用户中心控制文件 ***

创建 2016-08-05 刘深远

*** ***/

class Space extends MY_Controller {

	public function index(){
		$data['navSel'] = 4;
		$this->view('space',$data);
	}

	public function more(){
		$data['navSel'] = 4;
		$this->view('space/space_more',$data);
	}

	public function address(){
		$address = $this->user_model->getAddress($this->_member_userId);
		$data['list'] = $address;
		$this->view('space/space_address',$data);
	}

}