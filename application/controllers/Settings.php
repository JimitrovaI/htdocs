 <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Settings extends MY_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->model('login_model');
            $this->load->model('dashboard_model');
            $this->load->model('employee_model');
            $this->load->model('project_model');
            $this->load->model('settings_model');
            $this->load->model('leave_model');
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
        public function Settings()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $data['settingsvalue'] = $this->settings_model->GetSettingsValue();
                $this->load->view('backend/settings', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }
        public function Add_Settings()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = $this->input->post('id');
                $title = $this->input->post('title');
                $description = $this->input->post('description');
                $copyright = $this->input->post('copyright');
                $contact = $this->input->post('contact');
                $currency = $this->input->post('currency');
                $symbol = $this->input->post('symbol');
                $email = $this->input->post('email');
                $address = $this->input->post('address');
                $address2 = $this->input->post('address2');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters();
                // Validating Title Field
                $this->form_validation->set_rules('title', 'title', 'trim|required|min_length[5]|max_length[60]|xss_clean');
                // Validating description Field
                $this->form_validation->set_rules('description', 'description', 'trim|required|min_length[20]|max_length[512]|xss_clean');
                // Validating address Field
                $this->form_validation->set_rules('address', 'address', 'trim|min_length[5]|max_length[600]|xss_clean');
                $this->form_validation->set_rules('address2', 'address2', 'trim|min_length[5]|max_length[600]|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    $response = array('error' => 1, 'msg' => validation_errors());
                    echo json_encode($response);
                } else {

                    if ($_FILES['logo']['name']) {

                        $config = array(
                            'file_name' => 'logo.png',
                            'upload_path' => "./assets/images/background",
                            'allowed_types' => "gif|jpg|png|jpeg|svg",
                            'overwrite' => True,
                            'max_size' => "204800", // Can be set to particular file size , here it is 220KB(220 Kb)
                        );

                        $this->load->library('Upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('logo')) {
                            $response = array('error' => 1, 'msg' => $this->upload->display_errors());
                            echo json_encode($response);
                            return;
                        } else {
                            $path = $this->upload->data();
                            $this->session->set_flashdata('feedback', $this->lang->line('delete_cashfile'));
                        }
                    } 

                    if ($_FILES['background']['name']) {

                        $config = array(
                            'file_name' => 'login-register.png',
                            'upload_path' => "./assets/images/background",
                            'allowed_types' => "gif|jpg|png|jpeg|svg",
                            'overwrite' => True,
                            'max_size' => "2048000", // Can be set to particular file size , here it is 2MB
                        );

                        $this->load->library('Upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('background')) {
                            $response = array('error' => 1, 'msg' => $this->upload->display_errors());
                            echo json_encode($response);
                            return;
                        } else {
                            $path = $this->upload->data();
                            $this->session->set_flashdata('feedback', $this->lang->line('delete_cashfile'));
                        }
                    } 

                    if ($_FILES['iconlogo']['name']) {

                        $config = array(
                            'file_name' => 'loginlogo.png',
                            'upload_path' => "./assets/images/background",
                            'allowed_types' => "gif|jpg|png|jpeg|svg",
                            'overwrite' => True,
                            'max_size' => "204800", // Can be set to particular file size , here it is 200kbyte
                        );

                        $this->load->library('Upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('iconlogo')) {
                            $response = array('error' => 1, 'msg' => $this->upload->display_errors());
                            echo json_encode($response);
                            return;
                        } else {
                            $path = $this->upload->data();
                            $this->session->set_flashdata('feedback', $this->lang->line('delete_cashfile'));
                        }
                    } 

                    // if ($_FILES['logo']['name']) {

                    //     $config = array(
                    //         'file_name' => 'logo.png',
                    //         'upload_path' => "./assets/images/background",
                    //         'allowed_types' => "gif|jpg|png|jpeg|svg",
                    //         'overwrite' => True,
                    //         'max_size' => "204800", // Can be set to particular file size , here it is 220KB(220 Kb)
                    //     );

                    //     $this->load->library('Upload', $config);
                    //     $this->upload->initialize($config);
                    //     if (!$this->upload->do_upload('logo')) {
                    //         $response = array('error' => 1, 'msg' => $this->upload->display_errors());
                    //         echo json_encode($response);
                    //         return;
                    //     } else {
                    //         $path = $this->upload->data();
                    //     }
                    // } 

                    $data = array();
                    $data = array(
                        'sitetitle' => $title,
                        'description' => $description,
                        'copyright' => $copyright,
                        'contact' => $contact,
                        'currency' => $currency,
                        'symbol' => $symbol,
                        'system_email' => $email,
                        'address' => $address,
                        'address2' => $address2,
                    );
                    $success = $this->settings_model->SettingsUpdate($id, $data);
                    echo 'Successfully Updated';
                   
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }
