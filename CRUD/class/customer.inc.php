<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customer
 *
 * @author User
 */
class CUSTOMER {
    //put your code here
    protected $cid;
    protected $cus_name;
    protected $address1;
    protected $address2;
    protected $address3;
    protected $phone;
    protected $email;
    protected $status;
    protected $post_data;
    
    Public function __construct($post_data) {
        $this->post_data = $post_data;
        $this->extract_post_data($post_data);
    }
    
    Public function create(){
        $post_data = $this->post_data;
        $cnt = 0;
        unset($post_data['cid']);               //not needed for bindparam
        unset($post_data['submitCreate']);      //not needed for bindparam
        $arrCount = count($post_data);
        #echo "\$arrCount = $arrCount<br>";
        
        $qr = "INSERT INTO customers SET ";
        foreach ($post_data as $rowKey => $rowVal){
            $cnt++;
            $qr .= $rowKey."=:".$rowKey;
            if ($cnt != $arrCount){
                $qr .= ", ";
            }
        }
        #echo "\$qr = $qr<br>";
        $objSQL = new SQLBINDPARAM($qr, $post_data);
        $result = $objSQL->InsertData2();
        if($result == 'insert ok!'){
            return 'Insert Successful';
        }else{
            return 'Insert Failed';
        }
        
    }
    
    Public function update(){
        $post_data = $this->post_data;
        $cnt = 0;
        unset($post_data['cid']);               //not needed for bindparam
        unset($post_data['submitUpdate']);      //not needed for bindparam
        $arrCount = count($post_data);
        $cid = $this->get_cid();
        
        $qr = "UPDATE customers SET ";
        foreach ($post_data as $rowKey => $rowVal){
            $cnt++;
            $qr .= $rowKey."=:".$rowKey;
            if ($cnt != $arrCount){
                $qr .= ", ";
            }
        }
        $qr .= " WHERE cid = $cid";
        $objSQL = new SQLBINDPARAM($qr, $post_data);
        $result = $objSQL->UpdateData2();
        if ($result == 'Update ok!'){
            return 'Update Successful';
        }else{
            return 'Update Failed';
        }
    }
    
    Public function delete(){
        $cid = $this->get_cid();
        $qr = "DELETE FROM customers WHERE cid = $cid";
        
        $objSQL = new SQL($qr);
        $result = $objSQL->getDelete();
        if ($result == 'deleted'){
            return 'Delete Successful';
        }else{
            return 'Delete Failed';
        }
    }
    
    Public function extract_post_data($post_data){
        extract($post_data,EXTR_PREFIX_ALL,'post');
        $this->set_cid($post_cid);
        $this->set_cusName($post_cus_name);
        $this->set_address1($post_address1);
        $this->set_address2($post_address2);
        $this->set_address3($post_address3);
        $this->set_phone($post_phone);
        $this->set_email($post_email);
        $this->set_status($post_status);
    }
    
    Public function set_cid($input){
        $this->cid = $input;
    }
    
    Public function get_cid(){
        return $this->cid;
    }
    
    Public function set_cusName($input){
        $this->cus_name = $input;
    }
    
    Public function get_cusName(){
        return $this->cus_name;
    }
    
    Public function set_address1($input){
        $this->address1 = $input;
    }
    
    Public function get_address1(){
        return $this->address1;
    }
    
    Public function set_address2($input){
        $this->address2 = $input;
    }
    
    Public function get_address2(){
        return $this->address2;
    }
    
    Public function set_address3($input){
        $this->address3 = $input;
    }
    
    Public function get_address3(){
        return $this->address3;
    }
    
    public function set_phone($input){
        $this->phone = $input;
    }
    
    public function get_phone(){
        return $this->phone;
    }
    
    public function set_email($input){
        $this->email = $input;
    }
    
    Public function get_email(){
        return $this->email;
    }
    
    Public function set_status($input){
        $this->status = $input;
    }
    
    Public function get_status(){
        return $this->status;
    }
}
