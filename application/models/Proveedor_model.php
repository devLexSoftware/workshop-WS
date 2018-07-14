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
}
