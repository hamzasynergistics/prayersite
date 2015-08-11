<?php

class Json_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }   
    
    function getAllCountries(){
        
        $this->db->order_by('country_name ASC');
        $query = $this->db->get('countries');
        return $query->result_array();
    }
    
    function getCities($country_id){
        
        $this->db->order_by('city_name ASC');
        $query = $this->db->get_where('cities', array('country_id' => $country_id));
        return $query->result_array();
    }
    
    function searchLocation($search){
        
        $this->db->select('cities.*, cnt.country_name');
        $this->db->join('countries cnt', 'cnt.country_id = cities.country_id', 'INNER'); 
        $this->db->where("cities.city_name LIKE '%$search%'");
        $city = $this->db->get('cities');
        
        if($city->num_rows() > 0){
            return $city->result_array();            
        }
        else{
            $this->db->select('countries.*, cities.city_name');
            $this->db->join('cities', 'cities.country_id = countries.country_id', 'LEFT'); 
            $this->db->where("countries.country_name LIKE '%$search%'");
            $this->db->order_by('city_name ASC');
            $country = $this->db->get('countries');
            
            if($country->num_rows() > 0){
                return $country->result_array();          
            }
            else{
                return 'empty';
            }
        }
    }
}