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

  public function vw_info_obras_select_get()
  {
    $data = $this->Obra_model->select_vw_info_obras();

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

  public function registrar_modificar_obra_post()
  {
    error_log("WS Registar Cliente");

    $data = json_decode(file_get_contents('php://input'), true);

    if($data["id_obra"] != null){
      $dataInsert = array(                
        "usuCreacion" => "Móvil",
        "id" => $data["id_obra"],
        "identificador" => $data["identificador"],
        "nombre" => $data["nombre"],
        "calle" => $data["calle"],
        "numExt" => $data["numExt"],
        "numInt" => $data["numInt"],
        "colonia" => $data["colonia"],
        "cp" => $data["cp"],
        "ciudad" => $data["ciudad"],
        "municipio" => $data["municipio"],
        "fechInicio" => $data["fechInicio"],
        "fechFin" => $data["fechFin"],
        "avance" => $data["avance"],
        "comentario" => $data["comentario"],
        "fk_clientes" => $data["fk_clientes"],
        "fk_grupo" => $data["fk_grupo"],
        "estado"=>0,
      );

      if ($this->Obra_model->actualizar_obra($dataInsert))
      {
        error_log("Obra Actualizada");
        $respuesta = array('error' => FALSE, 'msj' => "Obra Registrado");
      }
      else
      {
        error_log("Obra NO Actualizada");
        $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
      }
    }
    
    else{
      $dataInsert = array(
        "fechCreacion" => date("Y-m-d H:is"),
        "fechCreado" => date("Y-m-d H:is"),
        "usuCreacion" => "Móvil",
        "id" => null,
        "identificador" => $data["identificador"],
        "nombre" => $data["nombre"],
        "calle" => $data["calle"],
        "numExt" => $data["numExt"],
        "numInt" => $data["numInt"],
        "colonia" => $data["colonia"],
        "cp" => $data["cp"],
        "ciudad" => $data["ciudad"],
        "municipio" => $data["municipio"],
        "fechInicio" => $data["fechInicio"],
        "fechFin" => $data["fechFin"],
        "avance" => $data["avance"],
        "comentario" => $data["comentario"],
        "fk_clientes" => $data["fk_clientes"],
        "fk_grupo" => $data["fk_grupo"],
        "estado" => 0,
      );

      if ($this->Obra_model->registrar_obra($dataInsert))
      {
        error_log("Obra Registrado");
        $respuesta = array('error' => FALSE, 'msj' => "Obra Registrado");
      }
      else
      {
        error_log("Obra NO Registrado");
        $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
      }

    }
    $this->response($respuesta);
  }


  public function eliminar_obra_post()
  {       
    
    $data = json_decode(file_get_contents('php://input'), true);

    error_log("WS Obras Eliminar");    

    if ($data['id'] != null)
    {

      $result = $this->Obra_model->eliminar_obra($data);

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

  public function select_obras_empleado_post()
    {
      $data = $this->input->post();

      error_log("WS Obras Campo Especifico");
      error_log("Campo: ".$data['campo']);
      error_log("Valor: ".$data['valor']);

      if(isset($data['campo']) && isset($data['valor']))
      {
        $data = $this->Obra_model->select_obras_empleado(false, $data['valor']);
  
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
