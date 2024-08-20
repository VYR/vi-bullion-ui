<?php defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends CI_Controller
{
    public $header = 'admin-includes/header';
    public $footer = 'admin-includes/footer';
    public $leftmenu = 'admin-includes/leftmenu';
    public $views_folder = 'admin/';
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Common_model','Admin_model'));
    }
    public function sendjson()
    {
        header($this->json_headers);
        echo json_encode($this->jsondataa, JSON_PRETTY_PRINT);
    }
    public function index()
    {
        $total = $this ->uri ->total_segments();
        if ($total == 0)
        {
            redirect(base_url());
        }
        elseif ($total == 1)
        {
            $segment1 = $this ->uri ->segment(1);
            if ($segment1 == 'admin')
            {
				if (!empty($this->session->userdata('admin_data')))
				{
					redirect('admin/dashboard');
				}
                $this ->load ->view($this->views_folder.'index');
            }
            else
            {
                redirect(base_url());
            }
        }
        else if ($total == 2)
        {
            $segment1 = $this ->uri ->segment(1);
            $segment2 = $this ->uri ->segment(2);
            if ($segment1 == "admin")
            {
                if ($segment2 == "ajax_login")
                {
                    if ($this->input->post('username') != '')
                    {
						$username = $this->input->post('username');
						$password = $this->input->post('password');
                        $encode_password = encode5t($password);
						$where="(mobile='".$username."' OR email='".$username."') AND password='".$encode_password."'";
						$record = $this->Common_model->get_record('tbl_admins', '*', $where,2);
                        if (!empty($record))
                        {
                            $this ->session ->set_userdata('admin_data', $record);
                            $data['msg'] = 'Login Sucecssfull...!! Welcome';
                            $data['status'] = 1;
                        }
                        else
                        {
                            $data['msg'] = 'Username Or Password Did Not Match ...';
                            $data['status'] = 0;
                        }
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "logout")
                {
                    $this->session->unset_userdata('admin_data');
                    /*$this->session->sess_destroy();*/
                    $this->session->set_flashdata('error', 'Logout Successfully...');
                    redirect('admin');
                }
                else if ($segment2 == "dashboard")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'dashboard');
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "profile")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $admin_data = $this->session->userdata('admin_data');
                    $id = $admin_data['id'];
                    $data['record'] = $this->Common_model->get_record('tbl_admins', '*', array('id' => $id) , 2);
                    $this->load->view($this->views_folder.'profile', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "ajax_profile")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $email = $this->input->post('email');
                    $mobile = $this->input->post('mobile');
                    $password = $this->input->post('password');
                    $epassword = encode5t($password);
                    $update_data = array(
						'name' => $name,
						'email' => $email,
                        'mobile' => $mobile,
                        'password' => $epassword
					);
					$result = $this->Common_model->update_record('tbl_admins', $update_data, array('id' => $id));
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
                else if ($segment2 == "home_content")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['record'] = $this->Common_model->get_record('tbl_home_content', '*', array('id' => 1) , 2);
                    $this->load->view($this->views_folder.'home_content', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "home_content_ajax")
                {
                    $id = $this->input->post('id');
                    $title = $this->input->post('title');
                    $meta_description = $this->input->post('meta_description');
                    $logo_alt = $this->input->post('logo_alt');       
                    $footer_logo_alt = $this->input->post('footer_logo_alt');       
					$email = $this->input->post('email');
                    $mobile = $this->input->post('mobile');
                    $address = $this->input->post('address');
                    $rights_reserved = $this->input->post('rights_reserved');
                    $meta_tags = $this->input->post('meta_tags');
                    $casted_gold_deposit = $this->input->post('casted_gold_deposit');
                    $casted_gold_discount = $this->input->post('casted_gold_discount');
                    $casted_gold_order_time = $this->input->post('casted_gold_order_time');
                    $casted_silver_deposit = $this->input->post('casted_silver_deposit');
                    $casted_silver_discount = $this->input->post('casted_silver_discount');
                    $casted_silver_order_time = $this->input->post('casted_silver_order_time');
                    $bank_details = $this->input->post('bank_details');
                    $scrolling_text = $this->input->post('scrolling_text');
					
					$record = $this->Common_model->get_record('tbl_home_content', '*', array('id' => $id    ) , 2);
					$oldimage1 = $record['logo'];
					if (isset($_FILES['logo']['name']) && !empty($_FILES["logo"]["name"]))
					{
						$path = './assets/images/logo/';
						$name1 = "logo";
						$width = "";
						$height = "";
						$Img1 = $this    ->Common_model    ->uploadImage($path, $name1, $width, $height);
						$logo = $Img1;
					}
					else
					{
						$logo = $oldimage1;
					}
					$oldimage2 = $record['footer_logo'];
					if (isset($_FILES['footer_logo']['name']) && !empty($_FILES["footer_logo"]["name"]))
					{
						$path = './assets/images/logo/';
						$name1 = "footer_logo";
						$width = "";
						$height = "";
						$Img1 = $this    ->Common_model    ->uploadImage($path, $name1, $width, $height);
						$footer_logo = $Img1;
					}
					else
					{
						$footer_logo = $oldimage2;
					}
                    $update_data = array(
                        'title' => $title,
                        'meta_description' => $meta_description,
                        'logo' => $logo,
                        'logo_alt' => $logo_alt,					
                        'footer_logo' => $footer_logo,
                        'footer_logo_alt' => $footer_logo_alt,						
                        'mobile' => $mobile,
                        'email' => $email,
                        'address' => $address,
                        'rights_reserved' => $rights_reserved,
                        'meta_tags' => $meta_tags,
                        'casted_gold_deposit' => $casted_gold_deposit,
                        'casted_gold_discount' => $casted_gold_discount,
                        'casted_gold_order_time' => $casted_gold_order_time,
                        'casted_silver_deposit' => $casted_silver_deposit,
                        'casted_silver_discount' => $casted_silver_discount,
                        'casted_silver_order_time' => $casted_silver_order_time,
                        'bank_details' => $bank_details,
                        'scrolling_text' => $scrolling_text
					);
                    $result = $this->Common_model->update_record('tbl_home_content', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
						if ($logo != $oldimage1)
						{
							if (!empty($record['logo']))
							{
								$aoldimage1 = $record['logo'];
								$upload_path = './assets/images/logo/';
								$file = $upload_path.$aoldimage1;
								if (file_exists($file))
								{
									unlink($file);
								}
							}
						}
						if ($footer_logo != $oldimage2)
						{
							if (!empty($record['footer_logo']))
							{
								$aoldimage1 = $record['footer_logo'];
								$upload_path = './assets/images/logo/';
								$file = $upload_path.$aoldimage1;
								if (file_exists($file))
								{
									unlink($file);
								}
							}
						}
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
                else if ($segment2 == "casted_gold_content")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 1) , 2);
                    $this->load->view($this->views_folder.'categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_categories")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->Common_model->get_record('tbl_casted_gold_categories', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_categories_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_gold_categories', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_categories_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_categories_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $display_order = $this->input->post('display_order');
                    $products_display_count = $this->input->post('products_display_count');
                    $ads_display_count = $this->input->post('ads_display_count');
                    if ($id == 0)
                    {
                        $add_data = array(
							'name' => $name,
                            'display_order' => $display_order,
                            'products_display_count' => $products_display_count,
                            'ads_display_count' => $ads_display_count,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_casted_gold_categories', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'name' => $name,
                            'display_order' => $display_order,
                            'products_display_count' => $products_display_count,
                            'ads_display_count' => $ads_display_count
                        );
                        $result = $this->Common_model->update_record('tbl_casted_gold_categories', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "casted_categories_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_gold_categories', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_categories');
                }
                else if ($segment2 == "casted_categories_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_casted_gold_products', '*', array('category_id' => $id) , 3);
					if($record>0){						
                        $this->session->set_flashdata('error', 'Products available with this casted_categories delete products and try again...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_casted_gold_categories');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Deleted...');
						}
                    }
                    redirect('admin/casted_categories');
                }
                else if ($segment2 == "casted_products")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->db->query("Select t1.*,t2.name as category_name from tbl_casted_gold_products t1 left join tbl_casted_gold_categories t2 on t1.category_id=t2.id order by t1.id desc")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_products', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_products_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_gold_products', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_casted_gold_categories', '*', '', 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_products_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_products_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $name = $this->input->post('name');
                    $image_alt = $this->input->post('image_alt');
                    $weight = $this->input->post('weight');
                    $mrp = $this->input->post('mrp');
                    $purity = $this->input->post('purity');
                    $purity_percentage = $this->input->post('purity_percentage');
                    if ($id == 0)
                    {
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/casted/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = '';
                        }
                        $add_data = array(
							'category_id' => $category_id,
							'name' => $name,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'weight' => $weight,
                            'mrp' => $mrp,
                            'purity' => $purity,
                            'purity_percentage' => $purity_percentage,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_casted_gold_products', $add_data);
                    }
                    else
                    {
                        $record = $this->Common_model->get_record('tbl_casted_gold_products', '*', array('id' => $id    ) , 2);
                        $oldimage = $record['image'];
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/casted/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = $oldimage;
                        }
                        $update_data = array(
							'category_id' => $category_id,
							'name' => $name,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'weight' => $weight,
                            'mrp' => $mrp,
                            'purity' => $purity,
                            'purity_percentage' => $purity_percentage
                        );
                        $result = $this->Common_model->update_record('tbl_casted_gold_products', $update_data, array('id' => $id));
                        if (!empty($result))
                        {
                            if ($image != $oldimage)
                            {
                                if (!empty($record['image']))
                                {
                                    $aoldimage1 = $record['image'];
                                    $upload_path = './assets/images/casted/';
                                    $file = $upload_path.$aoldimage1;
                                    if (file_exists($file))
                                    {
                                        unlink($file);
                                    }
                                }
                            }
                        }
                    }
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
                else if ($segment2 == "casted_products_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_gold_products', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_products');
                }
                else if ($segment2 == "casted_products_delete")
                {
                    $id = $this->input->get('id');
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_casted_gold_products');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Deleted...');
					}
                    redirect('admin/casted_products');
                }
                else if ($segment2 == "casted_products_prices")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					/*$data['org_price'] = $org_price='1853.65';
					$data['dollar_price'] = $dollar_price='75.555';*/
					$data['org_price'] = $org_price=$this->get_api_value(1);
					$data['dollar_price'] = $dollar_price=$this->get_api_value(3);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 1) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_casted_gold_products', '*', '', 1, array('id','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_products_prices', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_products_prices_loop")
                {
                    /*$org_price = $this->input->post('org_price');
					if($org_price=='1853.65'){
						$org_price='1853.75';
					}else if($org_price=='1853.75'){
						$org_price='1853.85';
					}else if($org_price=='1853.85'){
						$org_price='1853.65';
					}
					$data['org_price'] = $org_price;
                    $dollar_price = $this->input->post('dollar_price');
					if($dollar_price=='75.555'){
						$dollar_price='75.565';
					}else if($dollar_price=='75.565'){
						$dollar_price='75.575';
					}else if($dollar_price=='75.575'){
						$dollar_price='75.555';
					}
					$data['dollar_price'] = $dollar_price;*/
					$data['org_price'] = $org_price=$this->get_api_value(1);
					$data['dollar_price'] = $dollar_price=$this->get_api_value(3);
					
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 1) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_casted_gold_products', '*', '', 1, array('id','asc'));
                    $this->load->view($this->views_folder.'casted_products_prices_loop', $data);
                }
                else if ($segment2 == "casted_products_prices_ajax")
                {
                    $id = $this->input->post('id');
                    $a1_value = $this->input->post('a1_value');
                    $a3_value = $this->input->post('a3_value');
                    $b1_value = $this->input->post('b1_value');
                    $c_value = $this->input->post('c_value');
                    $e_value = $this->input->post('e_value');
                    $g_value = $this->input->post('g_value');
                    $gst = $this->input->post('gst');
                    $k_value = $this->input->post('k_value');
                    $l_value = $this->input->post('l_value');
                    $mcxa_value = $this->input->post('mcxa_value');
                    $mcxb_value = $this->input->post('mcxb_value');
                    $mcxc_value = $this->input->post('mcxc_value');
                    $all_india_display = $this->input->post('all_india_display');
					$update_data = array(
						'a1_value' => $a1_value,
						'a3_value' => $a3_value,
						'b1_value' => $b1_value,
						'c_value' => $c_value,
						'e_value' => $e_value,
						'g_value' => $g_value,
						'gst' => $gst,
						'k_value' => $k_value,
						'l_value' => $l_value,
						'mcxa_value' => $mcxa_value,
						'mcxb_value' => $mcxb_value,
						'mcxc_value' => $mcxc_value,
						'all_india_display' => $all_india_display
					);
					$result = $this->Common_model->update_record('tbl_categories', $update_data, array('id' => $id));
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
                else if ($segment2 == "casted_ads")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->db->query("Select t1.*,t2.name as category_name from tbl_casted_gold_ads t1 left join tbl_casted_gold_categories t2 on t1.category_id=t2.id order by t1.id desc")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_ads', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_ads_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_gold_ads', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_casted_gold_categories', '*', '', 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_ads_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_ads_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $ad_type = $this->input->post('ad_type');
                    $image_alt = $this->input->post('image_alt');
                    $url = $this->input->post('url');
                    $google_code = $this->input->post('google_code');
                    if ($id == 0)
                    {
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/casted/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = '';
                        }
                        $add_data = array(
							'category_id' => $category_id,
							'ad_type' => $ad_type,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'url' => $url,
                            'google_code' => $google_code,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_casted_gold_ads', $add_data);
                    }
                    else
                    {
                        $record = $this->Common_model->get_record('tbl_casted_gold_ads', '*', array('id' => $id    ) , 2);
                        $oldimage = $record['image'];
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/casted/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = $oldimage;
                        }
                        $update_data = array(
							'category_id' => $category_id,
							'ad_type' => $ad_type,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'url' => $url,
                            'google_code' => $google_code
                        );
                        $result = $this->Common_model->update_record('tbl_casted_gold_ads', $update_data, array('id' => $id));
                        if (!empty($result))
                        {
                            if ($image != $oldimage || $ad_type==1)
                            {
                                if (!empty($record['image']))
                                {
                                    $aoldimage1 = $record['image'];
                                    $upload_path = './assets/images/casted/';
                                    $file = $upload_path.$aoldimage1;
                                    if (file_exists($file))
                                    {
                                        unlink($file);
                                    }
                                }
                            }
                        }
                    }
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
                else if ($segment2 == "casted_ads_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_gold_ads', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_ads');
                }
                else if ($segment2 == "casted_ads_delete")
                {
                    $id = $this->input->get('id');
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_casted_gold_ads');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Deleted...');
					}
                    redirect('admin/casted_ads');
                }
                else if ($segment2 == "casted_gold_users")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$data['records'] = $this->db->query("Select t1.*,t2.unique_code as employee_code,t2.name as employee_name from tbl_casted_gold_users t1 left join tbl_company_employees t2 on t1.employee_id=t2.id order by t1.id DESC")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_gold_users', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_gold_users_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_gold_users', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_gold_users_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_gold_users_ajax")
                {
                    $id = $this->input->post('id');
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
                    if ($id == 0)
                    {
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = '';
						}
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
							'document' => $pdf,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
						$where="mobile='".$mobile."' OR email='".$email."'";
						$record = $this->Common_model->get_record('tbl_casted_gold_users', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->add_record('tbl_casted_gold_users', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Email ID or Mobile Number already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$record = $this->Common_model->get_record('tbl_casted_gold_users', '*', array('id' => $id    ) , 2);
						$oldimage1 = $record['document'];
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = $oldimage1;
						}
                        $update_data = array(
							'name_type' => $name_type,
							'name' => $name,
							'email' => $email,
							'mobile' => $mobile,
							'company_type' => $company_type,
							'company_name' => $company_name,
							'pan_number' => $pan_number,
							'firm_type' => $firm_type,
							'gst_no' => $gst_no,
							'shop_type' => $shop_type,
							'grams' => $grams,
							'kgs' => $kgs,
							'silver_grams' => $silver_grams,
							'silver_kgs' => $silver_kgs,
							'state' => $state,
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
							'document' => $pdf
                        );
						$where="(mobile='".$mobile."' OR email='".$email."') AND id!='".$id."'";
						$record = $this->Common_model->get_record('tbl_casted_gold_users', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->update_record('tbl_casted_gold_users', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Unique Code or Email ID or Mobile Number already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "casted_gold_users_edit")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_gold_users', '*', array('id' => $id) , 2);
					$data['employees'] = $this->Common_model->get_record('tbl_company_employees', '*', '', 1, array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_gold_users_edit', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_gold_users_edit_ajax")
                {
                    $id = $this->input->post('id');
                    $employee_id = $this->input->post('employee_id');
                    $unique_code = $this->input->post('unique_code');
                    $password = $this->input->post('password');
                    $epassword = encode5t($password);
                    $file_number = $this->input->post('file_number');
                    $deposit_amount = $this->input->post('deposit_amount');
					$update_data = array(
						'employee_id' => $employee_id,
						'unique_code' => $unique_code,
						'password' => $epassword,
						'file_number' => $file_number,
						'deposit_amount' => $deposit_amount
					);
					$where="unique_code='".$unique_code."' AND id!='".$id."'";
					$record = $this->Common_model->get_record('tbl_casted_gold_users', '*', $where,2);
					if(empty($record))
					{
						$result = $this->Common_model->update_record('tbl_casted_gold_users', $update_data, array('id' => $id));
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
					}
					else
					{
						$data['msg'] = 'Unique Code already exists...';
						$data['status'] = 0;
					}
                    echo json_encode($data);
                }
                else if ($segment2 == "casted_gold_users_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_gold_users', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_gold_users');
                }
                else if ($segment2 == "casted_gold_users_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_casted_gold_users');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_gold_users');
                }
                else if ($segment2 == "casted_employees")
                {
                    $data['records'] = $this->Common_model->get_record('tbl_casted_gold_employees', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_employees', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_employees_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_gold_employees', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_employees_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_employees_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $company_name = $this->input->post('company_name');
                    $gst = $this->input->post('gst');
                    $address = $this->input->post('address');
                    $pan_number = $this->input->post('pan_number');
                    $bank_name = $this->input->post('bank_name');
                    $account_number = $this->input->post('account_number');
                    $ifsc = $this->input->post('ifsc');
                    $branch = $this->input->post('branch');
                    $unique_code = $this->input->post('unique_code');
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_casted_gold_employees', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_casted_gold_employees', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Unique code already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_casted_gold_employees', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch
							);
							$result = $this->Common_model->update_record('tbl_casted_gold_employees', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Unique code already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "casted_employees_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_gold_employees', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_employees');
                }
                else if ($segment2 == "casted_employees_delete")
                {
                    $id = $this->input->get('id');
                    $promoters = $this->Common_model->get_record('tbl_casted_gold_promoters', '*', array('employee_id' => $id) , 3);
					if($promoters>0){
						$this->session->set_flashdata('error', 'Promoters Available...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_casted_gold_employees');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Updated...');
						}
                    }
                    redirect('admin/casted_employees');
                }
                else if ($segment2 == "casted_promoters")
                {
                    $employee_id = 0;
					if(!empty($_GET)){
                    $employee_id = $this->input->get('id');
					}
					$data['employee_id']=$employee_id;
                    /*$data['records'] = $this->Common_model->get_casted_promoters();*/
                    $data['records'] = $this->Common_model->get_record('tbl_casted_gold_promoters', '*', array('employee_id' => $employee_id) , 1,array('id','desc'));
                    $data['employees'] = $this->Common_model->get_record('tbl_casted_gold_employees', '*', array('status'=>1), 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_promoters', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_promoters_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_gold_promoters', '*', array('id' => $id) , 2);
                    $data['employees'] = $this->Common_model->get_record('tbl_casted_gold_employees', '*', array('status'=>1), 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_promoters_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_promoters_ajax")
                {
                    $id = $this->input->post('id');
                    $employee_id = $this->input->post('employee_id');
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $company_name = $this->input->post('company_name');
                    $gst = $this->input->post('gst');
                    $address = $this->input->post('address');
                    $pan_number = $this->input->post('pan_number');
                    $bank_name = $this->input->post('bank_name');
                    $account_number = $this->input->post('account_number');
                    $ifsc = $this->input->post('ifsc');
                    $branch = $this->input->post('branch');
                    $unique_code = $this->input->post('unique_code');
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_casted_gold_promoters', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_casted_gold_promoters', $add_data);
							if (!empty($result))
							{
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
								$data['employee_id'] = $employee_id;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
						/*if (!empty($result))
						{		
							$ukey=$result;
							if($result<10){
								$ukey='0'.$result;
							}
							$unique_code='Ahnp'.$ukey;
							$update_data = array(
								'unique_code' => $unique_code
							);
							$result = $this->Common_model->update_record('casted_promoters', $update_data, array('id' => $result));
						}*/
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_casted_gold_promoters', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch
							);
							$result = $this->Common_model->update_record('tbl_casted_gold_promoters', $update_data, array('id' => $id));
							if (!empty($result))
							{
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
								$data['employee_id'] = $employee_id;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "casted_promoters_status")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_casted_gold_promoters', '*', array('id' => $id) , 2);
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_gold_promoters', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_promoters?id='.$record['employee_id']);
                }
                else if ($segment2 == "casted_promoters_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_casted_gold_promoters', '*', array('id' => $id) , 2);
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_casted_gold_promoters');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_promoters?id='.$record['employee_id']);
                }
                else if ($segment2 == "casted_commission")
                {
                    $data['records'] = $this->Common_model->get_record('tbl_casted_gold_commission', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_commission', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_commission_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_gold_commission', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_commission_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_commission_ajax")
                {
                    $id = $this->input->post('id');
                    $employee_commission = $this->input->post('employee_commission');
                    $promoter_commission = $this->input->post('promoter_commission');
					$expiry_date=date("Y-m-d", strtotime($_POST['expiry_date']));
                    if ($id == 0)
                    {
                        $add_data = array(
							'employee_commission' => $employee_commission,
                            'promoter_commission' => $promoter_commission,
                            'expiry_date' => $expiry_date,
                            'status' => 1
                        );
                        $result = $this->Common_model->add_record('tbl_casted_gold_commission', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'employee_commission' => $employee_commission,
                            'promoter_commission' => $promoter_commission,
                            'expiry_date' => $expiry_date
                        );
                        $result = $this->Common_model->update_record('tbl_casted_gold_commission', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "casted_commission_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_gold_commission', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_commission');
                }
                else if ($segment2 == "casted_gold_sales")
                {
                    $data['commission'] = $this->Common_model->get_record('tbl_casted_gold_commission', '*',array('id' => 1) , 2);
                    $data['employees'] = $this->Common_model->get_record('tbl_company_employees', '*','' ,1,array('id','DESC'));
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$from_date=date("Y-m-d");
					$to_date=date("Y-m-d");
                    $data['records'] = $this->Admin_model->get_casted_gold_pending_sales($from_date,$to_date);
                    $data['home_content'] = $this->Common_model->get_record('tbl_home_content', '*',array('id' => 1) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_gold_sales', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_gold_sales_ajax")
                {
                    $data['commission'] = $this->Common_model->get_record('tbl_casted_gold_commission', '*',array('id' => 1) , 2);
                    $data['home_content'] = $this->Common_model->get_record('tbl_home_content', '*',array('id' => 1) , 2);
                    $from_date = $this->input->post('from_date');
                    $to_date = $this->input->post('to_date');
                    $order_type = $this->input->post('order_type');
					if($order_type!=2){
					if($order_type==0){
                    $data['records'] = $this->Admin_model->get_casted_gold_pending_sales($from_date,$to_date);
					}else if($order_type==1){
                    $data['records'] = $this->Admin_model->get_casted_gold_sales($from_date,$to_date);
					}else{
                    $data['records'] = $this->Admin_model->get_casted_gold_sales_cancelled($from_date,$to_date);
					}
                    $this->load->view($this->views_folder.'casted_gold_sales_ajax', $data);
					}else{
                    $data['records'] = $this->Admin_model->get_casted_gold_emp_sales($from_date,$to_date);
                    $this->load->view($this->views_folder.'casted_gold_emp_sales_ajax', $data);
					}
                }
                else if ($segment2 == "casted_gold_sales_update")
                {
                    $employee_id = $this->input->post('employee_id');
					$employee = $this->Common_model->get_record('tbl_company_employees', '*', array('id' =>$employee_id),2);
                    $id = $this->input->post('order_id');
                    $hsn_code = $this->input->post('hsn_code');
                    $gold_nos = $this->input->post('gold_nos');
                    $irn_no = $this->input->post('irn_no');
                    $tcs_value = $this->input->post('tcs_value');
                    $time = $this->input->post('time');
					if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
					{
						$path = './assets/images/casted/';
						$name1 = "image";
						$width = "";
						$height = "";
						$Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
						$qr_code = $Img1;
					}
					else
					{
						$qr_code = '';
					}
					$lrecord = $this->Common_model->get_record('tbl_casted_gold_orders', '*', array('order_status' =>1,'invoice_id!='=>0),2,array('id','desc'));
					$invoice_id=1;
					if(!empty($lrecord)){
					$invoice_id=$lrecord['invoice_id']+1;
					}
					$update_data = array(
					'employee_id' => $employee_id,
					'employee_code' => $employee['unique_code'],
					'employee_name' => $employee['name'],
					'invoice_id' => $invoice_id,
					'qr_code' => $qr_code,
					'hsn_code' => $hsn_code,
					'gold_nos' => $gold_nos,
					'irn_no' => $irn_no,
					'tcs_value' => $tcs_value,
					'time' => $time,
					'order_status' => 1
					);
					$result = $this->Common_model->update_record('tbl_casted_gold_orders', $update_data, array('id' => $id));
                }
                else if ($segment2 == "casted_gold_sales_cancel")
                {
                    $id = $this->input->post('order_id');
					$orecord = $this->Common_model->get_record('tbl_casted_gold_orders', '*', array('id' =>$id),2);
					$urecord = $this->Common_model->get_record('tbl_casted_gold_users', '*', array('id' =>$orecord['user_id']),2);
					$deposit_amount=$urecord['deposit_amount'];
                    $home_content = $this->Common_model->get_record('tbl_home_content', '*',array('id' => 1) , 2);
					$debit_amount=$orecord['total_weight']*$home_content['casted_gold_deposit'];
					$new_deposit_amount=$deposit_amount-$debit_amount;
					
					$update_data = array(
					'order_status' => 2
					);
					$result = $this->Common_model->update_record('tbl_casted_gold_orders', $update_data, array('id' => $id));
					
					$update_data1 = array(
					'deposit_amount' => $new_deposit_amount
					);
					$result = $this->Common_model->update_record('tbl_casted_gold_users', $update_data1, array('id' => $urecord['id']));
                }
                else if ($segment2 == "casted_gold_sales_download_admin")
                {
                    $id = $this->input->get('id');
                   
					$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
					$data['record'] =$this->Common_model->get_record('tbl_casted_gold_orders','*',array('id'=>$id),2);
					
					$data['order_products'] =$this->Common_model->get_record('tbl_casted_gold_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


					$invoice_page=$this->load->view($this->views_folder.'casted_gold_sales_invoice_admin',$data,TRUE);


					$pdfFilePath = "Invoice(".$id.").pdf";
					$this->load->library('m_pdf');
					$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
					$this->m_pdf->pdf->WriteHTML($invoice_page);
					$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
                }
                else if ($segment2 == "casted_gold_sales_download_customer")
                {
                    $id = $this->input->get('id');
                   
					$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
					$data['record'] =$this->Common_model->get_record('tbl_casted_gold_orders','*',array('id'=>$id),2);
					
					$data['order_products'] =$this->Common_model->get_record('tbl_casted_gold_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


					$invoice_page=$this->load->view($this->views_folder.'casted_gold_sales_invoice_customer',$data,TRUE);


					$pdfFilePath = "Invoice(".$id.").pdf";
					$this->load->library('m_pdf');
					$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
					$this->m_pdf->pdf->WriteHTML($invoice_page);
					$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
                }
                else if ($segment2 == "casted_gold_sales_download_pickup")
                {
                    $id = $this->input->get('id');
                   
					$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
					$data['record'] =$this->Common_model->get_record('tbl_casted_gold_orders','*',array('id'=>$id),2);
					
					$data['order_products'] =$this->Common_model->get_record('tbl_casted_gold_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


					$invoice_page=$this->load->view($this->views_folder.'casted_gold_sales_invoice_pickup',$data,TRUE);


					$pdfFilePath = "Invoice(".$id.").pdf";
					$this->load->library('m_pdf');
					$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
					$this->m_pdf->pdf->WriteHTML($invoice_page);
					$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
                }
                else if ($segment2 == "casted_silver_sales")
                {
                    $data['commission'] = $this->Common_model->get_record('tbl_casted_silver_commission', '*',array('id' => 1) , 2);
                    $data['employees'] = $this->Common_model->get_record('tbl_company_employees', '*','' ,1,array('id','DESC'));
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$from_date=date("Y-m-d");
					$to_date=date("Y-m-d");
                    $data['records'] = $this->Admin_model->get_casted_silver_pending_sales($from_date,$to_date);
                    $data['home_content'] = $this->Common_model->get_record('tbl_home_content', '*',array('id' => 1) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_sales', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_sales_ajax")
                {
                    $data['commission'] = $this->Common_model->get_record('tbl_casted_silver_commission', '*',array('id' => 1) , 2);
                    $data['home_content'] = $this->Common_model->get_record('tbl_home_content', '*',array('id' => 1) , 2);
                    $from_date = $this->input->post('from_date');
                    $to_date = $this->input->post('to_date');
                    $order_type = $this->input->post('order_type');
					if($order_type!=2){
					if($order_type==0){
                    $data['records'] = $this->Admin_model->get_casted_silver_pending_sales($from_date,$to_date);
					}else if($order_type==1){
                    $data['records'] = $this->Admin_model->get_casted_silver_sales($from_date,$to_date);
					}else{
                    $data['records'] = $this->Admin_model->get_casted_silver_sales_cancelled($from_date,$to_date);
					}
                    $this->load->view($this->views_folder.'casted_silver_sales_ajax', $data);
					}else{
                    $data['records'] = $this->Admin_model->get_casted_silver_emp_sales($from_date,$to_date);
                    $this->load->view($this->views_folder.'casted_silver_emp_sales_ajax', $data);
					}
                }
                else if ($segment2 == "casted_silver_sales_update")
                {
                    $employee_id = $this->input->post('employee_id');
					$employee = $this->Common_model->get_record('tbl_company_employees', '*', array('id' =>$employee_id),2);
                    $id = $this->input->post('order_id');
                    $hsn_code = $this->input->post('hsn_code');
                    $silver_nos = $this->input->post('silver_nos');
                    $irn_no = $this->input->post('irn_no');
                    $tcs_value = $this->input->post('tcs_value');
                    $time = $this->input->post('time');
					if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
					{
						$path = './assets/images/casted/';
						$name1 = "image";
						$width = "";
						$height = "";
						$Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
						$qr_code = $Img1;
					}
					else
					{
						$qr_code = '';
					}
					$lrecord = $this->Common_model->get_record('tbl_casted_silver_orders', '*', array('order_status' =>1,'invoice_id!='=>0),2,array('id','desc'));
					$invoice_id=1;
					if(!empty($lrecord)){
					$invoice_id=$lrecord['invoice_id']+1;
					}
					$update_data = array(
					'employee_id' => $employee_id,
					'employee_code' => $employee['unique_code'],
					'employee_name' => $employee['name'],
					'invoice_id' => $invoice_id,
					'qr_code' => $qr_code,
					'hsn_code' => $hsn_code,
					'silver_nos' => $silver_nos,
					'irn_no' => $irn_no,
					'tcs_value' => $tcs_value,
					'time' => $time,
					'order_status' => 1
					);
					$result = $this->Common_model->update_record('tbl_casted_silver_orders', $update_data, array('id' => $id));
                }
                else if ($segment2 == "casted_silver_sales_cancel")
                {
                    $id = $this->input->post('order_id');
					$orecord = $this->Common_model->get_record('tbl_casted_silver_orders', '*', array('id' =>$id),2);
					$urecord = $this->Common_model->get_record('tbl_casted_silver_users', '*', array('id' =>$orecord['user_id']),2);
					$deposit_amount=$urecord['deposit_amount'];
                    $home_content = $this->Common_model->get_record('tbl_home_content', '*',array('id' => 1) , 2);
					$debit_amount=$orecord['total_weight']*$home_content['casted_silver_deposit'];
					$new_deposit_amount=$deposit_amount-$debit_amount;
					
					$update_data = array(
					'order_status' => 2
					);
					$result = $this->Common_model->update_record('tbl_casted_silver_orders', $update_data, array('id' => $id));
					
					$update_data1 = array(
					'deposit_amount' => $new_deposit_amount
					);
					$result = $this->Common_model->update_record('tbl_casted_silver_users', $update_data1, array('id' => $urecord['id']));
                }
                else if ($segment2 == "casted_silver_sales_download_admin")
                {
                    $id = $this->input->get('id');
                   
					$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
					$data['record'] =$this->Common_model->get_record('tbl_casted_silver_orders','*',array('id'=>$id),2);
					
					$data['order_products'] =$this->Common_model->get_record('tbl_casted_silver_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


					$invoice_page=$this->load->view($this->views_folder.'casted_silver_sales_invoice_admin',$data,TRUE);


					$pdfFilePath = "Invoice(".$id.").pdf";
					$this->load->library('m_pdf');
					$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
					$this->m_pdf->pdf->WriteHTML($invoice_page);
					$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
                }
                else if ($segment2 == "casted_silver_sales_download_customer")
                {
                    $id = $this->input->get('id');
                   
					$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
					$data['record'] =$this->Common_model->get_record('tbl_casted_silver_orders','*',array('id'=>$id),2);
					
					$data['order_products'] =$this->Common_model->get_record('tbl_casted_silver_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


					$invoice_page=$this->load->view($this->views_folder.'casted_silver_sales_invoice_customer',$data,TRUE);


					$pdfFilePath = "Invoice(".$id.").pdf";
					$this->load->library('m_pdf');
					$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
					$this->m_pdf->pdf->WriteHTML($invoice_page);
					$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
                }
                else if ($segment2 == "casted_silver_sales_download_pickup")
                {
                    $id = $this->input->get('id');
                   
					$data['home_content'] =$this->Common_model->get_record('tbl_home_content','*',array('id'=>1),2);
					$data['record'] =$this->Common_model->get_record('tbl_casted_silver_orders','*',array('id'=>$id),2);
					
					$data['order_products'] =$this->Common_model->get_record('tbl_casted_silver_order_products','*',array('order_id'=>$id),1,array('id','ASC'));


					$invoice_page=$this->load->view($this->views_folder.'casted_silver_sales_invoice_pickup',$data,TRUE);


					$pdfFilePath = "Invoice(".$id.").pdf";
					$this->load->library('m_pdf');
					$this->m_pdf->pdf->SetFont('times', 'BI', 20, '', 'false');
					$this->m_pdf->pdf->WriteHTML($invoice_page);
					$this->m_pdf->pdf->Output($pdfFilePath, "I"); 	
                }
                else if ($segment2 == "casted_silver_content")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 4) , 2);
                    $this->load->view($this->views_folder.'categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_categories")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->Common_model->get_record('tbl_casted_silver_categories', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_categories_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_silver_categories', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_categories_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_categories_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $display_order = $this->input->post('display_order');
                    $products_display_count = $this->input->post('products_display_count');
                    $ads_display_count = $this->input->post('ads_display_count');
                    if ($id == 0)
                    {
                        $add_data = array(
							'name' => $name,
                            'display_order' => $display_order,
                            'products_display_count' => $products_display_count,
                            'ads_display_count' => $ads_display_count,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_casted_silver_categories', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'name' => $name,
                            'display_order' => $display_order,
                            'products_display_count' => $products_display_count,
                            'ads_display_count' => $ads_display_count
                        );
                        $result = $this->Common_model->update_record('tbl_casted_silver_categories', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "casted_silver_categories_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_silver_categories', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_silver_categories');
                }
                else if ($segment2 == "casted_silver_categories_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_casted_silver_products', '*', array('category_id' => $id) , 3);
					if($record>0){						
                        $this->session->set_flashdata('error', 'Products available with this casted_silver_categories delete products and try again...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_casted_silver_categories');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Deleted...');
						}
                    }
                    redirect('admin/casted_silver_categories');
                }
                else if ($segment2 == "casted_silver_products")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->db->query("Select t1.*,t2.name as category_name from tbl_casted_silver_products t1 left join tbl_casted_silver_categories t2 on t1.category_id=t2.id order by t1.id desc")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_products', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_products_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_silver_products', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_casted_silver_categories', '*', '', 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_products_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_products_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $name = $this->input->post('name');
                    $image_alt = $this->input->post('image_alt');
                    $weight = $this->input->post('weight');
                    $mrp = $this->input->post('mrp');
                    $purity = $this->input->post('purity');
                    $purity_percentage = $this->input->post('purity_percentage');
                    if ($id == 0)
                    {
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/casted_silver/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = '';
                        }
                        $add_data = array(
							'category_id' => $category_id,
							'name' => $name,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'weight' => $weight,
                            'mrp' => $mrp,
                            'purity' => $purity,
                            'purity_percentage' => $purity_percentage,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_casted_silver_products', $add_data);
                    }
                    else
                    {
                        $record = $this->Common_model->get_record('tbl_casted_silver_products', '*', array('id' => $id    ) , 2);
                        $oldimage = $record['image'];
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/casted_silver/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = $oldimage;
                        }
                        $update_data = array(
							'category_id' => $category_id,
							'name' => $name,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'weight' => $weight,
                            'mrp' => $mrp,
                            'purity' => $purity,
                            'purity_percentage' => $purity_percentage
                        );
                        $result = $this->Common_model->update_record('tbl_casted_silver_products', $update_data, array('id' => $id));
                        if (!empty($result))
                        {
                            if ($image != $oldimage)
                            {
                                if (!empty($record['image']))
                                {
                                    $aoldimage1 = $record['image'];
                                    $upload_path = './assets/images/casted_silver/';
                                    $file = $upload_path.$aoldimage1;
                                    if (file_exists($file))
                                    {
                                        unlink($file);
                                    }
                                }
                            }
                        }
                    }
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
                else if ($segment2 == "casted_silver_products_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_silver_products', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_silver_products');
                }
                else if ($segment2 == "casted_silver_products_delete")
                {
                    $id = $this->input->get('id');
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_casted_silver_products');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Deleted...');
					}
                    redirect('admin/casted_silver_products');
                }
                else if ($segment2 == "casted_silver_products_prices")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					/*$data['org_price'] = $org_price='1853.65';
					$data['dollar_price'] = $dollar_price='75.555';*/
					$data['org_price'] = $org_price=$this->get_api_value(2);
					$data['dollar_price'] = $dollar_price=$this->get_api_value(3);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 4) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_casted_silver_products', '*', '', 1, array('id','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_products_prices', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_products_prices_loop")
                {
                    /*$org_price = $this->input->post('org_price');
					if($org_price=='1853.65'){
						$org_price='1853.75';
					}else if($org_price=='1853.75'){
						$org_price='1853.85';
					}else if($org_price=='1853.85'){
						$org_price='1853.65';
					}
					$data['org_price'] = $org_price;
                    $dollar_price = $this->input->post('dollar_price');
					if($dollar_price=='75.555'){
						$dollar_price='75.565';
					}else if($dollar_price=='75.565'){
						$dollar_price='75.575';
					}else if($dollar_price=='75.575'){
						$dollar_price='75.555';
					}
					$data['dollar_price'] = $dollar_price;*/
					$data['org_price'] = $org_price=$this->get_api_value(2);
					$data['dollar_price'] = $dollar_price=$this->get_api_value(3);
					
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 4) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_casted_silver_products', '*', '', 1, array('id','asc'));
                    $this->load->view($this->views_folder.'casted_silver_products_prices_loop', $data);
                }
                else if ($segment2 == "casted_silver_products_prices_ajax")
                {
                    $id = $this->input->post('id');
                    $a1_value = $this->input->post('a1_value');
                    $a3_value = $this->input->post('a3_value');
                    $b1_value = $this->input->post('b1_value');
                    $c_value = $this->input->post('c_value');
                    $e_value = $this->input->post('e_value');
                    $g_value = $this->input->post('g_value');
                    $l_value = $this->input->post('l_value');
                    $gst = $this->input->post('gst');
                    $mcxa_value = $this->input->post('mcxa_value');
                    $mcxb_value = $this->input->post('mcxb_value');
                    $mcxc_value = $this->input->post('mcxc_value');
                    $all_india_display = $this->input->post('all_india_display');
					$update_data = array(
						'a1_value' => $a1_value,
						'a3_value' => $a3_value,
						'b1_value' => $b1_value,
						'c_value' => $c_value,
						'e_value' => $e_value,
						'g_value' => $g_value,
						'l_value' => $l_value,
						'gst' => $gst,
						'mcxa_value' => $mcxa_value,
						'mcxb_value' => $mcxb_value,
						'mcxc_value' => $mcxc_value,
						'all_india_display' => $all_india_display
					);
					$result = $this->Common_model->update_record('tbl_categories', $update_data, array('id' => $id));
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
                else if ($segment2 == "casted_silver_ads")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->db->query("Select t1.*,t2.name as category_name from tbl_casted_silver_ads t1 left join tbl_casted_silver_categories t2 on t1.category_id=t2.id order by t1.id desc")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_ads', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_ads_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_silver_ads', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_casted_silver_categories', '*', '', 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_ads_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_ads_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $ad_type = $this->input->post('ad_type');
                    $image_alt = $this->input->post('image_alt');
                    $url = $this->input->post('url');
                    $google_code = $this->input->post('google_code');
                    if ($id == 0)
                    {
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/casted_silver/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = '';
                        }
                        $add_data = array(
							'category_id' => $category_id,
							'ad_type' => $ad_type,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'url' => $url,
                            'google_code' => $google_code,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_casted_silver_ads', $add_data);
                    }
                    else
                    {
                        $record = $this->Common_model->get_record('tbl_casted_silver_ads', '*', array('id' => $id    ) , 2);
                        $oldimage = $record['image'];
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/casted_silver/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = $oldimage;
                        }
                        $update_data = array(
							'category_id' => $category_id,
							'ad_type' => $ad_type,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'url' => $url,
                            'google_code' => $google_code
                        );
                        $result = $this->Common_model->update_record('tbl_casted_silver_ads', $update_data, array('id' => $id));
                        if (!empty($result))
                        {
                            if ($image != $oldimage || $ad_type==1)
                            {
                                if (!empty($record['image']))
                                {
                                    $aoldimage1 = $record['image'];
                                    $upload_path = './assets/images/casted_silver/';
                                    $file = $upload_path.$aoldimage1;
                                    if (file_exists($file))
                                    {
                                        unlink($file);
                                    }
                                }
                            }
                        }
                    }
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
                else if ($segment2 == "casted_silver_ads_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_silver_ads', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_silver_ads');
                }
                else if ($segment2 == "casted_silver_ads_delete")
                {
                    $id = $this->input->get('id');
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_casted_silver_ads');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Deleted...');
					}
                    redirect('admin/casted_silver_ads');
                }
                else if ($segment2 == "casted_silver_users")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$data['records'] = $this->Common_model->get_record('tbl_casted_silver_users', '*', '', 1, array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_users', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_users_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_silver_users', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_users_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_users_ajax")
                {
                    $id = $this->input->post('id');
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
                    if ($id == 0)
                    {
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = '';
						}
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
							'document' => $pdf,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
						$where="mobile='".$mobile."' OR email='".$email."'";
						$record = $this->Common_model->get_record('tbl_casted_silver_users', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->add_record('tbl_casted_silver_users', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Email ID or Mobile Number already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$record = $this->Common_model->get_record('tbl_casted_silver_users', '*', array('id' => $id    ) , 2);
						$oldimage1 = $record['document'];
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = $oldimage1;
						}
                        $update_data = array(
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
							'document' => $pdf
                        );
						$where="(mobile='".$mobile."' OR email='".$email."') AND id!='".$id."'";
						$record = $this->Common_model->get_record('tbl_casted_silver_users', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->update_record('tbl_casted_silver_users', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Unique Code or Email ID or Mobile Number already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "casted_silver_users_edit")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_silver_users', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_users_edit', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_users_edit_ajax")
                {
                    $id = $this->input->post('id');
                    $unique_code = $this->input->post('unique_code');
                    $password = $this->input->post('password');
                    $epassword = encode5t($password);
                    $file_number = $this->input->post('file_number');
                    $deposit_amount = $this->input->post('deposit_amount');
					$update_data = array(
						'unique_code' => $unique_code,
						'password' => $epassword,
						'file_number' => $file_number,
						'deposit_amount' => $deposit_amount
					);
					$where="unique_code='".$unique_code."' AND id!='".$id."'";
					$record = $this->Common_model->get_record('tbl_casted_silver_users', '*', $where,2);
					if(empty($record))
					{
						$result = $this->Common_model->update_record('tbl_casted_silver_users', $update_data, array('id' => $id));
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
					}
					else
					{
						$data['msg'] = 'Unique Code already exists...';
						$data['status'] = 0;
					}
                    echo json_encode($data);
                }
                else if ($segment2 == "casted_silver_users_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_silver_users', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_silver_users');
                }
                else if ($segment2 == "casted_silver_users_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_casted_silver_users');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_silver_users');
                }
                else if ($segment2 == "casted_silver_employees")
                {
                    $data['records'] = $this->Common_model->get_record('tbl_casted_silver_employees', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_employees', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_employees_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_silver_employees', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_employees_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_employees_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $company_name = $this->input->post('company_name');
                    $gst = $this->input->post('gst');
                    $address = $this->input->post('address');
                    $pan_number = $this->input->post('pan_number');
                    $bank_name = $this->input->post('bank_name');
                    $account_number = $this->input->post('account_number');
                    $ifsc = $this->input->post('ifsc');
                    $branch = $this->input->post('branch');
                    $unique_code = $this->input->post('unique_code');
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_casted_silver_employees', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_casted_silver_employees', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_casted_silver_employees', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch
							);
							$result = $this->Common_model->update_record('tbl_casted_silver_employees', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "casted_silver_employees_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_silver_employees', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_silver_employees');
                }
                else if ($segment2 == "casted_silver_employees_delete")
                {
                    $id = $this->input->get('id');
                    $promoters = $this->Common_model->get_record('tbl_casted_silver_promoters', '*', array('employee_id' => $id) , 3);
					if($promoters>0){
						$this->session->set_flashdata('error', 'Promoters Available...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_casted_silver_employees');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Updated...');
						}
                    }
                    redirect('admin/casted_silver_employees');
                }
                else if ($segment2 == "casted_silver_promoters")
                {
                    $employee_id = 0;
					if(!empty($_GET)){
                    $employee_id = $this->input->get('id');
					}
					$data['employee_id']=$employee_id;
                    /*$data['records'] = $this->Common_model->get_casted_silver_promoters();*/
                    $data['records'] = $this->Common_model->get_record('tbl_casted_silver_promoters', '*', array('employee_id' => $employee_id) , 1,array('id','desc'));
                    $data['employees'] = $this->Common_model->get_record('tbl_casted_silver_employees', '*', array('status'=>1), 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_promoters', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_promoters_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_silver_promoters', '*', array('id' => $id) , 2);
                    $data['employees'] = $this->Common_model->get_record('tbl_casted_silver_employees', '*', array('status'=>1), 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_promoters_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_promoters_ajax")
                {
                    $id = $this->input->post('id');
                    $employee_id = $this->input->post('employee_id');
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $company_name = $this->input->post('company_name');
                    $gst = $this->input->post('gst');
                    $address = $this->input->post('address');
                    $pan_number = $this->input->post('pan_number');
                    $bank_name = $this->input->post('bank_name');
                    $account_number = $this->input->post('account_number');
                    $ifsc = $this->input->post('ifsc');
                    $branch = $this->input->post('branch');
                    $unique_code = $this->input->post('unique_code');
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_casted_silver_promoters', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_casted_silver_promoters', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
						/*if (!empty($result))
						{		
							$ukey=$result;
							if($result<10){
								$ukey='0'.$result;
							}
							$unique_code='Ahnp'.$ukey;
							$update_data = array(
								'unique_code' => $unique_code
							);
							$result = $this->Common_model->update_record('casted_silver_promoters', $update_data, array('id' => $result));
						}*/
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_casted_silver_promoters', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch
							);
							$result = $this->Common_model->update_record('tbl_casted_silver_promoters', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "casted_silver_promoters_status")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_casted_silver_promoters', '*', array('id' => $id) , 2);
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_silver_promoters', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_silver_promoters?id='.$record['employee_id']);
                }
                else if ($segment2 == "casted_silver_promoters_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_casted_silver_promoters', '*', array('id' => $id) , 2);
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_casted_silver_promoters');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_silver_promoters?id='.$record['employee_id']);
                }
                else if ($segment2 == "casted_silver_commission")
                {
                    $data['records'] = $this->Common_model->get_record('tbl_casted_silver_commission', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_commission', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_commission_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_casted_silver_commission', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'casted_silver_commission_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "casted_silver_commission_ajax")
                {
                    $id = $this->input->post('id');
                    $employee_commission = $this->input->post('employee_commission');
                    $promoter_commission = $this->input->post('promoter_commission');
					$expiry_date=date("Y-m-d", strtotime($_POST['expiry_date']));
                    if ($id == 0)
                    {
                        $add_data = array(
							'employee_commission' => $employee_commission,
                            'promoter_commission' => $promoter_commission,
                            'expiry_date' => $expiry_date,
                            'status' => 1
                        );
                        $result = $this->Common_model->add_record('tbl_casted_silver_commission', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'employee_commission' => $employee_commission,
                            'promoter_commission' => $promoter_commission,
                            'expiry_date' => $expiry_date
                        );
                        $result = $this->Common_model->update_record('tbl_casted_silver_commission', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "casted_silver_commission_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_casted_silver_commission', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/casted_silver_commission');
                }
                else if ($segment2 == "minted_gold_content")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 2) , 2);
                    $this->load->view($this->views_folder.'categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_categories")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->Common_model->get_record('tbl_minted_categories', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_categories_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_categories', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_categories_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_categories_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $display_order = $this->input->post('display_order');
                    $products_display_count = $this->input->post('products_display_count');
                    $ads_display_count = $this->input->post('ads_display_count');
                    if ($id == 0)
                    {
                        $add_data = array(
							'name' => $name,
                            'display_order' => $display_order,
                            'products_display_count' => $products_display_count,
                            'ads_display_count' => $ads_display_count,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_minted_categories', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'name' => $name,
                            'display_order' => $display_order,
                            'products_display_count' => $products_display_count,
                            'ads_display_count' => $ads_display_count
                        );
                        $result = $this->Common_model->update_record('tbl_minted_categories', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "minted_categories_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_categories', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_categories');
                }
                else if ($segment2 == "minted_categories_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_minted_products', '*', array('category_id' => $id) , 3);
					if($record>0){						
                        $this->session->set_flashdata('error', 'Products available with this minted_categories delete products and try again...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_minted_categories');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Deleted...');
						}
                    }
                    redirect('admin/minted_categories');
                }
                else if ($segment2 == "minted_products")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->db->query("Select t1.*,t2.name as category_name from tbl_minted_products t1 left join tbl_minted_categories t2 on t1.category_id=t2.id order by t1.id desc")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_products', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_products_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_products', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_minted_categories', '*', '', 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_products_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_products_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $name = $this->input->post('name');
                    $image_alt = $this->input->post('image_alt');
                    $weight = $this->input->post('weight');
                    $add_value = $this->input->post('add_value');
                    $mrp = $this->input->post('mrp');
                    if ($id == 0)
                    {
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/minted/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = '';
                        }
                        $add_data = array(
							'category_id' => $category_id,
							'name' => $name,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'weight' => $weight,
                            'add_value' => $add_value,
                            'mrp' => $mrp,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_minted_products', $add_data);
                    }
                    else
                    {
                        $record = $this->Common_model->get_record('tbl_minted_products', '*', array('id' => $id    ) , 2);
                        $oldimage = $record['image'];
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/minted/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = $oldimage;
                        }
                        $update_data = array(
							'category_id' => $category_id,
							'name' => $name,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'weight' => $weight,
                            'add_value' => $add_value,
                            'mrp' => $mrp
                        );
                        $result = $this->Common_model->update_record('tbl_minted_products', $update_data, array('id' => $id));
                        if (!empty($result))
                        {
                            if ($image != $oldimage)
                            {
                                if (!empty($record['image']))
                                {
                                    $aoldimage1 = $record['image'];
                                    $upload_path = './assets/images/minted/';
                                    $file = $upload_path.$aoldimage1;
                                    if (file_exists($file))
                                    {
                                        unlink($file);
                                    }
                                }
                            }
                        }
                    }
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
                else if ($segment2 == "minted_products_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_products', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_products');
                }
                else if ($segment2 == "minted_products_delete")
                {
                    $id = $this->input->get('id');
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_minted_products');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Deleted...');
					}
                    redirect('admin/minted_products');
                }
                else if ($segment2 == "minted_products_prices")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					/*$data['org_price'] = $org_price='1853.65';
					$data['dollar_price'] = $dollar_price='75.555';*/
					$data['org_price'] = $org_price=$this->get_api_value(1);
					$data['dollar_price'] = $dollar_price=$this->get_api_value(3);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 2) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_minted_products', '*', '', 1, array('id','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_products_prices', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_products_prices_loop")
                {
                    /*$org_price = $this->input->post('org_price');
					if($org_price=='1853.65'){
						$org_price='1853.75';
					}else if($org_price=='1853.75'){
						$org_price='1853.85';
					}else if($org_price=='1853.85'){
						$org_price='1853.65';
					}
					$data['org_price'] = $org_price;
                    $dollar_price = $this->input->post('dollar_price');
					if($dollar_price=='75.555'){
						$dollar_price='75.565';
					}else if($dollar_price=='75.565'){
						$dollar_price='75.575';
					}else if($dollar_price=='75.575'){
						$dollar_price='75.555';
					}
					$data['dollar_price'] = $dollar_price;*/
					$data['org_price'] = $org_price=$this->get_api_value(1);
					$data['dollar_price'] = $dollar_price=$this->get_api_value(3);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 2) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_minted_products', '*', '', 1, array('id','asc'));
                    $this->load->view($this->views_folder.'minted_products_prices_loop', $data);
                }
                else if ($segment2 == "minted_products_prices_ajax")
                {
                    $id = $this->input->post('id');
                    $a1_value = $this->input->post('a1_value');
                    $a3_value = $this->input->post('a3_value');
                    $b1_value = $this->input->post('b1_value');
                    $c_value = $this->input->post('c_value');
                    $e_value = $this->input->post('e_value');
                    $g_value = $this->input->post('g_value');
                    $gst = $this->input->post('gst');
					$update_data = array(
						'a1_value' => $a1_value,
						'a3_value' => $a3_value,
						'b1_value' => $b1_value,
						'c_value' => $c_value,
						'e_value' => $e_value,
						'g_value' => $g_value,
						'gst' => $gst
					);
					$result = $this->Common_model->update_record('tbl_categories', $update_data, array('id' => $id));
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
                else if ($segment2 == "minted_ads")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->db->query("Select t1.*,t2.name as category_name from tbl_minted_ads t1 left join tbl_minted_categories t2 on t1.category_id=t2.id order by t1.id desc")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_ads', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_ads_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_ads', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_minted_categories', '*', '', 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_ads_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_ads_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $ad_type = $this->input->post('ad_type');
                    $image_alt = $this->input->post('image_alt');
                    $google_code = $this->input->post('google_code');
                    if ($id == 0)
                    {
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/minted/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = '';
                        }
                        $add_data = array(
							'category_id' => $category_id,
							'ad_type' => $ad_type,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'google_code' => $google_code,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_minted_ads', $add_data);
                    }
                    else
                    {
                        $record = $this->Common_model->get_record('tbl_minted_ads', '*', array('id' => $id    ) , 2);
                        $oldimage = $record['image'];
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/minted/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = $oldimage;
                        }
                        $update_data = array(
							'category_id' => $category_id,
							'ad_type' => $ad_type,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'google_code' => $google_code
                        );
                        $result = $this->Common_model->update_record('tbl_minted_ads', $update_data, array('id' => $id));
                        if (!empty($result))
                        {
                            if ($image != $oldimage || $ad_type==1)
                            {
                                if (!empty($record['image']))
                                {
                                    $aoldimage1 = $record['image'];
                                    $upload_path = './assets/images/minted/';
                                    $file = $upload_path.$aoldimage1;
                                    if (file_exists($file))
                                    {
                                        unlink($file);
                                    }
                                }
                            }
                        }
                    }
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
                else if ($segment2 == "minted_ads_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_ads', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_ads');
                }
                else if ($segment2 == "minted_ads_delete")
                {
                    $id = $this->input->get('id');
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_minted_ads');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Deleted...');
					}
                    redirect('admin/minted_ads');
                }
                else if ($segment2 == "minted_users")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$data['records'] = $this->Common_model->get_record('tbl_minted_users', '*', '', 1, array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_users', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_users_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_users', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_users_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_users_ajax")
                {
                    $id = $this->input->post('id');
                    $name_type = $this->input->post('name_type');
                    $name = $this->input->post('name');
                    $email = $this->input->post('email');
                    $mobile = $this->input->post('mobile');
                    $company_type = $this->input->post('company_type');
                    $company_name = $this->input->post('company_name');
                    $pan_number = $this->input->post('pan_number');
                    $firm_type = $this->input->post('firm_type');
                    $gst_no = $this->input->post('gst_no');
                    $shop_type = $this->input->post('shop_type');
                    $grams = $this->input->post('grams');
                    $kgs = $this->input->post('kgs');
                    $silver_grams = $this->input->post('silver_grams');
                    $silver_kgs = $this->input->post('silver_kgs');
                    $state = $this->input->post('state');
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
                    if ($id == 0)
                    {
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = '';
						}
                        $add_data = array(
							'name_type' => $name_type,
							'name' => $name,
							'email' => $email,
							'mobile' => $mobile,
							'company_type' => $company_type,
							'company_name' => $company_name,
							'pan_number' => $pan_number,
							'firm_type' => $firm_type,
							'gst_no' => $gst_no,
							'shop_type' => $shop_type,
							'grams' => $grams,
							'kgs' => $kgs,
							'silver_grams' => $silver_grams,
							'silver_kgs' => $silver_kgs,
							'state' => $state,
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
							'document' => $pdf,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
						$where="mobile='".$mobile."' OR email='".$email."'";
						$record = $this->Common_model->get_record('tbl_minted_users', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->add_record('tbl_minted_users', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Email ID or Mobile Number already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$record = $this->Common_model->get_record('tbl_minted_users', '*', array('id' => $id    ) , 2);
						$oldimage1 = $record['document'];
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = $oldimage1;
						}
                        $update_data = array(
							'name_type' => $name_type,
							'name' => $name,
							'email' => $email,
							'mobile' => $mobile,
							'company_type' => $company_type,
							'company_name' => $company_name,
							'pan_number' => $pan_number,
							'firm_type' => $firm_type,
							'gst_no' => $gst_no,
							'shop_type' => $shop_type,
							'grams' => $grams,
							'kgs' => $kgs,
							'silver_grams' => $silver_grams,
							'silver_kgs' => $silver_kgs,
							'state' => $state,
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
							'document' => $pdf
                        );
						$where="(mobile='".$mobile."' OR email='".$email."') AND id!='".$id."'";
						$record = $this->Common_model->get_record('tbl_minted_users', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->update_record('tbl_minted_users', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Unique Code or Email ID or Mobile Number already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "minted_users_edit")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_users', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_users_edit', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_users_edit_ajax")
                {
                    $id = $this->input->post('id');
                    $unique_code = $this->input->post('unique_code');
                    $password = $this->input->post('password');
                    $epassword = encode5t($password);
                    $file_number = $this->input->post('file_number');
					$update_data = array(
						'unique_code' => $unique_code,
						'password' => $epassword,
						'file_number' => $file_number
					);
					$where="unique_code='".$unique_code."' AND id!='".$id."'";
					$record = $this->Common_model->get_record('tbl_minted_users', '*', $where,2);
					if(empty($record))
					{
						$result = $this->Common_model->update_record('tbl_minted_users', $update_data, array('id' => $id));
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
					}
					else
					{
						$data['msg'] = 'Unique Code already exists...';
						$data['status'] = 0;
					}
                    echo json_encode($data);
                }
                else if ($segment2 == "minted_users_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_users', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_users');
                }
                else if ($segment2 == "minted_users_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_minted_users');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_users');
                }
                else if ($segment2 == "minted_employees")
                {
                    $data['records'] = $this->Common_model->get_record('tbl_minted_employees', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_employees', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_employees_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_employees', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_employees_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_employees_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $company_name = $this->input->post('company_name');
                    $gst = $this->input->post('gst');
                    $address = $this->input->post('address');
                    $pan_number = $this->input->post('pan_number');
                    $bank_name = $this->input->post('bank_name');
                    $account_number = $this->input->post('account_number');
                    $ifsc = $this->input->post('ifsc');
                    $branch = $this->input->post('branch');
                    $unique_code = $this->input->post('unique_code');
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_minted_employees', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_minted_employees', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_minted_employees', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch
							);
							$result = $this->Common_model->update_record('tbl_minted_employees', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "minted_employees_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_employees', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_employees');
                }
                else if ($segment2 == "minted_employees_delete")
                {
                    $id = $this->input->get('id');
                    $promoters = $this->Common_model->get_record('tbl_minted_promoters', '*', array('employee_id' => $id) , 3);
					if($promoters>0){
						$this->session->set_flashdata('error', 'Promoters Available...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_minted_employees');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Updated...');
						}
                    }
                    redirect('admin/minted_employees');
                }
                else if ($segment2 == "minted_promoters")
                {
                    $employee_id = 0;
					if(!empty($_GET)){
                    $employee_id = $this->input->get('id');
					}
					$data['employee_id']=$employee_id;
                    /*$data['records'] = $this->Common_model->get_minted_promoters();*/
                    $data['records'] = $this->Common_model->get_record('tbl_minted_promoters', '*', array('employee_id' => $employee_id) , 1,array('id','desc'));
                    $data['employees'] = $this->Common_model->get_record('tbl_minted_employees', '*', array('status'=>1), 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_promoters', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_promoters_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_promoters', '*', array('id' => $id) , 2);
                    $data['employees'] = $this->Common_model->get_record('tbl_minted_employees', '*', array('status'=>1), 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_promoters_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_promoters_ajax")
                {
                    $id = $this->input->post('id');
                    $employee_id = $this->input->post('employee_id');
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $company_name = $this->input->post('company_name');
                    $gst = $this->input->post('gst');
                    $address = $this->input->post('address');
                    $pan_number = $this->input->post('pan_number');
                    $bank_name = $this->input->post('bank_name');
                    $account_number = $this->input->post('account_number');
                    $ifsc = $this->input->post('ifsc');
                    $branch = $this->input->post('branch');
                    $unique_code = $this->input->post('unique_code');
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_minted_promoters', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_minted_promoters', $add_data);
							if (!empty($result))
							{
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
								$data['employee_id'] = $employee_id;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Unique Code is already exists...';
							$data['status'] = 0;
						}
						/*if (!empty($result))
						{		
							$ukey=$result;
							if($result<10){
								$ukey='0'.$result;
							}
							$unique_code='Ahnp'.$ukey;
							$update_data = array(
								'unique_code' => $unique_code
							);
							$result = $this->Common_model->update_record('minted_promoters', $update_data, array('id' => $result));
						}*/
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_minted_promoters', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch
							);
							$result = $this->Common_model->update_record('tbl_minted_promoters', $update_data, array('id' => $id));
							if (!empty($result))
							{
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
								$data['employee_id'] = $employee_id;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Unique Code is already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "minted_promoters_status")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_minted_promoters', '*', array('id' => $id) , 2);
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_promoters', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_promoters?id='.$record['employee_id']);
                }
                else if ($segment2 == "minted_promoters_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_minted_promoters', '*', array('id' => $id) , 2);
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_minted_promoters');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_promoters?id='.$record['employee_id']);
                }
                else if ($segment2 == "minted_commission")
                {
                    $data['records'] = $this->Common_model->get_record('tbl_minted_commission', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_commission', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_commission_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_commission', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_commission_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_commission_ajax")
                {
                    $id = $this->input->post('id');
                    $employee_commission = $this->input->post('employee_commission');
                    $promoter_commission = $this->input->post('promoter_commission');
					$expiry_date=date("Y-m-d", strtotime($_POST['expiry_date']));
                    if ($id == 0)
                    {
                        $add_data = array(
							'employee_commission' => $employee_commission,
                            'promoter_commission' => $promoter_commission,
                            'expiry_date' => $expiry_date,
                            'status' => 1
                        );
                        $result = $this->Common_model->add_record('tbl_minted_commission', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'employee_commission' => $employee_commission,
                            'promoter_commission' => $promoter_commission,
                            'expiry_date' => $expiry_date
                        );
                        $result = $this->Common_model->update_record('tbl_minted_commission', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "minted_commission_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_commission', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_commission');
                }
                else if ($segment2 == "minted_silver_gold_content")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 5) , 2);
                    $this->load->view($this->views_folder.'categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_categories")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->Common_model->get_record('tbl_minted_silver_categories', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_categories_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_silver_categories', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_categories_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_categories_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $display_order = $this->input->post('display_order');
                    $products_display_count = $this->input->post('products_display_count');
                    $ads_display_count = $this->input->post('ads_display_count');
                    if ($id == 0)
                    {
                        $add_data = array(
							'name' => $name,
                            'display_order' => $display_order,
                            'products_display_count' => $products_display_count,
                            'ads_display_count' => $ads_display_count,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_minted_silver_categories', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'name' => $name,
                            'display_order' => $display_order,
                            'products_display_count' => $products_display_count,
                            'ads_display_count' => $ads_display_count
                        );
                        $result = $this->Common_model->update_record('tbl_minted_silver_categories', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "minted_silver_categories_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_silver_categories', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_silver_categories');
                }
                else if ($segment2 == "minted_silver_categories_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_minted_silver_products', '*', array('category_id' => $id) , 3);
					if($record>0){						
                        $this->session->set_flashdata('error', 'Products available with this minted_silver_categories delete products and try again...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_minted_silver_categories');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Deleted...');
						}
                    }
                    redirect('admin/minted_silver_categories');
                }
                else if ($segment2 == "minted_silver_products")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->db->query("Select t1.*,t2.name as category_name from tbl_minted_silver_products t1 left join tbl_minted_silver_categories t2 on t1.category_id=t2.id order by t1.id desc")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_products', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_products_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_silver_products', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_minted_silver_categories', '*', '', 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_products_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_products_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $name = $this->input->post('name');
                    $image_alt = $this->input->post('image_alt');
                    $weight = $this->input->post('weight');
                    $add_value = $this->input->post('add_value');
                    $mrp = $this->input->post('mrp');
                    if ($id == 0)
                    {
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/minted_silver/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = '';
                        }
                        $add_data = array(
							'category_id' => $category_id,
							'name' => $name,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'weight' => $weight,
                            'add_value' => $add_value,
                            'mrp' => $mrp,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_minted_silver_products', $add_data);
                    }
                    else
                    {
                        $record = $this->Common_model->get_record('tbl_minted_silver_products', '*', array('id' => $id    ) , 2);
                        $oldimage = $record['image'];
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/minted_silver/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = $oldimage;
                        }
                        $update_data = array(
							'category_id' => $category_id,
							'name' => $name,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'weight' => $weight,
                            'add_value' => $add_value,
                            'mrp' => $mrp
                        );
                        $result = $this->Common_model->update_record('tbl_minted_silver_products', $update_data, array('id' => $id));
                        if (!empty($result))
                        {
                            if ($image != $oldimage)
                            {
                                if (!empty($record['image']))
                                {
                                    $aoldimage1 = $record['image'];
                                    $upload_path = './assets/images/minted_silver/';
                                    $file = $upload_path.$aoldimage1;
                                    if (file_exists($file))
                                    {
                                        unlink($file);
                                    }
                                }
                            }
                        }
                    }
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
                else if ($segment2 == "minted_silver_products_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_silver_products', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_silver_products');
                }
                else if ($segment2 == "minted_silver_products_delete")
                {
                    $id = $this->input->get('id');
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_minted_silver_products');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Deleted...');
					}
                    redirect('admin/minted_silver_products');
                }
                else if ($segment2 == "minted_silver_products_prices")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					/*$data['org_price'] = $org_price='1853.65';
					$data['dollar_price'] = $dollar_price='75.555';*/
					$data['org_price'] = $org_price=$this->get_api_value(2);
					$data['dollar_price'] = $dollar_price=$this->get_api_value(3);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 5) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_minted_silver_products', '*', '', 1, array('id','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_products_prices', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_products_prices_loop")
                {
                    /*$org_price = $this->input->post('org_price');
					if($org_price=='1853.65'){
						$org_price='1853.75';
					}else if($org_price=='1853.75'){
						$org_price='1853.85';
					}else if($org_price=='1853.85'){
						$org_price='1853.65';
					}
					$data['org_price'] = $org_price;
                    $dollar_price = $this->input->post('dollar_price');
					if($dollar_price=='75.555'){
						$dollar_price='75.565';
					}else if($dollar_price=='75.565'){
						$dollar_price='75.575';
					}else if($dollar_price=='75.575'){
						$dollar_price='75.555';
					}
					$data['dollar_price'] = $dollar_price;*/
					$data['org_price'] = $org_price=$this->get_api_value(2);
					$data['dollar_price'] = $dollar_price=$this->get_api_value(3);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 5) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_minted_silver_products', '*', '', 1, array('id','asc'));
                    $this->load->view($this->views_folder.'minted_silver_products_prices_loop', $data);
                }
                else if ($segment2 == "minted_silver_products_prices_ajax")
                {
                    $id = $this->input->post('id');
                    $a1_value = $this->input->post('a1_value');
                    $a3_value = $this->input->post('a3_value');
                    $b1_value = $this->input->post('b1_value');
                    $c_value = $this->input->post('c_value');
                    $e_value = $this->input->post('e_value');
                    $g_value = $this->input->post('g_value');
                    $gst = $this->input->post('gst');
					$update_data = array(
						'a1_value' => $a1_value,
						'a3_value' => $a3_value,
						'b1_value' => $b1_value,
						'c_value' => $c_value,
						'e_value' => $e_value,
						'g_value' => $g_value,
						'gst' => $gst
					);
					$result = $this->Common_model->update_record('tbl_categories', $update_data, array('id' => $id));
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
                else if ($segment2 == "minted_silver_ads")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->db->query("Select t1.*,t2.name as category_name from tbl_minted_silver_ads t1 left join tbl_minted_silver_categories t2 on t1.category_id=t2.id order by t1.id desc")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_ads', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_ads_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_silver_ads', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_minted_silver_categories', '*', '', 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_ads_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_ads_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $ad_type = $this->input->post('ad_type');
                    $image_alt = $this->input->post('image_alt');
                    $google_code = $this->input->post('google_code');
                    if ($id == 0)
                    {
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/minted_silver/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = '';
                        }
                        $add_data = array(
							'category_id' => $category_id,
							'ad_type' => $ad_type,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'google_code' => $google_code,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_minted_silver_ads', $add_data);
                    }
                    else
                    {
                        $record = $this->Common_model->get_record('tbl_minted_silver_ads', '*', array('id' => $id    ) , 2);
                        $oldimage = $record['image'];
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/minted_silver/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = $oldimage;
                        }
                        $update_data = array(
							'category_id' => $category_id,
							'ad_type' => $ad_type,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'google_code' => $google_code
                        );
                        $result = $this->Common_model->update_record('tbl_minted_silver_ads', $update_data, array('id' => $id));
                        if (!empty($result))
                        {
                            if ($image != $oldimage || $ad_type==1)
                            {
                                if (!empty($record['image']))
                                {
                                    $aoldimage1 = $record['image'];
                                    $upload_path = './assets/images/minted_silver/';
                                    $file = $upload_path.$aoldimage1;
                                    if (file_exists($file))
                                    {
                                        unlink($file);
                                    }
                                }
                            }
                        }
                    }
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
                else if ($segment2 == "minted_silver_ads_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_silver_ads', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_silver_ads');
                }
                else if ($segment2 == "minted_silver_ads_delete")
                {
                    $id = $this->input->get('id');
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_minted_silver_ads');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Deleted...');
					}
                    redirect('admin/minted_silver_ads');
                }
                else if ($segment2 == "minted_silver_users")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$data['records'] = $this->Common_model->get_record('tbl_minted_silver_users', '*', '', 1, array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_users', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_users_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_silver_users', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_users_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_users_ajax")
                {
                    $id = $this->input->post('id');
                    $name_type = $this->input->post('name_type');
                    $name = $this->input->post('name');
                    $email = $this->input->post('email');
                    $mobile = $this->input->post('mobile');
                    $company_type = $this->input->post('company_type');
                    $company_name = $this->input->post('company_name');
                    $pan_number = $this->input->post('pan_number');
                    $firm_type = $this->input->post('firm_type');
                    $gst_no = $this->input->post('gst_no');
                    $shop_type = $this->input->post('shop_type');
                    $grams = $this->input->post('grams');
                    $kgs = $this->input->post('kgs');
                    $silver_grams = $this->input->post('silver_grams');
                    $silver_kgs = $this->input->post('silver_kgs');
                    $state = $this->input->post('state');
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
                    if ($id == 0)
                    {
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = '';
						}
                        $add_data = array(
							'name_type' => $name_type,
							'name' => $name,
							'email' => $email,
							'mobile' => $mobile,
							'company_type' => $company_type,
							'company_name' => $company_name,
							'pan_number' => $pan_number,
							'firm_type' => $firm_type,
							'gst_no' => $gst_no,
							'shop_type' => $shop_type,
							'grams' => $grams,
							'kgs' => $kgs,
							'silver_grams' => $silver_grams,
							'silver_kgs' => $silver_kgs,
							'state' => $state,
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
							'document' => $pdf,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
						$where="mobile='".$mobile."' OR email='".$email."'";
						$record = $this->Common_model->get_record('tbl_minted_silver_users', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->add_record('tbl_minted_silver_users', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Email ID or Mobile Number already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$record = $this->Common_model->get_record('tbl_minted_silver_users', '*', array('id' => $id    ) , 2);
						$oldimage1 = $record['document'];
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = $oldimage1;
						}
                        $update_data = array(
							'name_type' => $name_type,
							'name' => $name,
							'email' => $email,
							'mobile' => $mobile,
							'company_type' => $company_type,
							'company_name' => $company_name,
							'pan_number' => $pan_number,
							'firm_type' => $firm_type,
							'gst_no' => $gst_no,
							'shop_type' => $shop_type,
							'grams' => $grams,
							'kgs' => $kgs,
							'silver_grams' => $silver_grams,
							'silver_kgs' => $silver_kgs,
							'state' => $state,
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
							'document' => $pdf
                        );
						$where="(mobile='".$mobile."' OR email='".$email."') AND id!='".$id."'";
						$record = $this->Common_model->get_record('tbl_minted_silver_users', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->update_record('tbl_minted_silver_users', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Unique Code or Email ID or Mobile Number already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "minted_silver_users_edit")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_silver_users', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_users_edit', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_users_edit_ajax")
                {
                    $id = $this->input->post('id');
                    $unique_code = $this->input->post('unique_code');
                    $password = $this->input->post('password');
                    $epassword = encode5t($password);
                    $file_number = $this->input->post('file_number');
					$update_data = array(
						'unique_code' => $unique_code,
						'password' => $epassword,
						'file_number' => $file_number
					);
					$where="unique_code='".$unique_code."' AND id!='".$id."'";
					$record = $this->Common_model->get_record('tbl_minted_silver_users', '*', $where,2);
					if(empty($record))
					{
						$result = $this->Common_model->update_record('tbl_minted_silver_users', $update_data, array('id' => $id));
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
					}
					else
					{
						$data['msg'] = 'Unique Code already exists...';
						$data['status'] = 0;
					}
                    echo json_encode($data);
                }
                else if ($segment2 == "minted_silver_users_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_silver_users', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_silver_users');
                }
                else if ($segment2 == "minted_silver_users_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_minted_silver_users');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_silver_users');
                }
                else if ($segment2 == "minted_silver_employees")
                {
                    $data['records'] = $this->Common_model->get_record('tbl_minted_silver_employees', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_employees', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_employees_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_silver_employees', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_employees_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_employees_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $company_name = $this->input->post('company_name');
                    $gst = $this->input->post('gst');
                    $address = $this->input->post('address');
                    $pan_number = $this->input->post('pan_number');
                    $bank_name = $this->input->post('bank_name');
                    $account_number = $this->input->post('account_number');
                    $ifsc = $this->input->post('ifsc');
                    $branch = $this->input->post('branch');
                    $unique_code = $this->input->post('unique_code');
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_minted_silver_employees', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_minted_silver_employees', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_minted_silver_employees', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch
							);
							$result = $this->Common_model->update_record('tbl_minted_silver_employees', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "minted_silver_employees_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_silver_employees', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_silver_employees');
                }
                else if ($segment2 == "minted_silver_employees_delete")
                {
                    $id = $this->input->get('id');
                    $promoters = $this->Common_model->get_record('tbl_minted_silver_promoters', '*', array('employee_id' => $id) , 3);
					if($promoters>0){
						$this->session->set_flashdata('error', 'Promoters Available...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_minted_silver_employees');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Updated...');
						}
                    }
                    redirect('admin/minted_silver_employees');
                }
                else if ($segment2 == "minted_silver_promoters")
                {
                    $employee_id = 0;
					if(!empty($_GET)){
                    $employee_id = $this->input->get('id');
					}
					$data['employee_id']=$employee_id;
                    /*$data['records'] = $this->Common_model->get_minted_silver_promoters();*/
                    $data['records'] = $this->Common_model->get_record('tbl_minted_silver_promoters', '*', array('employee_id' => $employee_id) , 1,array('id','desc'));
                    $data['employees'] = $this->Common_model->get_record('tbl_minted_silver_employees', '*', array('status'=>1), 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_promoters', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_promoters_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_silver_promoters', '*', array('id' => $id) , 2);
                    $data['employees'] = $this->Common_model->get_record('tbl_minted_silver_employees', '*', array('status'=>1), 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_promoters_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_promoters_ajax")
                {
                    $id = $this->input->post('id');
                    $employee_id = $this->input->post('employee_id');
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $company_name = $this->input->post('company_name');
                    $gst = $this->input->post('gst');
                    $address = $this->input->post('address');
                    $pan_number = $this->input->post('pan_number');
                    $bank_name = $this->input->post('bank_name');
                    $account_number = $this->input->post('account_number');
                    $ifsc = $this->input->post('ifsc');
                    $branch = $this->input->post('branch');
                    $unique_code = $this->input->post('unique_code');
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_minted_silver_promoters', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_minted_silver_promoters', $add_data);
							if (!empty($result))
							{
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
								$data['employee_id'] = $employee_id;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}else{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
						/*if (!empty($result))
						{		
							$ukey=$result;
							if($result<10){
								$ukey='0'.$result;
							}
							$unique_code='Ahnp'.$ukey;
							$update_data = array(
								'unique_code' => $unique_code
							);
							$result = $this->Common_model->update_record('minted_silver_promoters', $update_data, array('id' => $result));
						}*/
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_minted_silver_promoters', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch
							);
							$result = $this->Common_model->update_record('tbl_minted_silver_promoters', $update_data, array('id' => $id));
							if (!empty($result))
							{
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
								$data['employee_id'] = $employee_id;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}else{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "minted_silver_promoters_status")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_minted_silver_promoters', '*', array('id' => $id) , 2);
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_silver_promoters', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_silver_promoters?id='.$record['employee_id']);
                }
                else if ($segment2 == "minted_silver_promoters_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_minted_silver_promoters', '*', array('id' => $id) , 2);
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_minted_silver_promoters');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_silver_promoters?id='.$record['employee_id']);
                }
                else if ($segment2 == "minted_silver_commission")
                {
                    $data['records'] = $this->Common_model->get_record('tbl_minted_silver_commission', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_commission', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_commission_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_minted_silver_commission', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'minted_silver_commission_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "minted_silver_commission_ajax")
                {
                    $id = $this->input->post('id');
                    $employee_commission = $this->input->post('employee_commission');
                    $promoter_commission = $this->input->post('promoter_commission');
					$expiry_date=date("Y-m-d", strtotime($_POST['expiry_date']));
                    if ($id == 0)
                    {
                        $add_data = array(
							'employee_commission' => $employee_commission,
                            'promoter_commission' => $promoter_commission,
                            'expiry_date' => $expiry_date,
                            'status' => 1
                        );
                        $result = $this->Common_model->add_record('tbl_minted_silver_commission', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'employee_commission' => $employee_commission,
                            'promoter_commission' => $promoter_commission,
                            'expiry_date' => $expiry_date
                        );
                        $result = $this->Common_model->update_record('tbl_minted_silver_commission', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "minted_silver_commission_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_minted_silver_commission', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/minted_silver_commission');
                }
                else if ($segment2 == "gold_scrap_content")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 3) , 2);
                    $this->load->view($this->views_folder.'categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "corporate_deals_content")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['record'] = $this->Common_model->get_record('tbl_categories', '*', array('id' => 6) , 2);
                    $this->load->view($this->views_folder.'categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "categories_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $image_alt = $this->input->post('image_alt');       
                    $banner_alt = $this->input->post('banner_alt');       
                    $description = $this->input->post('description');       
                    $long_description = $this->input->post('long_description');       
					$link_name = $this->input->post('link_name');
					$scrolling_text = $this->input->post('scrolling_text');
					$status = $this->input->post('status');
					$url_redirect = $this->input->post('url_redirect');
					
					$record = $this->Common_model->get_record('tbl_categories', '*', array('id' => $id    ) , 2);
					$oldimage1 = $record['image'];
					$oldimage2 = $record['banner'];
					if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
					{
						$path = './assets/images/categories/';
						$name1 = "image";
						$width = "";
						$height = "";
						$Img1 = $this    ->Common_model    ->uploadImage($path, $name1, $width, $height);
						$image = $Img1;
					}
					else
					{
						$image = $oldimage1;
					}
					if (isset($_FILES['banner']['name']) && !empty($_FILES["banner"]["name"]))
					{
						$path = './assets/images/categories/';
						$name1 = "banner";
						$width = "";
						$height = "";
						$Img1 = $this    ->Common_model    ->uploadImage($path, $name1, $width, $height);
						$banner = $Img1;
					}
					else
					{
						$banner = $oldimage2;
					}
                    $update_data = array(
                        'name' => $name,
                        'image' => $image,
                        'image_alt' => $image_alt,	
                        'banner' => $banner,
                        'banner_alt' => $banner_alt,					
                        'description' => $description,
                        'long_description' => $long_description,
                        'link_name' => $link_name,
                        'scrolling_text' => $scrolling_text,
                        'status' => $status,
                        'url_redirect' => $url_redirect
					);
                    $result = $this->Common_model->update_record('tbl_categories', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
						if ($image != $oldimage1)
						{
							if (!empty($record['image']))
							{
								$aoldimage1 = $record['image'];
								$upload_path = './assets/images/categories/';
								$file = $upload_path.$aoldimage1;
								if (file_exists($file))
								{
									unlink($file);
								}
							}
						}
						if ($banner != $oldimage2)
						{
							if (!empty($record['banner']))
							{
								$aoldimage1 = $record['banner'];
								$upload_path = './assets/images/categories/';
								$file = $upload_path.$aoldimage1;
								if (file_exists($file))
								{
									unlink($file);
								}
							}
						}
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
                else if ($segment2 == "company_employees")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['records'] = $this->Common_model->get_record('tbl_company_employees', '*', '', 1, array('id','desc'));
                    $this->load->view($this->views_folder.'company_employees', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "company_employees_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_company_employees', '*', array('id' => $id) , 2);
                    $this->load->view($this->views_folder.'company_employees_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "company_employees_ajax")
                {
                    $id = $this->input->post('id');
                    $unique_code = $this->input->post('unique_code');
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');     
					
                    if ($id == 0)
                    {
                        $add_data = array(
							'unique_code' => $unique_code,
                            'name' => $name,
                            'mobile' => $mobile,
                            'email' => $email,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_company_employees', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'unique_code' => $unique_code,
                            'name' => $name,
                            'mobile' => $mobile,
                            'email' => $email
                        );
                        $result = $this->Common_model->update_record('tbl_company_employees', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "company_employees_delete")
                {
                    $id = $this->input->get('id');
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_company_employees');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Updated...');
					}
                    redirect('admin/company_employees');
                }
                else if ($segment2 == "banners")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_banners', '*', array('id' => $id) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_banners', '*', '', 1, array('id',
                        'desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'banners', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "banners_ajax")
                {
                    $id = $this->input->post('id');
                    $image_alt = $this->input->post('image_alt');
                    $h1_tag = $this->input->post('h1_tag');
                    if ($id == 0)
                    {
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/banners/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this    ->Common_model    ->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = '';
                        }
                        $add_data = array(
							'image' => $image,
                            'image_alt' => $image_alt,
                            'h1_tag' => $h1_tag,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_banners', $add_data);
                    }
                    else
                    {
                        $record = $this->Common_model->get_record('tbl_banners', '*', array('id' => $id    ) , 2);
                        $oldimage1 = $record['image'];
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/banners/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this    ->Common_model    ->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = $oldimage1;
                        }
                        $update_data = array(
							'image' => $image,
                            'image_alt' => $image_alt,
                            'h1_tag' => $h1_tag
                        );
                        $result = $this->Common_model->update_record('tbl_banners', $update_data, array('id' => $id));
                        if (!empty($result))
                        {
                            if ($image != $oldimage1)
                            {
                                if (!empty($record['image']))
                                {
                                    $aoldimage1 = $record['image'];
                                    $upload_path = './assets/images/banners/';
                                    $file = $upload_path.$aoldimage1;
                                    if (file_exists($file))
                                    {
                                        unlink($file);
                                    }
                                }
                            }
                        }
                    }
                    if (!empty($result))
                    {
                        $data['msg'] = 'Submitted Successfully...';
                        $data['status'] = 1;
                    }
                    else
                    {
                        $data['msg'] = 'Data Already Exists...';
                        $data['status'] = 0;
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "banners_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_banners', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/banners');
                }
                else if ($segment2 == "banners_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_banners', '*', array('id' => $id) , 2);
                    $aoldimage1 = $record['image'];
                    $upload_path = './assets/images/banners/';
                    $file = $upload_path.$aoldimage1;
                    if (file_exists($file))
                    {
                        unlink($file);
                    }
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_banners');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/banners');
                }
                else if ($segment2 == "videos")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_videos', '*', array('id' => $id) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_videos', '*', '', 1, array('id',
                        'desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'videos', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "videos_ajax")
                {
                    $id = $this->input->post('id');
                    $video_url = $this->input->post('video_url');
                    $video_alt = $this->input->post('video_alt');
                    if ($id == 0)
                    {
						$add_data = array(    
							'video_url' => $video_url,
							'video_alt' => $video_alt,
							'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
						);
						$result = $this ->Common_model ->add_record('tbl_videos', $add_data);
                    }
                    else
                    {
						$update_data = array(    
							'video_url' => $video_url,
							'video_alt' => $video_alt
						);
						$result = $this ->Common_model ->update_record('tbl_videos', $update_data, array('id' => $id));
                    }
                    if (!empty($result))
                    {
                        $data['msg'] = 'Submitted Successfully...';
                        $data['status'] = 1;
                    }
                    else
                    {
                        $data['msg'] = 'Data Already Exists...';
                        $data['status'] = 0;
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "videos_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_videos', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/videos');
                }
                else if ($segment2 == "videos_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_videos');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/videos');
                }
                else if ($segment2 == "areas")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_areas', '*', array('id' => $id) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_areas', '*', '', 1, array('id',
                        'desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'areas', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "areas_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    if ($id == 0)
                    {
						$add_data = array(    
							'name' => $name,
							'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
						);
						$result = $this ->Common_model ->add_record('tbl_areas', $add_data);
                    }
                    else
                    {
						$update_data = array(    
							'name' => $name
						);
						$result = $this ->Common_model ->update_record('tbl_areas', $update_data, array('id' => $id));
                    }
                    if (!empty($result))
                    {
                        $data['msg'] = 'Submitted Successfully...';
                        $data['status'] = 1;
                    }
                    else
                    {
                        $data['msg'] = 'Data Already Exists...';
                        $data['status'] = 0;
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "areas_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_areas', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/areas');
                }
                else if ($segment2 == "areas_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_areas');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/areas');
                }
                else if ($segment2 == "rates")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_rates', '*', array('id' => $id) , 2);
                    $data['records'] = $this->Admin_model->get_rates();
                    $data['areas'] = $this->Common_model->get_record('tbl_areas', '*', array('status'=>1), 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'rates', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "rates_ajax")
                {
                    $id = $this->input->post('id');
                    $metal_type = $this->input->post('metal_type');
                    $area_id = $this->input->post('area_id');
                    $rate = $this->input->post('rate');
                    if ($id == 0)
                    {
						$add_data = array(    
							'metal_type' => $metal_type,
							'area_id' => $area_id,
							'rate' => $rate,
							'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
						);
						$result = $this ->Common_model ->add_record('tbl_rates', $add_data);
                    }
                    else
                    {
						$update_data = array(    
							'metal_type' => $metal_type,
							'area_id' => $area_id,
							'rate' => $rate
						);
						$result = $this ->Common_model ->update_record('tbl_rates', $update_data, array('id' => $id));
                    }
                    if (!empty($result))
                    {
                        $data['msg'] = 'Submitted Successfully...';
                        $data['status'] = 1;
                    }
                    else
                    {
                        $data['msg'] = 'Data Already Exists...';
                        $data['status'] = 0;
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "rates_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_rates', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/rates');
                }
                else if ($segment2 == "rates_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_rates');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/rates');
                }
                else if ($segment2 == "faq_categories")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_faq_categories', '*', array('id' => $id) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_faq_categories', '*', '', 1, array('id',
                        'desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'faq_categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "ajax_faq_categories")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    if ($id == 0)
                    {
                        $add_data = array(
							'name' => $name,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_faq_categories', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'name' => $name
                        );
                        $result = $this->Common_model->update_record('tbl_faq_categories', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "faq_categories_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_faq_categories', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/faq_categories');
                }
                else if ($segment2 == "faq_categories_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_faq_categories');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/faq_categories');
                }
                else if ($segment2 == "faqs")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->Admin_model->get_faqs();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'faqs', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "faqs_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_faqs', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_faq_categories', '*', '', 1, array('id',
                        'desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'faqs_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "faqs_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $question = $this->input->post('question');
                    $answer = $this->input->post('answer');
                    if ($id == 0)
                    {
                        $add_data = array(
							'category_id' => $category_id,
                            'question' => $question,
                            'answer' => $answer,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_faqs', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'category_id' => $category_id,
                            'question' => $question,
                            'answer' => $answer
                        );
                        $result = $this->Common_model->update_record('tbl_faqs', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "faqs_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_faqs', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/faqs');
                }
                else if ($segment2 == "faqs_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_faqs');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/faqs');
                }
                else if ($segment2 == "about_pdf")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->Common_model->get_record('tbl_about_pdf', '*', '', 1, array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'about_pdf', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "about_pdf_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_about_pdf', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_faq_categories', '*', '', 1, array('id',
                        'desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'about_pdf_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "about_pdf_ajax")
                {
                    $id = $this->input->post('id');
                    $link = $this->input->post('link');
                    $code = $this->input->post('code');
                    $position = $this->input->post('position');
                    if ($id == 0)
                    {
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/about/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = '';
						}
                        $add_data = array(
							'link' => $link,
                            'code' => $code,
                            'position' => $position,
                            'pdf' => $pdf,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_about_pdf', $add_data);
                    }
                    else
                    {
						$record = $this->Common_model->get_record('tbl_about_pdf', '*', array('id' => $id    ) , 2);
						$oldimage1 = $record['pdf'];
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/about/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = $oldimage1;
						}
                        $update_data = array(
							'link' => $link,
                            'code' => $code,
                            'position' => $position,
                            'pdf' => $pdf
                        );
                        $result = $this->Common_model->update_record('tbl_about_pdf', $update_data, array('id' => $id));
						if (!empty($result))
						{
							if ($pdf != $oldimage1)
							{
								if (!empty($record['pdf']))
								{
									$aoldimage1 = $record['pdf'];
									$upload_path = './assets/images/about/';
									$file = $upload_path.$aoldimage1;
									if (file_exists($file))
									{
										unlink($file);
									}
								}
							}
							$data['msg'] = 'Submitted Successfully...';
							$data['status'] = 1;
						}
                    }
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
                else if ($segment2 == "about_pdf_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_about_pdf', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/about_pdf');
                }
                else if ($segment2 == "about_pdf_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_about_pdf');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/about_pdf');
                }
                else if ($segment2 == "contact_details")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['record'] = $this->Common_model->get_record('tbl_contact_us_details', '*', array('id' => 1) , 2);
                    $this->load->view($this->views_folder.'contact_details', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "contact_details_ajax")
                {
                    $id = $this->input->post('id');
                    $h1_tag = $this->input->post('h1_tag');
                    $address = $this->input->post('address');
                    $google_map = $this->input->post('google_map');
                    $h2_tag = $this->input->post('h2_tag');
                    $title = $this->input->post('title');
                    $meta_description = $this->input->post('meta_description');
                    $meta_tags = $this->input->post('meta_tags');
					
                    $update_data = array(
                        'h1_tag' => $h1_tag,
                        'address' => $address,
                        'google_map' => $google_map,
                        'h2_tag' => $h2_tag,
                        'title' => $title,
                        'meta_description' => $meta_description,
                        'meta_tags' => $meta_tags
					);
                    $result = $this->Common_model->update_record('tbl_contact_us_details', $update_data, array('id' => $id));
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
                else if ($segment2 == "contact_addresses")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_contact_addresses', '*', array('id' => $id) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_contact_addresses', '*', '', 1, array('id',
                        'desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'contact_addresses', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "contact_addresses_ajax")
                {
                    $id = $this->input->post('id');
                    $address = $this->input->post('address');
                    $google_map = $this->input->post('google_map');
                    if ($id == 0)
                    {
                        $add_data = array(
							'address' => $address,
                            'google_map' => $google_map,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_contact_addresses', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'address' => $address,
                            'google_map' => $google_map
                        );
                        $result = $this->Common_model->update_record('tbl_contact_addresses', $update_data, array('id' => $id));
                    }
                    if (!empty($result))
                    {
                        $data['msg'] = 'Submitted Successfully...';
                        $data['status'] = 1;
                    }
                    else
                    {
                        $data['msg'] = 'Data Already Exists...';
                        $data['status'] = 0;
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "contact_addresses_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_contact_addresses', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/contact_addresses');
                }
                else if ($segment2 == "contact_addresses_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_contact_addresses');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/contact_addresses');
                }
                else if ($segment2 == "contact_enquiries")
                {
					$data['records'] = $this->Common_model->get_record('tbl_contact_us_enquiries', '*', '', 1, array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'contact_enquiries', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "contact_enquiries_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_contact_us_enquiries');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/contact_enquiries');
                }
                else if ($segment2 == "pickup_places")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_pickup_places', '*', array('id' => $id) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_pickup_places', '*', '', 1, array('id',
                        'desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'pickup_places', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "ajax_pickup_places")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $state_code = $this->input->post('state_code');
                    $position = $this->input->post('position');
                    $display_type = $this->input->post('display_type');
                    if ($id == 0)
                    {
                        $add_data = array(
							'name' => $name,
							'state_code' => $state_code,
							'position' => $position,
							'display_type' => $display_type,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_pickup_places', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'name' => $name,
							'state_code' => $state_code,
							'position' => $position,
							'display_type' => $display_type
                        );
                        $result = $this->Common_model->update_record('tbl_pickup_places', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "pickup_places_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_pickup_places', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/pickup_places');
                }
                else if ($segment2 == "pickup_places_delete")
                {
                    $id = $this->input->get('id');
                    $dealers = $this->Common_model->get_record('tbl_pickup_dealers', '*', array('place_id' => $id) , 3);
					if($dealers==0){
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_pickup_places');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Updated...');
						}
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Dealers Available...');
                    }
                    redirect('admin/pickup_places');
                }
                else if ($segment2 == "pickup_dealers")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->Admin_model->get_pickup_dealers();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'pickup_dealers', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "pickup_dealers_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_pickup_dealers', '*', array('id' => $id) , 2);
                    $data['places'] = $this->Common_model->get_record('tbl_pickup_places', '*', '', 1, array('id',
                        'desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'pickup_dealers_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "pickup_dealers_ajax")
                {
                    $id = $this->input->post('id');
                    $place_id = $this->input->post('place_id');
                    $address = $this->input->post('address');
                    $image_alt = $this->input->post('image_alt');
                    $unique_code = $this->input->post('unique_code');
                    $password = $this->input->post('password');
                    $epassword = encode5t($password);
                    $description = $this->input->post('description');
                    $google_map = $this->input->post('google_map');
                    if ($id == 0)
                    {
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/dealers/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this    ->Common_model    ->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = '';
                        }
                        $add_data = array(
							'place_id' => $place_id,
							'address' => $address,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'unique_code' => $unique_code,
                            'password' => $epassword,
                            'description' => $description,
                            'google_map' => $google_map,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_pickup_dealers', $add_data);
                    }
                    else
                    {
                        $record = $this->Common_model->get_record('tbl_pickup_dealers', '*', array('id' => $id    ) , 2);
                        $oldimage1 = $record['image'];
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/dealers/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this    ->Common_model    ->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = $oldimage1;
                        }
                        $update_data = array(
							'place_id' => $place_id,
							'address' => $address,
                            'image' => $image,
                            'image_alt' => $image_alt,
                            'unique_code' => $unique_code,
                            'password' => $epassword,
                            'description' => $description,
                            'google_map' => $google_map
                        );
                        $result = $this->Common_model->update_record('tbl_pickup_dealers', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "pickup_dealers_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_pickup_dealers', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/pickup_dealers');
                }
                else if ($segment2 == "pickup_dealers_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_pickup_dealers');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/pickup_dealers');
                }
                else if ($segment2 == "users_propreitership")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$admin_data=$this->session->userdata('admin_data');
                    $user_id = 0;
                    $data['user_id'] =$user_id = $this->input->get('user_id');
                    $data['record'] =$record= $this->Common_model->get_record('tbl_propreitership_firms', '*', array('user_id' => $user_id) , 2);
					if(!empty($record) && $admin_data['role']==1){
						redirect('admin/users');
					}
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'users_propreitership', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "users_propreitership_ajax")
                {
                    $id = $this->input->post('id');
                    $user_id = $this->input->post('user_id');
                    $referral_id = $this->input->post('referral_id');
                    $name = $this->input->post('name');
                    $father_name = $this->input->post('father_name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $pan_number = $this->input->post('pan_number');
                    $trade_name = $this->input->post('trade_name');
                    $gst_no = $this->input->post('gst_no');
                    $state = $this->input->post('state');
                    $district = $this->input->post('district');
                    $post = $this->input->post('post');
                    $pincode = $this->input->post('pincode');
                    $trade_contact_number = $this->input->post('trade_contact_number');
                    $trade_phone_number = $this->input->post('trade_phone_number');
                    $trade_email = $this->input->post('trade_email');
                    $bank_account_type = $this->input->post('bank_account_type');
                    $bank_account_name = $this->input->post('bank_account_name');
                    $bank_account_number = $this->input->post('bank_account_number');
                    $bank_ifsc = $this->input->post('bank_ifsc');
                    $bank_name = $this->input->post('bank_name');
                    $bank_branch = $this->input->post('bank_branch');
                    if ($id == 0)
                    {
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = '';
						}
                        $add_data = array(
							'user_id' => $user_id,
							'referral_id' => $referral_id,
							'name' => $name,
							'father_name' => $father_name,
							'mobile' => $mobile,
							'email' => $email,
							'pan_number' => $pan_number,
							'trade_name' => $trade_name,
							'gst_no' => $gst_no,
							'state' => $state,
							'district' => $district,
							'post' => $post,
							'pincode' => $pincode,
							'trade_contact_number' => $trade_contact_number,
							'trade_phone_number' => $trade_phone_number,
							'trade_email' => $trade_email,
							'bank_account_type' => $bank_account_type,
							'bank_account_name' => $bank_account_name,
							'bank_account_number' => $bank_account_number,
							'bank_ifsc' => $bank_ifsc,
							'bank_name' => $bank_name,
							'bank_branch' => $bank_branch,
							'document' => $pdf,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
						$where="referral_id='".$referral_id."'";
						$record = $this->Common_model->get_record('tbl_investors', '*', $where,2);
						if(!empty($record))
						{
							$result = $this->Common_model->add_record('tbl_propreitership_firms', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Referral Id not exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$record = $this->Common_model->get_record('tbl_propreitership_firms', '*', array('id' => $id    ) , 2);
						$oldimage1 = $record['document'];
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = $oldimage1;
						}
                        $update_data = array(
							'referral_id' => $referral_id,
							'name' => $name,
							'father_name' => $father_name,
							'mobile' => $mobile,
							'email' => $email,
							'pan_number' => $pan_number,
							'trade_name' => $trade_name,
							'gst_no' => $gst_no,
							'state' => $state,
							'district' => $district,
							'post' => $post,
							'pincode' => $pincode,
							'trade_contact_number' => $trade_contact_number,
							'trade_phone_number' => $trade_phone_number,
							'trade_email' => $trade_email,
							'bank_account_type' => $bank_account_type,
							'bank_account_name' => $bank_account_name,
							'bank_account_number' => $bank_account_number,
							'bank_ifsc' => $bank_ifsc,
							'bank_name' => $bank_name,
							'bank_branch' => $bank_branch,
							'document' => $pdf
                        );
						$where="referral_id='".$referral_id."'";
						$record = $this->Common_model->get_record('tbl_investors', '*', $where,2);
						if(!empty($record))
						{
							$result = $this->Common_model->update_record('tbl_propreitership_firms', $update_data, array('id' => $id));
							if (!empty($result))
							{
								if ($pdf != $oldimage1)
								{
									if (!empty($record['document']))
									{
										$aoldimage1 = $record['document'];
										$upload_path = './assets/images/users/';
										$file = $upload_path.$aoldimage1;
										if (file_exists($file))
										{
											unlink($file);
										}
									}
								}
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Referral Id not exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "users_partnership")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$admin_data=$this->session->userdata('admin_data');
                    $user_id = 0;
					$data['user_id'] = $user_id = $this->input->get('user_id');
                    $data['record'] =$record= $this->Common_model->get_record('tbl_partnership_firms', '*', array('user_id' => $user_id) , 2);
					if(!empty($record) && $admin_data['role']==1){
						redirect('admin/users');
					}
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'users_partnership', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "partnership_ajax")
                {
					$key = $this->input->post('key');
					$data['key'] = $key+1;
                    $this->load->view($this->views_folder.'partnership_ajax', $data);
                }
                else if ($segment2 == "users_partnership_ajax")
                {                   
                    $id = $this->input->post('id');
                    $user_id = $this->input->post('user_id');
                    $referral_id = $this->input->post('referral_id');
                    $partner_names = $this->input->post('partner_names');
					$partner_names_final=array();
					foreach($partner_names as $key => $row){ 
					if($partner_names[$key]==''){
						$partner_names_final[]='0';
					}else{
						$partner_names_final[]=$partner_names[$key];
					}
					}
					$partner_names_final=implode("**",$partner_names_final);
                    $partner_father_names = $this->input->post('partner_father_names');
					$partner_father_names_final=array();
					foreach($partner_father_names as $key => $row){
					if($partner_father_names[$key]==''){
						$partner_father_names_final[]='0';
					}else{
						$partner_father_names_final[]=$partner_father_names[$key];
					}
					}
					$partner_father_names_final=implode("**",$partner_father_names_final);
                    $partner_mobiles = $this->input->post('partner_mobiles');
					$partner_mobiles_final=array();
					foreach($partner_mobiles as $key => $row){ 
					if($partner_mobiles[$key]==''){
						$partner_mobiles_final[]='0';
					}else{
						$partner_mobiles_final[]=$partner_mobiles[$key];
					}
					}
					$partner_mobiles_final=implode("**",$partner_mobiles_final);
                    $partner_emails = $this->input->post('partner_emails');
					$partner_emails_final=array();
					foreach($partner_emails as $key => $row){ 
					if($partner_emails[$key]==''){
						$partner_emails_final[]='0';
					}else{
						$partner_emails_final[]=$partner_emails[$key];
					}
					}
					$partner_emails_final=implode("**",$partner_emails_final);
                    $partner_pan_numbers = $this->input->post('partner_pan_numbers');
					$partner_pan_numbers_final=array();
					foreach($partner_pan_numbers as $key => $row){
					if($partner_pan_numbers[$key]==''){
						$partner_pan_numbers_final[]='0';
					}else{
						$partner_pan_numbers_final[]=$partner_pan_numbers[$key];
					}
					}
					$partner_pan_numbers_final=implode("**",$partner_pan_numbers_final);
                    $firm_name = $this->input->post('firm_name');
                    $firm_reg_number = $this->input->post('firm_reg_number');
                    $firm_pan_number = $this->input->post('firm_pan_number');
                    $firm_gst_number = $this->input->post('firm_gst_number');
                    $state = $this->input->post('state');
                    $district = $this->input->post('district');
                    $post = $this->input->post('post');
                    $pincode = $this->input->post('pincode');
                    $contact_name = $this->input->post('contact_name');
                    $contact_mobile = $this->input->post('contact_mobile');
                    $contact_email = $this->input->post('contact_email');
                    $bank_account_type = $this->input->post('bank_account_type');
                    $bank_account_name = $this->input->post('bank_account_name');
                    $bank_account_number = $this->input->post('bank_account_number');
                    $bank_ifsc = $this->input->post('bank_ifsc');
                    $bank_name = $this->input->post('bank_name');
                    $bank_branch = $this->input->post('bank_branch');
                    if ($id == 0)
                    {
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = '';
						}
                        $add_data = array(
							'user_id' => $user_id,
							'referral_id' => $referral_id,
							'partner_names' => $partner_names_final,
							'partner_father_names' => $partner_father_names_final,
							'partner_mobiles' => $partner_mobiles_final,
							'partner_emails' => $partner_emails_final,
							'partner_pan_numbers' => $partner_pan_numbers_final,
							'firm_name' => $firm_name,
							'firm_reg_number' => $firm_reg_number,
							'firm_pan_number' => $firm_pan_number,
							'firm_gst_number' => $firm_gst_number,
							'state' => $state,
							'district' => $district,
							'post' => $post,
							'pincode' => $pincode,
							'contact_name' => $contact_name,
							'contact_mobile' => $contact_mobile,
							'contact_email' => $contact_email,
							'bank_account_type' => $bank_account_type,
							'bank_account_name' => $bank_account_name,
							'bank_account_number' => $bank_account_number,
							'bank_ifsc' => $bank_ifsc,
							'bank_name' => $bank_name,
							'bank_branch' => $bank_branch,
							'document' => $pdf,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
						$where="referral_id='".$referral_id."'";
						$record = $this->Common_model->get_record('tbl_investors', '*', $where,2);
						if(!empty($record))
						{
							$result = $this->Common_model->add_record('tbl_partnership_firms', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Referral Id not exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$record = $this->Common_model->get_record('tbl_partnership_firms', '*', array('id' => $id    ) , 2);
						$oldimage1 = $record['document'];
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = $oldimage1;
						}
                        $update_data = array(
							'referral_id' => $referral_id,
							'partner_names' => $partner_names_final,
							'partner_father_names' => $partner_father_names_final,
							'partner_mobiles' => $partner_mobiles_final,
							'partner_emails' => $partner_emails_final,
							'partner_pan_numbers' => $partner_pan_numbers_final,
							'firm_name' => $firm_name,
							'firm_reg_number' => $firm_reg_number,
							'firm_pan_number' => $firm_pan_number,
							'firm_gst_number' => $firm_gst_number,
							'state' => $state,
							'district' => $district,
							'post' => $post,
							'pincode' => $pincode,
							'contact_name' => $contact_name,
							'contact_mobile' => $contact_mobile,
							'contact_email' => $contact_email,
							'bank_account_type' => $bank_account_type,
							'bank_account_name' => $bank_account_name,
							'bank_account_number' => $bank_account_number,
							'bank_ifsc' => $bank_ifsc,
							'bank_name' => $bank_name,
							'bank_branch' => $bank_branch,
							'document' => $pdf
                        );
						$where="referral_id='".$referral_id."'";
						$record = $this->Common_model->get_record('tbl_investors', '*', $where,2);
						if(!empty($record))
						{
							$result = $this->Common_model->update_record('tbl_partnership_firms', $update_data, array('id' => $id));
							if (!empty($result))
							{
								if ($pdf != $oldimage1)
								{
									if (!empty($record['document']))
									{
										$aoldimage1 = $record['document'];
										$upload_path = './assets/images/users/';
										$file = $upload_path.$aoldimage1;
										if (file_exists($file))
										{
											unlink($file);
										}
									}
								}
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Referral Id not exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "users_public_private")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$admin_data=$this->session->userdata('admin_data');
                    $user_id = 0;
                    $data['user_id'] =$user_id = $this->input->get('user_id');
                    $data['record'] =$record= $this->Common_model->get_record('tbl_public_private_firms', '*', array('user_id' => $user_id) , 2);
					if(!empty($record) && $admin_data['role']==1){
						redirect('admin/users');
					}
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'users_public_private', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "users_public_private_ajax")
                {
                    $id = $this->input->post('id');
                    $user_id = $this->input->post('user_id');
                    $referral_id = $this->input->post('referral_id');
                    $director_names = $this->input->post('director_names');
					$director_names_final=array();
					foreach($director_names as $key => $row){ 
					if($director_names[$key]==''){
						$director_names_final[]='0';
					}else{
						$director_names_final[]=$director_names[$key];
					}
					}
					$director_names_final=implode("**",$director_names_final);
                    $director_father_names = $this->input->post('director_father_names');
					$director_father_names_final=array();
					foreach($director_father_names as $key => $row){
					if($director_father_names[$key]==''){
						$director_father_names_final[]='0';
					}else{
						$director_father_names_final[]=$director_father_names[$key];
					}
					}
					$director_father_names_final=implode("**",$director_father_names_final);
                    $director_mobiles = $this->input->post('director_mobiles');
					$director_mobiles_final=array();
					foreach($director_mobiles as $key => $row){ 
					if($director_mobiles[$key]==''){
						$director_mobiles_final[]='0';
					}else{
						$director_mobiles_final[]=$director_mobiles[$key];
					}
					}
					$director_mobiles_final=implode("**",$director_mobiles_final);
                    $director_emails = $this->input->post('director_emails');
					$director_emails_final=array();
					foreach($director_emails as $key => $row){ 
					if($director_emails[$key]==''){
						$director_emails_final[]='0';
					}else{
						$director_emails_final[]=$director_emails[$key];
					}
					}
					$director_emails_final=implode("**",$director_emails_final);
                    $director_pan_numbers = $this->input->post('director_pan_numbers');
					$director_pan_numbers_final=array();
					foreach($director_pan_numbers as $key => $row){
					if($director_pan_numbers[$key]==''){
						$director_pan_numbers_final[]='0';
					}else{
						$director_pan_numbers_final[]=$director_pan_numbers[$key];
					}
					}
					$director_pan_numbers_final=implode("**",$director_pan_numbers_final);
                    $company_name = $this->input->post('company_name');
                    $company_cin = $this->input->post('company_cin');
                    $company_pan_number = $this->input->post('company_pan_number');
                    $company_gst_number = $this->input->post('company_gst_number');
                    $state = $this->input->post('state');
                    $district = $this->input->post('district');
                    $post = $this->input->post('post');
                    $pincode = $this->input->post('pincode');
                    $contact_name = $this->input->post('contact_name');
                    $contact_mobile = $this->input->post('contact_mobile');
                    $contact_email = $this->input->post('contact_email');
                    $bank_account_type = $this->input->post('bank_account_type');
                    $bank_account_name = $this->input->post('bank_account_name');
                    $bank_account_number = $this->input->post('bank_account_number');
                    $bank_ifsc = $this->input->post('bank_ifsc');
                    $bank_name = $this->input->post('bank_name');
                    $bank_branch = $this->input->post('bank_branch');
                    if ($id == 0)
                    {
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = '';
						}
                        $add_data = array(
							'user_id' => $user_id,
							'referral_id' => $referral_id,
							'director_names' => $director_names_final,
							'director_father_names' => $director_father_names_final,
							'director_mobiles' => $director_mobiles_final,
							'director_emails' => $director_emails_final,
							'director_pan_numbers' => $director_pan_numbers_final,
							'company_name' => $company_name,
							'company_cin' => $company_cin,
							'company_pan_number' => $company_pan_number,
							'company_gst_number' => $company_gst_number,
							'state' => $state,
							'district' => $district,
							'post' => $post,
							'pincode' => $pincode,
							'contact_name' => $contact_name,
							'contact_mobile' => $contact_mobile,
							'contact_email' => $contact_email,
							'bank_account_type' => $bank_account_type,
							'bank_account_name' => $bank_account_name,
							'bank_account_number' => $bank_account_number,
							'bank_ifsc' => $bank_ifsc,
							'bank_name' => $bank_name,
							'bank_branch' => $bank_branch,
							'document' => $pdf,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
						$where="referral_id='".$referral_id."'";
						$record = $this->Common_model->get_record('tbl_investors', '*', $where,2);
						if(!empty($record))
						{
							$result = $this->Common_model->add_record('tbl_public_private_firms', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Referral Id not exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$record = $this->Common_model->get_record('tbl_public_private_firms', '*', array('id' => $id    ) , 2);
						$oldimage1 = $record['document'];
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = $oldimage1;
						}
                        $update_data = array(
							'referral_id' => $referral_id,
							'director_names' => $director_names_final,
							'director_father_names' => $director_father_names_final,
							'director_mobiles' => $director_mobiles_final,
							'director_emails' => $director_emails_final,
							'director_pan_numbers' => $director_pan_numbers_final,
							'company_name' => $company_name,
							'company_cin' => $company_cin,
							'company_pan_number' => $company_pan_number,
							'company_gst_number' => $company_gst_number,
							'state' => $state,
							'district' => $district,
							'post' => $post,
							'pincode' => $pincode,
							'contact_name' => $contact_name,
							'contact_mobile' => $contact_mobile,
							'contact_email' => $contact_email,
							'bank_account_type' => $bank_account_type,
							'bank_account_name' => $bank_account_name,
							'bank_account_number' => $bank_account_number,
							'bank_ifsc' => $bank_ifsc,
							'bank_name' => $bank_name,
							'bank_branch' => $bank_branch,
							'document' => $pdf
                        );
						$where="referral_id='".$referral_id."'";
						$record = $this->Common_model->get_record('tbl_investors', '*', $where,2);
						if(!empty($record))
						{
							$result = $this->Common_model->update_record('tbl_public_private_firms', $update_data, array('id' => $id));
							if (!empty($result))
							{
								if ($pdf != $oldimage1)
								{
									if (!empty($record['document']))
									{
										$aoldimage1 = $record['document'];
										$upload_path = './assets/images/users/';
										$file = $upload_path.$aoldimage1;
										if (file_exists($file))
										{
											unlink($file);
										}
									}
								}
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Referral Id not exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "users_huf")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$admin_data=$this->session->userdata('admin_data');
                    $user_id = 0;
                    $data['user_id'] =$user_id = $this->input->get('user_id');
                    $data['record'] =$record= $this->Common_model->get_record('tbl_huf_firms', '*', array('user_id' => $user_id) , 2);
					if(!empty($record) && $admin_data['role']==1){
						redirect('admin/users');
					}
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'users_huf', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "users_huf_ajax")
                {
                    $id = $this->input->post('id');
                    $user_id = $this->input->post('user_id');
                    $referral_id = $this->input->post('referral_id');
                    $partner_names = $this->input->post('partner_names');
					$partner_names_final=array();
					foreach($partner_names as $key => $row){ 
					if($partner_names[$key]==''){
						$partner_names_final[]='0';
					}else{
						$partner_names_final[]=$partner_names[$key];
					}
					}
					$partner_names_final=implode("**",$partner_names_final);
                    $partner_father_names = $this->input->post('partner_father_names');
					$partner_father_names_final=array();
					foreach($partner_father_names as $key => $row){
					if($partner_father_names[$key]==''){
						$partner_father_names_final[]='0';
					}else{
						$partner_father_names_final[]=$partner_father_names[$key];
					}
					}
					$partner_father_names_final=implode("**",$partner_father_names_final);
                    $partner_mobiles = $this->input->post('partner_mobiles');
					$partner_mobiles_final=array();
					foreach($partner_mobiles as $key => $row){ 
					if($partner_mobiles[$key]==''){
						$partner_mobiles_final[]='0';
					}else{
						$partner_mobiles_final[]=$partner_mobiles[$key];
					}
					}
					$partner_mobiles_final=implode("**",$partner_mobiles_final);
                    $partner_emails = $this->input->post('partner_emails');
					$partner_emails_final=array();
					foreach($partner_emails as $key => $row){ 
					if($partner_emails[$key]==''){
						$partner_emails_final[]='0';
					}else{
						$partner_emails_final[]=$partner_emails[$key];
					}
					}
					$partner_emails_final=implode("**",$partner_emails_final);
                    $partner_pan_numbers = $this->input->post('partner_pan_numbers');
					$partner_pan_numbers_final=array();
					foreach($partner_pan_numbers as $key => $row){
					if($partner_pan_numbers[$key]==''){
						$partner_pan_numbers_final[]='0';
					}else{
						$partner_pan_numbers_final[]=$partner_pan_numbers[$key];
					}
					}
					$partner_pan_numbers_final=implode("**",$partner_pan_numbers_final);
                    $firm_name = $this->input->post('firm_name');
                    $firm_reg_number = $this->input->post('firm_reg_number');
                    $firm_pan_number = $this->input->post('firm_pan_number');
                    $firm_gst_number = $this->input->post('firm_gst_number');
                    $state = $this->input->post('state');
                    $district = $this->input->post('district');
                    $post = $this->input->post('post');
                    $pincode = $this->input->post('pincode');
                    $contact_name = $this->input->post('contact_name');
                    $contact_mobile = $this->input->post('contact_mobile');
                    $contact_email = $this->input->post('contact_email');
                    $bank_account_type = $this->input->post('bank_account_type');
                    $bank_account_name = $this->input->post('bank_account_name');
                    $bank_account_number = $this->input->post('bank_account_number');
                    $bank_ifsc = $this->input->post('bank_ifsc');
                    $bank_name = $this->input->post('bank_name');
                    $bank_branch = $this->input->post('bank_branch');
                    if ($id == 0)
                    {
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = '';
						}
                        $add_data = array(
							'user_id' => $user_id,
							'referral_id' => $referral_id,
							'partner_names' => $partner_names_final,
							'partner_father_names' => $partner_father_names_final,
							'partner_mobiles' => $partner_mobiles_final,
							'partner_emails' => $partner_emails_final,
							'partner_pan_numbers' => $partner_pan_numbers_final,
							'firm_name' => $firm_name,
							'firm_reg_number' => $firm_reg_number,
							'firm_pan_number' => $firm_pan_number,
							'firm_gst_number' => $firm_gst_number,
							'state' => $state,
							'district' => $district,
							'post' => $post,
							'pincode' => $pincode,
							'contact_name' => $contact_name,
							'contact_mobile' => $contact_mobile,
							'contact_email' => $contact_email,
							'bank_account_type' => $bank_account_type,
							'bank_account_name' => $bank_account_name,
							'bank_account_number' => $bank_account_number,
							'bank_ifsc' => $bank_ifsc,
							'bank_name' => $bank_name,
							'bank_branch' => $bank_branch,
							'document' => $pdf,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
						$where="referral_id='".$referral_id."'";
						$record = $this->Common_model->get_record('tbl_investors', '*', $where,2);
						if(!empty($record))
						{
							$result = $this->Common_model->add_record('tbl_huf_firms', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Referral Id not exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$record = $this->Common_model->get_record('tbl_huf_firms', '*', array('id' => $id    ) , 2);
						$oldimage1 = $record['document'];
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/users/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = $oldimage1;
						}
                        $update_data = array(
							'referral_id' => $referral_id,
							'partner_names' => $partner_names_final,
							'partner_father_names' => $partner_father_names_final,
							'partner_mobiles' => $partner_mobiles_final,
							'partner_emails' => $partner_emails_final,
							'partner_pan_numbers' => $partner_pan_numbers_final,
							'firm_name' => $firm_name,
							'firm_reg_number' => $firm_reg_number,
							'firm_pan_number' => $firm_pan_number,
							'firm_gst_number' => $firm_gst_number,
							'state' => $state,
							'district' => $district,
							'post' => $post,
							'pincode' => $pincode,
							'contact_name' => $contact_name,
							'contact_mobile' => $contact_mobile,
							'contact_email' => $contact_email,
							'bank_account_type' => $bank_account_type,
							'bank_account_name' => $bank_account_name,
							'bank_account_number' => $bank_account_number,
							'bank_ifsc' => $bank_ifsc,
							'bank_name' => $bank_name,
							'bank_branch' => $bank_branch,
							'document' => $pdf
                        );
						$where="referral_id='".$referral_id."'";
						$record = $this->Common_model->get_record('tbl_investors', '*', $where,2);
						if(!empty($record))
						{
							$result = $this->Common_model->update_record('tbl_huf_firms', $update_data, array('id' => $id));
							if (!empty($result))
							{
								if ($pdf != $oldimage1)
								{
									if (!empty($record['document']))
									{
										$aoldimage1 = $record['document'];
										$upload_path = './assets/images/users/';
										$file = $upload_path.$aoldimage1;
										if (file_exists($file))
										{
											unlink($file);
										}
									}
								}
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Referral Id not exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "admins")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$data['records'] = $this->Common_model->get_record('tbl_admins', '*', array('role'=>1), 1, array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'admins', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "admins_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_admins', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'admins_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "admins_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $email = $this->input->post('email');
                    $mobile = $this->input->post('mobile');
                    $password = $this->input->post('password');
                    $epassword = encode5t($password);
                    if ($id == 0)
                    {
                        $add_data = array(
							'name' => $name,
							'email' => $email,
							'mobile' => $mobile,
							'password' => $epassword,
                            'status' => 1,
                            'role' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
						$where="mobile='".$mobile."' OR email='".$email."'";
						$record = $this->Common_model->get_record('tbl_admins', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->add_record('tbl_admins', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Email ID or Mobile Number already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
                        $update_data = array(
							'name' => $name,
							'email' => $email,
							'mobile' => $mobile,
							'password' => $epassword
                        );
						$where="(mobile='".$mobile."' OR email='".$email."') AND id!='".$id."'";
						$record = $this->Common_model->get_record('tbl_admins', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->update_record('tbl_admins', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Email ID or Mobile Number already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "admins_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_admins', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/admins');
                }
                else if ($segment2 == "admins_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_admins');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/admins');
                }
                else if ($segment2 == "investors")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$data['records'] = $this->Common_model->get_record('tbl_investors', '*', '', 1, array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'investors', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "investors_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_investors', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'investors_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "investors_add1")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_investors', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'investors_add1', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "investors_add_ajax")
                {
					$key = $this->input->post('key');
					$data['key'] = $key+1;
                    $this->load->view($this->views_folder.'investors_add_ajax', $data);
                }
                else if ($segment2 == "investors_ajax")
                {
                    $id = $this->input->post('id');
                    $referral_id = $this->input->post('referral_id');
                    $director_names = $this->input->post('director_names');
					$director_names_final=array();
					foreach($director_names as $key => $row){ 
					if($director_names[$key]==''){
						$director_names_final[]='0';
					}else{
						$director_names_final[]=$director_names[$key];
					}
					}
					$director_names_final=implode("**",$director_names_final);
                    $director_father_names = $this->input->post('director_father_names');
					$director_father_names_final=array();
					foreach($director_father_names as $key => $row){
					if($director_father_names[$key]==''){
						$director_father_names_final[]='0';
					}else{
						$director_father_names_final[]=$director_father_names[$key];
					}
					}
					$director_father_names_final=implode("**",$director_father_names_final);
                    $director_mobiles = $this->input->post('director_mobiles');
					$director_mobiles_final=array();
					foreach($director_mobiles as $key => $row){ 
					if($director_mobiles[$key]==''){
						$director_mobiles_final[]='0';
					}else{
						$director_mobiles_final[]=$director_mobiles[$key];
					}
					}
					$director_mobiles_final=implode("**",$director_mobiles_final);
                    $director_emails = $this->input->post('director_emails');
					$director_emails_final=array();
					foreach($director_emails as $key => $row){ 
					if($director_emails[$key]==''){
						$director_emails_final[]='0';
					}else{
						$director_emails_final[]=$director_emails[$key];
					}
					}
					$director_emails_final=implode("**",$director_emails_final);
                    $director_pan_numbers = $this->input->post('director_pan_numbers');
					$director_pan_numbers_final=array();
					foreach($director_pan_numbers as $key => $row){
					if($director_pan_numbers[$key]==''){
						$director_pan_numbers_final[]='0';
					}else{
						$director_pan_numbers_final[]=$director_pan_numbers[$key];
					}
					}
					$director_pan_numbers_final=implode("**",$director_pan_numbers_final);
                    $company_name = $this->input->post('company_name');
                    $company_cin = $this->input->post('company_cin');
                    $company_pan_number = $this->input->post('company_pan_number');
                    $company_gst_number = $this->input->post('company_gst_number');
                    $state = $this->input->post('state');
                    $district = $this->input->post('district');
                    $post = $this->input->post('post');
                    $pincode = $this->input->post('pincode');
                    $contact_name = $this->input->post('contact_name');
                    $contact_mobile = $this->input->post('contact_mobile');
                    $contact_email = $this->input->post('contact_email');
                    $bank_account_type = $this->input->post('bank_account_type');
                    $bank_account_name = $this->input->post('bank_account_name');
                    $bank_account_number = $this->input->post('bank_account_number');
                    $bank_ifsc = $this->input->post('bank_ifsc');
                    $bank_name = $this->input->post('bank_name');
                    $bank_branch = $this->input->post('bank_branch');
                    if ($id == 0)
                    {
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/investors/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = '';
						}
                        $add_data = array(
							'referral_id' => $referral_id,
							'director_names' => $director_names_final,
							'director_father_names' => $director_father_names_final,
							'director_mobiles' => $director_mobiles_final,
							'director_emails' => $director_emails_final,
							'director_pan_numbers' => $director_pan_numbers_final,
							'company_name' => $company_name,
							'company_cin' => $company_cin,
							'company_pan_number' => $company_pan_number,
							'company_gst_number' => $company_gst_number,
							'state' => $state,
							'district' => $district,
							'post' => $post,
							'pincode' => $pincode,
							'contact_name' => $contact_name,
							'contact_mobile' => $contact_mobile,
							'contact_email' => $contact_email,
							'bank_account_type' => $bank_account_type,
							'bank_account_name' => $bank_account_name,
							'bank_account_number' => $bank_account_number,
							'bank_ifsc' => $bank_ifsc,
							'bank_name' => $bank_name,
							'bank_branch' => $bank_branch,
							'document' => $pdf,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
						$where="referral_id='".$referral_id."'";
						$record = $this->Common_model->get_record('tbl_investors', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->add_record('tbl_investors', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Referral Id already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$record = $this->Common_model->get_record('tbl_investors', '*', array('id' => $id    ) , 2);
						$oldimage1 = $record['document'];
						if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
						{
							$path = './assets/images/investors/';
							$name1 = "pdf";
							$width = "";
							$height = "";
							$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
							$pdf = $Img1;
						}
						else
						{
							$pdf = $oldimage1;
						}
                        $update_data = array(
							'referral_id' => $referral_id,
							'director_names' => $director_names_final,
							'director_father_names' => $director_father_names_final,
							'director_mobiles' => $director_mobiles_final,
							'director_emails' => $director_emails_final,
							'director_pan_numbers' => $director_pan_numbers_final,
							'company_name' => $company_name,
							'company_cin' => $company_cin,
							'company_pan_number' => $company_pan_number,
							'company_gst_number' => $company_gst_number,
							'state' => $state,
							'district' => $district,
							'post' => $post,
							'pincode' => $pincode,
							'contact_name' => $contact_name,
							'contact_mobile' => $contact_mobile,
							'contact_email' => $contact_email,
							'bank_account_type' => $bank_account_type,
							'bank_account_name' => $bank_account_name,
							'bank_account_number' => $bank_account_number,
							'bank_ifsc' => $bank_ifsc,
							'bank_name' => $bank_name,
							'bank_branch' => $bank_branch,
							'document' => $pdf
                        );
						$where="referral_id='".$referral_id."' AND id!='".$id."'";
						$record = $this->Common_model->get_record('tbl_investors', '*', $where,2);
						if(empty($record))
						{
							$result = $this->Common_model->update_record('tbl_investors', $update_data, array('id' => $id));
							if (!empty($result))
							{
								if ($pdf != $oldimage1)
								{
									if (!empty($record['document']))
									{
										$aoldimage1 = $record['document'];
										$upload_path = './assets/images/investors/';
										$file = $upload_path.$aoldimage1;
										if (file_exists($file))
										{
											unlink($file);
										}
									}
								}
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Referral Id already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "investors_status")
                {
                    $id = $this->input->get('id');
					$where="id='".$id."'";
					$record = $this->Common_model->get_record('tbl_investors', 'referral_id', $where,2);
					$records = $this->Common_model->get_record('tbl_users', '*',array('referral_id'=>$record['referral_id']),3);
					if($records==0){
						$status = $this->input->get('status');
						$update_data = array('status' => $status);
						$result = $this->Common_model->update_record('tbl_investors', $update_data, array('id' => $id));
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Status Updated Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Updated...');
						}
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Users available with this investor...');
                    }
                    redirect('admin/investors');
                }
                else if ($segment2 == "investors_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_investors');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/investors');
                }
                else if ($segment2 == "booking_desk")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['record'] = $this->Common_model->get_record('tbl_booking_desk', '*', array('id' => 1) , 2);
                    $this->load->view($this->views_folder.'booking_desk', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "booking_desk_ajax")
                {
                    $id = $this->input->post('id');
                    $h1_tag = $this->input->post('h1_tag');
                    $h2_tag = $this->input->post('h2_tag');
                    $h2_tag2 = $this->input->post('h2_tag2');
                    $title = $this->input->post('title');
                    $meta_description = $this->input->post('meta_description');
                    $meta_tags = $this->input->post('meta_tags');
					$record = $this->Common_model->get_record('tbl_booking_desk', '*', array('id' => $id    ) , 2);
					$oldimage1 = $record['pdf'];
					if (isset($_FILES['pdf']['name']) && !empty($_FILES["pdf"]["name"]))
					{
						$path = './assets/images/booking/';
						$name1 = "pdf";
						$width = "";
						$height = "";
						$Img1 = $this    ->Common_model    ->uploadPdf($path, $name1, $width, $height);
						$pdf = $Img1;
					}
					else
					{
						$pdf = $oldimage1;
					}
					
                    $update_data = array(
                        'h1_tag' => $h1_tag,
                        'h2_tag' => $h2_tag,
                        'h2_tag2' => $h2_tag2,
                        'pdf' => $pdf,
                        'title' => $title,
                        'meta_description' => $meta_description,
                        'meta_tags' => $meta_tags
					);
                    $result = $this->Common_model->update_record('tbl_booking_desk', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
						if ($pdf != $oldimage1)
						{
							if (!empty($record['pdf']))
							{
								$aoldimage1 = $record['pdf'];
								$upload_path = './assets/images/booking/';
								$file = $upload_path.$aoldimage1;
								if (file_exists($file))
								{
									unlink($file);
								}
							}
						}
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
                else if ($segment2 == "bookings")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->Common_model->get_record('tbl_bookings', '*', '' , 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'bookings', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "bookings_view")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_bookings', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'bookings_view', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "bookings_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_bookings', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'bookings_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "bookings_ajax")
                {
                    $id = $this->input->post('id');
                    $record = $this->Common_model->get_record('tbl_bookings', '*', array('id' => $id) , 2);
					$total_amount=$record['total_amount'];
                    $commission_percentage = $this->input->post('commission_percentage');
					$commission_amount=($total_amount*$commission_percentage)/100;
                    $remarks = $this->input->post('remarks');
                    $status = $this->input->post('status');
					$update_data = array(
						'commission_percentage' => $commission_percentage,
						'commission_amount' => $commission_amount,
						'remarks' => $remarks,
						'status' => $status
					);
					$result = $this->Common_model->update_record('tbl_bookings', $update_data, array('id' => $id));
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
                else if ($segment2 == "bookings_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_bookings', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/bookings');
                }
                else if ($segment2 == "bookings_delete")
                {
                    $id = $this->input->get('id');
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_bookings');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/bookings');
                }
                else if ($segment2 == "cms_pages")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
					$data['records'] = $this->Common_model->get_record('tbl_cms_pages', '*', '', 1, array('id','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'cms_pages', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "cms_pages_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_cms_pages', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'cms_pages_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "cms_pages_ajax")
                {
                    $id = $this->input->post('id');
                    $h1_tag = $this->input->post('h1_tag');
                    $description = $this->input->post('description');
                    $title = $this->input->post('title');
                    $meta_description = $this->input->post('meta_description');
                    $meta_tags = $this->input->post('meta_tags');
                    if ($id == 0)
                    {
                        $add_data = array(
							'h1_tag' => $h1_tag,
							'description' => $description,
							'title' => $title,
							'meta_description' => $meta_description,
							'meta_tags' => $meta_tags
                        );
						$result = $this->Common_model->add_record('tbl_cms_pages', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'h1_tag' => $h1_tag,
							'description' => $description,
							'title' => $title,
							'meta_description' => $meta_description,
							'meta_tags' => $meta_tags
                        );
						$result = $this->Common_model->update_record('tbl_cms_pages', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "management_content")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['record'] = $this->Common_model->get_record('tbl_management_content', '*', array('id' => 1) , 2);
                    $this->load->view($this->views_folder.'management_content', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "management_content_ajax")
                {
                    $id = $this->input->post('id');
                    $image_alt = $this->input->post('image_alt');       
                    $h1_tag = $this->input->post('h1_tag');    
                    $description = $this->input->post('description');    
                    $title = $this->input->post('title');    
                    $meta_description = $this->input->post('meta_description');    
                    $meta_tags = $this->input->post('meta_tags');    
					
					$record = $this->Common_model->get_record('tbl_management_content', '*', array('id' => $id    ) , 2);
					$oldimage1 = $record['image'];
					if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
					{
						$path = './assets/images/management/';
						$name1 = "image";
						$width = "";
						$height = "";
						$Img1 = $this    ->Common_model    ->uploadImage($path, $name1, $width, $height);
						$image = $Img1;
					}
					else
					{
						$image = $oldimage1;
					}
                    $update_data = array(
                        'image' => $image,
                        'image_alt' => $image_alt,	
                        'h1_tag' => $h1_tag,				
                        'description' => $description,				
                        'title' => $title,				
                        'meta_description' => $meta_description,				
                        'meta_tags' => $meta_tags
					);
                    $result = $this->Common_model->update_record('tbl_management_content', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
						if ($image != $oldimage1)
						{
							if (!empty($record['image']))
							{
								$aoldimage1 = $record['image'];
								$upload_path = './assets/images/management/';
								$file = $upload_path.$aoldimage1;
								if (file_exists($file))
								{
									unlink($file);
								}
							}
						}
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
                else if ($segment2 == "management_categories")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->Common_model->get_record('tbl_management_categories', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'management_categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "management_categories_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_management_categories', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'management_categories_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "management_categories_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $position = $this->input->post('position');
                    $description = $this->input->post('description');
                    $display_count = $this->input->post('display_count');
                    if ($id == 0)
                    {
                        $add_data = array(
							'name' => $name,
							'position' => $position,
                            'description' => $description,
                            'display_count' => $display_count,
                            'status' => 1
                        );
                        $result = $this->Common_model->add_record('tbl_management_categories', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'name' => $name,
							'position' => $position,
                            'description' => $description,
                            'display_count' => $display_count,
                        );
                        $result = $this->Common_model->update_record('tbl_management_categories', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "management_categories_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_management_categories', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/management_categories');
                }
                else if ($segment2 == "management_categories_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_management_employees', '*', array('category_id' => $id) , 3);
					if($record>0){						
                        $this->session->set_flashdata('error', 'Employees available with this management_categories delete products and try again...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_management_categories');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Deleted...');
						}
                    }
                    redirect('admin/management_categories');
                }
                else if ($segment2 == "management_employees")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->db->query("Select t1.*,t2.name as category_name from tbl_management_employees t1 left join tbl_management_categories t2 on t1.category_id=t2.id order by t1.id desc")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'management_employees', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "management_employees_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_management_employees', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_management_categories', '*', '', 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'management_employees_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "management_employees_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $image_alt = $this->input->post('image_alt');
                    $name = $this->input->post('name');
                    $designation = $this->input->post('designation');
                    if ($id == 0)
                    {
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/management/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = '';
                        }
                        $add_data = array(
							'category_id' => $category_id,
                            'image' => $image,
                            'image_alt' => $image_alt,
							'name' => $name,
                            'designation' => $designation,
                            'status' => 1
                        );
                        $result = $this->Common_model->add_record('tbl_management_employees', $add_data);
                    }
                    else
                    {
                        $record = $this->Common_model->get_record('tbl_management_employees', '*', array('id' => $id    ) , 2);
                        $oldimage = $record['image'];
                        if (isset($_FILES['image']['name']) && !empty($_FILES["image"]["name"]))
                        {
                            $path = './assets/images/management/';
                            $name1 = "image";
                            $width = "";
                            $height = "";
                            $Img1 = $this->Common_model->uploadImage($path, $name1, $width, $height);
                            $image = $Img1;
                        }
                        else
                        {
                            $image = $oldimage;
                        }
                        $update_data = array(
							'category_id' => $category_id,
                            'image' => $image,
                            'image_alt' => $image_alt,
							'name' => $name,
                            'designation' => $designation
                        );
                        $result = $this->Common_model->update_record('tbl_management_employees', $update_data, array('id' => $id));
                        if (!empty($result))
                        {
                            if ($image != $oldimage)
                            {
                                if (!empty($record['image']))
                                {
                                    $aoldimage1 = $record['image'];
                                    $upload_path = './assets/images/management/';
                                    $file = $upload_path.$aoldimage1;
                                    if (file_exists($file))
                                    {
                                        unlink($file);
                                    }
                                }
                            }
                        }
                    }
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
                else if ($segment2 == "management_employees_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_management_employees', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/management_employees');
                }
                else if ($segment2 == "management_employees_delete")
                {
                    $id = $this->input->get('id');
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_management_employees');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Deleted...');
					}
                    redirect('admin/management_employees');
                }
                else if ($segment2 == "vi_pro")
                {
                    $data['records'] = $this->Common_model->get_record('tbl_vi_pro', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'vi_pro', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "vi_pro_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_vi_pro', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'vi_pro_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "vi_pro_ajax")
                {
                    $id = $this->input->post('id');
                    $unique_code = $this->input->post('unique_code');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $aadhaar_number = $this->input->post('aadhaar_number');
                    $pan_number = $this->input->post('pan_number');
                    $date = $this->input->post('date');
					$date_final=date("Y-m-d",strtotime($date));
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_vi_pro', '*', array('unique_code' => $unique_code) , 3);
						$check1 = $this->Common_model->get_record('tbl_vi_super', '*', array('unique_code' => $unique_code) , 3);
						if($check==0 && $check1==0){
							$add_data = array(
								'unique_code' => $unique_code,
								'password' => $password,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'aadhaar_number' => $aadhaar_number,
								'pan_number' => $pan_number,
								'date' => $date_final,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_vi_pro', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Unique code already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_vi_pro', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						$check1 = $this->Common_model->get_record('tbl_vi_super', '*', array('unique_code' => $unique_code) , 3);
						if($check==0 && $check1==0){
							$update_data = array(
								'unique_code' => $unique_code,
								'password' => $password,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'aadhaar_number' => $aadhaar_number,
								'pan_number' => $pan_number,
								'date' => $date_final
							);
							$result = $this->Common_model->update_record('tbl_vi_pro', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Unique code already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "vi_pro_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_vi_pro', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/vi_pro');
                }
                else if ($segment2 == "vi_pro_delete")
                {
                    $id = $this->input->get('id');
                    $promoters = $this->Common_model->get_record('tbl_vi_super', '*', array('employee_id' => $id) , 3);
					if($promoters>0){
						$this->session->set_flashdata('error', 'Promoters Available...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_vi_pro');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Updated...');
						}
                    }
                    redirect('admin/vi_pro');
                }
                else if ($segment2 == "vi_pro_payments")
                {
                    $pro_id = $this->input->get('pro_id');
					$data['pro_id']=$pro_id;
                    $data['pro']=$pro = $this->Common_model->get_record('tbl_vi_pro', '*', array('id'=>$pro_id),2);
					$where="employee_id=".$pro_id." AND date>='".$pro['date']."'";
                    $data['records'] = $this->Admin_model->get_pro_payments($where,$pro['date']);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'vi_pro_payments', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "vi_super")
                {
                    $employee_id = 0;
					if(!empty($_GET)){
                    $employee_id = $this->input->get('id');
					}
					$data['employee_id']=$employee_id;
                    /*$data['records'] = $this->Common_model->get_vi_super();*/
                    $data['records'] = $this->Common_model->get_record('tbl_vi_super', '*', array('employee_id' => $employee_id) , 1,array('id','desc'));
                    $data['employees'] = $this->Common_model->get_record('tbl_vi_pro', '*', array('status'=>1), 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'vi_super', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "vi_super_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_vi_super', '*', array('id' => $id) , 2);
                    $data['employees'] = $this->Common_model->get_record('tbl_vi_pro', '*', array('status'=>1), 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'vi_super_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "vi_super_ajax")
                {
                    $id = $this->input->post('id');
                    $employee_id = $this->input->post('employee_id');
                    $unique_code = $this->input->post('unique_code');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $aadhaar_number = $this->input->post('aadhaar_number');
                    $pan_number = $this->input->post('pan_number');
                    $amount = $this->input->post('amount');
                    $date = $this->input->post('date');
					$date_final=date("Y-m-d",strtotime($date));
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_vi_super', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'password' => $password,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'aadhaar_number' => $aadhaar_number,
								'pan_number' => $pan_number,
								'amount' => $amount,
								'date' => $date_final,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_vi_super', $add_data);
							if (!empty($result))
							{
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
								$data['employee_id'] = $employee_id;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
						/*if (!empty($result))
						{		
							$ukey=$result;
							if($result<10){
								$ukey='0'.$result;
							}
							$unique_code='Ahnp'.$ukey;
							$update_data = array(
								'unique_code' => $unique_code
							);
							$result = $this->Common_model->update_record('vi_super', $update_data, array('id' => $result));
						}*/
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_vi_super', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'password' => $password,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'aadhaar_number' => $aadhaar_number,
								'pan_number' => $pan_number,
								'amount' => $amount,
								'date' => $date_final
							);
							$result = $this->Common_model->update_record('tbl_vi_super', $update_data, array('id' => $id));
							if (!empty($result))
							{
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
								$data['employee_id'] = $employee_id;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "vi_super_status")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_vi_super', '*', array('id' => $id) , 2);
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_vi_super', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/vi_super?id='.$record['employee_id']);
                }
                else if ($segment2 == "vi_super_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_vi_super', '*', array('id' => $id) , 2);
                    $this->db->where('id', $id);
                    $result = $this->db->delete('tbl_vi_super');
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Deleted Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/vi_super?id='.$record['employee_id']);
                }
                else if ($segment2 == "vi_super_payments")
                {
                    $super_id = $this->input->get('super_id');
					$data['super_id']=$super_id;
                    $data['super']=$super = $this->Common_model->get_record('tbl_vi_super', '*', array('id'=>$super_id),2);
					$where="super_id=".$super_id." AND date>='".$super['date']."'";
                    $data['records'] = $this->Admin_model->get_super_payments($where,$super['date']);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'vi_super_payments', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "vi_super_payments_add")
                {
                    $id = 0;
                    $super_id = $this->input->get('super_id');
                    $id = $this->input->get('id');
                    $data['super'] = $this->Common_model->get_record('tbl_vi_super', '*', array('id'=>$super_id),2);
                    $data['record']=$record = $this->Common_model->get_record('tbl_vi_super_payments', '*', array('id' => $id) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_vi_super_payments', '*', array('super_id'=>$super_id,'heading'=>$record['heading']), 1, array('id','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'vi_super_payments_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "vi_super_payments_ajax")
                {
                    $employee_id = $this->input->post('employee_id');
                    $super_id = $this->input->post('super_id');
                    $heading = $this->input->post('heading');
                    $date = $this->input->post('date');
                    $fixed_amount = $this->input->post('fixed_amount');
                    $rate_per_gram = $this->input->post('rate_per_gram');
                    $total_grams = $this->input->post('total_grams');
                    $commission = $this->input->post('commission');
                    $amount = $this->input->post('amount');
                    $super_amount = $this->input->post('super_amount');
                    $pro_amount = $this->input->post('pro_amount');
					$created_date_time=date("Y-m-d H:i:s");
					
                    $this->db->where('super_id', $super_id);
                    $this->db->where('heading', $heading);
                    $result = $this->db->delete('tbl_vi_super_payments');
                    foreach($fixed_amount as $key=>$row){
						$add_data = array(
							'employee_id' => $employee_id,
							'super_id' => $super_id,
							'heading' => $heading,
							'date' => $date[$key],
							'fixed_amount' => $fixed_amount[$key],
							'rate_per_gram' => $rate_per_gram[$key],
							'total_grams' => $total_grams[$key],
							'commission' => $commission[$key],
							'amount' => $amount[$key],
							'super_amount' => $super_amount[$key],
							'pro_amount' => $pro_amount[$key],
							'created_date_time' => $created_date_time
						);
						$result = $this->Common_model->add_record('tbl_vi_super_payments', $add_data);
					}
					$data['msg'] = 'Submitted Successfully...';
					$data['status'] = 1;
                    echo json_encode($data);
                }
                else if ($segment2 == "vi_payments_details")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $data['record'] = $this->Common_model->get_record('tbl_vi_payments_details', '*', array('id' => 1) , 2);
                    $this->load->view($this->views_folder.'vi_payments_details', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "vi_payments_details_ajax")
                {
                    $id = $this->input->post('id');
                    $fixed_amount = $this->input->post('fixed_amount');
                    $pro_percentage = $this->input->post('pro_percentage');
                    $super_percentage = $this->input->post('super_percentage');
					
                    $update_data = array(
                        'fixed_amount' => $fixed_amount,
                        'pro_percentage' => $pro_percentage,
                        'super_percentage' => $super_percentage
					);
                    $result = $this->Common_model->update_record('tbl_vi_payments_details', $update_data, array('id' => $id));
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
                else if ($segment2 == "vi_payments")
                {
					$where="id!=0";
                    $data['records'] = $this->Admin_model->get_vi_payments($where);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'vi_payments', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "vi_payments_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['super'] = $this->Common_model->get_record('tbl_vi_payments_details', '*', array('id'=>1),2);
                    $data['record']=$record = $this->Common_model->get_record('tbl_vi_payments', '*', array('id' => $id) , 2);
                    $data['records'] = $this->Common_model->get_record('tbl_vi_payments', '*', array('heading'=>$record['heading']), 1, array('id','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'vi_payments_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "vi_payments_ajax")
                {
                    $edit = $this->input->post('edit');
                    $pro_percentage = $this->input->post('pro_percentage');
                    $super_percentage = $this->input->post('super_percentage');
                    $heading = $this->input->post('heading');
                    $date = $this->input->post('date');
                    $fixed_amount = $this->input->post('fixed_amount');
                    $rate_per_gram = $this->input->post('rate_per_gram');
                    $total_grams = $this->input->post('total_grams');
                    $commission = $this->input->post('commission');
                    $amount = $this->input->post('amount');
                    $super_amount = $this->input->post('super_amount');
                    $pro_amount = $this->input->post('pro_amount');
					$created_date_time=date("Y-m-d H:i:s");
				
					$check = $this->Common_model->get_record('tbl_vi_payments', '*', array('heading' => $heading) , 3);
					if($check>0 && $edit==0){
						$data['msg'] = 'Heading Already Exists...';
						$data['status'] = 0;						
					}else{
						$super_records = $this->Common_model->get_record('tbl_vi_super', '*', '', 1, array('id','asc'));
						if(!empty($super_records)){
						foreach($super_records as $skey=>$srow){
							$employee_id=$srow['employee_id'];
							$super_id=$srow['id'];	
							$s_amount=$srow['amount'];						
							$precords = $this->Common_model->get_record('tbl_vi_super_payments', '*', array('super_id'=>$super_id,'heading'=>$heading), 1, array('id','asc'));
							if(empty($precords)){								
								for($i=0;$i<20;$i++){ 
									$add_data = array(
										'employee_id' => $employee_id,
										'super_id' => $super_id,
										'heading' => $heading,
										'fixed_amount' => $s_amount,
										'created_date_time' => $created_date_time
									);
									$result = $this->Common_model->add_record('tbl_vi_super_payments', $add_data);
								}								
							}
						}}
															
						$this->db->where('heading', $heading);
						$result = $this->db->delete('tbl_vi_payments');
						if(!empty($fixed_amount)){
						foreach($fixed_amount as $key=>$row){
							$add_data = array(
								'heading' => $heading,
								'date' => $date[$key],
								'fixed_amount' => $fixed_amount[$key],
								'rate_per_gram' => $rate_per_gram[$key],
								'total_grams' => $total_grams[$key],
								'commission' => $commission[$key],
								'amount' => $amount[$key],
								'super_amount' => $super_amount[$key],
								'pro_amount' => $pro_amount[$key],
								'created_date_time' => $created_date_time
							);
							$result = $this->Common_model->add_record('tbl_vi_payments', $add_data);
							
							$super_records = $this->Common_model->get_record('tbl_vi_super', '*', '', 1, array('id','asc'));
							
							if(!empty($super_records)){
							foreach($super_records as $skey=>$srow){
								$super_id=$srow['id'];	
								$s_amount=$srow['amount'];						
								$precords = $this->Common_model->get_record('tbl_vi_super_payments', '*', array('super_id'=>$super_id,'heading'=>$heading), 1, array('id','asc'));
								if(!empty($precords)){
								foreach($precords as $pkey=>$prow){
									if($pkey==$key && !empty($rate_per_gram[$key])){
										if(empty($prow['rate_per_gram'])){	
											$p_fixed_amount=$s_amount;
										}else{	
											$p_fixed_amount=$prow['fixed_amount'];
										}
										$p_rate_per_gram=$rate_per_gram[$key];
										$p_total_grams=round($p_fixed_amount/$p_rate_per_gram);
										$p_amount=$p_total_grams*$commission[$key];
										$p_super_amount=round(($p_amount/10)*$super_percentage);
										$p_pro_amount=round(($p_amount/10)*$pro_percentage);
										$update_data = array(
											'date' => $date[$key],
											'fixed_amount' => $p_fixed_amount,
											'rate_per_gram' => $p_rate_per_gram,
											'total_grams' => $p_total_grams,
											'commission' => $commission[$key],
											'amount' => $p_amount,
											'super_amount' => $p_super_amount,
											'pro_amount' => $p_pro_amount,
											'created_date_time' => $created_date_time
										);
										$result = $this->Common_model->update_record('tbl_vi_super_payments', $update_data, array('id' => $prow['id']));
									}
								}}							
							}}
							
						}}
						$data['msg'] = 'Submitted Successfully...';
						$data['status'] = 1;
					}
                    echo json_encode($data);
                }
                else if ($segment2 == "visave_categories")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->Common_model->get_record('tbl_visave_categories', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_categories_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_visave_categories', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_categories_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_categories_ajax")
                {
                    $id = $this->input->post('id');
                    $category_name = $this->input->post('category_name');
                    $amount = $this->input->post('amount');
                    $penalty_per_day = $this->input->post('penalty_per_day');
                    if ($id == 0)
                    {
                        $add_data = array(
							'category_name' => $category_name,
                            'amount' => $amount,
                            'penalty_per_day' => $penalty_per_day,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_visave_categories', $add_data);
                    }
                    else
                    {
                        $update_data = array(
							'category_name' => $category_name,
							'amount' => $amount,
                            'penalty_per_day' => $penalty_per_day
                        );
                        $result = $this->Common_model->update_record('tbl_visave_categories', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "visave_categories_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_visave_categories', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/visave_categories');
                }
                else if ($segment2 == "visave_categories_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_visave_sub_categories', '*', array('category_id' => $id) , 3);
					if($record>0){						
                        $this->session->set_flashdata('error', 'Sub Categories available with this category delete sub categories and try again...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_visave_categories');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Deleted...');
						}
                    }
                    redirect('admin/visave_categories');
                }
                else if ($segment2 == "visave_sub_categories")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $data['records'] = $this->db->query("Select t1.*,t2.category_name from tbl_visave_sub_categories t1 left join tbl_visave_categories t2 on t1.category_id=t2.id order by t1.id DESC")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_sub_categories', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_sub_categories_add")
                {
                    if (empty($this->session->userdata('admin_data')))
                    {
                        redirect('admin');
                    }
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_visave_sub_categories', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_visave_categories', '*', '', 1,array('category_name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_sub_categories_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_sub_categories_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $sub_category_name = $this->input->post('sub_category_name');
                    if ($id == 0)
                    {
                        $add_data = array(
                            'category_id' => $category_id,
							'sub_category_name' => $sub_category_name,
                            'status' => 1,
                            'created_date_time' => date("Y-m-d H:i:s")
                        );
                        $result = $this->Common_model->add_record('tbl_visave_sub_categories', $add_data);
                    }
                    else
                    {
                        $update_data = array(
                            'category_id' => $category_id,
							'sub_category_name' => $sub_category_name
                        );
                        $result = $this->Common_model->update_record('tbl_visave_sub_categories', $update_data, array('id' => $id));
                    }
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
                else if ($segment2 == "visave_sub_categories_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_visave_sub_categories', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/visave_sub_categories');
                }
                else if ($segment2 == "visave_sub_categories_delete")
                {
                    $id = $this->input->get('id');
                    $record = $this->Common_model->get_record('tbl_visave_users', '*', array('sub_category_id' => $id) , 3);
					if($record>0){						
                        $this->session->set_flashdata('error', 'Users available with this sub category delete users and try again...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_visave_sub_categories');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Deleted...');
						}
                    }
                    redirect('admin/visave_sub_categories');
                }
                else if ($segment2 == "visave_employees")
                {
                    $data['records'] = $this->Common_model->get_record('tbl_visave_employees', '*', '', 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_employees', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_employees_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_visave_employees', '*', array('id' => $id) , 2);
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_employees_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_employees_ajax")
                {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $company_name = $this->input->post('company_name');
                    $gst = $this->input->post('gst');
                    $address = $this->input->post('address');
                    $pan_number = $this->input->post('pan_number');
                    $bank_name = $this->input->post('bank_name');
                    $account_number = $this->input->post('account_number');
                    $ifsc = $this->input->post('ifsc');
                    $branch = $this->input->post('branch');
                    $unique_code = $this->input->post('unique_code');
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_visave_employees', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_visave_employees', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_visave_employees', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch
							);
							$result = $this->Common_model->update_record('tbl_visave_employees', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Unique Code already exists...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "visave_employees_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_visave_employees', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/visave_employees');
                }
                else if ($segment2 == "visave_employees_delete")
                {
                    $id = $this->input->get('id');
                    $promoters = $this->Common_model->get_record('tbl_minted_promoters', '*', array('employee_id' => $id) , 3);
					if($promoters>0){
						$this->session->set_flashdata('error', 'Promoters Available...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_visave_employees');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Updated...');
						}
                    }
                    redirect('admin/visave_employees');
                }
                else if ($segment2 == "visave_promoters")
                {
                    $data['employees'] = $this->Common_model->get_record('tbl_visave_employees', '*', '', 1, array('name','asc'));
					$data['employee_id'] = $employee_id = $this->input->get('id');
					$where='';
					if(!empty($employee_id)){
						$where='employee_id='.$employee_id.'';
					}
                    $data['records'] = $this->Common_model->get_record('tbl_visave_promoters', '*', $where , 1,array('id','desc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_promoters', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_promoters_add")
                {
                    $id = 0;
                    $id = $this->input->get('id');
                    $data['record'] = $this->Common_model->get_record('tbl_visave_promoters', '*', array('id' => $id) , 2);
                    $data['employees'] = $this->Common_model->get_record('tbl_visave_employees', '*', '', 1, array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_promoters_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_promoters_ajax")
                {
                    $id = $this->input->post('id');
                    $employee_id = $this->input->post('employee_id');
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
                    $company_name = $this->input->post('company_name');
                    $gst = $this->input->post('gst');
                    $address = $this->input->post('address');
                    $pan_number = $this->input->post('pan_number');
                    $bank_name = $this->input->post('bank_name');
                    $account_number = $this->input->post('account_number');
                    $ifsc = $this->input->post('ifsc');
                    $branch = $this->input->post('branch');
                    $unique_code = $this->input->post('unique_code');
                    $commission = $this->input->post('commission');
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_visave_promoters', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch,
								'commission' => $commission,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_visave_promoters', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_visave_promoters', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'employee_id' => $employee_id,
								'unique_code' => $unique_code,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'password' => $password,
								'company_name' => $company_name,
								'gst' => $gst,
								'address' => $address,
								'pan_number' => $pan_number,
								'bank_name' => $bank_name,
								'account_number' => $account_number,
								'ifsc' => $ifsc,
								'branch' => $branch,
								'commission' => $commission
							);
							$result = $this->Common_model->update_record('tbl_visave_promoters', $update_data, array('id' => $id));
							if (!empty($result))
							{
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
								$data['employee_id'] = $employee_id;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "visave_promoters_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_visave_promoters', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/visave_promoters');
                }
                else if ($segment2 == "visave_promoters_delete")
                {
                    $id = $this->input->get('id');					
                    $record = $this->Common_model->get_record('tbl_visave_users', '*', array('promoter_id' => $id) , 3);
					if($record>0){						
                        $this->session->set_flashdata('error', 'Users available with this promoter delete users and try again...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_visave_promoters');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Deleted...');
						}
                    }
                    redirect('admin/visave_promoters');
                }
                else if ($segment2 == "visave_users")
                {
                    $data['records'] = $this->db->query("Select t1.*,t2.category_name,t3.sub_category_name,t4.name as promoter_name from tbl_visave_users t1 left join tbl_visave_categories t2 on t1.category_id=t2.id left join tbl_visave_sub_categories t3 on t1.sub_category_id=t3.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id order by t1.id DESC")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_users', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_user_payments")
                {								
                    $id = $this->input->get('id');
                    $data['record'] = $this->db->query("Select t1.*,t2.category_name,t3.sub_category_name,t4.name as promoter_name from tbl_visave_users t1 left join tbl_visave_categories t2 on t1.category_id=t2.id left join tbl_visave_sub_categories t3 on t1.sub_category_id=t3.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id where t1.id=".$id."")->row_array();
                    $data['payments'] = $this->Common_model->get_record('tbl_visave_user_payments', '*', array('user_id'=>$id), 1,array('id','asc'));
                    $data['bonus'] = $this->Common_model->get_record('tbl_visave_user_bonus', '*', array('user_id'=>$id), 1,array('id','asc'));
                    $data['penalties'] = $this->Common_model->get_record('tbl_visave_user_penalties', '*', array('user_id'=>$id), 1,array('id','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_user_payments', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_user_bonus_add")
                {
                    $data['user_id']=$user_id = $this->input->get('id');
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_user_bonus_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_user_bonus_ajax")
                {
                    $id = $this->input->post('id');
                    $user_id = $this->input->post('user_id');
                    $payment_date = date("Y-m-d",strtotime($_POST['payment_date']));
                    $amount = $this->input->post('amount');
					$payment_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$add_data = array(
							'user_id' => $user_id,
							'payment_date' => $payment_date,
							'amount' => $amount,
							'payment_date_time' => $payment_date_time
						);
						$result = $this->Common_model->add_record('tbl_visave_user_bonus', $add_data);
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
                    }
                    else
                    {
						$update_data = array(
							'payment_date' => $payment_date,
							'amount' => $amount,
						);
						$result = $this->Common_model->update_record('tbl_visave_user_bonus', $update_data, array('id' => $id));
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
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "visave_user_penalties_add")
                {
                    $data['user_id']=$user_id = $this->input->get('id');
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_user_penalties_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_user_penalties_ajax")
                {
                    $id = $this->input->post('id');
                    $user_id = $this->input->post('user_id');
                    $payment_date = date("Y-m-d",strtotime($_POST['payment_date']));
                    $amount = $this->input->post('amount');
					$payment_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$add_data = array(
							'user_id' => $user_id,
							'payment_date' => $payment_date,
							'amount' => $amount,
							'payment_date_time' => $payment_date_time
						);
						$result = $this->Common_model->add_record('tbl_visave_user_penalties', $add_data);
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
                    }
                    else
                    {
						$update_data = array(
							'payment_date' => $payment_date,
							'amount' => $amount,
						);
						$result = $this->Common_model->update_record('tbl_visave_user_penalties', $update_data, array('id' => $id));
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
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "visave_users_add")
                {
                    $id = $this->input->get('id');
                    $data['record']=$record = $this->Common_model->get_record('tbl_visave_users', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_visave_categories', '*', '', 1,array('category_name','asc'));
					if(!empty($id)){
						$data['sub_categories'] = $this->Common_model->get_record('tbl_visave_sub_categories', '*', array('category_id'=>$record['category_id']), 1,array('sub_category_name','asc'));
					}
                    $data['promoters'] = $this->Common_model->get_record('tbl_visave_promoters', '*', '', 1,array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_users_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_users_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $category = $this->Common_model->get_record('tbl_visave_categories', 'amount', array('id'=>$category_id), 2);
                    $sub_category_id = $this->input->post('sub_category_id');
                    $promoter_id = $this->input->post('promoter_id');
                    $joining_date = date("Y-m-d",strtotime($_POST['joining_date']));
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $unique_code = $this->input->post('unique_code');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_visave_users', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'category_id' => $category_id,
								'sub_category_id' => $sub_category_id,
								'promoter_id' => $promoter_id,
								'joining_date' => $joining_date,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'unique_code' => $unique_code,
								'password' => $password,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_visave_users', $add_data);
							if (!empty($result))
							{		
								$start_month=date("Y-m-d",strtotime($joining_date));
								$amount=round($category['amount']/12);
								for($i=0;$i<12;$i++){
									$payment_date=date("Y-m-d",strtotime($start_month." +".$i." month"));
									$add_data = array(
										'user_id' => $result,
										'payment_date' => $payment_date,
										'amount' => $amount
									);
									$result1 = $this->Common_model->add_record('tbl_visave_user_payments', $add_data);
								}
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_visave_users', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'category_id' => $category_id,
								'sub_category_id' => $sub_category_id,
								'promoter_id' => $promoter_id,
								'joining_date' => $joining_date,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'unique_code' => $unique_code,
								'password' => $password
							);
							$result = $this->Common_model->update_record('tbl_visave_users', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "visave_users_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_visave_users', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/visave_users');
                }
                else if ($segment2 == "visave_users_delete")
                {
                    $id = $this->input->get('id');		
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_visave_users');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Deleted...');
					}
                    redirect('admin/visave_users');
                }
                else if ($segment2 == "visave_groups")
                {
                    $data['records'] = $this->db->query("Select t1.*,t2.category_name,t3.sub_category_name from tbl_visave_groups t1 left join tbl_visave_categories t2 on t1.category_id=t2.id left join tbl_visave_sub_categories t3 on t1.sub_category_id=t3.id order by t1.id DESC")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_groups', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_group_lucky_draw")
                {
                    $id = $this->input->get('id');
                    $data['record']=$record = $this->db->query("Select t1.*,t2.category_name,t3.sub_category_name from tbl_visave_groups t1 left join tbl_visave_categories t2 on t1.category_id=t2.id left join tbl_visave_sub_categories t3 on t1.sub_category_id=t3.id where t1.id=".$id."")->row_array();
                    $data['records'] = $records = $this->Common_model->get_record('tbl_visave_group_lucky_draw', '*', array('group_id'=>$id), 1,array('id','asc'));
					if(empty($records)){
						$start_month=date("Y-m-d",strtotime($record['joining_date']));
						for($i=0;$i<12;$i++){
							$month=date("Y-m-d",strtotime($start_month." +".$i." month"));
							$add_data = array(
								'group_id' => $id,
								'month' => $month
							);
							$result1 = $this->Common_model->add_record('tbl_visave_group_lucky_draw', $add_data);
						}
						$data['records'] = $this->Common_model->get_record('tbl_visave_group_lucky_draw', '*', array('group_id'=>$id), 1,array('id','asc'));
					}
					$data['users'] = $this->Common_model->get_record('tbl_visave_group_users', '*', array('group_id'=>$id), 1,array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_group_lucky_draw', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_group_lucky_draw_add")
                {
                    $group_id = $this->input->post('group_id');
                    $id = $this->input->post('id');
                    $user_id = $this->input->post('user_id');
					$user = $this->Common_model->get_record('tbl_visave_group_users', '*', array('id'=>$user_id), 2);
					$created_date_time=date("Y-m-d H:i:s");
					$update_data = array(
						'user_id' => $user_id,
						'user_name' => $user['name'],
						'user_mobile' => $user['mobile'],
						'created_date_time' => $created_date_time
					);
					$result = $this->Common_model->update_record('tbl_visave_group_lucky_draw', $update_data, array('id' => $id));
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Submitted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Submitted...');
					}
                    redirect('admin/visave_group_lucky_draw?id='.$group_id.'');
                }
                else if ($segment2 == "visave_groups_add")
                {
                    $id = $this->input->get('id');
                    $data['record']=$record = $this->Common_model->get_record('tbl_visave_groups', '*', array('id' => $id) , 2);
                    $data['categories'] = $this->Common_model->get_record('tbl_visave_categories', '*', '', 1,array('category_name','asc'));
					if(!empty($id)){
						$data['sub_categories'] = $this->Common_model->get_record('tbl_visave_sub_categories', '*', array('category_id'=>$record['category_id']), 1,array('sub_category_name','asc'));
					}
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_groups_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_groups_ajax")
                {
                    $id = $this->input->post('id');
                    $category_id = $this->input->post('category_id');
                    $sub_category_id = $this->input->post('sub_category_id');
                    $group_name = $this->input->post('group_name');
                    $no_of_users = $this->input->post('no_of_users');
					$joining_date=date("Y-m-d",strtotime($_POST['joining_date']));
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_visave_groups', '*', array('group_name' => $group_name) , 3);
						if($check==0){
							$add_data = array(
								'category_id' => $category_id,
								'sub_category_id' => $sub_category_id,
								'group_name' => $group_name,
								'no_of_users' => $no_of_users,
								'joining_date' => $joining_date,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_visave_groups', $add_data);
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
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_visave_groups', '*', array('group_name' => $group_name,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'category_id' => $category_id,
								'sub_category_id' => $sub_category_id,
								'group_name' => $group_name,
								'no_of_users' => $no_of_users,
								'joining_date' => $joining_date
							);
							$result = $this->Common_model->update_record('tbl_visave_groups', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "visave_groups_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_visave_groups', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/visave_groups');
                }
                else if ($segment2 == "visave_groups_delete")
                {
                    $id = $this->input->get('id');						
                    $record = $this->Common_model->get_record('tbl_visave_group_users', '*', array('group_id' => $id) , 3);
					if($record>0){						
                        $this->session->set_flashdata('error', 'Users available with this group delete users and try again...');
					}else{
						$this->db->where('id', $id);
						$result = $this->db->delete('tbl_visave_groups');
						if (!empty($result))
						{
							$this->session->set_flashdata('success', 'Deleted Successfully...');
						}
						else
						{
							$this->session->set_flashdata('error', 'Not Deleted...');
						}
                    }
                    redirect('admin/visave_groups');
                }
                else if ($segment2 == "visave_group_users")
                {
                    $data['records'] = $this->db->query("Select t1.*,t2.group_name,t4.name as promoter_name from tbl_visave_group_users t1 left join tbl_visave_groups t2 on t1.group_id=t2.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id order by t1.id DESC")->result_array();
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_group_users', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_group_user_payments")
                {								
                    $id = $this->input->get('id');
                    $data['record'] = $this->db->query("Select t1.*,t2.group_name,t4.name as promoter_name from tbl_visave_group_users t1 left join tbl_visave_groups t2 on t1.group_id=t2.id left join tbl_visave_promoters t4 on t1.promoter_id=t4.id where t1.id=".$id."")->row_array();
                    $data['payments'] = $this->Common_model->get_record('tbl_visave_group_user_payments', '*', array('user_id'=>$id), 1,array('id','asc'));
                    $data['bonus'] = $this->Common_model->get_record('tbl_visave_group_user_bonus', '*', array('user_id'=>$id), 1,array('id','asc'));
                    $data['penalties'] = $this->Common_model->get_record('tbl_visave_group_user_penalties', '*', array('user_id'=>$id), 1,array('id','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_group_user_payments', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_group_payments_add")
                {
                    $user_id = $this->input->post('user_id');
                    $id = $this->input->post('id');
                    $payment_date_time = date("Y-m-d H:i:s",strtotime($_POST['payment_date_time']));
					$update_data = array(
						'payment_status' => 1,
						'payment_date_time' => $payment_date_time
					);
					$result = $this->Common_model->update_record('tbl_visave_group_user_payments', $update_data, array('id' => $id));
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Submitted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Submitted...');
					}
                    redirect('admin/visave_group_user_payments?id='.$user_id.'');
                }
                else if ($segment2 == "visave_group_user_bonus_add")
                {
                    $data['user_id']=$user_id = $this->input->get('id');
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_group_user_bonus_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_group_user_bonus_ajax")
                {
                    $id = $this->input->post('id');
                    $user_id = $this->input->post('user_id');
                    $payment_date = date("Y-m-d",strtotime($_POST['payment_date']));
                    $amount = $this->input->post('amount');
					$payment_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$add_data = array(
							'user_id' => $user_id,
							'payment_date' => $payment_date,
							'amount' => $amount,
							'payment_date_time' => $payment_date_time
						);
						$result = $this->Common_model->add_record('tbl_visave_group_user_bonus', $add_data);
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
                    }
                    else
                    {
						$update_data = array(
							'payment_date' => $payment_date,
							'amount' => $amount,
						);
						$result = $this->Common_model->update_record('tbl_visave_group_user_bonus', $update_data, array('id' => $id));
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
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "visave_group_user_penalties_add")
                {
                    $data['user_id']=$user_id = $this->input->get('id');
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_group_user_penalties_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_group_user_penalties_ajax")
                {
                    $id = $this->input->post('id');
                    $user_id = $this->input->post('user_id');
                    $payment_date = date("Y-m-d",strtotime($_POST['payment_date']));
                    $amount = $this->input->post('amount');
					$payment_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$add_data = array(
							'user_id' => $user_id,
							'payment_date' => $payment_date,
							'amount' => $amount,
							'payment_date_time' => $payment_date_time
						);
						$result = $this->Common_model->add_record('tbl_visave_group_user_penalties', $add_data);
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
                    }
                    else
                    {
						$update_data = array(
							'payment_date' => $payment_date,
							'amount' => $amount,
						);
						$result = $this->Common_model->update_record('tbl_visave_group_user_penalties', $update_data, array('id' => $id));
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
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "visave_group_users_add")
                {
                    $id = $this->input->get('id');
                    $data['record']=$record = $this->Common_model->get_record('tbl_visave_group_users', '*', array('id' => $id) , 2);
                    $data['groups'] = $this->Common_model->get_record('tbl_visave_groups', '*', '', 1,array('group_name','asc'));
                    $data['promoters'] = $this->Common_model->get_record('tbl_visave_promoters', '*', '', 1,array('name','asc'));
                    $this->load->view($this->header);
                    $this->load->view($this->leftmenu);
                    $this->load->view($this->views_folder.'visave_group_users_add', $data);
                    $this->load->view($this->footer);
                }
                else if ($segment2 == "visave_group_users_ajax")
                {
                    $id = $this->input->post('id');
                    $group_id = $this->input->post('group_id');
                    $group = $this->Common_model->get_record('tbl_visave_groups', 'category_id', array('id' => $group_id), 2);
                    $category = $this->Common_model->get_record('tbl_visave_categories', 'amount', array('id'=>$group['category_id']), 2);
                    $promoter_id = $this->input->post('promoter_id');
                    $joining_date = date("Y-m-d",strtotime($_POST['joining_date']));
                    $name = $this->input->post('name');
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $unique_code = $this->input->post('unique_code');
                    $cpassword = $this->input->post('password');
					$password=encode5t($cpassword);
					$created_date_time=date("Y-m-d H:i:s");
                    if ($id == 0)
                    {
						$check = $this->Common_model->get_record('tbl_visave_group_users', '*', array('unique_code' => $unique_code) , 3);
						if($check==0){
							$add_data = array(
								'group_id' => $group_id,
								'promoter_id' => $promoter_id,
								'joining_date' => $joining_date,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'unique_code' => $unique_code,
								'password' => $password,
								'created_date_time' => $created_date_time,
								'status' => 1
							);
							$result = $this->Common_model->add_record('tbl_visave_group_users', $add_data);
							if (!empty($result))
							{
								$start_month=date("Y-m-d",strtotime($joining_date));
								$amount=round($category['amount']/12);
								for($i=0;$i<12;$i++){
									$payment_date=date("Y-m-d",strtotime($start_month." +".$i." month"));
									$add_data = array(
										'user_id' => $result,
										'payment_date' => $payment_date,
										'amount' => $amount
									);
									$result1 = $this->Common_model->add_record('tbl_visave_group_user_payments', $add_data);
								}
								$data['msg'] = 'Submitted Successfully...';
								$data['status'] = 1;
							}
							else
							{
								$data['msg'] = 'Not Submitted...';
								$data['status'] = 0;
							}
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
                    }
                    else
                    {
						$check = $this->Common_model->get_record('tbl_visave_group_users', '*', array('unique_code' => $unique_code,'id!='=>$id) , 3);
						if($check==0){
							$update_data = array(
								'group_id' => $group_id,
								'promoter_id' => $promoter_id,
								'joining_date' => $joining_date,
								'name' => $name,
								'mobile' => $mobile,
								'email' => $email,
								'unique_code' => $unique_code,
								'password' => $password
							);
							$result = $this->Common_model->update_record('tbl_visave_group_users', $update_data, array('id' => $id));
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
						}
						else
						{
							$data['msg'] = 'Not Submitted...';
							$data['status'] = 0;
						}
                    }
                    echo json_encode($data);
                }
                else if ($segment2 == "visave_group_users_status")
                {
                    $id = $this->input->get('id');
                    $status = $this->input->get('status');
                    $update_data = array('status' => $status);
                    $result = $this->Common_model->update_record('tbl_visave_group_users', $update_data, array('id' => $id));
                    if (!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Status Updated Successfully...');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Not Updated...');
                    }
                    redirect('admin/visave_group_users');
                }
                else if ($segment2 == "visave_group_users_delete")
                {
                    $id = $this->input->get('id');		
					$this->db->where('id', $id);
					$result = $this->db->delete('tbl_visave_group_users');
					if (!empty($result))
					{
						$this->session->set_flashdata('success', 'Deleted Successfully...');
					}
					else
					{
						$this->session->set_flashdata('error', 'Not Deleted...');
					}
                    redirect('admin/visave_group_users');
                }
                else if ($segment2 == "get_visave_sub_categories")
                {
					$category_id=$_POST['category_id'];
					$records = $this->Common_model->get_record('tbl_visave_sub_categories', '*', array('category_id'=>$category_id), 1,array('sub_category_name','asc'));
					$html='<option value="">Select</option>';
					if(!empty($records)){
					foreach ($records as $key => $row){
						$html .='<option value="'.$row['id'].'">'.$row['sub_category_name'].'</option>';
					}}
					echo $html;
                }
            }
        }
        else
        {
            redirect(base_url());
        }
    }
	public function get_api_value($id)
	{	
		$ch = curl_init();
		$url="http://13.235.208.189/lmxtrade/goldapi";
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
} ?>
