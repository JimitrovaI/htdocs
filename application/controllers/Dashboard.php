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
                $businesses = $this->business_model->get_businessinfo();
                $data['businesses'] = $businesses;
                $data['bgs'] = array('bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-dark');
                $this->load->view('backend/dashboard', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        function search_employees()
        {
            $searchterm = $this->input->post('search');
            $employees = $this->business_model->searchemployeebyFullText($searchterm);
            // print_r($employees); exit;
            if (empty($employees)) {
                $result = array('success' => true, 'data' => 'Search results are empty');
                echo json_encode($result);
            } else {
                $tabledata = '';
                foreach ($employees as $employee) {
                    $tabledata .= "<tr>
                        <td class='td_business_$employee->id'>$employee->business</td>
                        <td class='td_pin_$employee->id'>$employee->em_code</td>
                        <td class='td_name_$employee->id'>$employee->full_name</td>
                        <td class='td_email_$employee->id'>$employee->em_email</td>
                        <td class='td_phone_$employee->id'>$employee->em_phone</td>
                        <td class='td_jobtitle_$employee->id'>$employee->em_job_title</td>
                        <td class='td_credit_$employee->id'>$employee->em_credit</td>
                        <td class='jsgrid-align-center'>
                            <a href='javascript:;' onclick='creditshop($employee->id)' title='" . $this->lang->line('credit_shop') . "' class='btn btn-sm btn-info waves-effect waves-light'><i class='fa fa-cart-plus'></i></a>
                        </td>
                    </tr>";
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

                            if(!empty($buy_date)){
                                $buy_date = strtotime($buy_date);
                                $buy_date = date('Y-m-d', $buy_date);
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
