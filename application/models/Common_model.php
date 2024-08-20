<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model {
	public function __construct() {
        parent::__construct();
    }	
	public function get_record($tablename,$fields,$where,$type,$order=''){
		$res=$this->db->select($fields)->from($tablename);
		if($where!='' OR $where!=NULL){$this->db->where($where);}
		if(!empty($order)){
			if(is_array($order)){
				$this->db->order_by($order[0],$order[1]);
			}
			else{
				$this->db->order_by('id',$order);
			}
		}
		if($type ==1){
			return $this->db->get()->result_array();
		}else if($type ==2){
			return $this->db->get()->row_array();
		}else{
			return $this->db->get()->num_rows();
		}
	}
	public function add_record($table,$add_data)
	{		
		$result = $this->db->insert($table, $add_data); 
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	public function update_record($tableName,$updateArray,$whereCondition){
		$up=$this->db->update($tableName,$updateArray,$whereCondition);
		return $up;
	}	
	public function delete_record($table,$slno)
	{	
		$this->db->where('slno',$slno);
		$result = $this->db->delete($table); 		
		return $result;
	}
	public function uploadImage($path,$name,$width,$height)
	{
		$config['upload_path'] = $path; 
		$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
		$config['max_size']  = '0';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$this->load->library('upload', $config);					
		if(! $this->upload->do_upload($name))
		{
			$data['msg'] = $this->upload->display_errors();
			$Img1='';
		}
		else
		{
			$data = $this->upload->data();
			$uploadedImages[$name] = $data['file_name'];
			$Img1 = $uploadedImages[$name];
			$config_image = array();
			$config_image = array(
				'image_library' => 'gd2',
				'source_image' => $path.$Img1,
				'new_image' => $path.$Img1,
				'width' => $width,
				'height' => $height,
				'maintain_ratio' => FALSE,
				'rotate_by_exif' => TRUE,
				'strip_exif' => TRUE,
			);					
			$this->load->library('image_lib', $config_image);
			$this->image_lib->initialize($config_image);
			$this->image_lib->resize();
			$this->image_lib->clear();							
		}
		return $Img1;
	}
	public function uploadPdf($path,$name,$width,$height)
	{
		$config['upload_path'] = $path; 
		$config['allowed_types'] = 'pdf';
		$config['max_size']  = '0';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$this->load->library('upload', $config);					
		if(! $this->upload->do_upload($name))
		{
			$data['msg'] = $this->upload->display_errors();
			$Img1='';
		}
		else
		{
			$data = $this->upload->data();
			$uploadedImages[$name] = $data['file_name'];
			$Img1 = $uploadedImages[$name];
			$config_image = array();
			$config_image = array(
				'image_library' => 'gd2',
				'source_image' => $path.$Img1,
				'new_image' => $path.$Img1,
				'width' => $width,
				'height' => $height,
				'maintain_ratio' => FALSE,
				'rotate_by_exif' => TRUE,
				'strip_exif' => TRUE,
			);					
			$this->load->library('image_lib', $config_image);
			$this->image_lib->initialize($config_image);
			$this->image_lib->resize();
			$this->image_lib->clear();							
		}
		return $Img1;
	}
	public function send_mail($to,$message,$subject)
	{
     	$headers  = 'MIME-Version: 1.0' . "\r\n"; 
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";  
		$headers .= 'Reply-To: sundaywebservice@gmail.com' . "\r\n" ;   
		$headers .= 'From: Jaibheemtv<sundaywebservice@gmail.com>' . "\r\n";	
		$result=	mail($to, $subject, $message, $headers);  
	}
}
