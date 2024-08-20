<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model {
	public function __construct() {
        parent::__construct();
    }			
	public function get_faqs() 
	{
        $this->db->select('t1.*,t2.name as category_name');
		$this->db->from('tbl_faqs as t1');
        $this->db->join('tbl_faq_categories as t2','t1.category_id = t2.id','left');
		$this->db->order_by('t1.id','desc');
		$query = $this->db->get();
		$result = $query->result_array();	
		return $result;
    }				
	public function get_pickup_dealers() 
	{
        $this->db->select('t1.*,t2.name as place_name');
		$this->db->from('tbl_pickup_dealers as t1');
        $this->db->join('tbl_pickup_places as t2','t1.place_id = t2.id','left');
		$this->db->order_by('t1.id','desc');
		$query = $this->db->get();
		$result = $query->result_array();	
		return $result;
    }		
	public function get_bookings() 
	{
        $this->db->select('t1.*,t2.unique_code,t2.name as user_name,t2.mobile as user_mobile,t2.email as user_email');
		$this->db->from('tbl_bookings as t1');
        $this->db->join('tbl_users as t2','t1.user_id = t2.id','left');
		$this->db->order_by('t1.id','desc');
		$query = $this->db->get();
		$result = $query->result_array();	
		return $result;
    }			
	public function get_rates() 
	{
        $this->db->select('t1.*,t2.name as area_name');
		$this->db->from('tbl_rates as t1');
        $this->db->join('tbl_areas as t2','t1.area_id = t2.id','left');
		$this->db->order_by('t1.id','desc');
		$query = $this->db->get();
		$result = $query->result_array();	
		return $result;
    }				
	public function get_casted_gold_pending_sales($from_date,$to_date) 
	{
		$where="order_status=0 AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
        $this->db->select('*');
		$this->db->from('tbl_casted_gold_orders');
		$this->db->order_by('id','desc');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->result_array();	
		return $result;
    }		
	public function get_casted_gold_sales($from_date,$to_date) 
	{
		$where="order_status=1 AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
        $this->db->select('*');
		$this->db->from('tbl_casted_gold_orders');
		$this->db->order_by('id','desc');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->result_array();	
		return $result;
    }				
	public function get_casted_gold_sales_cancelled($from_date,$to_date) 
	{
		$where="order_status=2 AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
        $this->db->select('*');
		$this->db->from('tbl_casted_gold_orders');
		$this->db->order_by('id','desc');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->result_array();	
		return $result;
    }					
	public function get_casted_gold_emp_sales($from_date,$to_date) 
	{
        $this->db->select('*');
		$this->db->from('tbl_casted_gold_employees');
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		$result = $query->result_array();	
		$records=array();
		if(!empty($result)){
		foreach($result as $ekey=>$erow){
			$this->db->select('*');
			$this->db->from('tbl_casted_gold_promoters');
			$this->db->where('employee_id',$erow['id']);
			$this->db->order_by('id','asc');
			$query = $this->db->get();
			$promoters = $query->result_array();	
			$precords=array();
			$weight=array();
			$sales=array();
			if(!empty($promoters)){
			foreach($promoters as $pkey=>$prow){
				$where="order_status=1 AND coupon_code='".$prow['unique_code']."' AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
				$this->db->select('*');
				$this->db->from('tbl_casted_gold_orders');
				$this->db->where($where);
				$this->db->order_by('id','desc');
				$query = $this->db->get();
				$orders = $query->result_array();
				$pweight=array();
				$psales=array();
				if(!empty($orders)){
				foreach($orders as $okey=>$orow){
					$weight[]=$orow['total_weight'];
					$sales[]=$orow['final_amount'];
					$pweight[]=$orow['total_weight'];
					$psales[]=$orow['final_amount'];
				}}
				$ptotal_weight=0;
				$ptotal_sales=0;
				if(!empty($psales)){
					$ptotal_weight=array_sum($pweight);
					$ptotal_sales=array_sum($psales);
				}
				$prow['weight']=$ptotal_weight;
				$prow['sales']=$ptotal_sales;
				$prow['orders']=$orders;
				$precords[]=$prow;
			}}
			$total_weight=0;
			$total_sales=0;
			if(!empty($sales)){
				$total_weight=array_sum($weight);
				$total_sales=array_sum($sales);
			}
			$erow['promoters']=$precords;			
			$erow['weight']=$total_weight;		
			$erow['sales']=$total_sales;		
			$records[]=$erow;
		}}
		return $records;
    }			
	public function get_casted_silver_pending_sales($from_date,$to_date) 
	{
		$where="order_status=0 AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
        $this->db->select('*');
		$this->db->from('tbl_casted_silver_orders');
		$this->db->order_by('id','desc');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->result_array();	
		return $result;
    }		
	public function get_casted_silver_sales($from_date,$to_date) 
	{
		$where="order_status=1 AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
        $this->db->select('*');
		$this->db->from('tbl_casted_silver_orders');
		$this->db->order_by('id','desc');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->result_array();	
		return $result;
    }				
	public function get_casted_silver_sales_cancelled($from_date,$to_date) 
	{
		$where="order_status=2 AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
        $this->db->select('*');
		$this->db->from('tbl_casted_silver_orders');
		$this->db->order_by('id','desc');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->result_array();	
		return $result;
    }					
	public function get_casted_silver_emp_sales($from_date,$to_date) 
	{
        $this->db->select('*');
		$this->db->from('tbl_casted_silver_employees');
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		$result = $query->result_array();	
		$records=array();
		if(!empty($result)){
		foreach($result as $ekey=>$erow){
			$this->db->select('*');
			$this->db->from('tbl_casted_silver_promoters');
			$this->db->where('employee_id',$erow['id']);
			$this->db->order_by('id','asc');
			$query = $this->db->get();
			$promoters = $query->result_array();	
			$precords=array();
			$weight=array();
			$sales=array();
			if(!empty($promoters)){
			foreach($promoters as $pkey=>$prow){
				$where="order_status=1 AND coupon_code='".$prow['unique_code']."' AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
				$this->db->select('*');
				$this->db->from('tbl_casted_silver_orders');
				$this->db->where($where);
				$this->db->order_by('id','desc');
				$query = $this->db->get();
				$orders = $query->result_array();
				$pweight=array();
				$psales=array();
				if(!empty($orders)){
				foreach($orders as $okey=>$orow){
					$weight[]=$orow['total_weight'];
					$sales[]=$orow['final_amount'];
					$pweight[]=$orow['total_weight'];
					$psales[]=$orow['final_amount'];
				}}
				$ptotal_weight=0;
				$ptotal_sales=0;
				if(!empty($psales)){
					$ptotal_weight=array_sum($pweight);
					$ptotal_sales=array_sum($psales);
				}
				$prow['weight']=$ptotal_weight;
				$prow['sales']=$ptotal_sales;
				$prow['orders']=$orders;
				$precords[]=$prow;
			}}
			$total_weight=0;
			$total_sales=0;
			if(!empty($sales)){
				$total_weight=array_sum($weight);
				$total_sales=array_sum($sales);
			}
			$erow['promoters']=$precords;			
			$erow['weight']=$total_weight;		
			$erow['sales']=$total_sales;		
			$records[]=$erow;
		}}
		return $records;
    }			
	public function get_pro_payments($where,$date) 
	{
        $this->db->select('*');
		$this->db->from('tbl_vi_super_payments');
		$this->db->group_by('heading');
		$this->db->order_by('id','desc');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->result_array();		
		$records=array();
		if(!empty($result)){
		foreach($result as $key=>$row){			
			$result1 = $this->db->query("Select * from tbl_vi_super where employee_id=".$row['employee_id']."")->result_array();
			$pro_amount=array();
			$super_amount=array();
			if(!empty($result1)){
			foreach($result1 as $key1=>$row1){	
				$pro = $this->db->query("Select SUM(pro_amount) as total_pro_amount from tbl_vi_super_payments where super_id=".$row1['id']." AND heading='".$row['heading']."' AND date>='".$row1['date']."'")->row_array();
				$pro_amount[]=$pro['total_pro_amount'];
				$super = $this->db->query("Select SUM(super_amount) as total_super_amount from tbl_vi_super_payments where super_id=".$row1['id']." AND heading='".$row['heading']."' AND date>='".$row1['date']."'")->row_array();
				$super_amount[]=$super['total_super_amount'];
			}}
			$final_pro['total_pro_amount']=array_sum($pro_amount);
			$final_super['total_super_amount']=array_sum($super_amount);
			$row['pro_amount'] =$final_pro;
			$row['super_amount'] =$final_super;
			$records[]=$row;
		}}
		return $records;
    }		
	public function get_super_payments($where,$date) 
	{
        $this->db->select('*');
		$this->db->from('tbl_vi_super_payments');
		$this->db->group_by('heading');
		$this->db->order_by('id','desc');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->result_array();		
		$records=array();
		if(!empty($result)){
		foreach($result as $key=>$row){
			$row['pro_amount'] = $this->db->query("Select SUM(pro_amount) as total_pro_amount from tbl_vi_super_payments where super_id=".$row['super_id']." AND heading='".$row['heading']."' AND date>='".$date."'")->row_array();
			$row['super_amount'] = $this->db->query("Select SUM(super_amount) as total_super_amount from tbl_vi_super_payments where super_id=".$row['super_id']." AND heading='".$row['heading']."' AND date>='".$date."'")->row_array();	
			$records[]=$row;
		}}
		return $records;
    }					
	public function get_vi_payments($where) 
	{
        $this->db->select('*');
		$this->db->from('tbl_vi_payments');
		$this->db->group_by('heading');
		$this->db->order_by('id','desc');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->result_array();	
		$records=array();
		if(!empty($result)){
		foreach($result as $key=>$row){
			$row['pro_amount'] = $this->db->query("Select SUM(pro_amount) as total_pro_amount from tbl_vi_payments where heading='".$row['heading']."'")->row_array();
			$row['super_amount'] = $this->db->query("Select SUM(super_amount) as total_super_amount from tbl_vi_payments where heading='".$row['heading']."'")->row_array();	
			$records[]=$row;
		}}
		return $records;
    }				
}
