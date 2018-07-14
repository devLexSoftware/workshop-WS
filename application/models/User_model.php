<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $tabla = "users";

    function __construct()
    {
      parent::__construct();
    }

    public function select($json = false, $data)
    {
      $queryResult = $this->db->get_where($this->tabla, $data);
      error_log($this->db->last_query());

      if (!$queryResult)
      {
        error_log("ERROR SELECT USERS");
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
