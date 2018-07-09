<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {
  public function __construct(){
      parent::__construct();
      
  }
	
  public function updata_data($table,$whereCondition,$updateData){
    
      $this->db->update($table, $updateData, $whereCondition);
      $row = $this->db->affected_rows() ;
      return $row;
  }    

   public function update_data($table,$whereCondition,$updateData){
    
      $this->db->update($table, $updateData, $whereCondition);
      $row = $this->db->affected_rows() ;
      return $row;
  } 

  public function insert_data($table,$data){
      $this->db->insert($table, $data);
      $last_id = $this->db->insert_id();
      return $last_id;
          
  }  
    
    
  public function delete_data($table,$whereCondition){
      $this->db->delete($table, $whereCondition); 
      $affected_rows  = $this->db->affected_rows();
      return $affected_rows;
      
  } 

  public function get_records_by_id($table,$single,$where,$select,$order_by_field,$order_by_value ){
        if(!empty($select)){
            $this->db->select($select);
        }
        
        if(!empty($where)){
            $this->db->where($where);
        }
        
        if(!empty($order_by_field) && !empty($order_by_value)){
            $this->db->order_by($order_by_field, $order_by_value);
        }
        
            $query = $this->db->get($table);
            $result = $query->result_array();
            if(!empty($result)){
            if($single){
                $result = $result[0];
            }else{
                $result = $result;
            }  
        } else{
           $result = 0; 
        }
        return $result; 
        //     if($single){
        //         $result = $result[0];
        //     }else{
        //         $result = $result;
        //     }
        
        // return $result;
        
    }   
    
    
    
}//end of clas