 <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Dashboard extends MY_Controller
    {

        function __construct()
        {
            parent::__construct();
            date_default_timezone_set('Asia/Dhaka');
            $this->load->database();
            $this->load->model('login_model');
            $this->load->model('dashboard_model');
            $this->load->model('employee_model');
            $this->load->model('settings_model');
            $this->load->model('notice_model');
            $this->load->model('project_model');
            $this->load->model('leave_model');
            $this->load->model('business_model');
            $this->load->model('transactions_model');
        }

        public function index()
        {
            #Redirect to Admin dashboard after authentication
            if ($this->session->userdata('user_login_access') == 1)
                redirect('dashboard/Dashboard');
            $data = array();
            #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
            $this->load->view('login');
        }
        function Dashboard()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $b_count = 0;
                $b_e_count = 0;
                $b_ae_count = 0;
                $b_tc_count = 0;
                $b_tc_price = 0;
                $b_tp_count = 0;
                $b_tp_price = 0;
                $b_to_count = 0;
                $b_to_price = 0;
                if ($this->session->userdata('user_business') == 'pharmacy') {
                    $businesses = $this->business_model->getBusinessInfo();

                    foreach ($businesses as $business) {
                        $b_count++;
                        $b_e_count += $business['emp_count'];
                        $b_ae_count += $business['active_count'];
                        $b_tc_count += $business['completed_count'];
                        $b_tc_price += $business['completed_credit'];
                        $b_tp_count += $business['pending_count'];
                        $b_tp_price += $business['pending_credit'];
                        $b_to_count += $business['overdue_count'];
                        $b_to_price += $business['overdue_credit'];
                    }
                } else {
                    $business_id = $this->session->userdata('user_business');
                    $business = $this->business_model->getBusinessInfo($business_id);
                    $data['business_name'] = $business['name'];
                    $b_count = 1;
                    $b_e_count += $business['emp_count'];
                    $b_ae_count += $business['active_count'];
                    $b_tc_count += $business['completed_count'];
                    $b_tc_price += $business['completed_credit'];
                    $b_tp_count += $business['pending_count'];
                    $b_tp_price += $business['pending_credit'];
                    $b_to_count += $business['overdue_count'];
                    $b_to_price += $business['overdue_credit'];
                }

                $data['business_count'] = $b_count;
                $data['employee_count'] = $b_e_count;
                $data['active_employee_count'] = $b_ae_count;
                $data['completed_transaction_count'] = $b_tc_count;
                $data['completed_transaction_price'] = $b_tc_price;
                $data['pending_transaction_count'] = $b_tp_count;
                $data['pending_transaction_price'] = $b_tp_price;
                $data['overdue_transaction_count'] = $b_to_count;
                $data['overdue_transaction_price'] = $b_to_price;

                $this->load->view('backend/dashboard', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function search_employees()
        {
            $searchterm = $this->input->post('search');
            if ($this->session->userdata('user_business') == 'pharmacy') {
                $employees = $this->business_model->searchemployeebyFullText($searchterm);
            } else {
                $business_id = $this->session->userdata('user_business');
                $employees = $this->business_model->searchemployeebyFullText($searchterm, $business_id);
            }
            // print_r($employees); exit;
            if (empty($employees)) {
                $result = array('success' => true, 'data' => 'Search results are empty');
                echo json_encode($result);
            } else {
                $tabledata = '';
                foreach ($employees as $employee) {
                    $credit = empty($employee->em_credit) ? (empty($employee->role_credit) ? $employee->default_credit : $employee->role_credit) : $employee->em_credit;
                    $used_credit = $employee->em_used_credit?$employee->em_used_credit : 0;
                    $available_credit = $credit - $used_credit;
                    $tabledata .= "<tr>
                        <td class='td_business_$employee->id'>$employee->business</td>
                        <td class='td_pin_$employee->id'>$employee->em_code</td>
                        <td class='td_name_$employee->id'>$employee->full_name</td>
                        <td class='td_email_$employee->id'>$employee->em_email</td>
                        <td class='td_phone_$employee->id'>$employee->em_phone</td>
                        <td class='td_jobtitle_$employee->id'>$employee->em_job_title</td>
                        <td class='td_credit_$employee->id'>$credit</td>
                        <td class='td_available_credit_$employee->id'>$available_credit</td>
                        <td class='text-center'>";

                    if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'SUPER ADMIN') {
                        if (($available_credit) > 0) {
                            $tabledata .= "<a href='javascript:;' onclick='creditshop($employee->id)' title='" . $this->lang->line('credit_shop') . "' class='btn btn-sm btn-info waves-effect waves-light m-1'><i class='fa fa-cart-plus'></i></a>";
                        } else {
                            $tabledata .= "<button disabled class='btn btn-sm btn-info waves-effect waves-light m-1'><i class='fa fa-shopping-cart'></i></button>";
                        }
                    }
                    $tabledata .= "<a href='" . base_url() . "transaction/transactions?emp_id=" . base64_encode($employee->id) . "' title='" . $this->lang->line('view_transactions') . "' class='btn btn-sm btn-info waves-effect waves-light m-1'><i class='fa fa-bars'></i></a>";
                    $tabledata .= "</td> </tr>";
                }
                $result = array('success' => true, 'data' => $tabledata);
                echo json_encode($result);
            }
        }

    }
