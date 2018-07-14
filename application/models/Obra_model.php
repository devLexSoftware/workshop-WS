<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Obra_model extends CI_Model
{
  private $tabla = "obras";

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
}
