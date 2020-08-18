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

    public function registrar_modificar_pedido_post()
    {
      error_log("WS Registar Pedido");

      $data = json_decode(file_get_contents('php://input'), true);
      
      // error_log("obraId: ".$data["fk_obra"]);    

      if($data["id"] != null)
      {
        $dataInsert = array(          
          "usuCreacion" => "Movíl",
          "id" => $data["id"],      
          "identificador" => $data["identificador"],      
          "descripcion" => $data["descripcion"],      
          "frente" => $data["frente"],      
          "fk_obra" => $data['fk_obra'],      
          "estado" => $data['estado'],      
          "estatus" => 0,      
        );
        if ($this->Pedido_model->actualizar_pedido($dataInsert))
        {
          error_log("Pedido Actualizado");
          $respuesta = array('error' => FALSE, 'msj' => "Pedido Actualizado");
        }
        else
        {
          error_log("Pedido NO Actualizado");
          $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
        }
      }
      else
      {
        $dataInsert = array(          
          "fechCreacion" => date("Y-m-d H:i:s"),
          "fechCreado" => date("Y-m-d H:i:s"),
          "usuCreacion" => "Movíl",
          "id" => NULL,      
          "identificador" => $data["identificador"],      
          "descripcion" => $data["descripcion"],      
          "frente" => $data["frente"],      
          "fk_obra" => $data['fk_obra'],      
          "estado" => $data['estado'],      
          "estatus" => 0,  
        );

        if ($this->Pedido_model->registrar_pedido($dataInsert))
        {
          error_log("Pedido Registrado");
          $respuesta = array('error' => FALSE, 'msj' => "Se Registro el Pedido");
        }
        else
        {
          error_log("Pedido NO Registrado");
          $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
        }
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
        $data = $this->Pedido_model->campo_especifico(false, array($data['campo'] => $data['valor']));
  
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
        $respuesta = array('error' => TRUE, 'msj' => "No fue posible recuperar el listado de pedidos (Campos incompletos)!");
        $this->response($respuesta);
      }
    }    

    public function select_pedidos_obras_get()
    {
      $data = $this->Pedido_model->select_pedidos_obras(false);
    
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
