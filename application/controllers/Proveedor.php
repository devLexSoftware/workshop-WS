<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Proveedor extends REST_Controller
{
  public function __construct()
  {
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Origin: *");

    parent::__construct();
    $this->load->model("Proveedor_model");
  }

  public function select_get()
  {
    error_log("WS PROVEEDOR");
    $data = $this->Proveedor_model->select();

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

  public function registrar_proveedor_post()
  {
    error_log("WS Registar Proveedor");

    $data = json_decode(file_get_contents('php://input'), true);

    // error_log("identificador: ".$data["identificador"]);
    // error_log("empresa: ".$data["empresa"]);
    // error_log("proveedor: ".$data["proveedor"]);
    // error_log("descripcion: ".$data["descripcion"]);
    // error_log("rfc: ".$data["rfc"]);
    // error_log("importe: ".$data["importe"]);
    // error_log("unidad: ".$data["unidad"]);
    // error_log("contacto1: ".$data["contacto1"]);
    // error_log("contacto2: ".$data["contacto2"]);
    // error_log("email: ".$data["email"]);
    // error_log("direccion: ".$data["direccion"]);
    // error_log("comentario: ".$data["comentario"]);

    $dataInsert = array(
      "fechCreacion" => date("Y-m-d H:is"),
      "fechCreado" => date("Y-m-d H:is"),
      "usuCreacion" => "Móvil",
      "id" => NULL,
      "identificador" => $data["identificador"],
      "empresa" => $data["empresa"],
      "proveedor" => $data["proveedor"],
      "descripcion" => $data["descripcion"],
      "rfc" => $data["rfc"],
      "importe" => $data["importe"],
      "unidad" => $data["unidad"],
      "contacto1" => $data["contacto1"],
      "contacto2" => $data["contacto2"],
      "email" => $data["email"],
      "direccion" => $data["direccion"],
      "comentario" => $data["comentario"],
      "estado" => 0
    );

    if ($this->Proveedor_model->registrar_proveedor($dataInsert))
    {
      error_log("Proveedor Registrado");
      $respuesta = array('error' => FALSE, 'msj' => "Proveedor Registrado");
    }
    else
    {
      error_log("Proveedor NO Registrado");
      $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
    }

    $this->response($respuesta);
  }
}
