<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Controller {
    
    public function __construct() {

        parent::__construct();

        $this->load->model('Json_model');
    }
    
    public function get_cities(){
       
        $country_id = $_REQUEST['country_id'];
        $result['cities'] = $this->Json_model->getCities($country_id);  
        
        if($result['cities']){
            $result['status'] = 'Success'; 
            echo json_encode($result);            
        }else{
            $result['status'] = 'No Record Found!'; 
            echo json_encode($result);          
        }        
    }
    
    public function search(){
        
        $search = $_REQUEST['location'];
        
        if(empty($search)){
            $result['type'] = 'country';         
            $result['status'] = 'Success';         
            $result['location'] = $this->Json_model->getAllCountries();        
            echo json_encode($result);
        }else{
            $res = $this->Json_model->searchLocation($search);

            if($res != 'empty'){
                $result['type'] = count($res) == 1 ? 'city' : 'country'; 
                $result['status'] = 'Success';
                $result['location'] = $res; 
                echo json_encode($result);            
            }else{
                $result['status'] = 'No Record Found!'; 
                echo json_encode($result);          
            }  
        }
        
        
    }
    
}
