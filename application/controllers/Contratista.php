<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Contratista extends REST_Controller
{
    public function __construct()
    {
      header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
      header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
      header("Access-Control-Allow-Origin: *");
  
      parent::__construct();
      $this->load->model("Contratista_model");
      $this->load->helper("url");
    }

    public function select_get()
    {
      $data = $this->Contratista_model->select();
  
      if (count($data) >= 0)
      {
        $respuesta = array('error' => FALSE, 'data' => $data);
        $this->response($respuesta);
      }
      else
      {
        $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
        $this->response($respuesta);
      }
    }

}