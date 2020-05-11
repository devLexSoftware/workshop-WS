<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Empleado extends REST_Controller
{
  public function __construct()
  {
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Origin: *");

    parent::__construct();
    $this->load->model("Empleado_model");
  }

  public function select_get()
  {
    $data = $this->Empleado_model->select();

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

  public function registrar_modificar_empleado_post()
  {
    error_log("WS Registar Cliente");

    $data = json_decode(file_get_contents('php://input'), true);

    // error_log("clienteId: ".$data['clienteId']);
    // error_log("obraId: ".$data["obraId"]);
    // error_log("imgn: ".$data['imgn']);
    // error_log("PeriodoI: ".$data["periodoInicial"]);
    // error_log("PeriodoF: ".$data["periodoFinal"]);


    if($data["id_empleado"] != null)
    {
      $dataInsert = array(
        "fechCreacion" => date("Y-m-d H:is"),
        "fechCreado" => date("Y-m-d H:is"),
        "usuCreacion" => "Móvil",
        "id" => $data["id_empleado"],
        "identificador" => $data["identificador"],
        "nombre" => $data["nombre"],        
        "rfc" => $data["rfc"],
        "direccion" => $data["direccion"],
        "movil" => $data["movil"],
        "telefono" => $data["telefono"],
        "email" => $data["email"],
        "empresa" => $data["empresa"],
        "giro" => $data["giro"],
        "nssi" => $data["nssi"],
        "salario" => $data["salario"],
        "categoria" => $data["categoria"],
        "rol" => $data["rol"],
        "nota" => $data["nota"],
        "estado" => 0
      );
  
      if ($this->Empleado_model->actualizar_empleado($dataInsert))
      {
        error_log("Empleado Registrado");
        $respuesta = array('error' => FALSE, 'msj' => "Empleado Registrado");
      }
      else
      {
        error_log("Empleado NO Registrado");
        $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
      }
  
      $this->response($respuesta);
    }
    else
    {
      $dataInsert = array(
        "fechCreacion" => date("Y-m-d H:is"),
        "fechCreado" => date("Y-m-d H:is"),
        "usuCreacion" => "Móvil",
        "id" => null,
        "identificador" => $data["identificador"],
        "nombre" => $data["nombre"],        
        "rfc" => $data["rfc"],
        "direccion" => $data["direccion"],
        "movil" => $data["movil"],
        "telefono" => $data["telefono"],
        "email" => $data["email"],
        "empresa" => $data["empresa"],
        "giro" => $data["giro"],
        "nssi" => $data["nssi"],
        "salario" => $data["salario"],
        "categoria" => $data["categoria"],
        "rol" => $data["rol"],
        "nota" => $data["nota"],
        "estado" => 0
      );
  
      if ($this->Empleado_model->registrar_empleado($dataInsert))
      {
        error_log("Empleado Registrado");
        $respuesta = array('error' => FALSE, 'msj' => "Empleado Registrado");
      }
      else
      {
        error_log("Empleado NO Registrado");
        $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
      }
  
      $this->response($respuesta);
    }
  }

  public function eliminar_empleado_post()
  {       
    
    $data = json_decode(file_get_contents('php://input'), true);

    error_log("WS Empleado Eliminar");    

    if ($data['id'] != null)
    {

      $result = $this->Empleado_model->eliminar_empleado($data);

      if ($result == true)
      {
        $respuesta = array('error' => FALSE, 'data' => $result);
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
