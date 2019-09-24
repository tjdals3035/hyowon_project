<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public $pc;
    public $date;
    public $file;
    public $dateFromCheckDate;
    public $dateToMail;

    public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        $this->load->model('home_model');
        $data_list['product_data'] = $this->home_model->get_all_product();
        $this->load->view('home_view', $data_list);
	}

    public function ajax_zipcode($post)
    {
        $url = 'http://zipcloud.ibsnet.co.jp/api/search?zipcode='.$post;

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $url);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $ch );

        $response = json_decode($response);

        if ($response->status === 200) {
            $addd = $response->results[0]->address1.$response->results[0]->address2.$response->results[0]->address3;
         echo $addd;
        }
        else{
            echo "error";
        }
    }

    public function mypage()
    {
        $this->load->model('home_model');
        $member_pk = $this->session->userdata('member_pk');
        if (empty($member_pk )) {
            $this->index();
        }else{
            $data = $this->home_model->member_info($member_pk);
            $data_list['member_info'] = $data[0];
            $data_list['order_info'] = $this->home_model->member_order_info($member_pk);
            $data_list['order_info_detail'] = $this->home_model->member_order_info_detail();

            $this->load->view('member/mypage', $data_list);
        }
    }

    public function checkOrder()
    {
        $this->load->view('product/checkOrder');
    }

    public function EC_law()
    {
        $this->load->view('EC_law');
    }

    public function signup()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id','id','required');
        $this->form_validation->set_rules('pw','pw','required');
        $this->form_validation->set_rules('name','name','required');
        $this->form_validation->set_rules('email','email','required');
        $this->form_validation->set_rules('post','post','required');
        $this->form_validation->set_rules('address','address','required');
        $this->form_validation->set_rules('phone','phone','required');

        $signupData = array(
            'id'=>$this->input->post('id'),
            'pw'=>$this->input->post('pw'),
            'name'=>$this->input->post('name'),
            'email'=>$this->input->post('email'),
            'post'=>$this->input->post('post'),
            'address'=>$this->input->post('address'),
            'phone'=>$this->input->post('phone'),
            'todoadd'=>$this->input->post('todoadd')
        );

        $this->load->model('home_model');

        $id = $this->input->post('id');
        $chk = $this->home_model->checkID($id);

        if($chk[0]['COUNT(*)'] != 0)
        {
            echo "同じアカウントがあります";
        }
        else
        {
            $result = $this->home_model->add($signupData);
            if ($result === true) echo "会員登録完了";
            else echo "会員登録失敗";
        }
    }

    public function product()
    {
       $pnum = $_GET["pcode"];
       $this->load->model('home_model');
       $result = $this->home_model->get_one_product($pnum);
       $one_product = array('op' => $result);
       $this->load->view('check', $one_product);
    }

    /**
     * カテゴリ別の商品データを持ってくる
     */
    public function getpowder()
    {
        $cname = $_GET["cname"];
        $this->load->model('home_model');
        $result = $this->home_model->get_one_category($cname);
        $data_list['show_category_product'] = $result;

        $this->load->view('product/showcategory', $data_list);
    }
}