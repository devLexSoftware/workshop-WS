<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( APPPATH.'/libraries/REST_Controller.php' );
use Restserver\libraries\REST_Controller;

class Avance extends REST_Controller
{

    public function __construct()
    {
        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header("Access-Control-Allow-Origin: *");

        parent::__construct();
        $this->load->model("Avance_model");
        $this->load->helper("url");

    }

    public function select_get()
    {
        $data = $this->Avance_model->select();
    
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

    public function dias_registrados_post()
    {
      $data = $this->input->post();


      if(isset($data['fk_obra']))
      {
        $data = $this->Avance_model->dias_registrados(false, $data);
  
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

    public function campo_especifico_post()
    {
      $data = $this->input->post();

      error_log("WS Avance Campo Especifico");      
      // error_log("fk_empleado: ".$data['fk_empleado']);

      if(isset($data['campo']) && isset($data['valor']))
      {
        $data = $this->Avance_model->campo_especifico(false, array($data['campo'] => $data['valor']));
  
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
        $respuesta = array('error' => TRUE, 'msj' => "No fue posible recuperar listado de Avances por Cliente (Campos incompletos)!");
        $this->response($respuesta);
      }
    }    

    public function registrar_avance_post()
    {
      error_log("WS Registar Avance");

      $data = json_decode(file_get_contents('php://input'), true);
      
      error_log("fk_obra: ".$data["fk_obra"]);    
      error_log("PeriodoInicial: ".$data["periodoInicial"]);
      error_log("PeriodoFinal: ".$data["periodoFinal"]);
      error_log("Avance: ".$data["avance"]);
      error_log("Semana: ".$data["semana"]);


      $dataInsert = array(
        "fechCreacion" => date("Y-m-d H:i:s"),
        "fechCreado" => date("Y-m-d H:i:s"),
        "usuCreacion" => "Movíl",
        "id" => NULL,
        "avance" => $data["avance"],
        "semana" => $data["semana"],
        "periodoInicial" => date_format(date_create($data["periodoInicial"]), 'Y-m-d H:i:s'),
        "periodoFinal" => date_format(date_create($data["periodoFinal"]), 'Y-m-d H:i:s'),
        "comentario" => $data["comentario"],
        "fk_obra" => $data["fk_obra"]      
      );        

      if ($this->Avance_model->registrar_avance($dataInsert, $data["imagesArray"]))
      {
        error_log("Avance Registrad");
        $respuesta = array('error' => FALSE, 'msj' => "Avance Registrado");
      }
      else
      {
        error_log("Avance NO Registrado");
        $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
      }

      $this->response($respuesta);
    }

    public function registrar_modificar_avance_post()
    {
      error_log("WS Registar Compra");

      $data = json_decode(file_get_contents('php://input'), true);   

      if($data["id_avance"] != null)
      {
        $dataInsert = array(          
          "usuCreacion" => "Movíl",
          "id" => $data["id_avance"],
          "avance" => NULL,
          "semana" => $data["semana"],
          "periodoInicial" => $data["fechInicial"],
          // "periodoInicial" => date_format(date_create($data["periodoInicial"]), 'Y-m-d H:i:s'),
          // "periodoFinal" => date_format(date_create($data["periodoFinal"]), 'Y-m-d H:i:s'),
          "periodoFinal" => $data["fechFinal"],
          "comentario" => $data["descripcion"],
          "fk_obra" => $data["fk_obra"],
          "dia" => $data["dia"],
        );        
  
        if ($this->Avance_model->actualizar_avance($dataInsert, $data["imagenes"]))
        {
          error_log("Avance Registrad");
          $respuesta = array('error' => FALSE, 'msj' => "Avance Registrado");
        }
        else
        {
          error_log("Avance NO Registrado");
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
          "avance" => NULL,
          "semana" => $data["semana"],
          "periodoInicial" => $data["fechInicial"],
          // "periodoInicial" => date_format(date_create($data["periodoInicial"]), 'Y-m-d H:i:s'),
          // "periodoFinal" => date_format(date_create($data["periodoFinal"]), 'Y-m-d H:i:s'),
          "periodoFinal" => $data["fechFinal"],
          "comentario" => $data["descripcion"],
          "fk_obra" => $data["fk_obra"]  ,
          "dia" => $data["dia"],
        );        
  
        if ($this->Avance_model->registrar_avance($dataInsert, $data["imagenes"]))
        {
          error_log("Avance Registrad");
          $respuesta = array('error' => FALSE, 'msj' => "Avance Registrado");
        }
        else
        {
          error_log("Avance NO Registrado");
          $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
        }
      }

      $this->response($respuesta);
      
    }
    
    public function fotos_post()
    {
      $data = $this->input->post();

      error_log("WS Avance Campo Especifico");      
      // error_log("fk_empleado: ".$data['fk_empleado']);

      if(isset($data['campo']) && isset($data['valor']))
      {
        $data = $this->Avance_model->fotos(false, array($data['campo'] => $data['valor']));
  
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
        $respuesta = array('error' => TRUE, 'msj' => "No fue posible recuperar listado de Avances por Cliente (Campos incompletos)!");
        $this->response($respuesta);
      }
    }    

    public function eliminar_avance_post()
    {       
      
      $data = json_decode(file_get_contents('php://input'), true);

      error_log("WS Avance Eliminar");    

      if ($data['id'] != null)
      {

        $result = $this->Avance_model->eliminar_avance($data);

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
        $respuesta = array('error' => TRUE, 'msj' => "No fue posible eliminar el avance (Campos incompletos)!");
        $this->response($respuesta);
      }
    }

    

    // public function registrar_pedido_post()
    // {
    //   error_log("WS Registar Pedido");

    //   $data = json_decode(file_get_contents('php://input'), true);
      
    //   error_log("obraId: ".$data["fk_obra"]);    

    //   if($data["id"] == null)
    //   {

    //   }

    //   $dataInsert = array(
    //     "fechCreacion" => date("Y-m-d H:i:s"),
    //     "fechCreado" => date("Y-m-d H:i:s"),
    //     "usuCreacion" => "Movíl",
    //     "id" => NULL,
    //     "identificador" => NULL,
    //     "descripcion" => $data["descripcion"],      
    //     "frente" => $data["frente"],      
    //     "fk_obra" => $data['fk_obra'],      
    //     "estado" => $data['estatus'],      
    //     "estatus" => 0,      
    //   );

    //   if ($this->Pedido_model->registrar_pedido($dataInsert))
    //   {
    //     error_log("Pedido Registrado");
    //     $respuesta = array('error' => FALSE, 'msj' => "Pedido Registrado");
    //   }
    //   else
    //   {
    //     error_log("Pedido NO Registrada");
    //     $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
    //   }

    //   $this->response($respuesta);
    // }

    // public function registrar_modificar_pedido_post()
    // {

    //   error_log("WS Registar Cliente");

    //   $data = json_decode(file_get_contents('php://input'), true);

    //   $dataUpdate = array(        
    //     "usuCreacion" => "Admin",
    //     "id" => $data['id'],
    //     "estado" => $data['estado']
    //   );

    //   if ($this->Pedido_model->actualizar_pedido($dataUpdate))
    //   {
    //     error_log("Pedido Actualizado");
    //     $respuesta = array('error' => FALSE, 'msj' => "Se cambio el estatus de pedido");
    //   }
    //   else
    //   {
    //     error_log("Pedido NO Actualizado");
    //     $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
    //   }
    //   $this->response($respuesta);

    // }

    // public function campo_especifico_post()
    // {
    //   $data = $this->input->post();

    //   error_log("WS Pedidos Campo Especifico");
    //   error_log("Campo: ".$data['campo']);
    //   error_log("Valor: ".$data['valor']);

    //   if(isset($data['campo']) && isset($data['valor']))
    //   {
    //     $data = $this->Pedido_model->campo_especifico(false, $data);
  
    //     if (count($data) >= 0)
    //     {
    //       $respuesta = array('error' => FALSE, 'data' => $data);
    //       $this->response($respuesta);
    //     }
    //     else
    //     {
    //       $respuesta = array('error' => TRUE, 'msj' => "Ocurrio un error inesperado en la aplicación, favor de contactar a soporte");
    //       $this->response($respuesta);
    //     }
    //   }
    //   else
    //   {
    //     $respuesta = array('error' => TRUE, 'msj' => "No fue posible recuperar listado de Obras por Cliente (Campos incompletos)!");
    //     $this->response($respuesta);
    //   }
    // }    



}
