<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public function index()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $url_c = "http://ip-api.com/json/$ip";
        $json_c = json_decode(file_get_contents($url_c));
        $city = $json_c->city;
        $date = date('Y-m-d');
        
        $url_t = "http://muslimsalat.com/$city/$date/5.json?key=f42d1ffabf360f269de7bf4032baaa28";
        $json_t = json_decode(file_get_contents($url_t));
        
        $result['data'] = array(
            'status'  => $json_t->status_valid,
            'state'   => $json_t->state,
            'country' => $json_t->country,
            'qibla'   => $json_t->qibla_direction,
            'fajr'    => $json_t->items[0]->fajr,
            'shurooq' => $json_t->items[0]->shurooq,
            'dhuhr'   => $json_t->items[0]->dhuhr,
            'asr'     => $json_t->items[0]->asr,
            'maghrib' => $json_t->items[0]->maghrib,
            'isha'    => $json_t->items[0]->isha
        );
        
//        echo '<pre>';
//        print_r($json_t); 
//        die;
        
        $this->load->view('home_view', $result);
    }
        
    public function search(){
        
        $address = $_GET['location'];
        $method  = $_GET['method'];
        $date    = date('Y-m-d');
                
        $new_address = str_replace(" ", "+", $address);
        $url_s = "http://maps.google.com/maps/api/geocode/json?address=$new_address&sensor=false";
        $json_s = file_get_contents($url_s);
        $j_s = json_decode($json_s);
        $city = $j_s->{'results'}[0]->{'address_components'}[0]->{'long_name'};                
        $new_city = str_replace(" ", "", $city);
                
        $url_t = "http://muslimsalat.com/$new_city/$date/5.json?key=f42d1ffabf360f269de7bf4032baaa28";
        $json_t = file_get_contents($url_t);
        $j_t = json_decode($json_t);
        
        $url_time = "http://www.earthtools.org/timezone/".$j_s->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}."/".$j_s->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        $xml_time = simplexml_load_file($url_time);
                        
//        echo '<pre>'; 
//        print_r($j_t); 
//        die;

        $result['data'] = array(
            'status'  => $j_t->status_valid,
            'lat'     => $j_s->{'results'}[0]->{'geometry'}->{'location'}->{'lat'},
            'long'    => $j_s->{'results'}[0]->{'geometry'}->{'location'}->{'lng'},                    
            'loc'     => $j_s->{'results'}[0]->{'formatted_address'},
            'time'    => $xml_time->isotime,
            'qibla'   => $j_t->qibla_direction,
            'fajr'    => $j_t->items[0]->fajr,
            'shurooq' => $j_t->items[0]->shurooq,
            'dhuhr'   => $j_t->items[0]->dhuhr,
            'asr'     => $j_t->items[0]->asr,
            'maghrib' => $j_t->items[0]->maghrib,
            'isha'    => $j_t->items[0]->isha
        );
           
        $this->load->view('home_view', $result);
    }    
    
    public function save_user(){
                
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('url', 'Website URL', 'required');

        if ($this->form_validation->run() == FALSE) {            
            $this->load->view('includes/header');
            $this->load->view('signup');
            $this->load->view('includes/footer');
        } 
        else{
            $user_data = array(
                'username' => $_POST['username'],
                'email'    => $_POST['email'],
                'address'  => $_POST['url']
            );

            $res = $this->Book_model->saveUser($user_data);
            if($res){
                $this->session->userdata('success', 'Your information hass been sent for Approval !');
                redirect('users');
            }
            else{
                $this->session->userdata('error', "Your account couldn't be created !");
                redirect('signup');                
            }                
        }
    }

    public function get_users(){
        $result['users'] = $this->Gold_model->getAllUsers();
        
        $this->load->view('includes/header');
        $this->load->view('users', $result);
        $this->load->view('includes/footer');
    } 
    
    public function update_user_status(){
        $result = $this->Gold_model->updateUserStatus($this->uri->segment(3));
        if($result != 0){
            $this->session->userdata('success', 'User Successfully Approved !');
            redirect('users');
        }
        else{
            $this->session->userdata('error', "User couldn't be Approved !");
            redirect('users');                
        }
    }
}
