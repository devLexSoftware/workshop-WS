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

    public function dias_registrados($json = false, $params)
    {
        $multipleWhere = ['periodoInicial' => $params['fechInicial'], 'periodoFinal' => $params['fechFinal'], 'fk_obra' => $params['fk_obra']];

        $this->db->select('dia, semana');
        $this->db->from('detalles_obras');        
        $this->db->where($multipleWhere);            
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

    public function campo_especifico($json = false, $params)
    {       
        $queryResult = $this->db->get_where($this->tabla, $params);
        error_log($this->db->last_query());

        if (!$queryResult)
        {
            error_log("ERROR SELECT COMPRAS CAMPO ESPECIFICO");
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

    public function fotos($json = false, $params)
    {
        $queryResult = $this->db->get_where($this->tabla2, $params);
        error_log($this->db->last_query());

        if (!$queryResult)
        {
            error_log("ERROR SELECT COMPRAS CAMPO ESPECIFICO");
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
                            "id" => NULL,
                            "semana" => $data["semana"],
                            "imagen" => $value,
                            "periodoInicial"=> NULL,
                            "periodoFinal"=> NULL,
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

    public function actualizar_avance($data, $images)
    {
        error_log("REGISTRAR AVANCE");

        $this->db->where('id',$data["id"]);

        if ($this->db->update($this->tabla, $data))
        {
            error_log("INSERT AVANCE: ".$this->db->last_query());            

            if( count($images) > 0)
            {                

                $result = $this->borrar_foto($data["id"]);

                foreach ($images as $key => $value) 
                {
                    if($value != null || $value != "")
                    {
                        $dataImagen = array(
                            "fechCreacion" => date("Y-m-d H:i:s"),
                            "fechCreado" => date("Y-m-d H:i:s"),
                            "usuCreacion" => "Móvil",
                            "id" => NULL,
                            "semana" => $data["semana"],
                            "imagen" => $value,
                            "periodoInicial"=> NULL,
                            "periodoFinal"=> NULL,
                            "fk_detalle_obra"=> $data["id"],
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

    public function borrar_foto($data)
    {
        error_log("BORRAR COMPRA");    

        $this->db->where('fk_detalle_obra', $data);

        if ($this->db->delete($this->tabla2))
        {
            error_log("UPDATE COMPRA: ".$this->db->last_query());
            return true;
        }
        else
        {
            error_log("UPDATE COMPRA: ".$this->db->last_query());
            return false;
        }
    }

    public function eliminar_avance($data)
    {
      error_log("BORRAR OBRA");    
      $result = $this->borrar_foto($data["id"]);
  
      $this->db->where('id', $data["id"]);

      if ($this->db->delete($this->tabla))
      {
        error_log("UPDATE OBRA: ".$this->db->last_query());
        return true;
      }
      else
      {
        error_log("UPDATE OBRA: ".$this->db->last_query());
        return false;
      }
    }



  
}
