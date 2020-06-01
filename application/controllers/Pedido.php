<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Pedido extends REST_Controller
{

    public function __construct()
    {
        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");

        parent::__construct();
        $this->load->model("Pedido_model");
        $this->load->helper("url");

    }

    public function select_get()
    {
        $data = $this->Pedido_model->select();
    
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

    

    public function registrar_pedido_post()
    {
      error_log("WS Registar Pedido");

      $data = json_decode(file_get_contents('php://input'), true);
      
      error_log("obraId: ".$data["fk_obra"]);    

      if($data["id"] == null)
      {

      }

      $dataInsert = array(
        "fechCreacion" => date("Y-m-d H:i:s"),
        "fechCreado" => date("Y-m-d H:i:s"),
        "usuCreacion" => "Movíl",
        "id" => NULL,
        "identificador" => NULL,
        "descripcion" => $data["descripcion"],      
        "frente" => $data["frente"],      
        "fk_obra" => $data['fk_obra'],      
        "estado" => $data['estatus'],      
        "estatus" => 0,      
      );

      if ($this->Pedido_model->registrar_pedido($dataInsert))
      {
        error_log("Pedido Registrado");
        $respuesta = array('error' => FALSE, 'msj' => "Pedido Registrado");
      }
      else
      {
        error_log("Pedido NO Registrada");
        $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
      }

      $this->response($respuesta);
    }

    public function registrar_modificar_pedido_post()
    {

      error_log("WS Registar Cliente");

      $data = json_decode(file_get_contents('php://input'), true);

      $dataUpdate = array(        
        "usuCreacion" => "Admin",
        "id" => $data['id'],
        "estado" => $data['estado']
      );

      if ($this->Pedido_model->actualizar_pedido($dataUpdate))
      {
        error_log("Pedido Actualizado");
        $respuesta = array('error' => FALSE, 'msj' => "Se cambio el estatus de pedido");
      }
      else
      {
        error_log("Pedido NO Actualizado");
        $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
      }
      $this->response($respuesta);

    }

    public function campo_especifico_post()
    {
      $data = $this->input->post();

      error_log("WS Pedidos Campo Especifico");
      error_log("Campo: ".$data['campo']);
      error_log("Valor: ".$data['valor']);

      if(isset($data['campo']) && isset($data['valor']))
      {
        $data = $this->Pedido_model->campo_especifico(false, $data);
  
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
