<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compra_model extends CI_Model
{
  private $tabla = "compras";
  private $view = "vw_info_compras";

  function __construct()
  {
    parent::__construct();
  }

  public function select($json = false)
  {
    $multipleWhere = ['estado' => 0];
    $this->db->where($multipleWhere);

    $queryResult = $this->db->get($this->tabla);
    error_log($this->db->last_query());
    

    if (!$queryResult)
    {
      error_log("ERROR SELECT COMPRAS");
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

  public function select_compras_obras($json = false)
  {

    $multipleWhere = ['c.estado' => 0];

    $this->db->select('count(c.fk_obra) as cantidad, o.nombre, o.id');
    $this->db->from('compras c');
    $this->db->join('obras o', 'c.fk_obra = o.id');    
    $this->db->where($multipleWhere);
    $this->db->group_by('c.fk_obra'); 
  
    $queryResult = $this->db->get();

    if (!$queryResult)
    {
      error_log("ERROR SELECT COMPRAS COUTN");
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

  public function select_vw_info_compras($json = false)
  {
    $this->db->order_by("fecha_compra", "DESC");
    $this->db->where('estado_compra',0);
    $queryResult = $this->db->get($this->view);
    // error_log($this->db->last_query());

    if (!$queryResult)
    {
      error_log("ERROR SELECT VW_INFO_COMPRAS");
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

  public function registrar_compra($data)
  {
    error_log("REGISTRAR COMPRA");
    if ($this->db->insert('compras', $data))
    {
      error_log("INSERT COMPRAS: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("INSERT COMPRAS: ".$this->db->last_query());
      return false;
    }
  }

  public function actualizar_compra($data)
  {
    error_log("ACTUALIZAR COMPRA");
    $this->db->where('id',$data["id"]);

    if ($this->db->update($this->tabla, $data))
    {
      error_log("UPDATE COMPRAS: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("UPDATE COMPRAS: ".$this->db->last_query());
      return false;
    }
  }

  public function eliminar_compra($data)
  {
    error_log("BORRAR COMPRA");    

    $this->db->where('id', $data["id"]);

    if ($this->db->update('compras', $data))
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
}
