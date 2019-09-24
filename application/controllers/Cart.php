<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {


    public function __construct()
	{
		parent::__construct();
        $this->load->library('cart');
        $this->load->helper('form');
	}

	public function index()
	{
		$this->load->view('product/cart');
	}

    public function insert()
    {
        $id = $_POST['id'];
        $qty = $_POST['qty'];
        $price = $_POST['price'];
        $name = $_POST['name'];
        $image = $_POST['image'];

        $data = array(
          'id' => $id,
          'qty' => $qty,
          'price' => $price,
          'name' => $name,
          'image' => $image
        );

        $res = $this->cart->insert($data);

        echo json_encode($res);
    }

    public function cartupdate()
    {
        $qty_all = $_POST['qty_all'];
        $itemrowid_all = $_POST['itemrowid_all'];
        $delimeter = $_POST['delimeter'];

        $qty_all_arr = explode($delimeter, $qty_all);

        $itemrowid_all_arr = explode($delimeter, $itemrowid_all);

        for($i=0; $i< count($itemrowid_all_arr); $i++){
            $itemrowid = $itemrowid_all_arr[$i];
            $qty = $qty_all_arr[$i];

            $data = array(
                'rowid' => $itemrowid,
                'qty' => $qty
            );

            $this->cart->update($data);
        }
        echo json_encode("ok");
    }

    public function cartdelete()
    {
        $itemrowid = $_POST['rowid'];

        $data = array(
            'rowid' => $itemrowid,
            'qty' => 0
        );

        $this->cart->update($data);
    }

    public function cartalldelete()
    {
      $this->cart->destroy();
      $this->load->view('product/cart');
    }
}