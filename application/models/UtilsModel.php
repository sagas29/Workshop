<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UtilsModel extends CI_Model
{
    function begin()
    {
        $this->db->trans_begin();
    }
    function rollback()
    {
        $this->db->trans_rollback();
    }
    function commit()
    {
        $this->db->trans_commit();
    }
    function error()
    {
        $this->db->error();
    }
    function insert($table_name,$form_data)
    {
        // retrieve the keys of the array (column titles)
        $form_data2=array();
        $variable='';
        // retrieve the keys of the array (column titles)
        $fields = array_keys ( $form_data );
        // join as string fields and variables to insert
        $fieldss = implode ( ',', $fields );
        //$variables = implode ( "','", $form_data ); U+0027
        foreach($form_data as $variable){
            $var1=preg_match('/\x{27}/u', $variable);
            $var2=preg_match('/\x{22}/u', $variable);
            if($var1==true || $var2==true){
                $variable = addslashes($variable);
            }
            array_push($form_data2,$variable);
        }
        $variables = implode ( "','",$form_data2 );

        // build the query
        $sql = "INSERT INTO " . $table_name . "(" . $fieldss . ")";
        $sql .= "VALUES('" . $variables . "')";
        return $this->db->query($sql);
    }

    function update($table_name,$form_data,$where_clause)
    {
        // check for optional where clause
        $whereSQL = '';
        $form_data2=array();
        $variable='';
        if(!empty($where_clause))
        {
            // check to see if the 'where' keyword exists
            if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
            {
                // not found, add key word
                $whereSQL = " WHERE ".$where_clause;
            } else
            {
                $whereSQL = " ".trim($where_clause);
            }
        }
        // start the actual SQL statement
        $sql = "UPDATE ".$table_name." SET ";

        // loop and build the column /
        $sets = array();
        //begin modified
        foreach($form_data as $index=>$variable){
            $var1=preg_match('/\x{27}/u', $variable);
            $var2=preg_match('/\x{22}/u', $variable);
            if($var1==true || $var2==true){
                $variable = addslashes($variable);
            }
            $form_data2[$index] = $variable;
        }
        foreach ( $form_data2 as $column => $value ) {
            $sets [] = $column . " = '" . $value . "'";
        }
        $sql .= implode(', ', $sets);

        // append the where statement
        $sql .= $whereSQL;
        return $this->db->query($sql);
    }

    function delete($table_name, $where_clause='')
    {
        // check for optional where clause
        $whereSQL = '';
        if(!empty($where_clause))
        {
            // check to see if the 'where' keyword exists
            if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
            {
                // not found, add keyword
                $whereSQL = " WHERE ".$where_clause;
            } else
            {
                $whereSQL = " ".trim($where_clause);
            }
        }
        // build the query
        $sql = "DELETE FROM ".$table_name.$whereSQL;
        return $this->db->query($sql);
    }
}

/* End of file UtilsModel.php */