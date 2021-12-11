<?php

class Business_model extends CI_Model
{


  function __consturct()
  {
    parent::__construct();
  }
  public function getAll()
  {
    $query = $this->db->get('business');
    $result = $query->result();
    return $result;
  }
  public function Add_Business($data)
  {
    $this->db->insert('business', $data);
  }

  public function Delete_Business($id)
  {
    $this->db->delete('business', array('id' => $id));
  }

  public function getById($id)
  {
    $sql    = "SELECT * FROM `business` WHERE `id`='$id'";
    $query  = $this->db->query($sql);
    $result = $query->row();
    return $result;
  }

  public function update_Business($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('business', $data);
  }


  public function GetEmployeeByBusinessId($id)
  {
    $this->db->select('business_employees.*, business.name AS business')->from('business_employees');
    $this->db->join('business', 'business_employees.business_id = business.id');
    if ($id != "all") {
      $this->db->where('business_employees.business_id', $id);
    }

    $this->db->order_by('business_employees.business_id');
    $this->db->order_by('business_employees.em_role');

    $query = $this->db->get();
    return $query->result();
  }

  public function GetEmployeeById($id)
  {
    $this->db->select('business_employees.*, business.name AS business')->from('business_employees');
    $this->db->join('business', 'business_employees.business_id = business.id');
    $this->db->where('business_employees.id', $id);
    $query = $this->db->get();
    return $query->row();
  }

  public function GetperAddress($id)
  {
    $sql = "SELECT * FROM `business_address`
    WHERE `emp_id`='$id' AND `type`='Permanent'";
    $query = $this->db->query($sql);
    $result = $query->row();
    return $result;
  }

  public function GetpreAddress($id)
  {
    $sql = "SELECT * FROM `business_address`
    WHERE `emp_id`='$id' AND `type`='Present'";
    $query = $this->db->query($sql);
    $result = $query->row();
    return $result;
  }

  public function is_email_exists($email)
  {
    $sql = "SELECT `id`,`em_email` FROM `business_employees`
        WHERE `em_email`='$email'";
    $result = $this->db->query($sql);
    if ($result->row()) {
      return $result->row();
    } else {
      return false;
    }
  }

  public function add_employee($data)
  {
    $this->db->insert('business_employees', $data);
  }

  public function update_employee($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('business_employees', $data);
  }

  public function add_employee_address($data)
  {
    $this->db->insert('business_address', $data);
  }

  public function update_employee_address($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('business_address', $data);
  }

  public function get_businessinfo(){
    $this->db->select('business.id, business.name, count(business_employees.id) employees');
    $this->db->from('business');
    $this->db->join('business_employees', 'business.id = business_employees.business_id AND business_employees.status = "ACTIVE"', "left");
    $this->db->group_by('business.id');
    return $this->db->get()->result_array();
  }


  public function searchemployeebyFullText($searchterm)
    {
        $this->db->select('business_employees.* ,business.name as business')->from('business_employees');
        $this->db->join('business', 'business.id = business_employees.business_id');
        $this->db->where('business_employees.status', 'ACTIVE');
        $this->db->group_start();
        $this->db->like('business_employees.full_name', $searchterm);
        $this->db->or_like('business_employees.em_email', $searchterm);
        $this->db->or_like('business_employees.em_phone', $searchterm);
        $this->db->or_like('business.name', $searchterm);
        $this->db->or_like('business_employees.em_job_title', $searchterm);
        $this->db->or_like('business_employees.em_code', $searchterm);
        $this->db->group_end();
        $this->db->order_by('business.name');
        $this->db->order_by('business_employees.full_name');

        return $this->db->get()->result();
    }


}
