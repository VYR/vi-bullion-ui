<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
        $this->load->model(array('Common_model','Welcome_model','Admin_model'));
		
	}
    public $header = 'front-end-includes/header';
    public $footer = 'front-end-includes/footer';
	private $liveRatesURL='https://vibullion.com/beta/get-gold-live-rates.php';
	public function sendjson()
	{
		header($this->json_headers);
		echo json_encode($this->jsondataa,JSON_PRETTY_PRINT);
	}
	public function index()
	{
		$total=$this->uri->total_segments();
		if($total==0)
		{		
			$data['banners'] = $this->Common_model->get_record('tbl_banners', '*',array('status'=>1), 2,array('id','desc'));		
			$data['categories'] = $this->Common_model->get_record('tbl_categories', '*','', 1,array('id','asc'));		
			$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
			$seo_tags=array();
			if(!empty($home_content)){
				$seo_tags['title']=$home_content['title'];
				$seo_tags['meta_description']=$home_content['meta_description'];
				$seo_tags['meta_tags']=$home_content['meta_tags'];
			}
			$seo['seo_tags']=$seo_tags;
			$this->load->view($this->header, $seo);
			$this->load->view('index', $data);
			$this->load->view($this->footer);
		}
		elseif($total==1)
		{
			$seg1=$this->uri->segment(1);
			if($seg1=="management")
			{				
				$data['record'] =$record= $this->Common_model->get_record('tbl_management_content', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;	
				$categories = $this->Common_model->get_record('tbl_management_categories', '*',array('status'=>1), 1,array('position','asc'));
				$all_categories=array();
				if(!empty($categories)){
				foreach($categories as $key=>$row){
					$row['employees'] = $this->Common_model->get_record('tbl_management_employees', '*',array('category_id'=>$row['id'],'status'=>1), 1,array('id','desc'));
					$all_categories[]=$row;
				}}
				$data['categories']=$all_categories;					
				$this->load->view($this->header, $seo);
				$this->load->view('management', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="check_api")
			{				
				$url=$this->liveRatesURL;
				echo file_get_contents($url);
			}
			else if($seg1=="gold_api")
			{
				$ch = curl_init();
				$url=$this->liveRatesURL;
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec($ch);
				echo '<pre>';print_r($server_output);exit;
				curl_close($ch);
				$data_record= json_decode($server_output, true);
			}
			else if($seg1=="live_api")
			{		
				$ch = curl_init();
				$url=$this->liveRatesURL;
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec($ch);
				curl_close($ch);
				$data_record= json_decode($server_output, true);
				$record=$data_record['rows'];
				echo '<pre>';print_r($record);
			}
			else if($seg1=="live_rates_ajax")
			{		
				$data['gold_mcx'] = $this->Common_model->get_record('tbl_categories', '*',array('id'=>1),2);	
				$data['silver_mcx'] = $this->Common_model->get_record('tbl_categories', '*',array('id'=>4),2);	
				$data['api_details']=$this->get_full_api();
				$data['gold_value']=$this->get_casted_value(1);
				$data['silver_value']=$this->get_casted_value(4);
				$this->load->view('live_rates_ajax', $data);
			}
			else if($seg1=="api_live_rates")
			{		
				$data['gold_mcx'] = $this->Common_model->get_record('tbl_categories', '*',array('id'=>1),2);	
				$data['silver_mcx'] = $this->Common_model->get_record('tbl_categories', '*',array('id'=>4),2);	
				$data['api_details']=$this->get_full_api();
				$data['gold_value']=$this->get_casted_value(1);
				$data['silver_value']=$this->get_casted_value(4);
				header('Content-Type: application/json');
				echo json_encode($data,JSON_PRETTY_PRINT);
			}
			else if($seg1=="gold-scrap")
			{				
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($home_content)){
					$seo_tags['title']=$home_content['title'];
					$seo_tags['meta_description']=$home_content['meta_description'];
					$seo_tags['meta_tags']=$home_content['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;		
				$data['record'] =$record= $this->Common_model->get_record('tbl_categories', '*',array('id'=>3),2);			
				$this->load->view($this->header, $seo);
				$this->load->view('gold_scrap', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="corporate-deals")
			{				
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($home_content)){
					$seo_tags['title']=$home_content['title'];
					$seo_tags['meta_description']=$home_content['meta_description'];
					$seo_tags['meta_tags']=$home_content['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;		
				$data['record'] =$record= $this->Common_model->get_record('tbl_categories', '*',array('id'=>6),2);			
				$this->load->view($this->header, $seo);
				$this->load->view('corporate_deals', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="casted-gold")
			{				
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($home_content)){
					$seo_tags['title']=$home_content['title'];
					$seo_tags['meta_description']=$home_content['meta_description'];
					$seo_tags['meta_tags']=$home_content['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;	
				$categories = $this->Common_model->get_record('tbl_casted_gold_categories', '*',array('status'=>1), 1,array('display_order','asc'));
				$data['gold_mcx'] = $this->Common_model->get_record('tbl_categories', '*',array('id'=>1),2);		
				$data['api_details']=$this->get_full_api();
				$data['casted_value']=$casted_value=$this->get_casted_value(1);
				$all_categories=array();
				if(!empty($categories)){
				foreach($categories as $key=>$row){
					$row['products'] = $this->Common_model->get_record('tbl_casted_gold_products', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$row['ads'] = $this->Common_model->get_record('tbl_casted_gold_ads', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$all_categories[]=$row;
				}}
				$data['categories']=$all_categories;					
				//$this->load->view($this->header, $seo);
				$this->load->view('casted_gold_products', $data);
				//$this->load->view($this->footer);
			}
			else if($seg1=="casted_gold_loop")
			{		
				$data['gold_mcx'] = $this->Common_model->get_record('tbl_categories', '*',array('id'=>1),2);		
				$data['api_details']=$this->get_full_api();
				$data['casted_value']=$casted_value=$this->get_casted_value(1);
				$categories = $this->Common_model->get_record('tbl_casted_gold_categories', '*',array('status'=>1), 1,array('display_order','asc'));	
				$all_categories=array();
				if(!empty($categories)){
				foreach($categories as $key=>$row){
					$row['products'] = $this->Common_model->get_record('tbl_casted_gold_products', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$row['ads'] = $this->Common_model->get_record('tbl_casted_gold_ads', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$all_categories[]=$row;
				}}
				$data['categories']=$all_categories;	
				$this->load->view('casted_gold_products_loop', $data);
			}
			else if($seg1=="casted-gold-logout")
			{
				$this ->session ->unset_userdata('casted_gold_user');
				redirect('casted-gold-login');
			}
			else if($seg1=="casted-gold-login")
			{						
				if (!empty($this->session->userdata('casted_gold_user')))
				{
					redirect('casted-gold-booking');
				}				
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>7),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']='Casted Gold Login';
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_gold_login', $data);
				$this->load->view($this->footer);		
			}
			else if($seg1=="casted_gold_login_ajax")
			{
				if ($this->input->post('unique_code') != '')
				{
					$unique_code = $this->input->post('unique_code');
					$password = $this->input->post('password');
					$encode_password = encode5t($password);
					$record = $this->Common_model->get_record('tbl_casted_gold_users', '*', array('unique_code'=>$unique_code,'password'=>$encode_password),2);
					if (!empty($record))
					{
						if($record['status']=='1'){
							$this ->session ->set_userdata('casted_gold_user', $record['id']);
							$data['msg'] = 'Login Successfull...';
							$data['status'] = 1;
						}
						else
						{
							$data['msg'] = 'Your account is not active please contact admin ...';
							$data['status'] = 0;
						}
					}
					else
					{
						$data['msg'] = 'Unique Code Or Password Did Not Match ...';
						$data['status'] = 0;
					}
				}
				echo json_encode($data);
			}
			else if($seg1=="casted-gold-user-dashboard")
			{						
				if (empty($this->session->userdata('casted_gold_user')))
				{
					redirect('casted-gold-login');
				}
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>7),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_gold_user_dashboard', $data);
				$this->load->view($this->footer);		
			}
			else if($seg1=="casted_gold_user_dashboard_ajax")
			{		
				$user_id=$this->session->userdata('casted_gold_user');
				$data['record']=$record =$this->Common_model->get_record('tbl_casted_gold_users','*',array('id'=>$user_id),2);
				if(!empty($record)){	
					if(!empty($_POST)){	
						$data['from_date']=$from_date=date("Y-m-d",strtotime($_POST['from_date']));
						$data['to_date']=$to_date=date("Y-m-d",strtotime($_POST['to_date']));
					}else{
						$data['from_date']=$from_date=date("Y-m-d");
						$data['to_date']=$to_date=date("Y-m-d");
					}
					$where="user_id=".$user_id." AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
					$data['records'] = $this->Common_model->get_record('tbl_casted_gold_orders', '*',$where,1,array('id','desc'));
					$this->load->view('casted_gold_user_dashboard_ajax', $data); 
				}else{	
					echo '<h4 class="text-center text-danger">Invalid Credentials</h4>';
				}					
			}
			else if($seg1=="casted-gold-register")
			{						
				if (!empty($this->session->userdata('casted_gold_user')))
				{
					redirect('casted-booking');
				}
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>7),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_gold_register', $data);
				$this->load->view($this->footer);		
			}
			else if ($seg1 == "get_casted_gold_promoter")
			{
				$promoter_id = $this->input->post('promoter_id');
				$precord = $this->Common_model->get_record('tbl_casted_gold_promoters', '*', array('unique_code'=>$promoter_id),2);
				if(!empty($precord))
				{
					echo $precord['name'];
				}				
			}
			else if ($seg1 == "casted_gold_register_ajax")
			{
				$name_type = $this->input->post('name_type');
				$name = $this->input->post('name');
				$email = $this->input->post('email');
				$mobile = $this->input->post('mobile');
				$company_type = $this->input->post('company_type');
				$company_name = $this->input->post('company_name');
				$pan_number = $this->input->post('pan_number');
				$aadhar_number = $this->input->post('aadhar_number');
				$firm_type = $this->input->post('firm_type');
				$gst_no = $this->input->post('gst_no');
				$shop_type = $this->input->post('shop_type');
				$grams = $this->input->post('grams');
				$kgs = $this->input->post('kgs');
				$silver_grams = $this->input->post('silver_grams');
				$silver_kgs = $this->input->post('silver_kgs');
				$state = $this->input->post('state');
				$state_code = $this->input->post('state_code');
				$district = $this->input->post('district');
				$pincode = $this->input->post('pincode');
				$address = $this->input->post('address');
				$bank_account_type = $this->input->post('bank_account_type');
				$bank_name = $this->input->post('bank_name');
				$account_number = $this->input->post('account_number');
				$ifsc_code = $this->input->post('ifsc_code');
				$promoter_id = $this->input->post('promoter_id');
				$promoter_name = $this->input->post('promoter_name');
				$remarks = $this->input->post('remarks');
				$add_data = array(
					'name_type' => $name_type,
					'name' => $name,
					'email' => $email,
					'mobile' => $mobile,
					'company_type' => $company_type,
					'company_name' => $company_name,
					'pan_number' => $pan_number,
					'aadhar_number' => $aadhar_number,
					'firm_type' => $firm_type,
					'gst_no' => $gst_no,
					'shop_type' => $shop_type,
					'grams' => $grams,
					'kgs' => $kgs,
					'silver_grams' => $silver_grams,
					'silver_kgs' => $silver_kgs,
					'state' => $state,
					'state_code' => $state_code,
					'district' => $district,
					'pincode' => $pincode,
					'address' => $address,
					'bank_account_type' => $bank_account_type,
					'bank_name' => $bank_name,
					'account_number' => $account_number,
					'ifsc_code' => $ifsc_code,
					'promoter_id' => $promoter_id,
					'promoter_name' => $promoter_name,
					'remarks' => $remarks,
					'created_date_time' => date("Y-m-d H:i:s")
				);
				$where="mobile='".$mobile."' OR email='".$email."'";
				$record = $this->Common_model->get_record('tbl_casted_gold_users', '*', $where,2);
				$precord = $this->Common_model->get_record('tbl_casted_gold_promoters', '*', array('unique_code'=>$promoter_id),2);
				if(!empty($record))
				{
					$data['msg'] = 'Email ID or Mobile Number already exists...';
					$data['status'] = 0;
				}
				else if(empty($precord))
				{
					$data['msg'] = 'Invalid Promoter...';
					$data['status'] = 0;
				}
				else
				{
					$result = $this->Common_model->add_record('tbl_casted_gold_users', $add_data);
					if (!empty($result))
					{
						$data['msg'] = 'Registered Successfully Login Credentials will be sent to your email after verification...';
						$data['status'] = 1;
					}
					else
					{
						$data['msg'] = 'Not Submitted...';
						$data['status'] = 0;
					}
				}
				echo json_encode($data);
			}
			else if($seg1=="casted-gold-booking")
			{					
				if (empty($this->session->userdata('casted_gold_user')))
				{
					redirect('casted-gold-login');
				}
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>8),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$data['places'] =$places=$this->Common_model->get_record('tbl_pickup_places','*',array('status'=>1),1,array('id','desc'));
				if(!empty($this->session->userdata('casted_gold_dealer'))){
					$dealer_id=$this->session->userdata('casted_gold_dealer');
					$data['dealer'] =$dealer= $this->Common_model->get_record('tbl_pickup_dealers', '*',array('id'=>$dealer_id),2);
					$data['dealers'] =$dealers=$this->Common_model->get_record('tbl_pickup_dealers','*',array('place_id'=>$dealer['place_id'],'status'=>1),1,array('id','desc'));
				}
				$data['org_price'] = $org_price='1853.65';
				$data['dollar_price'] = $dollar_price='75.555';
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_gold_booking', $data);
				$this->load->view($this->footer);		
			}
			else if ($seg1 == "casted_gold_pickup_ajax")
			{
				$dealer_id = $this->input->post('dealer_id');
				$this ->session ->set_userdata('casted_gold_dealer', $dealer_id);
			}
			else if($seg1=="casted_gold_add_cart")
			{						
				$pid=$this->input->post('pid');
				$qty=$this->input->post('qty');
				$casted_gold_cart_products=$this->session->userdata('casted_gold_cart_products');
				if(!empty($casted_gold_cart_products))
				{
					$ava=0;
					foreach($casted_gold_cart_products as $key=>$row)
					{
						if($row['pid']==$pid)
						{	
							$ava=1;							
							$casted_gold_cart_products[$key]['qty'] = $qty;
							if($qty==0){
								unset($casted_gold_cart_products[$key]);
								$casted_gold_cart_products = array_values($casted_gold_cart_products);
							}
						}
					}
					if($ava==0){						
						$casted_gold_cart_products[] = array(
						'pid' => $pid,
						'qty' => $qty
						);
					}
				}
				else
				{							
					$casted_gold_cart_products[] = array(
					'pid' => $pid,
					'qty' => $qty
					);
				}
				$this->session->set_userdata('casted_gold_cart_products',$casted_gold_cart_products);
			}
			else if($seg1=="casted-gold-cart")
			{					
				if (empty($this->session->userdata('casted_gold_user')))
				{
					redirect('casted-gold-login');
				}				
				if (empty($this->session->userdata('casted_gold_cart_products')))
				{
					redirect(site_url());
				}
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>8),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$data['org_price'] = $org_price='1853.65';
				$data['dollar_price'] = $dollar_price='75.555';
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_gold_cart', $data);
				$this->load->view($this->footer);		
			}
			else if($seg1=="casted_gold_cart_ajax")
			{		
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$user_id=$this->session->userdata('casted_gold_user');
				$data['urecord'] =$urecord= $this->Common_model->get_record('tbl_casted_gold_users', '*',array('id'=>$user_id),2);
				$data['cart_products']=$this->session->userdata('casted_gold_cart_products');
				$data['casted_value']=$casted_value=$this->get_casted_value(1);				
				$data['products'] = $this->Common_model->get_record('tbl_casted_gold_products', '*',array('status'=>1), 1,array('id','desc'));		
				$this->load->view('casted_gold_cart_ajax', $data);
			}
			else if($seg1=="casted-gold-checkout")
			{					
				if (empty($this->session->userdata('casted_gold_user')))
				{
					redirect('casted-gold-login');
				}				
				if (empty($this->session->userdata('casted_gold_cart_products')))
				{
					redirect(site_url());
				}
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>8),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$data['org_price'] = $org_price='1853.65';
				$data['dollar_price'] = $dollar_price='75.555';
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_gold_checkout', $data);
				$this->load->view($this->footer);		
			}
			else if($seg1=="casted_gold_checkout_ajax")
			{		
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$user_id=$this->session->userdata('casted_gold_user');
				$data['urecord'] =$urecord= $this->Common_model->get_record('tbl_casted_gold_users', '*',array('id'=>$user_id),2);
				$data['cart_products']=$this->session->userdata('casted_gold_cart_products');
				$data['casted_value']=$casted_value=$this->get_casted_value(1);				
				$data['products'] = $this->Common_model->get_record('tbl_casted_gold_products', '*',array('status'=>1), 1,array('id','desc'));	
				if(!empty($_POST['promoter_id'])){
					$promoter_id=$_POST['promoter_id'];
					$data['promoter'] =$promoter= $this->Common_model->get_record('tbl_casted_gold_promoters', '*',array('unique_code'=>$promoter_id),2);
				}
				$this->load->view('casted_gold_checkout_ajax', $data);
			}
			else if ($seg1 == "casted_gold_order_ajax")
			{			
				$casted_value=$this->get_casted_value(1);
				$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);
				$user_id=$this->session->userdata('casted_gold_user');
				$user= $this->Common_model->get_record('tbl_casted_gold_users', '*',array('id'=>$user_id),2);
				$cart_products=$this->session->userdata('casted_gold_cart_products');
				
				$dealer_id=$this->session->userdata('casted_gold_dealer');
				$dealer= $this->Common_model->get_record('tbl_pickup_dealers', '*',array('id'=>$dealer_id),2);
				$pickup= $this->Common_model->get_record('tbl_pickup_places', '*',array('id'=>$dealer['place_id']),2);
				
				$total_amount=0;
				$total_weight=0;
				if(!empty($cart_products)){
				foreach($cart_products as $pkey=>$prow)
				{
					$qty=$prow['qty'];
					$product = $this->Common_model->get_record('tbl_casted_gold_products', '*',array('id'=>$prow['pid']),2);
					$purity_amount=($product['purity_percentage']*$casted_value)/100;
					$price2=$casted_value-$purity_amount;
					$final_price=$price2*$product['weight'];
					$product_total=$final_price*$qty;
					$total_amount=$total_amount+$product_total;
					$product_weight=$product['weight']*$qty;
					$total_weight=$total_weight+$product_weight;
					
				}}
				$coupon_code = $this->input->post('promoter_id');				
				$coupon_amount=0;
				if(!empty($coupon_code)){
					$coupon_amount=$total_weight*$home_content['casted_gold_discount'];
					$coupon_amount=round($coupon_amount,2);
				}
				$total_amount=round($total_amount,2);
				$final_amount=$total_amount-$coupon_amount;
				$final_amount=round($final_amount,2);
				$order_date_time=date("Y-m-d H:i:s");
				$order_ref_id='ORD'.substr(str_shuffle("0123456789"), 0, 6);
				
				$add_data = array(
					'order_ref_id' => $order_ref_id,
					'user_id' => $user['id'],
					'buyer_name' => $user['name'],
					'buyer_mobile' => $user['mobile'],
					'buyer_email' => $user['email'],
					'buyer_address' => $user['address'],
					'buyer_pincode' => $user['pincode'],
					'buyer_state' => $user['state'],
					'buyer_state_code' => $user['state_code'],
					'buyer_gst_no' => $user['gst_no'],
					'buyer_pan_number' => $user['pan_number'],
					'buyer_aadhar_number' => $user['aadhar_number'],
					'pickup_state_id' => $pickup['id'],
					'pickup_state' => $pickup['name'],
					'pickup_state_code' => $pickup['state_code'],
					'pickup_dealer_id' => $dealer['id'],
					'pickup_dealer_address' => $dealer['address'],
					'total_weight' => $total_weight,
					'total_amount' => $total_amount,
					'coupon_code' => $coupon_code,
					'coupon_amount' => $coupon_amount,
					'final_amount' => $final_amount,
					'order_date_time' => $order_date_time
				);
				$result = $this->Common_model->add_record('tbl_casted_gold_orders', $add_data);
				if(!empty($result))
				{
					if(!empty($cart_products)){
					foreach($cart_products as $pkey=>$prow)
					{
						$qty=$prow['qty'];
						$product = $this->Common_model->get_record('tbl_casted_gold_products', '*',array('id'=>$prow['pid']),2);
						$category = $this->Common_model->get_record('tbl_casted_gold_categories', '*',array('id'=>$product['category_id']),2);
						
						$purity_amount=($product['purity_percentage']*$casted_value)/100;
						$price2=$casted_value-$purity_amount;
						$final_price=$price2*$product['weight'];
						$final_price=round($final_price,2);
						$product_total=$final_price*$qty;
						$product_total=round($product_total,2);
						
						$add_data1 = array(
							'order_id' => $result,
							'category_id' => $category['id'],
							'category_name' => $category['name'],
							'product_id' => $product['id'],
							'name' => $product['name'],
							'weight' => $product['weight'],
							'mrp' => $product['mrp'],
							'purity' => $product['purity'],
							'purity_percentage' => $product['purity_percentage'],
							'qty' => $qty,
							'price' => $final_price,
							'sub_total' => $product_total
						);
						$result1 = $this->Common_model->add_record('tbl_casted_gold_order_products', $add_data1);
						if(!empty($result1))
						{	
							$this ->session ->set_userdata('casted_gold_order', $result);
							$this->session->unset_userdata('casted_gold_cart_products');
							$this->session->unset_userdata('casted_gold_dealer');
						}
					}}
					$data['msg'] = 'Order Placed Successfully...';
					$data['status'] = 1;
				}else{
					$data['msg'] = 'Order Not Placed Please Try Again...';
					$data['status'] = 0;
				}
				echo json_encode($data);				
			}
			else if($seg1=="casted-gold-success")
			{					
				if (empty($this->session->userdata('casted_gold_user')))
				{
					redirect('casted-gold-login');
				}				
				if(empty($this->session->userdata('casted_gold_order'))){
					redirect(site_url());
				}
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>8),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);			
				$order_id=$this->session->userdata('casted_gold_order');	
				$data['order'] =$order= $this->Common_model->get_record('tbl_casted_gold_orders', '*',array('id'=>$order_id),2);	
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_gold_success', $data);
				$this->load->view($this->footer);		
			}
			else if ($seg1 == "casted_gold_sales_download_admin")
			{
				$id = $this->input->get('id');
			   
				$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
				$data['record'] =$this->Common_model->get_record('tbl_casted_gold_orders','*',array('id'=>$id),2);
				
				$data['order_products'] =$this->Common_model->get_record('tbl_casted_gold_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


				$invoice_page=$this->load->view('casted_gold_sales_invoice_admin',$data,TRUE);


				$pdfFilePath = "Invoice(".$id.").pdf";
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
				$this->m_pdf->pdf->WriteHTML($invoice_page);
				$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
			}
			else if ($seg1 == "casted_gold_sales_download_customer")
			{
				$id = $this->input->get('id');
			   
				$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
				$data['record'] =$this->Common_model->get_record('tbl_casted_gold_orders','*',array('id'=>$id),2);
				
				$data['order_products'] =$this->Common_model->get_record('tbl_casted_gold_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


				$invoice_page=$this->load->view('casted_gold_sales_invoice_customer',$data,TRUE);


				$pdfFilePath = "Invoice(".$id.").pdf";
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
				$this->m_pdf->pdf->WriteHTML($invoice_page);
				$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
			}
			else if ($seg1 == "casted_gold_sales_download_pickup")
			{
				$id = $this->input->get('id');
			   
				$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
				$data['record'] =$this->Common_model->get_record('tbl_casted_gold_orders','*',array('id'=>$id),2);
				
				$data['order_products'] =$this->Common_model->get_record('tbl_casted_gold_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


				$invoice_page=$this->load->view('casted_gold_sales_invoice_pickup',$data,TRUE);


				$pdfFilePath = "Invoice(".$id.").pdf";
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
				$this->m_pdf->pdf->WriteHTML($invoice_page);
				$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
			}
			else if($seg1=="casted-gold-dashboard")
			{		
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$this->load->view('casted_gold_dashboard', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="casted_gold_dashboard_check")
			{		
				$unique_code = $this->input->post('unique_code');					
				$password = $this->input->post('password');	
				$password=encode5t($password);
				$data['erecord']=$erecord =$this->Common_model->get_record('tbl_casted_gold_employees','*',array('unique_code'=>$unique_code,'password'=>$password),2);	
				$data['precord']=$precord =$this->Common_model->get_record('tbl_casted_gold_promoters','*',array('unique_code'=>$unique_code,'password'=>$password),2);	
				$data['commission'] = $this->Common_model->get_record('tbl_casted_gold_commission', '*',array('id' => 1) , 2);
				if(!empty($erecord)){	
					$data['type']=0;
					$data['emp_id']=$erecord['id'];
					$data['from_date']=$from_date=date("Y-m-d");
					$data['to_date']=$to_date=date("Y-m-d");
                    $data['records'] = $this->Welcome_model->get_casted_gold_emp_sales($erecord['id'],$from_date,$to_date);
					$this->load->view('casted_gold_dashboard_ajax', $data); 
				}else if(!empty($precord)){	
					$data['type']=1;
					$data['emp_id']=$precord['id'];
					$data['from_date']=$from_date=date("Y-m-d");
					$data['to_date']=$to_date=date("Y-m-d");
                    $data['records'] = $this->Welcome_model->get_casted_gold_pro_sales($precord['id'],$from_date,$to_date);
					$this->load->view('casted_gold_dashboard_ajax', $data); 
				}else{	
					echo '<h4 class="text-center text-danger">Invalid Credentials</h4>';
				}					
			}
			else if($seg1=="casted_gold_dashboard_ajax")
			{		
				$data['commission'] = $this->Common_model->get_record('tbl_casted_gold_commission', '*',array('id' => 1) , 2);
				$data['type']=$type = $this->input->post('type');					
				$data['emp_id']=$emp_id = $this->input->post('emp_id');					
				$data['from_date']=$from_date = $this->input->post('from_date');
				$data['to_date']=$to_date = $this->input->post('to_date');
				if($type==0){	
                    $data['records'] = $this->Welcome_model->get_casted_gold_emp_sales($emp_id,$from_date,$to_date);
				}else{
                    $data['records'] = $this->Welcome_model->get_casted_gold_pro_sales($emp_id,$from_date,$to_date);
				}
				$this->load->view('casted_gold_dashboard_ajax', $data);
			}
			else if($seg1=="casted-silver")
			{				
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($home_content)){
					$seo_tags['title']=$home_content['title'];
					$seo_tags['meta_description']=$home_content['meta_description'];
					$seo_tags['meta_tags']=$home_content['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;	
				$categories = $this->Common_model->get_record('tbl_casted_silver_categories', '*',array('status'=>1), 1,array('display_order','asc'));
				$data['casted_value']=$casted_value=$this->get_casted_value(4);
				$all_categories=array();
				if(!empty($categories)){
				foreach($categories as $key=>$row){
					$row['products'] = $this->Common_model->get_record('tbl_casted_silver_products', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$row['ads'] = $this->Common_model->get_record('tbl_casted_silver_ads', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$all_categories[]=$row;
				}}
				$data['categories']=$all_categories;					
				$this->load->view($this->header, $seo);
				$this->load->view('casted_silver_products', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="casted_silver_loop")
			{		
				$data['casted_value']=$casted_value=$this->get_casted_value(4);
				$categories = $this->Common_model->get_record('tbl_casted_silver_categories', '*',array('status'=>1), 1,array('display_order','asc'));	
				$all_categories=array();
				if(!empty($categories)){
				foreach($categories as $key=>$row){
					$row['products'] = $this->Common_model->get_record('tbl_casted_silver_products', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$row['ads'] = $this->Common_model->get_record('tbl_casted_silver_ads', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$all_categories[]=$row;
				}}
				$data['categories']=$all_categories;	
				$this->load->view('casted_silver_products_loop', $data);
			}
			else if($seg1=="casted-silver-logout")
			{
				$this ->session ->unset_userdata('casted_silver_user');
				redirect('casted-silver-login');
			}
			else if($seg1=="casted-silver-login")
			{						
				if (!empty($this->session->userdata('casted_silver_user')))
				{
					redirect('casted-silver-booking');
				}				
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>7),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']='Casted Gold Login';
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_silver_login', $data);
				$this->load->view($this->footer);		
			}
			else if($seg1=="casted_silver_login_ajax")
			{
				if ($this->input->post('unique_code') != '')
				{
					$unique_code = $this->input->post('unique_code');
					$password = $this->input->post('password');
					$encode_password = encode5t($password);
					$record = $this->Common_model->get_record('tbl_casted_silver_users', '*', array('unique_code'=>$unique_code,'password'=>$encode_password),2);
					if (!empty($record))
					{
						if($record['status']=='1'){
							$this ->session ->set_userdata('casted_silver_user', $record['id']);
							$data['msg'] = 'Login Successfull...';
							$data['status'] = 1;
						}
						else
						{
							$data['msg'] = 'Your account is not active please contact admin ...';
							$data['status'] = 0;
						}
					}
					else
					{
						$data['msg'] = 'Unique Code Or Password Did Not Match ...';
						$data['status'] = 0;
					}
				}
				echo json_encode($data);
			}
			else if($seg1=="casted-silver-user-dashboard")
			{						
				if (empty($this->session->userdata('casted_silver_user')))
				{
					redirect('casted-silver-login');
				}
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>7),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_silver_user_dashboard', $data);
				$this->load->view($this->footer);		
			}
			else if($seg1=="casted_silver_user_dashboard_ajax")
			{		
				$user_id=$this->session->userdata('casted_silver_user');
				$data['record']=$record =$this->Common_model->get_record('tbl_casted_silver_users','*',array('id'=>$user_id),2);
				if(!empty($record)){	
					if(!empty($_POST)){	
						$data['from_date']=$from_date=date("Y-m-d",strtotime($_POST['from_date']));
						$data['to_date']=$to_date=date("Y-m-d",strtotime($_POST['to_date']));
					}else{
						$data['from_date']=$from_date=date("Y-m-d");
						$data['to_date']=$to_date=date("Y-m-d");
					}
					$where="user_id=".$user_id." AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
					$data['records'] = $this->Common_model->get_record('tbl_casted_silver_orders', '*',$where,1,array('id','desc'));
					$this->load->view('casted_silver_user_dashboard_ajax', $data); 
				}else{	
					echo '<h4 class="text-center text-danger">Invalid Credentials</h4>';
				}					
			}
			else if($seg1=="casted-silver-register")
			{						
				if (!empty($this->session->userdata('casted_silver_user')))
				{
					redirect('casted-booking');
				}
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>7),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_silver_register', $data);
				$this->load->view($this->footer);		
			}
			else if ($seg1 == "get_casted_silver_promoter")
			{
				$promoter_id = $this->input->post('promoter_id');
				$precord = $this->Common_model->get_record('tbl_casted_silver_promoters', '*', array('unique_code'=>$promoter_id),2);
				if(!empty($precord))
				{
					echo $precord['name'];
				}				
			}
			else if ($seg1 == "casted_silver_register_ajax")
			{
				$name_type = $this->input->post('name_type');
				$name = $this->input->post('name');
				$email = $this->input->post('email');
				$mobile = $this->input->post('mobile');
				$company_type = $this->input->post('company_type');
				$company_name = $this->input->post('company_name');
				$pan_number = $this->input->post('pan_number');
				$aadhar_number = $this->input->post('aadhar_number');
				$firm_type = $this->input->post('firm_type');
				$gst_no = $this->input->post('gst_no');
				$shop_type = $this->input->post('shop_type');
				$grams = $this->input->post('grams');
				$kgs = $this->input->post('kgs');
				$silver_grams = $this->input->post('silver_grams');
				$silver_kgs = $this->input->post('silver_kgs');
				$state = $this->input->post('state');
				$state_code = $this->input->post('state_code');
				$district = $this->input->post('district');
				$pincode = $this->input->post('pincode');
				$address = $this->input->post('address');
				$bank_account_type = $this->input->post('bank_account_type');
				$bank_name = $this->input->post('bank_name');
				$account_number = $this->input->post('account_number');
				$ifsc_code = $this->input->post('ifsc_code');
				$promoter_id = $this->input->post('promoter_id');
				$promoter_name = $this->input->post('promoter_name');
				$remarks = $this->input->post('remarks');
				$add_data = array(
					'name_type' => $name_type,
					'name' => $name,
					'email' => $email,
					'mobile' => $mobile,
					'company_type' => $company_type,
					'company_name' => $company_name,
					'pan_number' => $pan_number,
					'aadhar_number' => $aadhar_number,
					'firm_type' => $firm_type,
					'gst_no' => $gst_no,
					'shop_type' => $shop_type,
					'grams' => $grams,
					'kgs' => $kgs,
					'silver_grams' => $silver_grams,
					'silver_kgs' => $silver_kgs,
					'state' => $state,
					'state_code' => $state_code,
					'district' => $district,
					'pincode' => $pincode,
					'address' => $address,
					'bank_account_type' => $bank_account_type,
					'bank_name' => $bank_name,
					'account_number' => $account_number,
					'ifsc_code' => $ifsc_code,
					'promoter_id' => $promoter_id,
					'promoter_name' => $promoter_name,
					'remarks' => $remarks,
					'created_date_time' => date("Y-m-d H:i:s")
				);
				$where="mobile='".$mobile."' OR email='".$email."'";
				$record = $this->Common_model->get_record('tbl_casted_silver_users', '*', $where,2);
				$precord = $this->Common_model->get_record('tbl_casted_silver_promoters', '*', array('unique_code'=>$promoter_id),2);
				if(!empty($record))
				{
					$data['msg'] = 'Email ID or Mobile Number already exists...';
					$data['status'] = 0;
				}
				else if(empty($precord))
				{
					$data['msg'] = 'Invalid Promoter...';
					$data['status'] = 0;
				}
				else
				{
					$result = $this->Common_model->add_record('tbl_casted_silver_users', $add_data);
					if (!empty($result))
					{
						$data['msg'] = 'Registered Successfully Login Credentials will be sent to your email after verification...';
						$data['status'] = 1;
					}
					else
					{
						$data['msg'] = 'Not Submitted...';
						$data['status'] = 0;
					}
				}
				echo json_encode($data);
			}
			else if($seg1=="casted-silver-booking")
			{					
				if (empty($this->session->userdata('casted_silver_user')))
				{
					redirect('casted-silver-login');
				}
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>8),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$data['places'] =$places=$this->Common_model->get_record('tbl_pickup_places','*',array('status'=>1),1,array('id','desc'));
				if(!empty($this->session->userdata('casted_silver_dealer'))){
					$dealer_id=$this->session->userdata('casted_silver_dealer');
					$data['dealer'] =$dealer= $this->Common_model->get_record('tbl_pickup_dealers', '*',array('id'=>$dealer_id),2);
					$data['dealers'] =$dealers=$this->Common_model->get_record('tbl_pickup_dealers','*',array('place_id'=>$dealer['place_id'],'status'=>1),1,array('id','desc'));
				}
				$data['org_price'] = $org_price='1853.65';
				$data['dollar_price'] = $dollar_price='75.555';
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_silver_booking', $data);
				$this->load->view($this->footer);		
			}
			else if ($seg1 == "casted_silver_pickup_ajax")
			{
				$dealer_id = $this->input->post('dealer_id');
				$this ->session ->set_userdata('casted_silver_dealer', $dealer_id);
			}
			else if($seg1=="casted_silver_add_cart")
			{						
				$pid=$this->input->post('pid');
				$qty=$this->input->post('qty');
				$casted_silver_cart_products=$this->session->userdata('casted_silver_cart_products');
				if(!empty($casted_silver_cart_products))
				{
					$ava=0;
					foreach($casted_silver_cart_products as $key=>$row)
					{
						if($row['pid']==$pid)
						{	
							$ava=1;							
							$casted_silver_cart_products[$key]['qty'] = $qty;
							if($qty==0){
								unset($casted_silver_cart_products[$key]);
								$casted_silver_cart_products = array_values($casted_silver_cart_products);
							}
						}
					}
					if($ava==0){						
						$casted_silver_cart_products[] = array(
						'pid' => $pid,
						'qty' => $qty
						);
					}
				}
				else
				{							
					$casted_silver_cart_products[] = array(
					'pid' => $pid,
					'qty' => $qty
					);
				}
				$this->session->set_userdata('casted_silver_cart_products',$casted_silver_cart_products);
			}
			else if($seg1=="casted-silver-cart")
			{					
				if (empty($this->session->userdata('casted_silver_user')))
				{
					redirect('casted-silver-login');
				}				
				if (empty($this->session->userdata('casted_silver_cart_products')))
				{
					redirect(site_url());
				}
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>8),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$data['org_price'] = $org_price='1853.65';
				$data['dollar_price'] = $dollar_price='75.555';
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_silver_cart', $data);
				$this->load->view($this->footer);		
			}
			else if($seg1=="casted_silver_cart_ajax")
			{		
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$user_id=$this->session->userdata('casted_silver_user');
				$data['urecord'] =$urecord= $this->Common_model->get_record('tbl_casted_silver_users', '*',array('id'=>$user_id),2);
				$data['cart_products']=$this->session->userdata('casted_silver_cart_products');
				$data['casted_value']=$casted_value=$this->get_casted_value(4);				
				$data['products'] = $this->Common_model->get_record('tbl_casted_silver_products', '*',array('status'=>1), 1,array('id','desc'));		
				$this->load->view('casted_silver_cart_ajax', $data);
			}
			else if($seg1=="casted-silver-checkout")
			{					
				if (empty($this->session->userdata('casted_silver_user')))
				{
					redirect('casted-silver-login');
				}				
				if (empty($this->session->userdata('casted_silver_cart_products')))
				{
					redirect(site_url());
				}
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>8),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$data['org_price'] = $org_price='1853.65';
				$data['dollar_price'] = $dollar_price='75.555';
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_silver_checkout', $data);
				$this->load->view($this->footer);		
			}
			else if($seg1=="casted_silver_checkout_ajax")
			{		
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$user_id=$this->session->userdata('casted_silver_user');
				$data['urecord'] =$urecord= $this->Common_model->get_record('tbl_casted_silver_users', '*',array('id'=>$user_id),2);
				$data['cart_products']=$this->session->userdata('casted_silver_cart_products');
				$data['casted_value']=$casted_value=$this->get_casted_value(4);				
				$data['products'] = $this->Common_model->get_record('tbl_casted_silver_products', '*',array('status'=>1), 1,array('id','desc'));	
				if(!empty($_POST['promoter_id'])){
					$promoter_id=$_POST['promoter_id'];
					$data['promoter'] =$promoter= $this->Common_model->get_record('tbl_casted_silver_promoters', '*',array('unique_code'=>$promoter_id),2);
				}
				$this->load->view('casted_silver_checkout_ajax', $data);
			}
			else if ($seg1 == "casted_silver_order_ajax")
			{			
				$casted_value=$this->get_casted_value(4);
				$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);
				$user_id=$this->session->userdata('casted_silver_user');
				$user= $this->Common_model->get_record('tbl_casted_silver_users', '*',array('id'=>$user_id),2);
				$cart_products=$this->session->userdata('casted_silver_cart_products');
				
				$dealer_id=$this->session->userdata('casted_silver_dealer');
				$dealer= $this->Common_model->get_record('tbl_pickup_dealers', '*',array('id'=>$dealer_id),2);
				$pickup= $this->Common_model->get_record('tbl_pickup_places', '*',array('id'=>$dealer['place_id']),2);
				
				$total_amount=0;
				$total_weight=0;
				if(!empty($cart_products)){
				foreach($cart_products as $pkey=>$prow)
				{
					$qty=$prow['qty'];
					$product = $this->Common_model->get_record('tbl_casted_silver_products', '*',array('id'=>$prow['pid']),2);
					$purity_amount=($product['purity_percentage']*$casted_value)/100;
					$price2=$casted_value-$purity_amount;
					$final_price=$price2*$product['weight'];
					$product_total=$final_price*$qty;
					$total_amount=$total_amount+$product_total;
					$product_weight=$product['weight']*$qty;
					$total_weight=$total_weight+$product_weight;
					
				}}
				$coupon_code = $this->input->post('promoter_id');				
				$coupon_amount=0;
				if(!empty($coupon_code)){
					$coupon_amount=$total_weight*$home_content['casted_silver_discount'];
					$coupon_amount=round($coupon_amount,2);
				}
				$total_amount=round($total_amount,2);
				$final_amount=$total_amount-$coupon_amount;
				$final_amount=round($final_amount,2);
				$order_date_time=date("Y-m-d H:i:s");
				$order_ref_id='ORD'.substr(str_shuffle("0123456789"), 0, 6);
				
				$add_data = array(
					'order_ref_id' => $order_ref_id,
					'user_id' => $user['id'],
					'buyer_name' => $user['name'],
					'buyer_mobile' => $user['mobile'],
					'buyer_email' => $user['email'],
					'buyer_address' => $user['address'],
					'buyer_pincode' => $user['pincode'],
					'buyer_state' => $user['state'],
					'buyer_state_code' => $user['state_code'],
					'buyer_gst_no' => $user['gst_no'],
					'buyer_pan_number' => $user['pan_number'],
					'buyer_aadhar_number' => $user['aadhar_number'],
					'pickup_state_id' => $pickup['id'],
					'pickup_state' => $pickup['name'],
					'pickup_state_code' => $pickup['state_code'],
					'pickup_dealer_id' => $dealer['id'],
					'pickup_dealer_address' => $dealer['address'],
					'total_weight' => $total_weight,
					'total_amount' => $total_amount,
					'coupon_code' => $coupon_code,
					'coupon_amount' => $coupon_amount,
					'final_amount' => $final_amount,
					'order_date_time' => $order_date_time
				);
				$result = $this->Common_model->add_record('tbl_casted_silver_orders', $add_data);
				if(!empty($result))
				{
					if(!empty($cart_products)){
					foreach($cart_products as $pkey=>$prow)
					{
						$qty=$prow['qty'];
						$product = $this->Common_model->get_record('tbl_casted_silver_products', '*',array('id'=>$prow['pid']),2);
						$category = $this->Common_model->get_record('tbl_casted_silver_categories', '*',array('id'=>$product['category_id']),2);
						
						$purity_amount=($product['purity_percentage']*$casted_value)/100;
						$price2=$casted_value-$purity_amount;
						$final_price=$price2*$product['weight'];
						$final_price=round($final_price,2);
						$product_total=$final_price*$qty;
						$product_total=round($product_total,2);
						
						$add_data1 = array(
							'order_id' => $result,
							'category_id' => $category['id'],
							'category_name' => $category['name'],
							'product_id' => $product['id'],
							'name' => $product['name'],
							'weight' => $product['weight'],
							'mrp' => $product['mrp'],
							'purity' => $product['purity'],
							'purity_percentage' => $product['purity_percentage'],
							'qty' => $qty,
							'price' => $final_price,
							'sub_total' => $product_total
						);
						$result1 = $this->Common_model->add_record('tbl_casted_silver_order_products', $add_data1);
						if(!empty($result1))
						{	
							$this ->session ->set_userdata('casted_silver_order', $result);
							$this->session->unset_userdata('casted_silver_cart_products');
							$this->session->unset_userdata('casted_silver_dealer');
						}
					}}
					$data['msg'] = 'Order Placed Successfully...';
					$data['status'] = 1;
				}else{
					$data['msg'] = 'Order Not Placed Please Try Again...';
					$data['status'] = 0;
				}
				echo json_encode($data);				
			}
			else if($seg1=="casted-silver-success")
			{					
				if (empty($this->session->userdata('casted_silver_user')))
				{
					redirect('casted-silver-login');
				}				
				if(empty($this->session->userdata('casted_silver_order'))){
					redirect(site_url());
				}
				$data['record'] =$record= $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>8),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);			
				$order_id=$this->session->userdata('casted_silver_order');	
				$data['order'] =$order= $this->Common_model->get_record('tbl_casted_silver_orders', '*',array('id'=>$order_id),2);	
				$this->load->view($this->header, $seo);			
				$this->load->view('casted_silver_success', $data);
				$this->load->view($this->footer);		
			}
			else if ($seg1 == "casted_silver_sales_download_admin")
			{
				$id = $this->input->get('id');
			   
				$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
				$data['record'] =$this->Common_model->get_record('tbl_casted_silver_orders','*',array('id'=>$id),2);
				
				$data['order_products'] =$this->Common_model->get_record('tbl_casted_silver_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


				$invoice_page=$this->load->view('casted_silver_sales_invoice_admin',$data,TRUE);


				$pdfFilePath = "Invoice(".$id.").pdf";
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
				$this->m_pdf->pdf->WriteHTML($invoice_page);
				$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
			}
			else if ($seg1 == "casted_silver_sales_download_customer")
			{
				$id = $this->input->get('id');
			   
				$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
				$data['record'] =$this->Common_model->get_record('tbl_casted_silver_orders','*',array('id'=>$id),2);
				
				$data['order_products'] =$this->Common_model->get_record('tbl_casted_silver_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


				$invoice_page=$this->load->view('casted_silver_sales_invoice_customer',$data,TRUE);


				$pdfFilePath = "Invoice(".$id.").pdf";
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
				$this->m_pdf->pdf->WriteHTML($invoice_page);
				$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
			}
			else if ($seg1 == "casted_silver_sales_download_pickup")
			{
				$id = $this->input->get('id');
			   
				$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
				$data['record'] =$this->Common_model->get_record('tbl_casted_silver_orders','*',array('id'=>$id),2);
				
				$data['order_products'] =$this->Common_model->get_record('tbl_casted_silver_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


				$invoice_page=$this->load->view('casted_silver_sales_invoice_pickup',$data,TRUE);


				$pdfFilePath = "Invoice(".$id.").pdf";
				$this->load->library('m_pdf');
				$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
				$this->m_pdf->pdf->WriteHTML($invoice_page);
				$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
			}
			else if($seg1=="casted-silver-dashboard")
			{		
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$this->load->view('casted_silver_dashboard', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="casted_silver_dashboard_check")
			{		
				$unique_code = $this->input->post('unique_code');					
				$password = $this->input->post('password');	
				$password=encode5t($password);
				$data['erecord']=$erecord =$this->Common_model->get_record('tbl_casted_silver_employees','*',array('unique_code'=>$unique_code,'password'=>$password),2);	
				$data['precord']=$precord =$this->Common_model->get_record('tbl_casted_silver_promoters','*',array('unique_code'=>$unique_code,'password'=>$password),2);	
				$data['commission'] = $this->Common_model->get_record('tbl_casted_silver_commission', '*',array('id' => 1) , 2);
				if(!empty($erecord)){	
					$data['type']=0;
					$data['emp_id']=$erecord['id'];
					$data['from_date']=$from_date=date("Y-m-d");
					$data['to_date']=$to_date=date("Y-m-d");
                    $data['records'] = $this->Welcome_model->get_casted_silver_emp_sales($erecord['id'],$from_date,$to_date);
					$this->load->view('casted_silver_dashboard_ajax', $data); 
				}else if(!empty($precord)){	
					$data['type']=1;
					$data['emp_id']=$precord['id'];
					$data['from_date']=$from_date=date("Y-m-d");
					$data['to_date']=$to_date=date("Y-m-d");
                    $data['records'] = $this->Welcome_model->get_casted_silver_pro_sales($precord['id'],$from_date,$to_date);
					$this->load->view('casted_silver_dashboard_ajax', $data); 
				}else{	
					echo '<h4 class="text-center text-danger">Invalid Credentials</h4>';
				}					
			}
			else if($seg1=="casted_silver_dashboard_ajax")
			{		
				$data['commission'] = $this->Common_model->get_record('tbl_casted_silver_commission', '*',array('id' => 1) , 2);
				$data['type']=$type = $this->input->post('type');					
				$data['emp_id']=$emp_id = $this->input->post('emp_id');					
				$data['from_date']=$from_date = $this->input->post('from_date');
				$data['to_date']=$to_date = $this->input->post('to_date');
				if($type==0){	
                    $data['records'] = $this->Welcome_model->get_casted_silver_emp_sales($emp_id,$from_date,$to_date);
				}else{
                    $data['records'] = $this->Welcome_model->get_casted_silver_pro_sales($emp_id,$from_date,$to_date);
				}
				$this->load->view('casted_silver_dashboard_ajax', $data);
			}
			else if($seg1=="minted-gold")
			{				
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($home_content)){
					$seo_tags['title']=$home_content['title'];
					$seo_tags['meta_description']=$home_content['meta_description'];
					$seo_tags['meta_tags']=$home_content['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;	
				$data['minted_value']=$minted_value=$this->get_minted_value(2);
				$data['crecord']= $this->Common_model->get_record('tbl_categories', '*',array('id'=>2), 2);	
				$categories = $this->Common_model->get_record('tbl_minted_categories', '*',array('status'=>1), 1,array('display_order','asc'));	
				$all_categories=array();
				if(!empty($categories)){
				foreach($categories as $key=>$row){
					$row['products'] = $this->Common_model->get_record('tbl_minted_products', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$row['ads'] = $this->Common_model->get_record('tbl_minted_ads', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$all_categories[]=$row;
				}}
				$data['categories']=$all_categories;					
				$this->load->view($this->header, $seo);
				$this->load->view('minted_products', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="minted_gold_loop")
			{				
				$data['minted_value']=$minted_value=$this->get_minted_value(2);
				$data['crecord']= $this->Common_model->get_record('tbl_categories', '*',array('id'=>2), 2);	
				$categories = $this->Common_model->get_record('tbl_minted_categories', '*',array('status'=>1), 1,array('display_order','asc'));	
				$all_categories=array();
				if(!empty($categories)){
				foreach($categories as $key=>$row){
					$row['products'] = $this->Common_model->get_record('tbl_minted_products', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$row['ads'] = $this->Common_model->get_record('tbl_minted_ads', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$all_categories[]=$row;
				}}
				$data['categories']=$all_categories;		
				$this->load->view('minted_products_loop', $data);
			}
			else if($seg1=="minted_add_cart")
			{						
				$pid=$this->input->post('pid');
				$qty=$this->input->post('qty');
				$minted_cart_products=$this->session->userdata('minted_cart_products');
				if(!empty($minted_cart_products))
				{
					$ava=0;
					foreach($minted_cart_products as $key=>$row)
					{
						if($row['pid']==$pid)
						{	
							$ava=1;							
							$minted_cart_products[$key]['qty'] = $qty;
						}
					}
					if($ava==0){						
						$minted_cart_products[] = array(
						'pid' => $pid,
						'qty' => $qty
						);
					}
				}
				else
				{							
					$minted_cart_products[] = array(
					'pid' => $pid,
					'qty' => $qty
					);
				}
				$this->session->set_userdata('minted_cart_products',$minted_cart_products);
			}
			else if($seg1=="minted_remove_cart")
			{						
				$pid=$this->input->post('pid');
				$minted_cart_products=$this->session->userdata('minted_cart_products');
				if(!empty($minted_cart_products))
				{
					foreach($minted_cart_products as $key=>$row)
					{
						if($row['pid']=$pid)
						{							
							unset($minted_cart_products[$key]);
							$minted_cart_products = array_values($minted_cart_products);
						}
					}
				}
				$this->session->set_userdata('minted_cart_products',$minted_cart_products);
			}
			else if($seg1=="minted-cart")
			{				
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($home_content)){
					$seo_tags['title']=$home_content['title'];
					$seo_tags['meta_description']=$home_content['meta_description'];
					$seo_tags['meta_tags']=$home_content['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;	
				$minted_cart_products=$this->session->userdata('minted_cart_products');
				$records=array();
				if(!empty($minted_cart_products)){
				foreach($minted_cart_products as $key=>$row){
					$product = $this->Common_model->get_record('tbl_minted_products', '*',array('id'=>$row['pid']),2);
					$product['qty']=$row['qty'];	
					$records[] =$product;
				}}
				$data['records']=$records;				
				$this->load->view($this->header, $seo);
				$this->load->view('minted_cart', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="minted_cart_ajax")
			{		
				$minted_cart_products=$this->session->userdata('minted_cart_products');
				$records=array();
				if(!empty($minted_cart_products)){
				foreach($minted_cart_products as $key=>$row){
					$product = $this->Common_model->get_record('tbl_minted_products', '*',array('id'=>$row['pid']),2);
					$product['qty']=$row['qty'];	
					$records[] =$product;
				}}
				$data['records']=$records;				
				$this->load->view('minted_cart_ajax', $data);
			}
			else if($seg1=="minted-silver")
			{				
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($home_content)){
					$seo_tags['title']=$home_content['title'];
					$seo_tags['meta_description']=$home_content['meta_description'];
					$seo_tags['meta_tags']=$home_content['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;	
				$data['minted_value']=$minted_value=$this->get_minted_value(5);
				$data['crecord']= $this->Common_model->get_record('tbl_categories', '*',array('id'=>5), 2);	
				$categories = $this->Common_model->get_record('tbl_minted_silver_categories', '*',array('status'=>1), 1,array('display_order','asc'));	
				$all_categories=array();
				if(!empty($categories)){
				foreach($categories as $key=>$row){
					$row['products'] = $this->Common_model->get_record('tbl_minted_silver_products', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$row['ads'] = $this->Common_model->get_record('tbl_minted_silver_ads', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$all_categories[]=$row;
				}}
				$data['categories']=$all_categories;					
				$this->load->view($this->header, $seo);
				$this->load->view('minted_silver_products', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="minted_silver_loop")
			{					
				$data['minted_value']=$minted_value=$this->get_minted_value(5);
				$data['crecord']= $this->Common_model->get_record('tbl_categories', '*',array('id'=>5), 2);	
				$categories = $this->Common_model->get_record('tbl_minted_silver_categories', '*',array('status'=>1), 1,array('display_order','asc'));	
				$all_categories=array();
				if(!empty($categories)){
				foreach($categories as $key=>$row){
					$row['products'] = $this->Common_model->get_record('tbl_minted_silver_products', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$row['ads'] = $this->Common_model->get_record('tbl_minted_silver_ads', '*',array('category_id'=>$row['id']), 1,array('id','desc'));
					$all_categories[]=$row;
				}}
				$data['categories']=$all_categories;		
				$this->load->view('minted_silver_products_loop', $data);
			}
			else if($seg1=="minted_silver_add_cart")
			{						
				$pid=$this->input->post('pid');
				$qty=$this->input->post('qty');
				$minted_silver_cart_products=$this->session->userdata('minted_silver_cart_products');
				if(!empty($minted_silver_cart_products))
				{
					$ava=0;
					foreach($minted_silver_cart_products as $key=>$row)
					{
						if($row['pid']==$pid)
						{	
							$ava=1;							
							$minted_silver_cart_products[$key]['qty'] = $qty;
						}
					}
					if($ava==0){						
						$minted_silver_cart_products[] = array(
						'pid' => $pid,
						'qty' => $qty
						);
					}
				}
				else
				{							
					$minted_silver_cart_products[] = array(
					'pid' => $pid,
					'qty' => $qty
					);
				}
				$this->session->set_userdata('minted_silver_cart_products',$minted_silver_cart_products);
			}
			else if($seg1=="minted_silver_remove_cart")
			{						
				$pid=$this->input->post('pid');
				$minted_silver_cart_products=$this->session->userdata('minted_silver_cart_products');
				if(!empty($minted_silver_cart_products))
				{
					foreach($minted_silver_cart_products as $key=>$row)
					{
						if($row['pid']=$pid)
						{							
							unset($minted_silver_cart_products[$key]);
							$minted_silver_cart_products = array_values($minted_silver_cart_products);
						}
					}
				}
				$this->session->set_userdata('minted_silver_cart_products',$minted_silver_cart_products);
			}
			else if($seg1=="minted-silver-cart")
			{				
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($home_content)){
					$seo_tags['title']=$home_content['title'];
					$seo_tags['meta_description']=$home_content['meta_description'];
					$seo_tags['meta_tags']=$home_content['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;	
				$minted_silver_cart_products=$this->session->userdata('minted_silver_cart_products');
				$records=array();
				if(!empty($minted_silver_cart_products)){
				foreach($minted_silver_cart_products as $key=>$row){
					$product = $this->Common_model->get_record('tbl_minted_silver_products', '*',array('id'=>$row['pid']),2);
					$product['qty']=$row['qty'];	
					$records[] =$product;
				}}
				$data['records']=$records;				
				$this->load->view($this->header, $seo);
				$this->load->view('minted_silver_cart', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="minted_silver_cart_ajax")
			{		
				$minted_silver_cart_products=$this->session->userdata('minted_silver_cart_products');
				$records=array();
				if(!empty($minted_silver_cart_products)){
				foreach($minted_silver_cart_products as $key=>$row){
					$product = $this->Common_model->get_record('tbl_minted_silver_products', '*',array('id'=>$row['pid']),2);
					$product['qty']=$row['qty'];	
					$records[] =$product;
				}}
				$data['records']=$records;				
				$this->load->view('minted_silver_cart_ajax', $data);
			}
			else if ($seg1 == "get_dealers")
			{
				$place_id = $this->input->post('place_id');
				$records=$this->Common_model->get_record('tbl_pickup_dealers','*',array('place_id'=>$place_id,'status'=>1),1,array('id','desc'));
				$html='<option value="">Select</option>';
				if(!empty($records)){		
				foreach ($records as $key => $row){
				$html .='<option value="'.$row['id'].'">'.$row['address'].'</option>';
				}}
				echo $html;	
				
			} 
			else if($seg1=="about")
			{		
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$data['pdfs'] = $this->Common_model->get_record('tbl_about_pdf', '*',array('status'=>1),1,array('position','asc'));	
				$this->load->view('about', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="selling-authority")
			{			
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>2),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$this->load->view('selling-authority', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="our-supporters")
			{			
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>3),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$this->load->view('our-supporters', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="contact")
			{			
				$data['record']=$record = $this->Common_model->get_record('tbl_contact_us_details', '*', array('id' => 1) , 2);
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;	
				$data['addresses']=$addresses = $this->Common_model->get_record('tbl_contact_addresses', '*', array('status' => 1) , 1,array('id','desc'));	
				$this->load->view($this->header, $seo);
				$this->load->view('contact', $data);
				$this->load->view($this->footer);	
			}
			else if($seg1=="contact_ajax")
			{						
				$name = $this->input->post('name');
				$mobile = $this->input->post('mobile');
				$email = $this->input->post('email');
				$subject = $this->input->post('subject');
				$add_data = array(
					'name' => $name,
					'mobile' => $mobile,
					'email' => $email,
					'subject' => $subject,
					'contacted_date_time' => date("Y-m-d H:i:s")
				);
				$result = $this->Common_model->add_record('tbl_contact_us_enquiries', $add_data);
				if (!empty($result))
				{
					$data['msg'] = 'Submitted Successfully...';
					$data['status'] = 1;
				}
				else
				{
					$data['msg'] = 'Not Submitted...';
					$data['status'] = 0;
				}
				echo json_encode($data);
			}
			else if($seg1=="faqs")
			{				
				$data['records'] = $this->Welcome_model->get_faqs();	
				$data['home_content'] =$home_content= $this->Common_model->get_record('tbl_home_content', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($home_content)){
					$seo_tags['title']=$home_content['title'];
					$seo_tags['meta_description']=$home_content['meta_description'];
					$seo_tags['meta_tags']=$home_content['meta_tags'];
				}
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$this->load->view('faqs', $data);
				$this->load->view($this->footer);	
			}
			else if($seg1=="terms-and-conditions")
			{			
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>4),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$this->load->view('terms-and-conditions', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="privacy-policy")
			{		
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>5),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$this->load->view('privacy-policy', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="pickup-point")
			{		
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$records = $this->Common_model->get_record('tbl_pickup_places', '*',array('status'=>1),1,array('position','asc'));	
				$all_records=array();
				if(!empty($records)){
				foreach($records as $key=>$row){
					$row['dealers'] = $this->Common_model->get_record('tbl_pickup_dealers', '*',array('place_id'=>$row['id'],'status'=>1),1,array('id','desc'));
					$all_records[]=$row;					
				}}
				$data['records']=$all_records;
				$this->load->view('pickup-point', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="pickup-dashboard")
			{		
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$records = $this->Common_model->get_record('tbl_pickup_places', '*',array('status'=>1),1,array('position','asc'));	
				$all_records=array();
				if(!empty($records)){
				foreach($records as $key=>$row){
					$row['dealers'] = $this->Common_model->get_record('tbl_pickup_dealers', '*',array('place_id'=>$row['id'],'status'=>1),1,array('id','desc'));
					$all_records[]=$row;					
				}}
				$data['records']=$all_records;
				$this->load->view('pickup_dashboard', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="pickup_dashboard_check")
			{		
				$category_id = $this->input->post('category_id');					
				$unique_code = $this->input->post('unique_code');					
				$password = $this->input->post('password');	
				$password=encode5t($password);
				$data['record']=$record =$this->Common_model->get_record('tbl_pickup_dealers','*',array('unique_code'=>$unique_code,'password'=>$password),2);
				if(!empty($record)){	
					$data['category_id']=$category_id;
					$data['dealer_id']=$dealer_id=$record['id'];
					$data['from_date']=$from_date=date("Y-m-d");
					$data['to_date']=$to_date=date("Y-m-d");
					$where="pickup_dealer_id=".$dealer_id." AND order_status=1 AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
					if($category_id==1){
					$data['records'] = $this->Common_model->get_record('tbl_casted_gold_orders', '*',$where,1,array('id','desc'));
					$this->load->view('pickup_gold_dashboard_ajax', $data); 
					}else{
						
					}
				}else{	
					echo '<h4 class="text-center text-danger">Invalid Credentials</h4>';
				}					
			}
			else if($seg1=="pickup_dashboard_ajax")
			{		
				$data['category_id']=$category_id = $this->input->post('category_id');					
				$data['dealer_id']=$dealer_id = $this->input->post('dealer_id');					
				$data['from_date']=$from_date = $this->input->post('from_date');
				$data['to_date']=$to_date = $this->input->post('to_date');
				$where="pickup_dealer_id=".$dealer_id." AND order_status=1 AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
				if($category_id==1){
				$data['records'] = $this->Common_model->get_record('tbl_casted_gold_orders', '*',$where,1,array('id','desc'));
				$this->load->view('pickup_gold_dashboard_ajax', $data);
				}
			}
			else if($seg1=="vi-grants")
			{		
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$this->load->view('vi_authority', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="vi_authority_check")
			{		
				$data['drecord']=$drecord =$this->Common_model->get_record('tbl_vi_payments_details','*',array('id'=>1),2);	
				$unique_code = $this->input->post('unique_code');					
				$password = $this->input->post('password');	
				$password=encode5t($password);
				$data['erecord']=$erecord =$this->Common_model->get_record('tbl_vi_pro','*',array('unique_code'=>$unique_code,'password'=>$password),2);	
				$data['precord']=$precord =$this->Common_model->get_record('tbl_vi_super','*',array('unique_code'=>$unique_code,'password'=>$password),2);	
				if(!empty($erecord)){	
					$data['type']=0;
					$data['emp_id']=$erecord['id'];
					$data['heading']=$heading=date("Y-m-01");
					$data['records']=$records =$this->Common_model->get_record('tbl_vi_pro','*',array('id'=>$erecord['id']),1,array('id','desc'));	
                    /*$data['pro_amount'] = $this->db->query("Select SUM(pro_amount) as total_pro_amount from tbl_vi_super_payments where employee_id=".$erecord['id']." AND heading='".$heading."' AND date>='".$erecord['date']."'")->row_array();*/
					
					$super_records =$this->Common_model->get_record('tbl_vi_super','*',array('employee_id'=>$erecord['id']),1,array('id','desc'));	
					$pro_amount=array();
					$super_records_final=array();
					if(!empty($super_records)){
					foreach($super_records as $key=>$row){
						$pro = $this->db->query("Select SUM(pro_amount) as total_pro_amount from tbl_vi_super_payments where super_id=".$row['id']." AND heading='".$heading."' AND date>='".$row['date']."'")->row_array();
						$pro_amount[]=$pro['total_pro_amount'];
				
						$row['super_amount'] = $this->db->query("Select SUM(super_amount) as total_super_amount from tbl_vi_super_payments where super_id=".$row['id']." AND heading='".$heading."' AND date>='".$row['date']."'")->row_array();
						$row['super_payments'] = $this->db->query("Select * from tbl_vi_super_payments where super_id=".$row['id']." AND heading='".$heading."' AND amount!='' AND date>='".$row['date']."' order by id asc")->result_array();
						$super_records_final[]=$row;
					}}		
					$final_pro['total_pro_amount']=array_sum($pro_amount);
					$data['pro_amount'] =$final_pro;			
                    $data['super_records'] = $super_records_final;
					$this->load->view('vi_authority_ajax', $data); 
				}else if(!empty($precord)){	
					$data['type']=1;
					$data['emp_id']=$precord['id'];
					$data['heading']=$heading=date("Y-m-01");
					$super_records =$this->Common_model->get_record('tbl_vi_super','*',array('id'=>$precord['id']),1,array('id','desc'));	
					$super_records_final=array();
					if(!empty($super_records)){
					foreach($super_records as $key=>$row){
						$row['super_amount'] = $this->db->query("Select SUM(super_amount) as total_super_amount from tbl_vi_super_payments where super_id=".$row['id']." AND heading='".$heading."' AND date>='".$row['date']."'")->row_array();
						$row['super_payments'] = $this->db->query("Select * from tbl_vi_super_payments where super_id=".$row['id']." AND heading='".$heading."' AND amount!='' AND date>='".$row['date']."' order by id asc")->result_array();
						$super_records_final[]=$row;
					}}					
                    $data['super_records'] = $super_records_final;
					$this->load->view('vi_authority_ajax', $data); 
				}else{	
					echo '<h4 class="text-center text-danger">Invalid Credentials</h4>';
				}					
			}
			else if($seg1=="vi_authority_ajax")
			{		
				$data['drecord']=$drecord =$this->Common_model->get_record('tbl_vi_payments_details','*',array('id'=>1),2);	
				$data['commission'] = $this->Common_model->get_record('tbl_casted_gold_commission', '*',array('id' => 1) , 2);
				$data['type']=$type = $this->input->post('type');					
				$data['emp_id']=$emp_id = $this->input->post('emp_id');					
				$data['heading']=$heading = $this->input->post('heading');
				if($type==0){	
					$data['records']=$records =$this->Common_model->get_record('tbl_vi_pro','*',array('id'=>$emp_id),1,array('id','desc'));	
                    /*$data['pro_amount'] = $this->db->query("Select SUM(pro_amount) as total_pro_amount from tbl_vi_super_payments where employee_id=".$emp_id." AND heading='".$heading."' AND date>='".$records[0]['date']."'")->row_array();*/
					$super_records =$this->Common_model->get_record('tbl_vi_super','*',array('employee_id'=>$emp_id),1,array('id','desc'));	
					$pro_amount=array();
					$super_records_final=array();
					if(!empty($super_records)){
					foreach($super_records as $key=>$row){
						$pro = $this->db->query("Select SUM(pro_amount) as total_pro_amount from tbl_vi_super_payments where super_id=".$row['id']." AND heading='".$heading."' AND date>='".$row['date']."'")->row_array();
						$pro_amount[]=$pro['total_pro_amount'];
						
						$row['super_amount'] = $this->db->query("Select SUM(super_amount) as total_super_amount from tbl_vi_super_payments where super_id=".$row['id']." AND heading='".$heading."' AND date>='".$row['date']."'")->row_array();
						$row['super_payments'] = $this->db->query("Select * from tbl_vi_super_payments where super_id=".$row['id']." AND heading='".$heading."' AND amount!='' AND date>='".$row['date']."' order by id asc")->result_array();
						$super_records_final[]=$row;
					}}	
					$final_pro['total_pro_amount']=array_sum($pro_amount);
					$data['pro_amount'] =$final_pro;					
                    $data['super_records'] = $super_records_final;
				}else{
					$super_records =$this->Common_model->get_record('tbl_vi_super','*',array('id'=>$emp_id),1,array('id','desc'));	
					$super_records_final=array();
					if(!empty($super_records)){
					foreach($super_records as $key=>$row){
						$row['super_amount'] = $this->db->query("Select SUM(super_amount) as total_super_amount from tbl_vi_super_payments where super_id=".$row['id']." AND heading='".$heading."' AND date>='".$row['date']."'")->row_array();
						$row['super_payments'] = $this->db->query("Select * from tbl_vi_super_payments where super_id=".$row['id']." AND heading='".$heading."' AND amount!='' AND date>='".$row['date']."' order by id asc")->result_array();
						$super_records_final[]=$row;
					}}					
                    $data['super_records'] = $super_records_final;
				}
				$this->load->view('vi_authority_ajax', $data);
			}
			else if($seg1=="vi-save")
			{		
				if(!empty($this->session->userdata('user_data')))
				{
					redirect('vi-save/dashboard');
				}
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$this->load->view('visave_user', $data);
				$this->load->view($this->footer);
			}
			else if($seg1=="payment")
			{					
				$data['secretKey'] = "TESTf9e73f5eeee3744386942f70748fc0a36ba47244";
				$data['appId'] = "TEST3737956c2d8e00a0414f3f87b0597373";
				$data['orderId']=$orderId = "ORD123456";
				$data['orderAmount'] = "100";
				$data['orderCurrency'] = "INR";
				$data['orderNote'] = "order";
				$data['customerName'] = "Test";
				$data['customerPhone'] = "9876543210";
				$data['customerEmail'] = "test@gmail.com";
				$data['returnUrl']=$returnUrl = site_url().'payment_success/'.$orderId;
				$data['notifyUrl']=$notifyUrl = site_url().'payment_success/'.$orderId;
				$this->load->view('payment', $data);
			}
			else if($seg1=="payment_success")
			{		
				echo '<pre>';print_r($_POST);exit;
				$secretKey = "TESTf9e73f5eeee3744386942f70748fc0a36ba47244";
				$orderId = $_POST["orderId"];
				$orderAmount = $_POST["orderAmount"];
				$referenceId = $_POST["referenceId"];
				$txStatus = $_POST["txStatus"];
				$paymentMode = $_POST["paymentMode"];
				$txMsg = $_POST["txMsg"];
				$txTime = $_POST["txTime"];
				$signature = $_POST["signature"];
				$data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
				$hash_hmac = hash_hmac('sha256', $data, $secretkey, true) ;
				$computedSignature = base64_encode($hash_hmac);
				if ($signature == $computedSignature) {
					
				}else{
					
				}
			}
			else if($seg1=="visave_user_ajax")
			{		
				$unique_code = $this->input->post('unique_code');					
				$password = $this->input->post('password');	
				$password=encode5t($password);
				$where="unique_code='".$unique_code."' AND password='".$password."'";
				$urecord =$this->Common_model->get_record('tbl_visave_users','*',array('unique_code'=>$unique_code,'password'=>$password),2);	
				$grecord =$this->Common_model->get_record('tbl_visave_group_users','*',array('unique_code'=>$unique_code,'password'=>$password),2);		
				$precord =$this->Common_model->get_record('tbl_visave_promoters','*',array('unique_code'=>$unique_code,'password'=>$password),2);	
				$erecord =$this->Common_model->get_record('tbl_visave_employees','*',array('unique_code'=>$unique_code,'password'=>$password),2);	
				if(!empty($urecord)){	
                    $data['type'] = 0;
                    $data['record'] = $this->db->query("Select t1.*,t2.category_name,t3.sub_category_name,t4.name as promoter_name from tbl_visave_users t1 left join tbl_visave_categories t2 on t1.category_id=t2.id left join tbl_visave_sub_categories t3 on t1.sub_category_id=t3.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id where t1.id=".$urecord['id']."")->row_array();
                    $data['payments'] = $this->Common_model->get_record('tbl_visave_user_payments', '*', array('user_id'=>$urecord['id']), 1,array('id','asc'));
                    $data['bonus'] = $this->Common_model->get_record('tbl_visave_user_bonus', '*', array('user_id'=>$urecord['id']), 1,array('id','asc'));
                    $data['penalties'] = $this->Common_model->get_record('tbl_visave_user_penalties', '*', array('user_id'=>$urecord['id']), 1,array('id','asc'));
					if($urecord['fixed_gold_price_status']=='1'){
						$this->load->view('visave_user_ajax', $data);
					}else{
						$data['api_details']=$this->get_full_api();
						$this->load->view('visave_price_ajax', $data);
					}					
				}else if(!empty($grecord)){	
                    $data['type'] = 1;
                    $data['record'] = $this->db->query("Select t1.*,t2.group_name,t4.name as promoter_name from tbl_visave_group_users t1 left join tbl_visave_groups t2 on t1.group_id=t2.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id where t1.id=".$grecord['id']."")->row_array();
                    $data['lucky_draw'] = $this->Common_model->get_record('tbl_visave_group_lucky_draw', '*', array('group_id'=>$grecord['group_id']), 1,array('id','asc'));
                    $data['payments'] = $this->Common_model->get_record('tbl_visave_group_user_payments', '*', array('user_id'=>$grecord['id']), 1,array('id','asc'));
                    $data['bonus'] = $this->Common_model->get_record('tbl_visave_group_user_bonus', '*', array('user_id'=>$grecord['id']), 1,array('id','asc'));
                    $data['penalties'] = $this->Common_model->get_record('tbl_visave_group_user_penalties', '*', array('user_id'=>$grecord['id']), 1,array('id','asc'));
					if($grecord['fixed_gold_price_status']=='1'){
						$this->load->view('visave_user_ajax', $data);
					}else{
						$data['api_details']=$this->get_full_api();
						$this->load->view('visave_price_ajax', $data);
					}					
				}else if(!empty($precord)){	
                    $data['type'] = 2;
                    $data['record'] = $precord;
                    $uresult = $this->db->query("Select t1.*,t2.category_name,t3.sub_category_name,t4.name as promoter_name from tbl_visave_users t1 left join tbl_visave_categories t2 on t1.category_id=t2.id left join tbl_visave_sub_categories t3 on t1.sub_category_id=t3.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id where t1.promoter_id=".$precord['id']."")->result_array();
					$urecords=array();
					if(!empty($uresult)){
					foreach($uresult as $key => $row){ 
						$row['payments'] = $this->Common_model->get_record('tbl_visave_user_payments', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
						$row['bonus'] = $this->Common_model->get_record('tbl_visave_user_bonus', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
						$row['penalties'] = $this->Common_model->get_record('tbl_visave_user_penalties', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
						$urecords[]=$row;
					}}					
					$data['urecords'] =$urecords;
                    $gresult = $this->db->query("Select t1.*,t2.group_name,t4.name as promoter_name from tbl_visave_group_users t1 left join tbl_visave_groups t2 on t1.group_id=t2.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id where t1.promoter_id=".$precord['id']."")->result_array();
					$grecords=array();
					if(!empty($gresult)){
					foreach($gresult as $key => $row){ 
						$row['lucky_draw'] = $this->Common_model->get_record('tbl_visave_group_lucky_draw', '*', array('group_id'=>$row['group_id']), 1,array('id','asc'));
						$row['payments'] = $this->Common_model->get_record('tbl_visave_group_user_payments', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
						$row['bonus'] = $this->Common_model->get_record('tbl_visave_group_user_bonus', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
						$row['penalties'] = $this->Common_model->get_record('tbl_visave_group_user_penalties', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
						$grecords[]=$row;
					}}					
					$data['grecords'] =$grecords;
					$this->load->view('visave_promoter_ajax', $data);				
				}else if(!empty($erecord)){	
                    $data['type'] = 3;
                    $data['record'] = $erecord;
					$promoters = $this->Common_model->get_record('tbl_visave_promoters', '*', array('employee_id'=>$erecord['id']), 1,array('id','asc'));
					$precords=array();
					if(!empty($promoters)){
					foreach($promoters as $key1 => $row1){ 
						$uresult = $this->db->query("Select t1.*,t2.category_name,t3.sub_category_name,t4.name as promoter_name from tbl_visave_users t1 left join tbl_visave_categories t2 on t1.category_id=t2.id left join tbl_visave_sub_categories t3 on t1.sub_category_id=t3.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id where t1.promoter_id=".$row1['id']."")->result_array();
						$urecords=array();
						if(!empty($uresult)){
						foreach($uresult as $key => $row){ 
							$row['payments'] = $this->Common_model->get_record('tbl_visave_user_payments', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
							$row['bonus'] = $this->Common_model->get_record('tbl_visave_user_bonus', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
							$row['penalties'] = $this->Common_model->get_record('tbl_visave_user_penalties', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
							$urecords[]=$row;
						}}					
						$row1['urecords'] =$urecords;
						$gresult = $this->db->query("Select t1.*,t2.group_name,t4.name as promoter_name from tbl_visave_group_users t1 left join tbl_visave_groups t2 on t1.group_id=t2.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id where t1.promoter_id=".$row1['id']."")->result_array();
						$grecords=array();
						if(!empty($gresult)){
						foreach($gresult as $key => $row){ 
							$row['lucky_draw'] = $this->Common_model->get_record('tbl_visave_group_lucky_draw', '*', array('group_id'=>$row['group_id']), 1,array('id','asc'));
							$row['payments'] = $this->Common_model->get_record('tbl_visave_group_user_payments', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
							$row['bonus'] = $this->Common_model->get_record('tbl_visave_group_user_bonus', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
							$row['penalties'] = $this->Common_model->get_record('tbl_visave_group_user_penalties', '*', array('user_id'=>$row['id']), 1,array('id','asc'));
							$grecords[]=$row;
						}}					
						$row1['grecords'] =$grecords;
						$precords[]=$row1;
					}}
					$data['precords'] =$precords;					
					$this->load->view('visave_employee_ajax', $data);
				}else{	
					echo '<h4 class="text-center text-danger">Invalid Credentials</h4>';
				}					
			}
			else if($seg1=="visave_live_ajax")
			{
				$api_details=$this->get_full_api();
				echo round($api_details[0]['Ask'],2);
			}
			else if($seg1=="visave_price_ajax")
			{
				$type = $this->input->post('type');
				$id = $this->input->post('id');
				$fixed_gold_price = $this->input->post('fixed_gold_price');
				$update_data = array(
					'fixed_gold_price_status' => 1,
					'fixed_gold_price' => $fixed_gold_price
				);
				if($type==0){
					$result = $this->Common_model->update_record('tbl_visave_users', $update_data, array('id' => $id));
				}else{
					$result = $this->Common_model->update_record('tbl_visave_group_users', $update_data, array('id' => $id));
				}
				echo 1;
			}
			else if($seg1=="vi-save-dashboard")
			{		
				if(!empty($urecord)){	
					$user_data=array(
						'type'=>0,
						'id'=>$urecord['id']
					);
					$this ->session ->set_userdata('user_data', $user_data);
				}else if(!empty($precord)){		
					$user_data=array(
						'type'=>1,
						'id'=>$grecord['id']
					);
					$this ->session ->set_userdata('user_data', $user_data);
				}else{	
					echo '<h4 class="text-center text-danger">Invalid Credentials</h4>';
				}					
				if(empty($this->session->userdata('user_data')))
				{
					redirect('vi-save');
				}
				$data['record']=$record = $this->Common_model->get_record('tbl_cms_pages', '*',array('id'=>1),2);	
				$seo_tags=array();
				if(!empty($record)){
					$seo_tags['title']=$record['title'];
					$seo_tags['meta_description']=$record['meta_description'];
					$seo_tags['meta_tags']=$record['meta_tags'];
				}	
				$seo['seo_tags']=$seo_tags;
				$this->load->view($this->header, $seo);
				$user_data=$this->session->userdata('user_data');
				if($user_data['type']==0){
                    $data['record'] = $this->db->query("Select t1.*,t2.category_name,t3.sub_category_name,t4.name as promoter_name from tbl_visave_users t1 left join tbl_visave_categories t2 on t1.category_id=t2.id left join tbl_visave_sub_categories t3 on t1.sub_category_id=t3.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id where t1.id=".$user_data['id']."")->row_array();
                    $data['payments'] = $this->Common_model->get_record('tbl_visave_user_payments', '*', array('user_id'=>$user_data['id']), 1,array('id','asc'));
                    $data['bonus'] = $this->Common_model->get_record('tbl_visave_user_bonus', '*', array('user_id'=>$user_data['id']), 1,array('id','asc'));
                    $data['penalties'] = $this->Common_model->get_record('tbl_visave_user_penalties', '*', array('user_id'=>$user_data['id']), 1,array('id','asc'));
				}else{					
                    $data['record'] = $this->db->query("Select t1.*,t2.group_name,t4.name as promoter_name from tbl_visave_group_users t1 left join tbl_visave_groups t2 on t1.group_id=t2.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id where t1.id=".$user_data['id']."")->row_array();
                    $data['payments'] = $this->Common_model->get_record('tbl_visave_group_user_payments', '*', array('user_id'=>$user_data['id']), 1,array('id','asc'));
                    $data['bonus'] = $this->Common_model->get_record('tbl_visave_group_user_bonus', '*', array('user_id'=>$user_data['id']), 1,array('id','asc'));
                    $data['penalties'] = $this->Common_model->get_record('tbl_visave_group_user_penalties', '*', array('user_id'=>$user_data['id']), 1,array('id','asc'));
				}
				$this->load->view('visave_dashboard', $data);
				$this->load->view($this->footer);
			}
			else
			{					
				$url=site_url().$seg1;
				redirect(site_url());
			}
		}		
	}
	public function getCurrentDateTime()
	{		
			return date('Y-m-d H:i:s');		
	}
	public function EmailFormat($content,$contactEmail)
	{
			$config = array(
			'protocol'=>'smtp',
			'smtp_host'=>'mail.ahanaturals.com',
			'smtp_port'=>25,
			'smtp_user'=>'orders@ahanaturals.com',
			'smtp_pass'=>'Developer@123',
			'mailtype'=>'html',
			'charset'=>'utf-8',
			'newline'=>'\r\n'
			);

			$this->load->library('email', $config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			$this->email->to($contactEmail);
			$this->email->from('contactEmail','Order Placed');
			$this->email->subject('Thank you for booking your orders with Ahanaturals');
			$this->email->message($content);
			$this->email->send();
		
	}	
	public function startHomePage($data)
	{	
		$this->load->view('index', $data);
	}	
	public function get_casted_value($id)
	{	
		/*$oprice = array('1853.65','1853.75','1853.85');
		$org_price = $oprice[array_rand($oprice, 1)];
		$dprice = array('75.555','75.666','75.777');
		$dollar_price = $dprice[array_rand($dprice, 1)];*/	
		$aid=1;
		if($id==4){
			$aid=2;
		}
		$org_price = $this->get_api_value($aid);
		$dollar_price = $this->get_api_value(3);
		$record = $this->Common_model->get_record('tbl_categories', '*', array('id' => $id) , 2);
		$a2_value=$org_price+$record['a1_value'];
		$b2_value=$dollar_price+$record['b1_value'];
		$a4_value=$a2_value+$record['a3_value'];	
		$a5_value=$a4_value*$b2_value;
		$d_value=$a5_value+$record['c_value'];
		if($id==1){	
			$f_value=$d_value*$record['e_value'];
			$f_value=$f_value/1000;
			$h_value=$f_value+$record['g_value'];
			$i_value=($record['gst']*$h_value)/100;
			$j_value=$h_value+$i_value;		
			$k_value=($record['k_value']*$j_value)/100;
			$m_value=$j_value+$record['k_value'];		
			$l_value=$record['l_value'];
			$n_value=$m_value-$l_value;
		}else{
			/*$f_value=$d_value/$record['e_value'];*/
			$f_value=$d_value*$record['e_value'];
			$f_value=$f_value/1000;
			$i_value=($record['gst']*$f_value)/100;
			$h_value=$f_value+$i_value;	
			$j_value=$h_value+$record['g_value'];	
			$l_value=$record['l_value'];
			$n_value=$j_value-$l_value;
		}	
		return $n_value;
	}
	public function get_minted_value($id)
	{	
		/*$oprice = array('1853.65','1853.75','1853.85');
		$org_price = $oprice[array_rand($oprice, 1)];
		$dprice = array('75.555','75.666','75.777');
		$dollar_price = $dprice[array_rand($dprice, 1)];*/	
		$aid=2;
		if($id==5){
			$aid=2;
		}	
		$org_price = $this->get_api_value($aid);
		$dollar_price = $this->get_api_value(3);
		$record = $this->Common_model->get_record('tbl_categories', '*', array('id' => $id) , 2);
		$a2_value=$org_price+$record['a1_value'];
		$b2_value=$dollar_price+$record['b1_value'];
		$a4_value=$a2_value+$record['a3_value'];	
		$a5_value=$a4_value*$b2_value;
		$d_value=$a5_value/$record['e_value'];
		$f_value=$d_value+$record['c_value'];
		return $f_value;
	}
	public function get_api_value($id)
	{	
		$ch = curl_init();
		$url=$this->liveRatesURL;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		curl_close($ch);
		$data_record= json_decode($server_output, true);
		$record=$data_record['rows'];
		if($id==1){
			return $data_record['rows'][2]['Ask'];
		}else if($id==2){
			return $data_record['rows'][3]['Ask'];
		}else{
			return $data_record['rows'][4]['Ask'];
		}
	}
	public function get_full_api()
	{	
		$ch = curl_init();
		$url=$this->liveRatesURL;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		curl_close($ch);
		$data_record= json_decode($server_output, true);
		$record=$data_record['rows'];
		return $record;
	}
	public function get_casted_value1($id,$org_price,$dollar_price)
	{	
		$record = $this->Common_model->get_record('tbl_categories', '*', array('id' => $id) , 2);
		$a2_value=$org_price+$record['a1_value'];
		$b2_value=$dollar_price+$record['b1_value'];
		$a4_value=$a2_value+$record['a3_value'];	
		$a5_value=$a4_value*$b2_value;
		$d_value=$a5_value+$record['c_value'];
		$f_value=$d_value/$record['e_value'];
		$h_value=$f_value+$record['g_value'];
		$i_value=($record['gst']*$h_value)/100;
		$j_value=$h_value+$i_value;
		return $j_value;
	}
	public function get_minted_value1($id,$org_price,$dollar_price)
	{	
		$record = $this->Common_model->get_record('tbl_categories', '*', array('id' => $id) , 2);
		$a2_value=$org_price+$record['a1_value'];
		$b2_value=$dollar_price+$record['b1_value'];
		$a4_value=$a2_value+$record['a3_value'];	
		$a5_value=$a4_value*$b2_value;
		$d_value=$a5_value+$record['c_value'];
		$f_value=$d_value/$record['e_value'];
		return $f_value;
	}
}
?>
