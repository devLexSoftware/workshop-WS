<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frente_model extends CI_Model
{
  private $tabla = "frentes";
//   private $view = "vw_info_obras";
  

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
      error_log("ERROR SELECT OBRFRENTESAS");
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