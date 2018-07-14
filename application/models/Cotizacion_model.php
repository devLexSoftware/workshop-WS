<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cotizacion_model extends CI_Model
{
  private $tabla = "cotizaciones";
  private $view = "vw_info_cotizaciones";

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
      error_log("ERROR SELECT COTIZACIONES");
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

  public function vw_info_cotizaciones_select($json = false)
  {
    $queryResult = $this->db->get($this->view);
    error_log($this->db->last_query());

    if (!$queryResult)
    {
      error_log("ERROR SELECT VW_INFO_COTIZACIONES");
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
