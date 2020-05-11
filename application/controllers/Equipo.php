<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Equipo extends REST_Controller
{
    public function __construct()
    {
      header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
      header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
      header("Access-Control-Allow-Origin: *");
  
      parent::__construct();
      $this->load->model("Equipo_model");
      $this->load->helper("url");
    }

    public function select_get()
    {
      $data = $this->Equipo_model->select();
  
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


    public function vw_info_grupos_campo_especifico_post()
    {
      $data = json_decode(file_get_contents('php://input'), true);

      $data = $this->Equipo_model->select_vw_info_equipos(false, $data['campo'], $data['valor']);

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




    public function registrar_modificar_equipo_post()
    {
      error_log("WS Registar Equipo");
      $data = json_decode(file_get_contents('php://input'), true);

      //---Actualizar
      if($data["id_equipo"] != null){
        $dataInsert = array(                
          "usuCreacion" => "Móvil",
          "id" => $data["id_equipo"],
          "nombre" => $data["nombreGrupo"],
          "nota" => $data["notaGrupo"],          
          "estado"=>0,
        );
                
          
        if ($this->Equipo_model->actualizar_equipo($dataInsert, $data["empleadosId"]))
        {
          error_log("Equipo Actualizado");
          $respuesta = array('error' => FALSE, 'msj' => "Equipo Registrado");
        }
        else
        {
          error_log("Equipo NO Actualizado");
          $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
        }
      }
      else{
        $dataInsert = array(                
          "usuCreacion" => "Móvil",
          "id" => null,
          "nombre" => $data["nombreGrupo"],
          "nota" => $data["notaGrupo"],          
          "estado"=>0,
        );

        if ($this->Equipo_model->registrar_equipo($dataInsert, $data["empleadosId"]))
        {
          error_log("Equipo Actualizado");
          $respuesta = array('error' => FALSE, 'msj' => "Equipo Registrado");
        }
        else
        {
          error_log("Equipo NO Actualizado");
          $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
        }
      }

      
    $this->response($respuesta);
              
    }




    public function eliminar_equipo_post()
    {       
      
      $data = json_decode(file_get_contents('php://input'), true);
  
      error_log("WS Equipo Eliminar");    
  
      if ($data['id'] != null)
      {
  
        $result = $this->Equipo_model->eliminar_equipo($data['id']);
  
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