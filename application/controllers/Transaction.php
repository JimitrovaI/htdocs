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
            $this->load->model('business_model');
            $this->load->model('transactions_model');
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
                $transactions = $this->transactions_model->get();
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
                $data['basic'] = $this->business_model->GetEmployeeById($transaction['em_id']);
                $this->load->view('backend/transaction_view', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function addTransaction()
        {
            if ($this->session->userdata('user_login_access') != False) {
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
            if ($this->session->userdata('user_login_access') != False) {
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
                            if ($balance > $transaction['cost']) {
                                array_push($paid_transactions, $transaction['id']);
                                $balance = $balance - $transaction['cost'];
                            }
                        }
                        $this->transactions_model->addPayment(array('id' => $insert_id, 'balance' => $balance));
                        $this->transactions_model->bulk_updateTransactions($paid_transactions, array('status' => 'COMPLETE', 'payment_id' => $insert_id));
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
