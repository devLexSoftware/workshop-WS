<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Cliente extends REST_Controller
{
  public function __construct()
  {
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Origin: *");

    parent::__construct();
    $this->load->model("Cliente_model");
  }

  public function select_get()
  {
    $data = $this->Cliente_model->select();

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

  public function registrar_cliente_post()
  {
    error_log("WS Registar Cliente");

    $data = json_decode(file_get_contents('php://input'), true);

    // error_log("clienteId: ".$data['clienteId']);
    // error_log("obraId: ".$data["obraId"]);
    // error_log("imgn: ".$data['imgn']);
    // error_log("PeriodoI: ".$data["periodoInicial"]);
    // error_log("PeriodoF: ".$data["periodoFinal"]);

    $dataInsert = array(
      "fechCreacion" => date("Y-m-d H:is"),
      "fechCreado" => date("Y-m-d H:is"),
      "usuCreacion" => "Móvil",
      "id" => NULL,
      "identificador" => $data["identificador"],
      "nombre" => $data["nombre"],
      "rfc" => $data["rfc"],
      "calle" => $data["calle"],
      "numExt" => $data["noExt"],
      "numInt" => $data["noInt"],
      "colonia" => $data["colonia"],
      "cp" => $data["cp"],
      "ciudad" => $data["ciudad"],
      "municipio" => $data["municipio"],
      "empresa" => $data["empresa"],
      "email" => $data["email"],
      "movil" => $data["movil"],
      "telefono" => $data["telefono"],
      "nota" => $data["nota"],
      "estado" => 0,
    );

    if ($this->Cliente_model->registrar_cliente($dataInsert))
    {
      error_log("Cliente Registrado");
      $respuesta = array('error' => FALSE, 'msj' => "Cliente Registrado");
    }
    else
    {
      error_log("Cliente NO Registrado");
      $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
    }

    $this->response($respuesta);
  }
}
