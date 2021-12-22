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
    $this->db->trans_start(); # Starting Transaction
    $this->db->trans_strict(false); # See Note 01. If you wish can remove as well

    if (isset($data['id']) && $data['id'] != '') {
      $this->db->where('id', $data['id']);
      $query = $this->db->update('business', $data);
      $insert_id = $data['id'];
    } else {
      $this->db->insert('business', $data);
      $insert_id = $this->db->insert_id();
    }

    $this->db->trans_complete(); # Completing transaction
    if ($this->db->trans_status() === false) {
      $this->db->trans_rollback();
      return false;
    } else {
      return $insert_id;
    }
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
    $this->db->select('business_employees.*, business.name AS business, business_role_credit.role as business_role, business_role_credit.credit as role_credit, default_role_credit.credit as default_credit, sum(case business_transactions.status when "PENDING" then business_transactions.cost else 0 end) as pending_credit, sum(case business_transactions.status when "OVERDUE" then business_transactions.cost else 0 end) as overdue_credit');
    $this->db->from('business_employees');
    $this->db->join('business', 'business_employees.business_id = business.id');
    $this->db->join('business_role_credit', 'business_employees.em_role_id = business_role_credit.id', 'left');
    $this->db->join('business_role_credit as default_role_credit', 'business_employees.business_id = default_role_credit.business_id AND default_role_credit.role = "Default"', 'left');
    $this->db->join('business_transactions', 'business_employees.id = business_transactions.emp_id', 'left');
    if ($id != "all") {
      $this->db->where('business_employees.business_id', $id);
    }
    $this->db->group_by('business_employees.id');
    $this->db->order_by('business_employees.business_id');
    $this->db->order_by('business_employees.em_role');

    $query = $this->db->get();
    return $query->result();
  }

  public function GetEmployeeById($id)
  {
    $this->db->select('business_employees.*, business.name AS business, business_role_credit.role as business_role, business_role_credit.credit as role_credit, default_role_credit.credit as default_credit, sum(case business_transactions.status when "PENDING" then business_transactions.cost else 0 end) as pending_credit, sum(case business_transactions.status when "OVERDUE" then business_transactions.cost else 0 end) as overdue_credit');
    $this->db->from('business_employees');
    $this->db->join('business', 'business_employees.business_id = business.id');
    $this->db->join('business_role_credit', 'business_employees.em_role_id = business_role_credit.id', 'left');
    $this->db->join('business_role_credit as default_role_credit', 'business_employees.business_id = default_role_credit.business_id AND default_role_credit.role = "Default"', 'left');
    $this->db->join('business_transactions', 'business_employees.id = business_transactions.emp_id', 'left');
    $this->db->where('business_employees.id', $id);
    $this->db->group_by('business_employees.id');
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
    $this->db->trans_start(); # Starting Transaction
    $this->db->trans_strict(false); # See Note 01. If you wish can remove as well

    if (isset($data['id']) && $data['id'] != '') {
      $this->db->where('id', $data['id']);
      $query = $this->db->update('business_employees', $data);
      $insert_id = $data['id'];
    } else {
      $this->db->insert('business_employees', $data);
      $insert_id = $this->db->insert_id();
    }

    $this->db->trans_complete(); # Completing transaction
    if ($this->db->trans_status() === false) {
      $this->db->trans_rollback();
      return false;
    } else {
      return $insert_id;
    }
  }

  public function update_employee($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('business_employees', $data);
  }

  public function delete_employee($id)
  {
    $this->db->select('id')->from('business_transactions');
    $this->db->where('emp_id', $id);
    if ($this->db->get()->num_rows() > 0) {
      $this->db->where('id', $id);
      $this->db->update('business_employees', array('status' => 'INACTIVE'));
    } else {
      $this->db->delete('business_employees', array('id' => $id));
    }
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

  public function getBusinessInfo($id = null)
  {

    $this->db->select('business.*, COUNT(`business_transactions`.`id`) trs_count, COUNT(DISTINCT `business_employees`.`id`) emp_count, active_employee_counts.active_count, sum(case business_transactions.status when "COMPLETE" then business_transactions.cost else 0 end) as completed_credit, sum(case business_transactions.status when "COMPLETE" then 1 else 0 end) as completed_count, sum(case business_transactions.status when "PENDING" then business_transactions.cost else 0 end) as pending_credit, sum(case business_transactions.status when "PENDING" then 1 else 0 end) as pending_count, sum(case business_transactions.status when "OVERDUE" then business_transactions.cost else 0 end) as overdue_credit, sum(case business_transactions.status when "OVERDUE" then 1 else 0 end) as overdue_count');
    $this->db->from('business');
    $this->db->join("(SELECT business_id, COUNT(id) AS active_count FROM business_employees WHERE STATUS= 'ACTIVE' GROUP BY business_id) as active_employee_counts", 'business.id = active_employee_counts.business_id', "left");
    $this->db->join('business_employees', 'business.id = business_employees.business_id', "left");
    $this->db->join('business_transactions', 'business_employees.id = business_transactions.emp_id', "left");
    if ($id != null) {
      $this->db->where('business.id', $id);
    }
    $this->db->group_by('business.id');

    $query = $this->db->get();
    if ($id != null) {
      return $query->row_array();
    } else {
      return $query->result_array();
    }
  }

  public function searchemployeebyFullText($searchterm, $business_id = null)
  {
    $this->db->select('business_employees.* ,business.name as business, business_role_credit.role as business_role, business_role_credit.credit as role_credit, default_role_credit.credit as default_credit, sum(case business_transactions.status when "PENDING" then business_transactions.cost else 0 end) as pending_credit, sum(case business_transactions.status when "OVERDUE" then business_transactions.cost else 0 end) as overdue_credit')->from('business_employees');
    $this->db->join('business', 'business.id = business_employees.business_id');
    $this->db->join('business_role_credit', 'business_employees.em_role_id = business_role_credit.id', 'left');
    $this->db->join('business_role_credit as default_role_credit', 'business_employees.business_id = default_role_credit.business_id AND default_role_credit.role = "Default"', 'left');
    $this->db->join('business_transactions', 'business_employees.id = business_transactions.emp_id', 'left');
    $this->db->where('business_employees.status', 'ACTIVE');
    if ($business_id != null) {
      $this->db->where('business_employees.business_id', $business_id);
    }
    $this->db->group_start();
    $this->db->like('business_employees.full_name', $searchterm);
    $this->db->or_like('business_employees.em_email', $searchterm);
    $this->db->or_like('business_employees.em_phone', $searchterm);
    $this->db->or_like('business.name', $searchterm);
    $this->db->or_like('business_employees.em_job_title', $searchterm);
    $this->db->or_like('business_employees.em_code', $searchterm);
    $this->db->group_end();
    $this->db->group_by('business_employees.id');
    $this->db->order_by('business.name');
    $this->db->order_by('business_employees.full_name');

    return $this->db->get()->result();
  }

  public function getRoles($id = null, $bybusiness = null)
  {
    $this->db->select('business_role_credit.*, business.name as business')->from('business_role_credit');
    $this->db->join('business', 'business_role_credit.business_id = business.id');

    if ($bybusiness) {
      $this->db->where('business_role_credit.business_id', $id);
      return $this->db->get()->result_array();
    }

    if ($id != null) {
      $this->db->where('business_role_credit.id', $id);
    }

    $this->db->order_by('business_role_credit.business_id');

    $query = $this->db->get();
    if ($id != null) {
      return $query->row_array();
    } else {
      return $query->result_array();
    }
  }

  public function Add_BusinessRole($data)
  {
    $this->db->trans_start(); # Starting Transaction
    $this->db->trans_strict(false); # See Note 01. If you wish can remove as well

    if (isset($data['id']) && $data['id'] != '') {
      $this->db->where('id', $data['id']);
      $query = $this->db->update('business_role_credit', $data);
      $insert_id = $data['id'];
    } else {
      $this->db->insert('business_role_credit', $data);
      $insert_id = $this->db->insert_id();
    }

    $this->db->trans_complete(); # Completing transaction
    if ($this->db->trans_status() === false) {
      $this->db->trans_rollback();
      return false;
    } else {
      return $insert_id;
    }
  }

  public function Delete_BusinessRole($id)
  {
    $this->db->delete('business_role_credit', array('id' => $id));
  }

  public function getBusinessRolebyRole($role, $business_id)
  {
    $this->db->select('business_role_credit.*')->from('business_role_credit');
    $this->db->where('business_role_credit.business_id', $business_id);
    $this->db->where('business_role_credit.role', $role);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      $business_role = $query->row_array();
      return $business_role['id'];
    } else {
      $data = array('role' => $role, 'business_id' => $business_id, 'credit' => 10);
      return $this->Add_BusinessRole($data);
    }
  }
}
