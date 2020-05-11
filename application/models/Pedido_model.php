<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_model extends CI_Model
{
  private $tabla = "pedidos";
  // private $view = "vw_info_pedidos";

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

  public function registrar_pedido($data)
  {
    error_log("REGISTRAR PEDIDO");
    if ($this->db->insert($this->tabla, $data))
    {
      error_log("INSERT PEDIDO: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("INSERT PEDIDO: ".$this->db->last_query());
      return false;
    }
  }


  
}
