<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Equipo_model extends CI_Model
{
    private $tabla = "grupos";
    private $tablaJoin = "grupos_empleados";
    private $view = "vw_info_grupos";    


    function __construct()
    {
        parent::__construct();
    }

    public function select($json = false)
    {
        $this->db->where("estado",0);                

        $queryResult = $this->db->get($this->tabla);
        error_log($this->db->last_query());

        if (!$queryResult)
        {
            error_log("ERROR SELECT GRUPOS");
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

    public function select_vw_info_equipos($json, $campo, $valor)
    {
        $this->db->where($campo,$valor);                
    
        $queryResult = $this->db->get($this->view);
        // error_log($this->db->last_query());
    
        if (!$queryResult)
        {
          error_log("ERROR SELECT VW_INFO_ESTADO");
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

    public function registrar_equipo($data, $empleados)
    {
        error_log("REGISTRAR EQUIPO");

        if ($this->db->insert($this->tabla, $data))
        {
            error_log("INSERT EQUIPO: ".$this->db->last_query());
            $insert_id = $this->db->insert_id();

            if($insert_id != null && count($empleados) > 0)
            {

                //---Borrar
                $result = $this->borrar_empleados($data["id"]);

                foreach ($empleados as $key => $value) 
                {
                    $dataEmpleado = array(
                        "usuCreacion" => "Móvil",
                        "id" => null,
                        "fk_grupo" => $insert_id,
                        "fk_empleado" => $value,
                        "estado"=>0,
                    );
                    $this->db->insert($this->tablaJoin, $dataEmpleado);

                }
            }

            return true;
        }
        else
        {
            error_log("INSERT EQUIPO: ".$this->db->last_query());
            return false;
        }
    }

    public function actualizar_equipo($data, $empleados)
    {
        error_log("ACTUALIZAR EQUIPO");
        $this->db->where('id',$data["id"]);

        if ($this->db->update($this->tabla, $data))
        {
            error_log("UPDATE EQUIPO: ".$this->db->last_query());            
            if(count($empleados) > 0)
            {

                //---Borrar
                $result = $this->borrar_empleados($data["id"]);

                foreach ($empleados as $key => $value) 
                {
                    $dataEmpleado = array(
                        "usuCreacion" => "Móvil",
                        "id" => null,
                        "fk_grupo" => $data["id"],
                        "fk_empleado" => $value,
                        "estado"=>0,
                    );
                    $this->db->insert($this->tablaJoin, $dataEmpleado);

                }
            }

            return true;
        }
        else
        {
            error_log("UPDATE EQUIPO: ".$this->db->last_query());
            return false;
        }
    }


    public function borrar_empleados($id)
    {
        error_log("BORRAR EQUIPOS");
        $this->db->where('fk_grupo', $id);

        if ($this->db->delete($this->tablaJoin))
        {
            error_log("DELETE EMPLEADOS: ".$this->db->last_query());            
            return true;
        }
        else
        {
            error_log("DELETE EMPLEADOS: ".$this->db->last_query());
            return false;
        }
    }

    public function eliminar_equipo($id)
    {

        //--Cambiar fk_grupo por default
        $borrar = $this->cambiar_equipo_obra($id);

        if($borrar == true)
        {
            $result = $this->borrar_empleados($id);
            error_log("BORRAR EQUIPOS");
            $this->db->where('id', $id);        
            if ($this->db->delete($this->tabla))
            {            
                error_log("DELETE EMPLEADOS: ".$this->db->last_query());            
                return true;
            }
            else
            {
                error_log("DELETE EMPLEADOS: ".$this->db->last_query());
                return false;
            }
        }
        else
        {
            error_log("DELETE EMPLEADOS: ".$this->db->last_query());
                return false;
        }
        
    }

    public function cambiar_equipo_obra($id)
    {
        error_log("BORRAR OBRA");    

        $this->db->where('fk_grupo', $id);

        $data = array(
            "fk_grupo" => "10",            
        );

        if ($this->db->update('obras', $data))
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