<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleado_model extends CI_Model
{
  private $tabla = "empleados";

  function __construct()
  {
    parent::__construct();
  }

  public function select($json = false)
  {
    $this->db->where('estado',0);

    $queryResult = $this->db->get($this->tabla);
    error_log($this->db->last_query());

    if (!$queryResult)
    {
      error_log("ERROR SELECT EMPLEADOS");
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

  public function registrar_empleado($data)
  {
    if ($this->db->insert($this->tabla, $data))
    {
      error_log("INSERT EMPLEADO: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("INSERT EMPLEADO: ".$this->db->last_query());
      return false;
    }
  }

  public function actualizar_empleado($data)
  {
    error_log("ACTUALIZAR EMPLEADO");
    $this->db->where('id',$data["id"]);

    if ($this->db->update($this->tabla, $data))
    {
      error_log("UPDATE EMPLEADO: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("UPDATE EMPLEADO: ".$this->db->last_query());
      return false;
    }
  }

  public function eliminar_empleado($data)
  {
    error_log("BORRAR EMPLEADO");    

    $this->db->where('id', $data["id"]);

    if ($this->db->update($this->tabla, $data))
    {
      error_log("UPDATE EMPLEADO: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("UPDATE EMPLEADO: ".$this->db->last_query());
      return false;
    }
  }
}
