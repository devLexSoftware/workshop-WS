<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Obra_model extends CI_Model
{
  private $tabla = "obras";
  private $view = "vw_info_obras";
  

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
      error_log("ERROR SELECT OBRAS");
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
      error_log("ERROR SELECT OBRAS CAMPO ESPECIFICO");
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

  public function select_vw_info_obras($json = false)
  {
    $this->db->order_by("fechInicio_obra", "DESC");
    $this->db->where('estado',0);

    $queryResult = $this->db->get($this->view);
    // error_log($this->db->last_query());

    if (!$queryResult)
    {
      error_log("ERROR SELECT VW_INFO_OBRAS");
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

  public function registrar_obra($data)
  {
    error_log("REGISTRAR OBRA");

    if ($this->db->insert('obras', $data))
    {
      error_log("INSERT OBRA: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("INSERT OBRA: ".$this->db->last_query());
      return false;
    }
  }

  public function actualizar_obra($data)
  {
    error_log("ACTUALIZAR OBRA");
    $this->db->where('id',$data["id"]);

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

  public function eliminar_obra($data)
  {
    error_log("BORRAR OBRA");    

    $this->db->where('id', $data["id"]);

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

  public function select_obras_empleado($json = false, $params)
  {
    $this->db->select('o.id as id_obra, o.identificador as identificador_obra, o.nombre, o.fk_grupo');
    $this->db->from('obras o');    
    $this->db->join('grupos_empleados ge', 'ge.fk_grupo = o.fk_grupo');
    $this->db->where('ge.fk_empleado', $params);

    $queryResult = $this->db->get();

    // $queryResult = $this->db->get_where($this->tabla, $params);
    // error_log($this->db->last_query());

    if (!$queryResult)
    {
      error_log("ERROR SELECT OBRAS CAMPO ESPECIFICO");
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

}
