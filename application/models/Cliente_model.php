<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_model extends CI_Model
{
  private $tabla = "clientes";

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
      error_log("ERROR SELECT CLIENTES");
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

  public function registrar_cliente($data)
  {
    error_log("REGISTRAR CLIENTE");

    if ($this->db->insert('clientes', $data))
    {
      error_log("INSERT CLIENTE: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("INSERT CLIENTE: ".$this->db->last_query());
      return false;
    }
  }

  public function actualizar_cliente($data)
  {
    error_log("ACTUALIZAR CLIENTE");
    $this->db->where('id',$data["id"]);

    if ($this->db->update('clientes', $data))
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

  public function eliminar_cliente($data)
  {
    error_log("BORRAR CLIENTE");    

    $this->db->where('id', $data["id"]);

    if ($this->db->update('clientes', $data))
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
}
