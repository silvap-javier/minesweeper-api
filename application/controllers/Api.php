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
            $params['username'] = 'guest'.'_'.md5(strtotime("now").'guest');
        }

        if (empty($params['mines'])){
            $params['mines'] = 10;
        }

        if (empty($params['time'])){
            $params['time'] = 0;
        }

        $game['username'] = $params['username'];
        $matrix = create_matrix($params['row'],$params['col']);
        $matrix = create_mines($params['mines'],$matrix);
        $matrix = create_number_block($matrix,$params['row'],$params['col']);

        $ip = $_SERVER['REMOTE_ADDR'];
        $game['matrix'] = json_encode($matrix);
        $game['ip'] = $ip;
        $game['time'] = $params['time'];
        
        $response['idGame'] = $this->basic->save('game','id',$game);
        $response['mines'] = $params['mines'];
        $response['username'] = $params['username'];
        $response['data'] = $matrix;

        $response['status'] = true;

        echo json_encode($response);
    }

    public function game_get($id_game = false){
        $response = get_default_array_response_json();
        if ($id_game){
            $response['data'] = $this->basic->get_where('game',array('id' => $id_game))->result_array();
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

    public function games_get($username){
        $response = get_default_array_response_json();
         if ($username){
            $response['data'] = $this->basic->get_where('game',array('username' => $username))->result_array();
            $response['status'] = false;
        }
        $response['status'] = true;
        echo json_encode($response);
    }

    public function update_game_post(){
        $response = get_default_array_response_json();
        $_POST = json_decode(file_get_contents('php://input'), true);
        $game = $_POST['params']['game'];
        $matrix = $_POST['params']['matrix'];
        
        $new_game = array();
        $new_game['id'] = $game['id'];
        $new_game['time'] = $game['time'];
        $new_game['matrix'] = json_encode($matrix);

        $this->basic->save('game','id',$new_game);

        echo json_encode($response);
    }

}