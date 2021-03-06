<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> <?php echo $this->lang->line('pharmacy_staff') ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('pharmacy_staff') ?></li>
            </ol>
        </div>
    </div>
    <div class="message"></div>
    <div class="container-fluid">
        <div class="row m-b-10">
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

                        <form class="row" method="post" action="Save" enctype="multipart/form-data">
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('first_name') ?></label>
                                <input type="text" name="fname" class="form-control form-control-line" placeholder="Your first name" minlength="2" required>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('last_name') ?> </label>
                                <input type="text" id="" name="lname" class="form-control form-control-line" value="" placeholder="Your last name" minlength="2" required>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('employee_code') ?> </label>
                                <input type="text" name="eid" class="form-control form-control-line" placeholder="ID">
                            </div>

                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('role') ?> </label>
                                <select name="role" class="form-control custom-select" required>
                                    <option><?php echo $this->lang->line('select_role') ?></option>
                                    <option value="PHARMACIST"><?php echo $this->lang->line('pharmacist') ?></option>
                                    <option value="ACCOUNTANT"><?php echo $this->lang->line('accountant') ?></option>
                                    <option value="SUPER ADMIN"><?php echo $this->lang->line('super_admin') ?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('gender') ?> </label>
                                <select name="gender" class="form-control custom-select" required>
                                    <option><?php echo $this->lang->line('select_gender') ?></option>
                                    <option value="MALE"><?php echo $this->lang->line('male') ?></option>
                                    <option value="FEMALE"><?php echo $this->lang->line('female') ?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('boold_group') ?> </label>
                                <select name="blood" class="form-control custom-select">
                                    <option><?php echo $this->lang->line('select_boold') ?></option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('contact_number') ?></label>
                                <input type="text" name="contact" class="form-control" value="" placeholder="+8801231456" minlength="10" maxlength="15" required>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('date_of_birth') ?></label>
                                <input type="date" name="dob" id="example-email2" name="example-email" class="form-control" placeholder="" required>
                            </div>
                            
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('email') ?> </label>
                                <input type="email" id="example-email2" name="email" class="form-control" placeholder="email@mail.com" minlength="7" required>
                            </div>
                            <!--
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Password </label>
                                        <input type="text" name="password" class="form-control" value="" placeholder="**********"> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Confirm Password </label>
                                        <input type="text" name="confirm" class="form-control" value="" placeholder="**********"> 
                                    </div>-->
                            <div class="form-group col-md-3 m-t-20">
                                <label><?php echo $this->lang->line('image') ?> </label>
                                <input type="file" name="image_url" class="form-control" value="">
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