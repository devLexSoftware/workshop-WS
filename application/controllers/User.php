<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class User extends REST_Controller
{
  public function __construct()
  {
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Origin: *");

    parent::__construct();
    $this->load->model("User_model");
  }

  public function select_post()
  {
    error_log("WS User Select");

    $data = json_decode(file_get_contents('php://input'), true);
    error_log("User: ".$data['user']);
    error_log("Pass: ".$data['password']);

    if(isset($data['user']) && isset($data['password']))
    {
      $data = $this->User_model->select(false, array("usuario" => $data['user'], "pass" => $data['password']));

      if (count($data) >= 0)
      {
        $respuesta = array('error' => FALSE,'data' => $data);
        $this->response($respuesta);
      }
      else
      {
        $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
        $this->response( $respuesta );
      }
    }
    else
    {
      $respuesta = array('error' => TRUE, 'msj'=> 'Datos incompletos');
      $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
    }
  }
}
