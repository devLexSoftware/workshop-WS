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
    $this->load->helper("url");

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

  public function registrar_modificar_compra_post()
  {
    error_log("WS Registar Compra");

    $data = json_decode(file_get_contents('php://input'), true);   

    if($data["id_compra"] != null)
    {
      $dataInsert = array(
        "fechCreacion" => date("Y-m-d H:i:s"),
        "fechCreado" => date("Y-m-d H:i:s"),
        "usuCreacion" => "Movíl",
        "id" => $data["id_compra"],
        "identificador" => null,
        "nombre" =>  null,
        "descripcion" => $data["descripcion"],      
        "fecha" => $data["fecha"],      
        // "fecha" => date_format(date_create($data["fechaCompra"]), 'd-m-Y'),
        "frente" => $data["frente"],     
        "semana" => $data["semana"],
        "numero" => NULL,
        "unidad" => $data["unidad"],
        "factura" => $data["factura"],
        "costo" => $data["costo"],
        "cantidad" => $data["cantidad"],
        "importe" => $data["importe"],
        "iva" => $data["iva"],
        "subtotal" => $data["subtotal"],
        "comentario" => $data["comentario"],
        "fk_proveedor" => $data["fk_proveedor"],
        "fk_obra" => $data['fk_obra'],
        "fk_clientes" => $data['fk_cliente'],
        "fk_contratista" => $data['fk_contratista'],
        "foto" => $data['foto'],
        "fechInicial" => $data['fechInicial'],
        "fechFinal" => $data['fechFinal'],
        "estado" => 0
      );
  
      if ($this->Compra_model->actualizar_compra($dataInsert))
      {
        error_log("Compra Actualizado");
        $respuesta = array('error' => FALSE, 'msj' => "Compra Actualizada");
      }
      else
      {
        error_log("Compra NO Actualizada");
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
        "identificador" => NULL,
        "nombre" =>  NULL,
        "descripcion" => $data["descripcion"],      
        "fecha" => $data["fecha"],      
        // "fecha" => date_format(date_create($data["fechaCompra"]), 'd-m-Y'),
        "frente" => $data["frente"],     
        "semana" => $data["semana"],
        "numero" => NULL,
        "unidad" => $data["unidad"],
        "factura" => $data["factura"],
        "costo" => $data["costo"],
        "cantidad" => $data["cantidad"],
        "importe" => $data["importe"],
        "iva" => $data["iva"],
        "subtotal" => $data["subtotal"],
        "comentario" => $data["comentario"],
        "fk_proveedor" => $data["fk_proveedor"],
        "fk_obra" => $data['fk_obra'],
        "fk_clientes" => $data['fk_cliente'],
        "fk_contratista" => $data['fk_contratista'],
        "foto" => $data['foto'],
        "fechInicial" => $data['fechInicial'],
        "fechFinal" => $data['fechFinal'],
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

  public function select_compras_obras_get()
  {
    $data = $this->Compra_model->select_compras_obras(false);
  
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

    error_log("WS Pedidos Campo Especifico");
    error_log("Campo: ".$data['campo']);
    error_log("Valor: ".$data['valor']);

    if(isset($data['campo']) && isset($data['valor']))
    {
      $data = $this->Compra_model->campo_especifico(false, array($data['campo'] => $data['valor'], "estado" => "0"));

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
      $respuesta = array('error' => TRUE, 'msj' => "No fue posible recuperar el listado de compras (Campos incompletos)!");
      $this->response($respuesta);
    }
  }  
}
