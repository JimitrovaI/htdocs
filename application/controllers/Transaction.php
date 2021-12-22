 <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Transaction extends MY_Controller
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
        }

        public function index()
        {
            #Redirect to Admin dashboard after authentication
            if ($this->session->userdata('user_login_access') == 1)
                redirect('dashboard/Dashboard');
            $this->load->view('login');
        }

        function transactions()
        {
            if ($this->session->userdata('user_login_access') != False) {

                $emp_id = base64_decode($this->input->get('emp_id'));
                $business_id = base64_decode($this->input->get('business_id'));
                $status = $this->input->get('status');
                $from = $this->input->get('from');
                $to = $this->input->get('to');

                $data['by_business'] = false;
                $data['by_employee'] = false;

                $searchdata = array();
                if (!empty($status)) {
                    $searchdata['status'] = $status;
                }

                if (!empty($from)) {
                    $searchdata['from'] = $from;
                }

                if (!empty($to)) {
                    $searchdata['to'] = $to;
                }

                if (isset($emp_id) && !empty($emp_id)) {
                    $data['by_employee'] = true;
                    $data['emp_id'] = $emp_id;
                    $searchdata['emp_id'] = $emp_id;
                    $transactions = $this->transactions_model->searchTansactions($searchdata);
                } else {

                    if (!$data['by_employee'] && $this->session->userdata('user_business') != 'pharmacy') {
                        $data['by_business'] = true;
                        $business_id = $this->session->userdata('user_business');
                    }

                    if (!empty($business_id)) {
                        $searchdata['business_id'] = $business_id;
                    }

                    $transactions = $this->transactions_model->searchTansactions($searchdata);
                }
                $data['emp_id'] = $emp_id;
                $data['business_id'] = $business_id;
                $data['status'] = $status;
                $data['from'] = $from;
                $data['to'] = $to;


                $data['transactions'] = $transactions;
                $data['businesses'] = $this->business_model->getAll();
                $this->load->view('backend/transactions', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function transaction_view()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = base64_decode($this->input->get('id'));
                $transaction = $this->transactions_model->get($id);
                $staffs = $this->employee_model->GetAllEmployee();
                $data['transaction'] = $transaction;
                $data['staffs'] = $staffs;
                $data['basic'] = $this->business_model->GetEmployeeById($transaction['emp_id']);
                $data['pharmacist'] = $this->employee_model->get_by_id($transaction['buy_staff_id']);
                $data['socialmedia'] = $this->employee_model->GetSocialValue($data['pharmacist']->em_id);
                $this->load->view('backend/transaction_view', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function addTransaction()
        {
            if ($this->session->userdata('user_login_access') != False && $this->session->userdata('user_business') == 'pharmacy') {
                $staffs = $this->employee_model->GetAllEmployee();
                $data['staffs'] = $staffs;
                $data['businesses'] = $this->business_model->getAll();
                $this->load->view('backend/transaction_add', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function deleteTransaction()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = base64_decode($this->input->get('id'));
                $this->transactions_model->delete($id);
                $this->session->set_flashdata('delsuccess', $this->lang->line('delete_message'));
                redirect('transaction/transactions');
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function business_transaction()
        {
            if ($this->session->userdata('user_login_access') != False && $this->session->userdata('user_business') == 'pharmacy') {
                $business_transactions = $this->transactions_model->getBusinessTransactions();
                $data['business_transactions'] = $business_transactions;
                $this->load->view('backend/business_transaction', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function business_transaction_view()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = base64_decode($this->input->get('id'));
                if ($this->session->userdata('user_business') != 'pharmacy' && $id != $this->session->userdata('user_business')) {
                    redirect(base_url(), 'refresh');
                }
                $business_transaction = $this->transactions_model->getBusinessTransactions($id);
                $data['business_transaction'] = $business_transaction;
                $data['balance'] = 0;
                $last_payment = $this->transactions_model->getLastPayment($id);
                if (!empty($last_payment)) {
                    $data['balance'] = $last_payment['balance'];
                }

                $business_employee_transactions = $this->transactions_model->searchTansactions(array('business_id' => $id));
                $data['transactions'] = $business_employee_transactions;

                $this->load->view('backend/business_transaction_view', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function saveTransaction()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = $this->input->post('id');
                $emp_id = $this->input->post('emp_id');
                $details = $this->input->post('details');
                $buy_date = $this->input->post('date');
                $cost = $this->input->post('cost');
                $buy_staff_id = $this->input->post('buy_staff_id');
                if (empty($buy_staff_id)) {
                    $buy_staff_id = $this->session->userdata('staff_id');
                }

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
                                $data['buy_date'] = $buy_date;
                            }

                            if (!empty($id)) {
                                $data['id'] = $id;
                            }

                            $success = $this->transactions_model->add($data);
                            if (empty($id) && $success) {
                                $employeeProfile = $this->business_model->GetEmployeeById($emp_id);
                                $employee_availablecredit = empty($employeeProfile->em_credit) ? (!empty($employeeProfile->em_role_id) ? $employeeProfile->role_credit : $employeeProfile->detault_credit) : $employeeProfile->em_credit;
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


                                $businessInfo = $this->business_model->getBusinessInfo($employeeProfile->business_id);
                                // $toemail = $businessInfo['contact_email'];
                                $toemail = 'vadim.kim2022@gmail.com';
                                $subject = "Your employee purchased with Credit.";
                                $content = "Employee[$employeeProfile->full_name] purchased some pharms [details: $details] from our Pharmacy with your company credit($cost) at $buy_time. <br>";
                                $content .= "<b>Employee profile</b> <br>";
                                $content .= "Name   : $employeeProfile->full_name<br>";
                                $content .= "PIN  : $employeeProfile->em_code <br>";
                                $content .= "Phone  : $employeeProfile->em_phone <br>";
                                $content .= "Email  : $employeeProfile->em_email <br>";
                                $content .= "Approved Credit  : $employee_availablecredit <br>";
                                $content .= "Usable Credit  : $employee_credit <br>";
                                $content .= "<br>";
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

        public function getEmployeesbyBusiness()
        {
            $business_id = $this->input->post('business_id');
            if (empty($business_id)) {
                $response = array('success' => 1, 'data' => '');
                echo json_encode($response);
            } else {
                $employees = $this->business_model->GetEmployeeByBusinessId($business_id);

                $options = '';
                foreach ($employees as $employee) {
                    $options .= '<option value="' . $employee->id . '">' . $employee->full_name . ' (' . $this->lang->line('PIN') . ': ' . $employee->em_code . ', ' . $this->lang->line('email') . ': ' . $employee->em_email . ', ' . $this->lang->line('phone') . ': ' . $employee->em_phone . ')</option>';
                }
                $response = array('success' => 1, 'data' => $options);
                echo json_encode($response);
            }
        }
        public function getEmployeeDatabyId()
        {
            $employee_id = $this->input->post('employee_id');
            if (empty($employee_id)) {
                $response = array('success' => 1, 'data' => '');
                echo json_encode($response);
            } else {
                $employee = $this->business_model->GetEmployeeById($employee_id);
                $credit = empty($employee->em_credit) ? (empty($employee->role_credit) ? $employee->default_credit : $employee->role_credit) : $employee->em_credit;
                $img = empty($employee->em_image) ? base_url() . "assets/images/users/user.png" : base_url() . "assets/images/business/" . $employee->em_image;
                $response = array('success' => 1, 'data' => array('name' => $employee->full_name, 'business' => $employee->business, 'email' => $employee->em_email, 'phone' => $employee->em_phone, 'job_title' => $employee->em_job_title, 'credit' => $credit, 'pending_credit' => $employee->pending_credit, 'img' => $img));
                echo json_encode($response);
            }
        }

        function business_payments()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $payments = $this->transactions_model->getBusinessPayments();
                if ($this->session->userdata('user_business') != 'pharmacy') {
                    $payments = $this->transactions_model->getBusinessPaymentsByBusiness($this->session->userdata('user_business'));
                }
                $data['payments'] = $payments;
                $data['businesses'] = $this->business_model->getAll();
                $this->load->view('backend/business_payments', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function savePayment()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $user_name = $this->session->userdata('name');
                $user_type = $this->session->userdata('type');
                $user_email = $this->session->userdata('email');
                $user_phone = $this->session->userdata('phone');

                $id = $this->input->post('id');
                $business_id = $this->input->post('business_id');
                $added_amount = $this->input->post('added_amount');
                $paid_date = $this->input->post('paid_date');
                $paid_amount = $this->input->post('paid_amount');
                $paid_balance = $this->input->post('balance');

                $this->form_validation->set_error_delimiters();
                $this->form_validation->set_rules('business_id', $this->lang->line('business'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('paid_amount', $this->lang->line('paid_amount'), 'trim|required|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    $response = array('error' => 1, 'msg' => validation_errors());
                    echo json_encode($response);
                } else {
                    $invoice = '';
                    if (isset($_FILES['invoice']) && !empty($_FILES['invoice']['name'])) {
                        $uploaddir = './assets/images/invoices/';
                        if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                            die("Error creating folder " . base_url() . $uploaddir);
                        }

                        $image_name = str_replace(" ", "", $business_id) . date("YmdHis");

                        $config = array(
                            'file_name' => $image_name,
                            'upload_path' => $uploaddir,
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'overwrite' => False,
                            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                        );

                        $this->load->library('Upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('invoice')) {
                            $response = array('error' => 1, 'msg' => $this->upload->display_errors());
                            echo json_encode($response);
                            return;
                        } else {
                            $path = $this->upload->data();
                            $invoice = $path['file_name'];
                        }
                    }
                    $data = array(
                        'business_id' => $business_id,
                        'added_amount' => $added_amount,
                        'paid_amount' => $paid_amount,
                        'balance' => $paid_balance,
                    );

                    if (!empty($invoice)) {
                        $data['invoice'] = $invoice;
                    }

                    if (!empty($paid_date)) {
                        $data['paid_date'] = $paid_date;
                    }

                    if (!empty($id)) {
                        $data['id'] = $id;
                    }

                    $insert_id = $this->transactions_model->addPayment($data);
                    if (empty($id) && $insert_id) {
                        $pending_transactions = $this->transactions_model->searchTansactions(array('business_id' => $business_id, 'status' => 'PENDING'));
                        $balance = $paid_amount + $added_amount;
                        $paid_transactions = array();
                        foreach ($pending_transactions as $transaction) {
                            if ($balance >= $transaction['cost']) {
                                array_push($paid_transactions, $transaction['id']);
                                $balance = $balance - $transaction['cost'];
                            }
                        }
                        $this->transactions_model->addPayment(array('id' => $insert_id, 'balance' => $balance));
                        $this->transactions_model->bulk_updateTransactions($paid_transactions, array('status' => 'COMPLETE', 'payment_id' => $insert_id));

                        $businessInfo = $this->business_model->getBusinessInfo($business_id);
                        $pay_time = date('Y-m-d H:i');
                        // $toemail = $businessInfo['contact_email'];
                        $toemail = 'vadim.kim2022@gmail.com';
                        $subject = "Credit Payment";
                        $content = "Your company[".$businessInfo['name']."] paid $".$paid_amount." and payment was checked by $user_name [Email: $user_email, Phone: $user_phone] of pharmacy at $pay_time. <br>";
                        $content .= "<b>Payment Details</b> <br>";
                        $content .= "Previous Balance : $added_amount <br>";
                        $content .= "Payment Amount  : $paid_amount <br>";
                        $content .= "Paid Transactions and Credit    : ".count($paid_transactions).", $".$paid_amount + $added_amount-$balance." <br>";
                        $content .= "Unpaid Transactions and Credit  : ".$businessInfo['pending_count']+$businessInfo['overdue_count'].", $".$businessInfo['pending_credit']+ $businessInfo['overdue_credit']." <br>";
                        $content .= "Current Balance  : $balance <br>";
                        $this->mailer->send_mail($toemail, $subject, $content);
                    }
                    echo $this->lang->line('success_message');
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function payment_detail_view()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = base64_decode($this->input->get('id'));
                $business_payment = $this->transactions_model->getBusinessPayments($id);
                $data['business_payment'] = $business_payment;

                $completed_transactions = $this->transactions_model->searchTansactions(array('payment_id' => $id));
                $completed = 0;
                foreach ($completed_transactions as $transaction) {
                    $completed += $transaction['cost'];
                }
                $data['completed'] = $completed;
                $data['transactions'] = $completed_transactions;

                $this->load->view('backend/business_payment_view', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }
