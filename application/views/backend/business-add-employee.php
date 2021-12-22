<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> <?php echo $this->lang->line('employee') ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"> <?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"> <?php echo $this->lang->line('employee') ?></li>
            </ol>
        </div>
    </div>
    <div class="message"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-user-o" aria-hidden="true"></i> <?php echo $this->lang->line('add_new_employee') ?><span class="pull-right "></span></h4>
                    </div>
                    <?php echo validation_errors(); ?>
                    <?php echo $this->upload->display_errors(); ?>
                    <?php echo $this->session->flashdata('formdata'); ?>
                    <?php echo $this->session->flashdata('feedback'); ?>
                    <div class="card-body">

                        <form class="row" method="post" action="save_employee" enctype="multipart/form-data">
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('name') ?></label>
                                <input type="text" name="full_name" class="form-control form-control-line" placeholder="<?php echo $this->lang->line('full_name') ?>" minlength="2" required>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('employee_code') ?> </label>
                                <input type="text" name="em_code" class="form-control form-control-line" placeholder="ID">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('business') ?></label>
                                <select name="business_id" id="business_id" class="form-control" value="" class="form-control custom-select" required <?php echo $this->session->userdata('user_business') != 'pharmacy' ? "disabled" : "" ?>>
                                    <option value=""><?php echo $this->lang->line('select_business') ?> </option>
                                    <?Php foreach ($businesses as $business) : ?>
                                        <option <?php if ($business_id == $business->id) echo 'Selected' ?> value="<?php echo $business->id ?>"><?php echo $business->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('role') ?> </label>
                                <select name="em_role_id" id="business_roles" class="form-control custom-select">
                                    <option value=""><?php echo $this->lang->line('select_role') ?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('gender') ?> </label>
                                <select name="em_gender" class="form-control custom-select">
                                    <option><?php echo $this->lang->line('select_gender') ?> </option>
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('phone') ?> </label>
                                <input type="text" name="em_phone" class="form-control" value="" placeholder="+8801231456" minlength="10" maxlength="15" required>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('date_of_birth') ?></label>
                                <input type="date" name="em_birthday" class="form-control" placeholder="">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('email') ?> </label>
                                <input type="email" id="example-email2" name="em_email" class="form-control" placeholder="email@mail.com" minlength="7" required>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('image') ?> </label>
                                <input type="file" name="image_url" class="form-control" value="">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('credit') ?> </label>
                                <input type="number" name="em_credit" class="form-control" value="">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('job_title') ?></label>
                                <input type="text" name="em_job_title" class="form-control form-control-line" placeholder="Administration Chief Executive Officer (CEO)">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Blood Group </label>
                                <select name="em_blood_group" class="form-control custom-select">
                                    <option value="">Select Gender</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                </select>
                            </div>
                            <div class="form-actions col-md-12">
                                <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                <button type="reset" class="btn btn-info"><?php echo $this->lang->line('cancel') ?></button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('backend/footer'); ?>

        <script type="text/javascript">
            function get_roles() {
                $('#business_roles').html('<option value=""><?php echo $this->lang->line('select_role') ?></option>');
                var business_id = $('#business_id').val();

                if (business_id !== "") {
                    $.ajax({
                        url: "getRoleByBusinessId",
                        type: "POST",
                        data: {
                            business_id: business_id
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#business_roles').append(response.data);
                        }
                    });
                }
            }

            $(document).ready(function() {
                get_roles();
                $("#business_id").on("change", function(event) {
                    get_roles();
                });
            });
        </script>