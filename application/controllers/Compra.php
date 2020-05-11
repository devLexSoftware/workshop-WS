<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Compra extends REST_Controller
{
  public function __construct()
  {
    header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    header("Access-Control-Allow-Origin: *");

    parent::__construct();
    $this->load->model("Compra_model");
  }

  public function select_get()
  {
    $data = $this->Compra_model->select();

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

  public function get_compras_order_desc_get()
  {
    $data = $this->Compra_model->select_vw_info_compras();

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

  public function registrar_compra_post()
  {
    error_log("WS Registar Compra");

    $data = json_decode(file_get_contents('php://input'), true);

    error_log("clienteId: ".$data['clienteId']);
    error_log("obraId: ".$data["obraId"]);
    error_log("imgn: ".$data['imgn']);
    error_log("PeriodoI: ".$data["periodoInicial"]);
    error_log("PeriodoF: ".$data["periodoFinal"]);

    $dataInsert = array(
      "fechCreacion" => date("Y-m-d H:i:s"),
      "fechCreado" => date("Y-m-d H:i:s"),
      "usuCreacion" => "Movíl",
      "id" => NULL,
      "identificador" => null,
      "nombre" =>  null,
      "descripcion" => $data["descripcion"],      
      "fecha" => date_format(date_create($data["fechaCompra"]), 'Y-m-d H:i:s'),
      "frente" => NULL,
      "semana" => NULL,
      "numero" => NULL,
      "unidad" => NULL,
      "factura" => $data["factura"],
      "costo" => NULL,
      "cantidad" => $data["cantidad"],
      "importe" => $data["importe"],
      "iva" => $data["iva"],
      "subtotal" => $data["subtotal"],
      "comentario" => null,
      "fk_proveedor" => $data["proveedorId"],
      "fk_obra" => $data['obraId'],
      "fk_clientes" => $data['clienteId'],
      "foto" => $data['imgn'],
      "fechInicial" => date_format(date_create($data["periodoInicial"]), 'Y-m-d H:i:s'),
      "fechFinal" => null,
      "estado" => 0
    );

    if ($this->Compra_model->registrar_compra($dataInsert))
    {
      error_log("Compra Registrada");
      $respuesta = array('error' => FALSE, 'msj' => "Compra Registrada");
    }
    else
    {
      error_log("Compra NO Registrada");
      $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
    }

    $this->response($respuesta);
  }

  public function eliminar_compra_post()
  {       
    
    $data = json_decode(file_get_contents('php://input'), true);
    error_log("WS Compras Eliminar");    
    if ($data['id'] != null)
    {

      $result = $this->Compra_model->eliminar_compra($data);
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
