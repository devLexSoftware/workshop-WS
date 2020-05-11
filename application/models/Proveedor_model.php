<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedor_model extends CI_Model
{
  private $tabla = "proveedores";

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
      error_log("ERROR SELECT PROVEEDORES");
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

  public function registrar_proveedor($data)
  {
    if ($this->db->insert($this->tabla, $data))
    {
      error_log("INSERT PROVEEDOR: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("INSERT PROVEEDOR: ".$this->db->last_query());
      return false;
    }
  }

  public function actualizar_proveedor($data)
  {
    error_log("ACTUALIZAR PROVEEDOR");
    $this->db->where('id',$data["id"]);

    if ($this->db->update($this->tabla, $data))
    {
      error_log("UPDATE CLIENTE: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("UPDATE CLIENTE: ".$this->db->last_query());
      return false;
    }
  }

  public function eliminar_proveedor($data)
  {
    error_log("BORRAR PROVEEDOR");    

    $this->db->where('id', $data["id"]);

    if ($this->db->update($this->tabla, $data))
    {
      error_log("UPDATE PROVEEDOR: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("UPDATE PROVEEDOR: ".$this->db->last_query());
      return false;
    }
  }
}
