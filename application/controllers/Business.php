 <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Business extends MY_Controller
    {


        function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->model('login_model');
            $this->load->model('dashboard_model');
            $this->load->model('employee_model');
            $this->load->model('business_model');
            $this->load->model('settings_model');
            $this->load->model('leave_model');
        }

        public function index()
        {
            if ($this->session->userdata('user_login_access') == 1)
                redirect('dashboard/Dashboard');
            $this->load->view('login');
        }

        public function business()
        {
            if ($this->session->userdata('user_login_access') != False) {
                
                // if($this->mailer->send_mail('vadim.kim2022@gmail.com', 'Pharmacy Mail Test', 'mail test success')){
                //     echo 'send successfully';
                // }else{
                //     echo 'send failed';
                // }
                // exit;
                $data['businesses'] = $this->business_model->getBusinessInfo();
                $this->load->view('backend/business', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function save()
        {
            if ($this->session->userdata('user_login_access') != False && $this->session->userdata('user_type') == 'SUPER ADMIN') {
                $id = $this->input->post('id');
                $bname = $this->input->post('business');
                $government_id = $this->input->post('government_id');
                $payment_agreement = $this->input->post('payment_agreement');
                $contact_person = $this->input->post('contact_person');
                $contact_email = $this->input->post('contact_email');
                $contact_phone = $this->input->post('contact_phone');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                $this->form_validation->set_rules('business', $this->lang->line('business_name'), 'trim|required|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    $response = array('error' => 1, 'msg' => validation_errors());
                    echo json_encode($response);
                } else {
                    $data = array();
                    $data = array('name' => $bname, 'government_id' => $government_id, 'payment_agreement' => $payment_agreement, 'contact_person' => $contact_person, 'contact_email' => $contact_email, 'contact_phone' => $contact_phone);

                    if (!empty($id)) {
                        $data['id'] = $id;
                    }

                    $success = $this->business_model->Add_Business($data);

                    if ($success && empty($id)) {
                        $role_manager = array('business_id' => $success, 'role' => 'Manager', 'credit' => 100);
                        $this->business_model->Add_BusinessRole($role_manager);

                        $role_default = array('business_id' => $success, 'role' => 'Default', 'credit' => 10);
                        $this->business_model->Add_BusinessRole($role_default);
                    }

                    $this->session->set_flashdata('feedback', $this->lang->line('success_message'));
                    echo $this->lang->line('success_message');
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function delete($id)
        {
            if ($this->session->userdata('user_login_access') != False) {
                $this->business_model->Delete_Business($id);
                $this->session->set_flashdata('delsuccess', $this->lang->line('delete_message'));
                redirect('business/business');
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function edit($id)
        {
            if ($this->session->userdata('user_login_access') != False) {
                $data['businesses'] = $this->business_model->getBusinessInfo();
                $data['editbusiness'] = $this->business_model->getBusinessInfo($id);
                $this->load->view('backend/business', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }
        public function update()
        {

            if ($this->session->userdata('user_login_access') != False) {
                $id = $this->input->post('id');
                $bname = $this->input->post('name');
                $government_id = $this->input->post('government_id');
                $contact_person = $this->input->post('contact_person');
                $contact_email = $this->input->post('contact_email');
                $contact_phone = $this->input->post('contact_phone');

                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                $this->form_validation->set_rules('name', $this->lang->line('business_name'), 'trim|required|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    $response = array('error' => 1, 'msg' => validation_errors());
                    echo json_encode($response);
                } else {
                    $data = array();
                    $data = array('name' => $bname, 'government_id' => $government_id, 'contact_person' => $contact_person, 'contact_email' => $contact_email, 'contact_phone' => $contact_phone);
                    $this->business_model->update_Business($id, $data);
                    $this->session->set_flashdata('feedback', $this->lang->line('update_message'));
                    echo $this->lang->line('update_message');
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }



        public function business_role()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $data['businesses'] = $this->business_model->getAll();
                $data['business_roles'] = $this->business_model->getRoles();
                if ($this->session->userdata('user_business') != 'pharmacy') {
                    $data['business_id'] = $this->session->userdata('user_business');
                    $data['business_roles'] = $this->business_model->getRoles($data['business_id'], true);
                }
                $this->load->view('backend/business_role', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function save_role()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $business_id = $this->input->post('business_id');
                $role = $this->input->post('role');
                $credit = $this->input->post('credit');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                $this->form_validation->set_rules('business_id', $this->lang->line('business'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('role', $this->lang->line('role'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('credit', $this->lang->line('credit'), 'trim|required|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    $response = array('error' => 1, 'msg' => validation_errors());
                    echo json_encode($response);
                } else {
                    $data = array();
                    $data = array('business_id' => $business_id, 'role' => $role, 'credit' => $credit);
                    $success = $this->business_model->Add_BusinessRole($data);
                    $this->session->set_flashdata('feedback', $this->lang->line('success_message'));
                    echo $this->lang->line('success_message');
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }
        public function delete_role($id)
        {
            if ($this->session->userdata('user_login_access') != False) {
                $this->business_model->Delete_BusinessRole($id);
                $this->session->set_flashdata('delsuccess', $this->lang->line('delete_message'));
                redirect('business/business_role');
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function edit_role($id)
        {
            if ($this->session->userdata('user_login_access') != False) {
                $data['businesses'] = $this->business_model->getAll();
                $data['business_roles'] = $this->business_model->getRoles();
                $data['editrole'] = $this->business_model->getRoles($id);
                if ($this->session->userdata('user_business') != 'pharmacy') {
                    $data['business_id'] = $this->session->userdata('user_business');
                    $data['business_roles'] = $this->business_model->getRoles($data['business_id'], true);
                }
                $this->load->view('backend/business_role', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }
        public function update_role()
        {

            if ($this->session->userdata('user_login_access') != False) {
                $id = $this->input->post('id');
                $business_id = $this->input->post('business_id');
                $role = $this->input->post('role');
                $credit = $this->input->post('credit');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                $this->form_validation->set_rules('business_id', $this->lang->line('business'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('role', $this->lang->line('role'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('credit', $this->lang->line('credit'), 'trim|required|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    $response = array('error' => 1, 'msg' => validation_errors());
                    echo json_encode($response);
                } else {
                    $data = array();
                    $data = array('id' => $id, 'business_id' => $business_id, 'role' => $role, 'credit' => $credit);
                    $success = $this->business_model->Add_BusinessRole($data);
                    $this->session->set_flashdata('feedback', $this->lang->line('update_message'));
                    echo $this->lang->line('update_message');
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }


        // Get leave details hourly
        public function Get_BusinessDetails()
        {
            $business_id   = $this->input->get('business_id');

            $report = $this->business_model->GetEmployeeByBusinessId($business_id);

            if (is_array($report) || is_object($report)) {
                foreach ($report as $value) {
                    $em_role = $value->business_role;
                    if (empty($em_role)) {
                        $em_role = $this->lang->line('default');
                    }

                    $em_credit = $value->em_credit;
                    if (empty($em_credit)) {
                        $em_credit = $value->role_credit;
                        if (empty($em_credit)) {
                            $em_credit = $value->default_credit;
                        }
                    }

                    echo "<tr>
                        <td>$value->business</td>
                        <td>$value->full_name</td>
                        <td>$value->em_code</td>
                        <td>$value->em_email</td>
                        <td>$value->em_phone hours</td>
                        <td>$em_role</td>
                        <td>$em_credit</td>";
                    if ($this->session->userdata('user_business') != 'pharmacy' || ($this->session->userdata('user_business') == 'pharmacy' && $this->session->userdata('user_type') == 'SUPER ADMIN')) {
                        echo "<td class='text-center'>
                            <a href='" . base_url() . "business/edit_employee?id=" . base64_encode($value->id) . "' title='" . $this->lang->line('edit') . "' class='btn btn-sm btn-info waves-effect waves-light'><i class='fa fa-pencil-square-o'></i></a>
                            <a onclick='return confirm(\"" . $this->lang->line('are_you_sure_to_delete_this') . "\")' href='" . base_url() . "business/delete_employee?id=" . base64_encode($value->id) . "' title='" . $this->lang->line('delete') . "' class='btn btn-sm btn-info waves-effect waves-light'><i class='fa fa-trash-o'></i></a>
                        </td>";
                    }else{
                        echo "<td class='text-center'>
                            <a href='" . base_url() . "business/edit_employee?id=" . base64_encode($value->id) . "' title='" . $this->lang->line('view') . "' class='btn btn-sm btn-info waves-effect waves-light'><i class='fa fa-bars'></i></a>
                        </td>";

                    }
                    echo "</tr>";
                }
            } else {
                echo "<p>No Data Found</p>";
            }
        }

        public function business_employees()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $data['businesses'] = $this->business_model->getAll();
                if ($this->session->userdata('user_business') != 'pharmacy') {
                    $data['business'] = $this->business_model->getBusinessInfo($this->session->userdata('user_business'));
                }
                $this->load->view('backend/business_employees', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function add_employee($business_id = null)
        {
            if ($this->session->userdata('user_login_access') != False) {
                $data['business_id'] = $business_id;
                if ($this->session->userdata('user_business') != 'pharmacy') {
                    $data['business_id'] = $this->session->userdata('user_business');
                }
                $data['businesses'] = $this->business_model->getAll();
                $this->load->view('backend/business-add-employee', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function delete_employee()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = base64_decode($this->input->get('id'));
                $this->business_model->delete_employee($id);
                $this->session->set_flashdata('delsuccess', $this->lang->line('delete_message'));
                redirect('business/business_employees');
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function edit_employee()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = base64_decode($this->input->get('id'));

                if ($this->session->userdata('user_login_id') == $id) {
                    $data['isprofile'] = true;
                } else {
                    $data['isprofile'] = false;
                }
                $data['businesses'] = $this->business_model->getAll();
                $data['basic'] = $this->business_model->GetEmployeeById($id);
                $data['roles'] = $this->business_model->getRoles($data['basic']->business_id, true);

                $data['permanent'] = $this->business_model->GetperAddress($id);
                $data['present'] = $this->business_model->GetpreAddress($id);
                $this->load->view('backend/business_employee_view', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function save_employee()
        {
           
            if ($this->session->userdata('user_login_access') != False || $this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') {
                $id = $this->input->post('id');
                $em_code = $this->input->post('em_code');
                $full_name = $this->input->post('full_name');
                $business_id = $this->input->post('business_id');
                if ($this->session->userdata('user_business') != 'pharmacy') {
                    $business_id = $this->session->userdata('user_business');
                }
                $em_role_id = $this->input->post('em_role_id');
                $em_gender = $this->input->post('em_gender');
                $em_phone = $this->input->post('em_phone');
                $em_birthday = $this->input->post('em_birthday');
                $em_email = $this->input->post('em_email');
                $em_blood_group = $this->input->post('em_blood_group');
                $em_job_title = $this->input->post('em_job_title');
                $em_credit = $this->input->post('em_credit');
                $status = $this->input->post('status');
                $password = sha1($em_phone);
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters();
                // Validating Name Field
                $this->form_validation->set_rules('business_id', $this->lang->line('business'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('em_phone', $this->lang->line('phone'), 'trim|required|min_length[10]|max_length[15]|xss_clean');
                /*validating email field*/
                $this->form_validation->set_rules('em_email', $this->lang->line('email'), 'trim|required|min_length[7]|max_length[100]|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    $response = array('error' => 1, 'msg' => validation_errors());
                    echo json_encode($response);
                } else {
                    if ($this->business_model->is_email_exists($em_email) && $this->business_model->is_email_exists($em_email)->id != $id) {
                        $this->session->set_flashdata('formdata', $this->lang->line('email_already_exist'));
                        $response = array('error' => 1, 'msg' => $this->lang->line('email_already_exist'));
                        echo json_encode($response);
                    } else {
                        $img_url = "";
                        if ($_FILES['image_url']['name']) {

                            $uploaddir = './assets/images/business/';
                            if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                                die("Error creating folder " . base_url() . $uploaddir);
                            }

                            $image_name = str_replace(" ", "", $full_name) . date("YmdHis");

                            $config = array(
                                'file_name' => $image_name,
                                'upload_path' => $uploaddir,
                                'allowed_types' => "gif|jpg|png|jpeg",
                                'overwrite' => False,
                                'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                                'max_height' => "1000",
                                'max_width' => "1000"
                            );

                            $this->load->library('Upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('image_url')) {
                                $response = array('error' => 1, 'msg' => $this->upload->display_errors());
                                echo json_encode($response);
                                return;
                            } else {
                                $path = $this->upload->data();
                                $img_url = $path['file_name'];
                            }
                        }
                        $data = array(
                            'em_code' => $em_code,
                            'full_name' => $full_name,
                            'business_id' => $business_id,
                            'em_email' => $em_email,
                            'em_role_id' => $em_role_id,
                            'em_gender' => $em_gender,
                            'status' => 'ACTIVE',
                            'em_phone' => $em_phone,
                            'em_birthday' => $em_birthday,
                            'em_job_title' => $em_job_title,
                            'em_blood_group' => $em_blood_group,
                            'em_credit' => $em_credit
                        );

                        if (!empty($img_url)) {
                            $data['em_image'] = $img_url;
                        }

                        if (!empty($status)) {
                            $data['status'] = $status;
                        }

                        if (!empty($id)) {
                            $success = $this->business_model->update_employee($data, $id);
                            if($success){
                                $employeeProfile = $this->business_model->GetEmployeeById($success);
                                $employee_credit = empty($employeeProfile->em_credit) ? (!empty($employeeProfile->em_role_id)?$employeeProfile->role_credit: $employeeProfile->detault_credit) :$employeeProfile->em_credit;
                                // $toemail = $employeeProfile->em_email;
                                $toemail = 'vadim.kim2022@gmail.com';
                                $subject = "Successfully Sign up";
                                $content = "Your account has been signed up successfully. <br>";
                                $content .= "From now you can buy all products of our pharmacy using your business credit. <br>";
                                $content .= "Your profile <br>";
                                $content .= "Business : $employeeProfile->business <br>";
                                $content .= "Name     : $employeeProfile->full_name <br>";
                                $content .= "Phone    : $employeeProfile->em_phone <br>";
                                $content .= "Credit   : $employee_credit <br>";
                                $this->mailer->send_mail($toemail, $subject, $content);
                            }
                            echo $this->lang->line('update_message');
                        } else {
                            $data['em_password'] = $password;
                            $success = $this->business_model->add_employee($data);
                            if($success){
                                $employeeProfile = $this->business_model->GetEmployeeById($success);
                                $employee_credit = empty($employeeProfile->em_credit) ? (!empty($employeeProfile->em_role_id)?$employeeProfile->role_credit: $employeeProfile->detault_credit) :$employeeProfile->em_credit;
                                // $toemail = $employeeProfile->em_email;
                                $toemail = 'vadim.kim2022@gmail.com';
                                $subject = "Your Profile Updated";
                                $content = "Your account has been updated. <br>";
                                $content .= "Your profile <br>";
                                $content .= "Business : $employeeProfile->business <br>";
                                $content .= "Name     : $employeeProfile->full_name <br>";
                                $content .= "Phone    : $employeeProfile->em_phone <br>";
                                $content .= "Credit   : $employee_credit <br>";
                                $this->mailer->send_mail($toemail, $subject, $content);
                            }
                            echo $this->lang->line('success_message');
                        }
                    }
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function save_address()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = $this->input->post('id');
                $em_id = $this->input->post('emid');
                $type = $this->input->post('type');
                $address = $this->input->post('address');
                $city = $this->input->post('city');
                $country = $this->input->post('country');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters();
                $this->form_validation->set_rules('address', 'address', 'trim|required|min_length[5]|max_length[100]|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    $response = array('error' => 1, 'msg' => validation_errors());
                    echo json_encode($response);
                } else {
                    $data = array();
                    $data = array(
                        'emp_id' => $em_id,
                        'city' => $city,
                        'country' => $country,
                        'address' => $address,
                        'type' => $type
                    );
                    if (empty($id)) {
                        $success = $this->business_model->add_employee_address($data);
                        $this->session->set_flashdata('feedback', 'Successfully Added');
                        echo "Successfully Updated";
                    } else {
                        $success = $this->business_model->update_employee_address($id, $data);
                        $this->session->set_flashdata('feedback', 'Successfully Updated');
                        echo "Successfully Added";
                    }
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function reset_password()
        {
            if ($this->session->userdata('user_login_access') != False) {

                $id = $this->input->post('emid');
                $employee = $this->business_model->GetEmployeeById($id);
                if ($this->session->userdata('user_login_id') == $id) {
                    $oldp = sha1($this->input->post('old'));
                    if ($employee->em_password != $oldp) {
                        $this->session->set_flashdata('feedback', $this->lang->line('current_password_incorrect'));
                        $response = array('error' => 1, 'msg' => $this->lang->line('current_password_incorrect'));
                        echo json_encode($response);
                        return;
                    }
                }

                $pass = $this->input->post('new1');
                $confirm = $this->input->post('new2');

                if ($pass == $confirm) {
                    $data = array(
                        'em_password' => sha1($pass)
                    );
                    $this->business_model->update_employee($data, $id);
                    $this->session->set_flashdata('feedback', 'Successfully Updated');
                    echo $this->lang->line('password_changed_successfully');
                } else {
                    $this->session->set_flashdata('feedback', $this->lang->line('confirm_password_incorrect'));
                    $response = array('error' => 1, 'msg' => $this->lang->line('confirm_password_incorrect'));
                    echo json_encode($response);
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }


        public function import()
        {
            if ($this->session->userdata('user_business') == 'pharmacy') {
                $business_id = $this->input->post('business_id');
            } else {
                $business_id = $this->session->userdata('user_business');
            }
            $this->load->library('csvimport');
            $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
            //echo $file_data;
            $added = 0;
            $updated = 0;
            foreach ($file_data as $row) {

                $role = $row['Role'];
                $role_id = $this->business_model->getBusinessRolebyRole($role, $business_id);

                $duplicate = $this->business_model->is_email_exists($row["Email"]);

                $birthday = '';
                if (empty($row["DoB"])) {
                    $birthday = date('Y-m-d', strtotime($row["DoB"]));
                }
                //print_r($duplicate);

                $data = array();
                $data = array(
                    'em_code' => $row["Employee Code"],
                    'business_id' => $business_id,
                    'full_name' => $row["Full Name"],
                    'em_email' => $row["Email"],
                    'em_phone' => $row["Phone"],
                    'em_password' => sha1($row["Phone"]),
                    'em_gender' => $row["Gender"],
                    'em_role_id' => $role_id,
                    'em_job_title' => $row["Job Title"],
                    'em_birthday' => $birthday,
                );
                if (!empty($duplicate)) {
                    $data['id'] = $duplicate->id;
                    $updated++;
                } else {
                    $added++;
                }

                $success = $this->business_model->add_employee($data);
                // if($success){
                //     $employeeProfile = $this->business_model->GetEmployeeById($success);
                //     $employee_credit = empty($employeeProfile->em_credit) ? (!empty($employeeProfile->em_role_id)?$employeeProfile->role_credit: $employeeProfile->detault_credit) :$employeeProfile->em_credit;
                //     // $toemail = $employeeProfile->em_email;
                //     $toemail = 'vadim.kim2022@gmail.com';
                //     $subject = "Successfully Sign up";
                //     $content = "Your account has been signed up successfully. <br>";
                //     $content .= "From now you can buy all products of our pharmacy using your business credit. <br>";
                //     $content .= "Your profile <br>";
                //     $content .= "Business : $employeeProfile->business <br>";
                //     $content .= "Name     : $employeeProfile->full_name <br>";
                //     $content .= "Phone    : $employeeProfile->em_phone <br>";
                //     $content .= "Credit   : $employee_credit <br>";
                //     $this->mailer->send_mail($toemail, $subject, $content);
                // }
            }
            echo "Success Import<br>Added: $added, Updated: $updated";
        }

        public function getRoleByBusinessId()
        {
            $business_id = $this->input->post('business_id');
            if (empty($business_id)) {
                $response = array('success' => 1, 'data' => '');
                echo json_encode($response);
            } else {
                $roles = $this->business_model->getRoles($business_id, true);

                $options = '';
                foreach ($roles as $role) {
                    $options .= '<option value="' . $role['id'] . '">' . $role['role'] . ' (' . $this->lang->line('credit') . ': ' . $role['credit'] . ')</option>';
                }
                $response = array('success' => 1, 'data' => $options);
                echo json_encode($response);
            }
        }

        public function cron_checkpaydate()
        {
            if ($this->input->is_cli_request()) {
                $businesses = $this->db->getBusinessInfo();

                foreach ($businesses as $business) {
                    $credit = $business['pending_credit'] + $business['overdue_credit'];
                    $credit_count = $business['pending_count'] + $business['overdue_count'];
                    $pay_rule = $business['payment_agreement'];
                    $today_date = date('j');
                    $today_day = date('w');
                    $month_last_day = date('t');
                    $is_pay_date = false;

                    if ($pay_rule == "WEEK" && $today_day == 5) {
                        $is_pay_date = true;
                    }

                    if ($pay_rule == "TWICE") {
                        if ($today_date == 15 || $today_date == 30 || ($month_last_day < 30 && $today_date == $month_last_day)) {
                            $is_pay_date = true;
                        }
                    }

                    if ($pay_rule == "MONTH" && $today_day == 1) {
                        $is_pay_date = true;
                    }

                    if ($is_pay_date && $credit > 0) {
                        // $toemail = $business['contact_email'];
                        $toemail = 'vadim.kim2022@gmail.com';
                        $subject = 'Payment Date';
                        $content = 'payment date is ' . date('Y-m-d') . "<br>";
                        $content .= $business['name'] . ' has ' . $credit_count . ' counts and $' . $credit . ' of transactions to pay.';
                        $this->mailer->send_mail($toemail, $subject, $content);
                    }

                    $is_overdue_date = false;
                    if ($pay_rule == "WEEK" && $today_day == 6) {
                        $is_overdue_date = true;
                    }

                    if ($pay_rule == "TWICE") {
                        if ($today_date == 16 || $today_date == 31 || ($today_date == 1 && date('t', strtotime(date('Y-m-d') . " -1 month")) < 31)) {
                            $is_overdue_date = true;
                        }
                    }

                    if ($pay_rule == "MONTH" && $today_day == 2) {
                        $is_overdue_date = true;
                    }

                    if ($is_pay_date && $credit > 0) {
                        $pay_date = date('Y-m-d', strtotime(date('Y-m-d') . " -1 day"));
                        $this->transactions_model->overdueBusinessTransactions($business['id'], $pay_date);
                    }
                }
            } else {
                echo "You dont have access";
            }
        }
    }
