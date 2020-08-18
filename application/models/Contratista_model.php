<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contratista_model extends CI_Model
{
    private $tabla = "contratistas";
    

    function __construct()
    {
        parent::__construct();
    }

    public function select($json = false)
    {
        $this->db->where("estado",0);                

        $queryResult = $this->db->get($this->tabla);
        error_log($this->db->last_query());

        if (!$queryResult)
        {
            error_log("ERROR SELECT CONTRATISTAS");
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