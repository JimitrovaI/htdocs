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
                    $tabledata .= "<tr>
                        <td class='td_business_$employee->id'>$employee->business</td>
                        <td class='td_pin_$employee->id'>$employee->em_code</td>
                        <td class='td_name_$employee->id'>$employee->full_name</td>
                        <td class='td_email_$employee->id'>$employee->em_email</td>
                        <td class='td_phone_$employee->id'>$employee->em_phone</td>
                        <td class='td_jobtitle_$employee->id'>$employee->em_job_title</td>
                        <td class='td_credit_$employee->id'>$credit</td>
                        <td class='td_pending_credit_$employee->id'>$employee->pending_credit</td>
                        <td class='text-center'>";

                    if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'SUPER ADMIN') {
                        if (($credit - $employee->pending_credit) > 0) {
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

        function addcreditshop()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $buy_staff_id = $this->session->userdata('staff_id');
                $emp_id = $this->input->post('emp_id');
                $details = $this->input->post('details');
                $buy_date = $this->input->post('buy_date');
                $cost = $this->input->post('cost');

                $this->form_validation->set_error_delimiters();
                $this->form_validation->set_rules('emp_id', $this->lang->line('employee'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('details', $this->lang->line('details'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('cost', $this->lang->line('prices'), 'trim|required|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    $response = array('error' => 1, 'msg' => validation_errors());
                    echo json_encode($response);
                } else {
                    if (isset($_FILES['bill']) && !empty($_FILES['bill']['name'])) {
                        $uploaddir = './assets/images/bills/';
                        if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                            die("Error creating folder " . base_url() . $uploaddir);
                        }

                        $image_name = str_replace(" ", "", $emp_id) . date("YmdHis");

                        $config = array(
                            'file_name' => $image_name,
                            'upload_path' => $uploaddir,
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'overwrite' => False,
                            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        );

                        $this->load->library('Upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('bill')) {
                            $response = array('error' => 1, 'msg' => $this->upload->display_errors());
                            echo json_encode($response);
                            return;
                        } else {
                            $path = $this->upload->data();
                            $bill_url = $path['file_name'];
                            $data = array(
                                'emp_id' => $emp_id,
                                'details' => $details,
                                'cost' => $cost,
                                'bill' => $bill_url,
                                'buy_staff_id' => $buy_staff_id,
                            );

                            if (!empty($buy_date)) {
                                $buy_date = strtotime($buy_date);
                                $buy_date = date('Y-m-d', $buy_date);
                                $data['buy_date'] = $buy_date;
                            }

                            $success = $this->transactions_model->add($data);
                            if($success){
                                $employeeProfile = $this->business_model->GetEmployeeById($emp_id);
                                $employee_availablecredit = empty($employeeProfile->em_credit) ? (!empty($employeeProfile->em_role_id)?$employeeProfile->role_credit: $employeeProfile->detault_credit) :$employeeProfile->em_credit;
                                $employee_credit = $employee_availablecredit - $employeeProfile->pending_credit;
                                $buy_time = date('Y-m-d H:i');
                                $pharmacist = $this->employee_model->get_by_id($buy_staff_id);
                                // $toemail = $employeeProfile->em_email;
                                $toemail = 'vadim.kim2022@gmail.com';
                                $subject = "Purchased with Credit";
                                $content = "You have purchased some pharms [details: $details] from our Pharmacy with your company credit($cost) at $buy_time. <br>";
                                $content .= "Now your reamined credit is $employee_credit for this term. <br>";
                                $content .= "<b>Pharmacist profile</b> <br>";
                                $content .= "Name   : $pharmacist->first_name $pharmacist->last_name <br>";
                                $content .= "Phone  : $pharmacist->em_phone <br>";
                                $content .= "Email  : $pharmacist->em_phone <br>";
                                $this->mailer->send_mail($toemail, $subject, $content);
                            }
                            echo $this->lang->line('success_message');
                        }
                    } else {
                        $response = array('error' => 1, 'msg' => 'Bill required');
                        echo json_encode($response);
                    }
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }
