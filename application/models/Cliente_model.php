<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_model extends CI_Model
{
  private $tabla = "clientes";
  private $tabla2 = "users";

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

      $insert_id = $this->db->insert_id();

      // $data2 = array(
      //   "fechCreacion" => NULL,
      //   "fechCreado" => NULL,
      //   "usuCreacion" => "Móvil",
      //   "id" => NULL,
      //   "usuario" => $data["email"],
      //   "pass" => $data["movil"],
      //   "perfil" => "cliente",
      //   "fk_vinculada" => $insert_id
      // );

      // $result = $this->registrar_user($data2);

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


  public function registrar_user($data)
  {
    error_log("REGISTRAR USER");

    if ($this->db->insert($this->tabla2, $data))
    {
      error_log("INSERT USER: ".$this->db->last_query());      

      return true;
    }
    else
    {
      error_log("INSERT USER: ".$this->db->last_query());
      return false;
    }
  }
}
