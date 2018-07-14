<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Obra extends REST_Controller
{
  public function __construct()
  {
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Origin: *");

    parent::__construct();
    $this->load->model("Obra_model");
    $this->load->helper("url");
  }

  public function select_get()
  {
    $data = $this->Obra_model->select();

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

  public function campo_especifico_post()
  {
    $data = $this->input->post();

    error_log("WS Obras Campo Especifico");
    error_log("Campo: ".$data['campo']);
    error_log("Valor: ".$data['valor']);

    if(isset($data['campo']) && isset($data['valor']))
    {
      $data = $this->Obra_model->campo_especifico(false, array($data['campo'] => $data['valor']));

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
    else
    {
      $respuesta = array('error' => TRUE, 'msj' => "No fue posible recuperar listado de Obras por Cliente (Campos incompletos)!");
      $this->response($respuesta);
    }
  }
}
