<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Api extends REST_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->CI = & get_instance();
        $this->load->library(array('form_validation', 'session'));
        $this->load->model(array('basic'));
        $this->load->helper(array('array_response','tools'));
        $this->data['lang'] = $this->CI->config->item('language_abbr');
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH');
        header('Access-Control-Allow-Header: token, Content-Type');
   
    }
	
    public function game_post(){
        $response = get_default_array_response_json();
        $game = $_POST['data'];
        $message = '';

        if (isset($game['id'])){
            unset($game['_id']);
            $game = $this->validate_game($game);
            $game = $this->create_game($game);
            $message = $this->basic->update('game',array('id' => $game['id']),$game);
        }else{
            $game = $this->validate_game($game);
            $game = $this->create_game($game);
            $game['id'] = md5($game['nombre'] . time());
            $message = $this->basic->add('games',$game);
        }
        
        $response['message'] = $message;
        $response['status'] = true;
        $response['data']['cards'] = $game['cards'];
        $response['data']['players'] = $game['players'];
        $response['data']['round'] = $game['round'];
        $response['data']['name'] = $game['nombre'];
        $response['data']['id'] = $game['id']; 
        $response['data']['start_game'] = $game['start_game']; 
        echo json_encode($response);
    }

    public function create_game_post(){
        $response = get_default_array_response_json();
        $_POST = json_decode(file_get_contents('php://input'), true);
        $params = $_POST['params']['game'];
        
        $game = array();

        if (empty($params['row'])){
            $params['row'] = 8;
        }

        if (empty($params['col'])){
            $params['col'] = 8;
        }

        if (empty($params['username'])){
            $params['username'] = 'guest';
        }

        if (empty($params['mines'])){
            $params['mines'] = 10;
        }

        $game['username'] = $params['username'];
        $matrix = create_matrix($params['row'],$params['col']);
        $matrix = create_mines($params['mines'],$matrix);
        $matrix = create_number_block($matrix,$params['row'],$params['col']);

        $ip = $_SERVER['REMOTE_ADDR'];
        $game['matrix'] = json_encode($matrix);
        $game['ip'] = $ip;
        
        $this->basic->save('game','id',$game);

        $response['idGame'] = $this->basic->save('game','id',$game);
        $response['data'] = $matrix;

        $response['status'] = true;
        
        echo json_encode($response);
    }

    public function game_get($game_id = false){
        $response = get_default_array_response_json();

        if ($game_id){
            $response['data'] = $this->basic->get_where('game',array('id' => $game_id));
            $response['status'] = true;            
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
            $response['data'] = $this->basic->get_where('game',array('ip' => $ip))->result_array();
            if (count($response['data']) > 0){
                $response['data'] = $response['data']['0'];
                $response['data']['matrix'] = json_decode($response['data']['matrix']);
                $response['status'] = true;
            }else{
                $response['status'] = false;
            }
        }

        echo json_encode($response);
    }

    public function cards_get($card_id = false){
        $response = get_default_array_response_json();

        if ($card_id){
            $response['data'] = $this->basic->get_where('cards',array('id' => $card_id));
        }else{
            $response['data'] = $this->basic->get_all('cards','order');    
        }

        $response['status'] = true;
        echo json_encode($response);
    }

    public function algo_get(){
        $response = get_default_array_response_json();
        $response['status'] = true;
        echo json_encode($response);
    }
    public function card_post(){
        $response = get_default_array_response_json();
        $card = $_POST['data'];
        $message = '';

        if (isset($card['id'])){
            unset($card['_id']);
            $message = $this->basic->update('cards',array('id' => $card['id']),$card);
        }else{
            $card['id'] = md5($card['consigna'] . time());    
            $message = $this->basic->add('cards',$card);
        }
        $response['message'] = $message;
        $response['status'] = true;
        echo json_encode($response);
    }

}