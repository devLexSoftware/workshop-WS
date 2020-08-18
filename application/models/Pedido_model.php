<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_model extends CI_Model
{
  private $tabla = "pedidos";
  private $tabla2 = "obras";
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

  public function select_pedidos_obras($json = false)
  {

    $multipleWhere = ['p.estatus' => 0];

    $this->db->select('count(p.fk_obra) as cantidad, o.nombre, o.id');
    $this->db->from('pedidos p');
    $this->db->join('obras o', 'p.fk_obra = o.id');    
    $this->db->where($multipleWhere);
    $this->db->group_by('p.fk_obra'); 
  
    $queryResult = $this->db->get();

    if (!$queryResult)
    {
      error_log("ERROR SELECT PEDIDOS COUTN");
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

  public function actualizar_pedido($data)
  {
    error_log("ACTUALIZAR PEDIDO");
    $this->db->where('id',$data["id"]);

    if ($this->db->update($this->tabla, $data))
    {
      error_log("UPDATE PEDIDO: ".$this->db->last_query());
      return true;
    }
    else
    {
      error_log("UPDATE PEDIDO: ".$this->db->last_query());
      return false;
    }
  }

  public function campo_especifico($json = false, $params)
  {
    $queryResult = $this->db->get_where($this->tabla, $params);
    error_log($this->db->last_query());

    if (!$queryResult)
    {
      error_log("ERROR SELECT PEDIDOS CAMPO ESPECIFICO");
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


  // public function campo_especifico($json = false, $params)
  // {
  //   $this->db->select('p.id, p.identificador, p.fk_obra, p.frente, p.descripcion, p.estado, o.nombre, p.usuCreacion, p.fechCreacion');
  //   $this->db->from('pedidos p');
  //   $this->db->join('obras o', 'p.fk_obra = o.id');
  //   if($params['campo'] == 'empleado')
  //   {
  //     $this->db->join('grupos_empleados ge', 'ge.fk_grupo = o.fk_grupo');
  //     $this->db->where('ge.fk_empleado', $params['valor']);
  //   }

    

  //   $queryResult = $this->db->get();

  //   if (!$queryResult)
  //   {
  //     error_log("ERROR SELECT OBRAS CAMPO ESPECIFICO");
  //     return false;
  //   }
  //   else
  //   {
  //     if ($json)
  //     { return json_encode($queryResult->result()); }
  //     else
  //     { return $queryResult->result_array(); }
  //   }
  // }




  
}
