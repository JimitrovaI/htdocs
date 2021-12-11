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

        function business_transaction(){
            if ($this->session->userdata('user_login_access') != False) {
                $business_transactions = $this->transactions_model->getBusinessTransactions();
                $data['business_transactions'] = $business_transactions;
                $this->load->view('backend/business_transaction', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function business_transaction_view(){
            if ($this->session->userdata('user_login_access') != False) {
                $id = base64_decode($this->input->get('id'));
                $business_transaction = $this->transactions_model->getBusinessTransactions($id);
                $data['business_transaction'] = $business_transaction;

                $business_employee_transactions = $this->transactions_model->searchTansactions(array('business_id'=>$id));
                $data['transactions'] = $business_employee_transactions;

                $this->load->view('backend/business_transaction_view', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function addcreditshop()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $buy_staff_id = $this->session->userdata('staff_id');
                $emp_id = $this->input->post('emp_id');
                $details = $this->input->post('details');
                $buy_date = $this->input->post('date');
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

                            if(!empty($buy_date)){
                                $data['buy_date'] = $buy_date;
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
    }
