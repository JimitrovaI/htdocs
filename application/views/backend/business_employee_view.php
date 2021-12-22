<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-user-secret" style="color:#1976d2"></i> <?php echo $basic->full_name; ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('profile') ?></li>
            </ol>
        </div>
    </div>
    <?php $degvalue = $this->employee_model->getdesignation(); ?>
    <?php $depvalue = $this->employee_model->getdepartment(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-xlg-12 col-md-12">
                <div class="card">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs profile-tab" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab" style="font-size: 14px;"> <?php echo $this->lang->line('personal_info') ?> </a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab" style="font-size: 14px;"> <?php echo $this->lang->line('address') ?> </a> </li>
                        <?php if ($this->session->userdata('user_type') != 'PHARMACIST' && $this->session->userdata('user_type') != 'ACCOUNTANT') { ?>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#password" role="tab" style="font-size: 14px;"> <?php echo $this->lang->line('change_password') ?></a> </li>
                        <?php } ?>
                    </ul>
                    <!-- Tab panes -->

                    <div class="tab-content">
                        <div class="tab-pane active" id="home" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <center class="m-t-30">
                                                        <?php if (!empty($basic->em_image)) { ?>
                                                            <img src="<?php echo base_url(); ?>assets/images/business/<?php echo $basic->em_image; ?>" class="img-circle" width="150" />
                                                        <?php } else { ?>
                                                            <img src="<?php echo base_url(); ?>assets/images/users/user.png" class="img-circle" width="150" alt="<?php echo $basic->full_name ?>" title="<?php echo $basic->full_name ?>" />
                                                        <?php } ?>
                                                        <h4 class="card-title m-t-10"><?php echo $basic->full_name ?></h4>
                                                        <h6 class="card-subtitle"><?php echo $basic->business; ?></h6>
                                                    </center>
                                                </div>
                                                <div>
                                                    <hr>
                                                </div>
                                                <div class="card-body"> <small class="text-muted"><?php echo $this->lang->line('email') ?> </small>
                                                    <h6><?php echo $basic->em_email; ?></h6> <small class="text-muted p-t-30 db"><?php echo $this->lang->line('phone') ?></small>
                                                    <h6><?php echo $basic->em_phone; ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <form class="row" action="save_employee" method="post" enctype="multipart/form-data">

                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('PIN') ?> </label>
                                                    <input type="text" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> class="form-control form-control-line" placeholder="ID" name="em_code" value="<?php echo $basic->em_code; ?>" required >
                                                </div>
                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('name') ?></label>
                                                    <input type="text" class="form-control form-control-line" placeholder="<?php echo $this->lang->line('full_name') ?> " name="full_name" value="<?php echo $basic->full_name; ?>" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> minlength="3" required>
                                                </div>
                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('blood_group') ?> </label>
                                                    <select name="em_blood_group" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> disabled <?php } ?> class="form-control custom-select">
                                                        <option <?php if ($basic->em_blood_group == 'O+') echo "Selected" ?> value="O+">O+</option>
                                                        <option <?php if ($basic->em_blood_group == 'O-') echo "Selected" ?> value="O-">O-</option>
                                                        <option <?php if ($basic->em_blood_group == 'A+') echo "Selected" ?> value="A+">A+</option>
                                                        <option <?php if ($basic->em_blood_group == 'A-') echo "Selected" ?> value="A-">A-</option>
                                                        <option <?php if ($basic->em_blood_group == 'B+') echo "Selected" ?> value="B+">B+</option>
                                                        <option <?php if ($basic->em_blood_group == 'B-') echo "Selected" ?> value="B-">B-</option>
                                                        <option <?php if ($basic->em_blood_group == 'AB+') echo "Selected" ?> value="AB+">AB+</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('gender') ?> </label>
                                                    <select name="em_gender" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> disabled <?php } ?> class="form-control custom-select">
                                                        <option <?php if ($basic->em_gender == 'Male') echo "Selected" ?> value="Male">Male</option>
                                                        <option <?php if ($basic->em_gender == 'Female') echo "Selected" ?> value="Female">Female</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('role') ?> </label>
                                                    <select name="em_role_id" id="business_roles" class="form-control custom-select" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> disabled <?php } ?>>
                                                        <option value=""><?php echo $this->lang->line('select_role') ?></option>
                                                        <?php foreach ($roles as $role) { ?>
                                                            <option <?php if ($role['id'] == $basic->em_role_id) echo "Selected" ?> value="<?php echo $role['id'] ?>"><?php echo $role['role'] ?> (<?php echo $this->lang->line('credit') ?>: <?php echo $role['credit'] ?>)</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <?php if ($this->session->userdata('user_type') != 'PHARMACIST' && $this->session->userdata('user_type') != 'ACCOUNTANT') { ?>
                                                    <div class="form-group col-md-4 m-t-10">
                                                        <label><?php echo $this->lang->line('status') ?> </label>
                                                        <select name="status" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> disabled <?php } ?> class="form-control custom-select" required>
                                                            <option <?php if ($basic->status == 'ACTIVE') echo "Selected" ?> value="ACTIVE">ACTIVE</option>
                                                            <option <?php if ($basic->status == 'INACTIVE') echo "Selected" ?> value="INACTIVE">INACTIVE</option>
                                                        </select>
                                                    </div>
                                                <?php } ?>

                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('date_of_birth') ?> </label>
                                                    <input type="date" id="bs_em_birthday" name="em_birthday" class="form-control" placeholder="" value="<?php echo $basic->em_birthday; ?>" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?>>
                                                </div>

                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('phone') ?> </label>
                                                    <input type="text" class="form-control" placeholder="" name="em_phone" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> value="<?php echo $basic->em_phone; ?>" minlength="10" maxlength="15" required>
                                                </div>

                                                <?php if ($this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                                                    <div class="form-group col-md-4 m-t-10">
                                                        <label><?php echo $this->lang->line('business') ?></label>
                                                        <select name="business_id" id="business_id" value="" class="form-control custom-select" required>
                                                            <option value=""><?php echo $this->lang->line('select_business') ?> </option>
                                                            <?Php foreach ($businesses as $business) : ?>
                                                                <option <?php if ($basic->business_id == $business->id) echo 'Selected' ?> value="<?php echo $business->id ?>"><?php echo $business->name ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                <?php } ?>

                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('email') ?> </label>
                                                    <input type="email" id="bs_em_email" name="em_email" class="form-control" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> value="<?php echo $basic->em_email; ?>" placeholder="email@mail.com" minlength="7" required>
                                                </div>

                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('job_title') ?> </label>
                                                    <input type="text" id="bs_em_job_title" name="em_job_title" class="form-control" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> value="<?php echo $basic->em_job_title; ?>" placeholder="">
                                                </div>

                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('custom_credit') ?> </label>
                                                    <input type="text" id="bs_em_credit" name="em_credit" class="form-control" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> value="<?php echo $basic->em_credit; ?>" placeholder="">
                                                </div>

                                                <div class="form-group col-md-12 m-t-10">
                                                    <?php if (!empty($basic->em_image)) { ?>
                                                        <img src="<?php echo base_url(); ?>assets/images/business/<?php echo $basic->em_image; ?>" class="img-circle" width="150" />
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>assets/images/users/user.png" class="img-circle" width="150" alt="<?php echo $basic->full_name ?>" title="<?php echo $basic->full_name ?>" />
                                                    <?php } ?>
                                                    <label><?php echo $this->lang->line('image') ?> </label>
                                                    <?php if ($this->session->userdata('user_type') != 'PHARMACIST' && $this->session->userdata('user_type') != 'ACCOUNTANT') { ?>
                                                        <input type="file" name="image_url" class="form-control" value="">
                                                    <?php } ?>
                                                </div>

                                                <?php if ($this->session->userdata('user_type') != 'PHARMACIST' && $this->session->userdata('user_type') != 'ACCOUNTANT') { ?>
                                                    <div class="form-actions col-md-12">
                                                        <input type="hidden" name="id" value="<?php echo $basic->id; ?>">
                                                        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                                        <button type="reset" class="btn btn-info"><?php echo $this->lang->line('cancel') ?></button>
                                                    </div>
                                                <?php } ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--second tab-->
                        <div class="tab-pane" id="profile" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $this->lang->line('permanent_contact_information') ?></h3>
                                    <form class="row" action="save_address" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-md-12 m-t-5">
                                            <label><?php echo $this->lang->line('address') ?></label>
                                            <textarea name="address" value="<?php if (!empty($permanent->address)) echo $permanent->address  ?>" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> class="form-control" rows="3" minlength="7" required><?php if (!empty($permanent->address)) echo $permanent->address  ?></textarea>
                                        </div>
                                        <div class="form-group col-md-6 m-t-5">
                                            <label><?php echo $this->lang->line('city') ?></label>
                                            <input type="text" name="city" class="form-control form-control-line" placeholder="" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> value="<?php if (!empty($permanent->city)) echo $permanent->city ?>" minlength="2" required>
                                        </div>
                                        <div class="form-group col-md-6 m-t-5">
                                            <label><?php echo $this->lang->line('country') ?></label>
                                            <input type="text" name="country" class="form-control form-control-line" placeholder="" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> value="<?php if (!empty($permanent->country)) echo $permanent->country ?>" minlength="2" required>
                                        </div>
                                        <?php if ($this->session->userdata('user_type') != 'PHARMACIST' && $this->session->userdata('user_type') != 'ACCOUNTANT') { ?>
                                            <div class="form-actions col-md-12">
                                                <input type="hidden" name="type" value="Permanent">
                                                <input type="hidden" name="emid" value="<?php echo $basic->id ?>">
                                                <input type="hidden" name="id" value="<?php if (!empty($permanent->id)) echo $permanent->id  ?>">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                            </div>
                                        <?php } ?>
                                    </form>

                                    <div class="mt-4">
                                        <h3 class="col-md-12"><?php echo $this->lang->line('present_contact_information') ?></h3>
                                    </div>
                                    <hr>
                                    <form class="row" action="save_address" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-md-12 m-t-5">
                                            <label><?php echo $this->lang->line('address') ?></label>
                                            <textarea name="address" value="<?php if (!empty($present->address)) echo $present->address  ?>" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> class="form-control" rows="3" minlength="7" required><?php if (!empty($present->address)) echo $present->address  ?></textarea>
                                        </div>
                                        <div class="form-group col-md-6 m-t-5">
                                            <label><?php echo $this->lang->line('city') ?></label>
                                            <input type="text" name="city" class="form-control form-control-line" value="<?php if (!empty($present->address)) echo $present->city  ?>" placeholder=" City name" minlength="2" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> required>
                                        </div>
                                        <div class="form-group col-md-6 m-t-5">
                                            <label><?php echo $this->lang->line('country') ?></label>
                                            <input type="text" name="country" class="form-control form-control-line" placeholder="" value="<?php if (!empty($present->address)) echo $present->country  ?>" minlength="2" <?php if ($this->session->userdata('user_type') == 'PHARMACIST' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?> readonly <?php } ?> required>
                                        </div>
                                        <?php if ($this->session->userdata('user_type') != 'PHARMACIST' && $this->session->userdata('user_type') != 'ACCOUNTANT') { ?>
                                            <div class="form-actions col-md-12">
                                                <input type="hidden" name="type" value="Present">
                                                <input type="hidden" name="emid" value="<?php echo $basic->id ?>">
                                                <input type="hidden" name="id" value="<?php if (!empty($present->id)) echo $present->id  ?>">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                            </div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php if ($this->session->userdata('user_type') != 'PHARMACIST' && $this->session->userdata('user_type') != 'ACCOUNTANT') { ?>
                            <div class="tab-pane" id="password" role="tabpanel">
                                <div class="card-body">
                                    <form class="row" action="reset_password" method="post" enctype="multipart/form-data">
                                        <?php if ($isprofile) { ?>
                                            <div class="form-group col-md-6 m-t-20">
                                                <label><?php echo $this->lang->line('current_password') ?></label>
                                                <input type="text" class="form-control" name="old" value="" placeholder="<?php echo $this->lang->line('current_password') ?>" required minlength="6">
                                            </div>
                                            <div class="form-group col-md-6 m-t-20"></div>
                                        <?php } ?>

                                        <div class="form-group col-md-6 m-t-20">
                                            <label><?php echo $this->lang->line('new_password') ?></label>
                                            <input type="text" class="form-control" name="new1" value="" required minlength="6">
                                        </div>
                                        <div class="form-group col-md-6 m-t-20">
                                            <label><?php echo $this->lang->line('confirm_password') ?></label>
                                            <input type="text" id="" name="new2" class="form-control " required minlength="6">
                                        </div>
                                        <div class="form-actions col-md-12">
                                            <input type="hidden" name="emid" value="<?php echo $basic->id; ?>">
                                            <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#business_id").on("change", function(event) {

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

                });
            });
        </script>
        <?php $this->load->view('backend/footer'); ?>