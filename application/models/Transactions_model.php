<?php

class Transactions_model extends CI_Model
{


  public function add($data)
  {

    $this->db->trans_start(); # Starting Transaction
    $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
    //=======================Code Start===========================
    if (isset($data['id']) && $data['id'] != '') {

      $this->db->where('id', $data['id']);
      $query = $this->db->update('business_transactions', $data);
      $insert_id = $data['id'];
    } else {
      $this->db->insert('business_transactions', $data);
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

  public function get($id = null)
  {
    $this->db->select('business_transactions.*, business_employees.full_name as em_name,business_employees.id as em_id,business_employees.em_code as PIN, business.name as business, buy_employee.first_name as buy_staff, pay_employee.first_name as pay_staff')->from('business_transactions');
    $this->db->join('business_employees', 'business_transactions.emp_id = business_employees.id');
    $this->db->join('business', 'business_employees.business_id = business.id');
    $this->db->join('employee as buy_employee', 'business_transactions.buy_staff_id = buy_employee.id');
    $this->db->join('employee as pay_employee', 'business_transactions.pay_staff_id = pay_employee.id', "left");

    if ($id != null) {
      $this->db->where('business_transactions.id', $id);
    }

    $query = $this->db->get();
    if ($id != null) {
      return $query->row_array();
    } else {
      return $query->result_array();
    }
  }

  public function getBusinessTransactions($business_id = null)
  {
    $this->db->select('business.id as business_id, business.name as business, sum(case business_transactions.status when "PENDING" then 1 else 0 end) as pending_count, count(business_transactions.id) as total_count, sum(case business_transactions.status when "PENDING" then business_transactions.cost else 0 end) as total_price');
    $this->db->from('business');
    $this->db->join('business_employees', 'business.id = business_employees.business_id', 'left');
    $this->db->join('business_transactions', 'business_employees.id = business_transactions.emp_id');
    $this->db->group_by('business.id');

    if ($business_id != null) {
      $this->db->where('business.id', $business_id);
    }

    $query = $this->db->get();
    if ($business_id != null) {
      return $query->row_array();
    } else {
      return $query->result_array();
    }
  }

  public function searchTansactions($array)
  {
    $this->db->select('business_transactions.*, business_employees.full_name as em_name,business_employees.id as em_id,business_employees.em_code as PIN, business.name as business, buy_employee.first_name as buy_staff, pay_employee.first_name as pay_staff')->from('business_transactions');
    $this->db->join('business_employees', 'business_transactions.emp_id = business_employees.id');
    $this->db->join('business', 'business_employees.business_id = business.id');
    $this->db->join('employee as buy_employee', 'business_transactions.buy_staff_id = buy_employee.id');
    $this->db->join('employee as pay_employee', 'business_transactions.pay_staff_id = pay_employee.id', "left");

    foreach($array as $key => $value) {
      if($key == 'from'){
        $this->db->where("business_transactions.buy_date >= $value");
      }
      if($key == 'to'){
        $this->db->where("business_transactions.buy_date <= $value");
      }
      if($key == 'business_id'){
        $this->db->where("business.id = $value");
      }
      if($key == 'emp_id'){
        $this->db->where("business_transactions.emp_id = $value");
      }
    }

    return $this->db->get()->result_array();
  }
}
