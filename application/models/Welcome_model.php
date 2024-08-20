<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome_model extends CI_Model
{
   		
	public function get_faqs() 
	{
        $this->db->select('*');
		$this->db->from('tbl_faq_categories');
		$this->db->where('status',1);
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		$result = $query->result_array();	
		$records=array();
		if(!empty($result)){
		foreach($result as $key=>$row){
			$this->db->select('*');
			$this->db->from('tbl_faqs');
			$this->db->where('status',1);
			$this->db->where('category_id',$row['id']);
			$this->db->order_by('id','asc');
			$query = $this->db->get();
			$products = $query->result_array();	
			$row['faqs']=$products;
			$records[]=$row;
		}}
		return $records;
    }				
	public function get_casted_gold_emp_sales($id,$from_date,$to_date) 
	{
        $this->db->select('*');
		$this->db->from('tbl_casted_gold_employees');
		$this->db->where('id',$id);
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
			if(!empty($weight)){
				$total_weight=array_sum($weight);
			}
			$total_sales=0;
			if(!empty($sales)){
				$total_sales=array_sum($sales);
			}
			$erow['promoters']=$precords;			
			$erow['weight']=$total_weight;			
			$erow['sales']=$total_sales;		
			$records[]=$erow;
		}}
		return $records;
    }					
	public function get_casted_gold_pro_sales($id,$from_date,$to_date) 
	{
		$this->db->select('*');
		$this->db->from('tbl_casted_gold_promoters');
		$this->db->where('id',$id);
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
		return $precords;
    }				
	public function get_casted_silver_emp_sales($id,$from_date,$to_date) 
	{
        $this->db->select('*');
		$this->db->from('tbl_casted_silver_employees');
		$this->db->where('id',$id);
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
			if(!empty($weight)){
				$total_weight=array_sum($weight);
			}
			$total_sales=0;
			if(!empty($sales)){
				$total_sales=array_sum($sales);
			}
			$erow['promoters']=$precords;			
			$erow['weight']=$total_weight;			
			$erow['sales']=$total_sales;		
			$records[]=$erow;
		}}
		return $records;
    }					
	public function get_casted_silver_pro_sales($id,$from_date,$to_date) 
	{
		$this->db->select('*');
		$this->db->from('tbl_casted_silver_promoters');
		$this->db->where('id',$id);
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
		return $precords;
    }	
	public function get_casted_emp_sales($id,$from_date,$to_date) 
	{
        $this->db->select('*');
		$this->db->from('tbl_casted_gold_employees');
		$this->db->where('id',$id);
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
			$sales=array();
			if(!empty($promoters)){
			foreach($promoters as $pkey=>$prow){
				$where="order_status=1 AND coupon_code='".$prow['unique_code']."' AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
				$this->db->select('*');
				$this->db->from('tbl_casted_orders');
				$this->db->where($where);
				$this->db->order_by('id','desc');
				$query = $this->db->get();
				$orders = $query->result_array();
				$psales=array();
				if(!empty($orders)){
				foreach($orders as $okey=>$orow){
					$sales[]=$orow['final_amount'];
					$psales[]=$orow['final_amount'];
				}}
				$ptotal_sales=0;
				if(!empty($psales)){
					$ptotal_sales=array_sum($psales);
				}
				$prow['sales']=$ptotal_sales;
				$prow['orders']=$orders;
				$precords[]=$prow;
			}}
			$total_sales=0;
			if(!empty($sales)){
				$total_sales=array_sum($sales);
			}
			$erow['promoters']=$precords;			
			$erow['sales']=$total_sales;		
			$records[]=$erow;
		}}
		return $records;
    }					
	public function get_casted_pro_sales($id,$from_date,$to_date) 
	{
		$this->db->select('*');
		$this->db->from('tbl_casted_gold_promoters');
		$this->db->where('id',$id);
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		$promoters = $query->result_array();	
		$precords=array();
		$sales=array();
		if(!empty($promoters)){
		foreach($promoters as $pkey=>$prow){
			$where="order_status=1 AND coupon_code='".$prow['unique_code']."' AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
			$this->db->select('*');
			$this->db->from('tbl_casted_orders');
			$this->db->where($where);
			$this->db->order_by('id','desc');
			$query = $this->db->get();
			$orders = $query->result_array();
			$psales=array();
			if(!empty($orders)){
			foreach($orders as $okey=>$orow){
				$sales[]=$orow['final_amount'];
				$psales[]=$orow['final_amount'];
			}}
			$ptotal_sales=0;
			if(!empty($psales)){
				$ptotal_sales=array_sum($psales);
			}
			$prow['sales']=$ptotal_sales;
			$prow['orders']=$orders;
			$precords[]=$prow;
		}}
		return $precords;
    }		
	public function get_minted_emp_sales($id,$from_date,$to_date) 
	{
        $this->db->select('*');
		$this->db->from('tbl_minted_employees');
		$this->db->where('id',$id);
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		$result = $query->result_array();	
		$records=array();
		if(!empty($result)){
		foreach($result as $ekey=>$erow){
			$this->db->select('*');
			$this->db->from('tbl_minted_promoters');
			$this->db->where('employee_id',$erow['id']);
			$this->db->order_by('id','asc');
			$query = $this->db->get();
			$promoters = $query->result_array();	
			$precords=array();
			$sales=array();
			if(!empty($promoters)){
			foreach($promoters as $pkey=>$prow){
				$where="order_status=1 AND coupon_code='".$prow['unique_code']."' AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
				$this->db->select('*');
				$this->db->from('tbl_minted_orders');
				$this->db->where($where);
				$this->db->order_by('id','desc');
				$query = $this->db->get();
				$orders = $query->result_array();
				$psales=array();
				if(!empty($orders)){
				foreach($orders as $okey=>$orow){
					$sales[]=$orow['final_amount'];
					$psales[]=$orow['final_amount'];
				}}
				$ptotal_sales=0;
				if(!empty($psales)){
					$ptotal_sales=array_sum($psales);
				}
				$prow['sales']=$ptotal_sales;
				$prow['orders']=$orders;
				$precords[]=$prow;
			}}
			$total_sales=0;
			if(!empty($sales)){
				$total_sales=array_sum($sales);
			}
			$erow['promoters']=$precords;			
			$erow['sales']=$total_sales;		
			$records[]=$erow;
		}}
		return $records;
    }					
	public function get_minted_pro_sales($id,$from_date,$to_date) 
	{
		$this->db->select('*');
		$this->db->from('tbl_minted_promoters');
		$this->db->where('id',$id);
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		$promoters = $query->result_array();	
		$precords=array();
		$sales=array();
		if(!empty($promoters)){
		foreach($promoters as $pkey=>$prow){
			$where="order_status=1 AND coupon_code='".$prow['unique_code']."' AND date(order_date_time)>='".$from_date."' AND date(order_date_time)<='".$to_date."'";
			$this->db->select('*');
			$this->db->from('tbl_minted_orders');
			$this->db->where($where);
			$this->db->order_by('id','desc');
			$query = $this->db->get();
			$orders = $query->result_array();
			$psales=array();
			if(!empty($orders)){
			foreach($orders as $okey=>$orow){
				$sales[]=$orow['final_amount'];
				$psales[]=$orow['final_amount'];
			}}
			$ptotal_sales=0;
			if(!empty($psales)){
				$ptotal_sales=array_sum($psales);
			}
			$prow['sales']=$ptotal_sales;
			$prow['orders']=$orders;
			$precords[]=$prow;
		}}
		return $precords;
    }

}
?>