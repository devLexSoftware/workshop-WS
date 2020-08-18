<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avance_model extends CI_Model
{
    private $tabla = "detalles_obras";
    private $tabla2 = "fotos_detalles_obras";  

    function __construct()
    {
        parent::__construct();
    }

    public function select($json = false)
    {
        $queryResult = $this->db->get($this->tabla);
        error_log($this->db->last_query());

        if (!$queryResult)
        {
        error_log("ERROR SELECT PEDIDOS");
        return false;
        }
        else
        {
        if ($json)
        { return json_encode($queryResult->result()); }
        else
        { return $queryResult->result_array(); }
        }
    }

    public function campo_especifico($json = false, $params)
    {
        $this->db->select('deo.avance, deo.id, deo.periodoInicial, deo.periodoFinal, deo.semana, o.nombre');
        $this->db->from('obras o');
        $this->db->join('detalles_obras deo', 'deo.fk_obra = o.id');            

        if($params['fk_empleado'] != '')
        {
            $this->db->join('grupos_empleados ge', 'o.fk_grupo = ge.fk_grupo');            
            $this->db->where('ge.fk_empleado', $params['fk_empleado']);
        }    
        

        $queryResult = $this->db->get();

        if (!$queryResult)
        {
        error_log("ERROR SELECT Avances CAMPO ESPECIFICO");
        return false;
        }
        else
        {
        if ($json)
        { return json_encode($queryResult->result()); }
        else
        { return $queryResult->result_array(); }
        }
    }

    public function registrar_avance($data, $images)
    {
        error_log("REGISTRAR AVANCE");

        if ($this->db->insert($this->tabla, $data))
        {
            error_log("INSERT AVANCE: ".$this->db->last_query());
            $insert_id = $this->db->insert_id();

            if($insert_id != null && count($images) > 0)
            {                

                foreach ($images as $key => $value) 
                {
                    if($value != null || $value != "")
                    {
                        $dataImagen = array(
                            "fechCreacion" => date("Y-m-d H:i:s"),
                            "fechCreado" => date("Y-m-d H:i:s"),
                            "usuCreacion" => "Móvil",
                            "id" => null,
                            "semana" => $data["semana"],
                            "imagen" => $value,
                            "periodoInicial"=>$data["periodoInicial"],
                            "periodoFinal"=> $data["periodoFinal"],
                            "fk_detalle_obra"=> $insert_id,
                        );
                        $this->db->insert($this->tabla2, $dataImagen);
    
                    }                    
                }
            }

            return true;
        }
        else
        {
            error_log("INSERT Imagen: ".$this->db->last_query());
            return false;
        }
    }

//   public function registrar_pedido($data)
//   {
//     error_log("REGISTRAR PEDIDO");
//     if ($this->db->insert($this->tabla, $data))
//     {
//       error_log("INSERT PEDIDO: ".$this->db->last_query());
//       return true;
//     }
//     else
//     {
//       error_log("INSERT PEDIDO: ".$this->db->last_query());
//       return false;
//     }
//   }

//   public function actualizar_pedido($data)
//   {
//     error_log("ACTUALIZAR PEDIDO");
//     $this->db->where('id',$data["id"]);

//     if ($this->db->update($this->tabla, $data))
//     {
//       error_log("UPDATE PEDIDO: ".$this->db->last_query());
//       return true;
//     }
//     else
//     {
//       error_log("UPDATE PEDIDO: ".$this->db->last_query());
//       return false;
//     }
//   }

//  




  
}
