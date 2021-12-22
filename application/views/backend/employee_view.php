<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-user-secret" style="color:#1976d2"></i> <?php echo $basic->first_name . ' ' . $basic->last_name; ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <?php if ($isprofile) { ?>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line('profile') ?></a></li>
                <?php } elseif ($isedit) { ?>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line('edit_employee') ?></a></li>
                <?php } else { ?>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line('view_employee') ?></a></li>
                <?php } ?>
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
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#social" role="tab" style="font-size: 14px;"> <?php echo $this->lang->line('social_media') ?></a> </li>
                        <?php if ($isprofile) { ?>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#password" role="tab" style="font-size: 14px;"> <?php echo $this->lang->line('change_password') ?></a> </li>
                        <?php } elseif ($isedit) { ?>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#password1" role="tab" style="font-size: 14px;"> <?php echo $this->lang->line('change_password') ?></a> </li>
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
                                                            <img src="<?php echo base_url(); ?>assets/images/users/<?php echo $basic->em_image; ?>" class="img-circle" width="150" />
                                                        <?php } else { ?>
                                                            <img src="<?php echo base_url(); ?>assets/images/users/user.png" class="img-circle" width="150" alt="<?php echo $basic->first_name ?>" title="<?php echo $basic->first_name ?>" />
                                                        <?php } ?>
                                                        <h4 class="card-title m-t-10"><?php echo $basic->first_name . ' ' . $basic->last_name; ?></h4>
                                                        <h6 class="card-subtitle"><?php echo $basic->des_name; ?></h6>
                                                    </center>
                                                </div>
                                                <div>
                                                    <hr>
                                                </div>
                                                <div class="card-body"> <small class="text-muted">Email address </small>
                                                    <h6><?php echo $basic->em_email; ?></h6> <small class="text-muted p-t-30 db">Phone</small>
                                                    <h6><?php echo $basic->em_phone; ?></h6>
                                                    <small class="text-muted p-t-30 db">Social Profile</small>
                                                    <br />
                                                    <a class="btn btn-circle btn-secondary" href="<?php if (!empty($socialmedia->facebook)) echo $socialmedia->facebook ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                                    <a class="btn btn-circle btn-secondary" href="<?php if (!empty($socialmedia->twitter)) echo $socialmedia->twitter ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                                    <a class="btn btn-circle btn-secondary" href="<?php if (!empty($socialmedia->skype_id)) echo $socialmedia->skype_id ?>" target="_blank"><i class="fa fa-skype"></i></a>
                                                    <a class="btn btn-circle btn-secondary" href="<?php if (!empty($socialmedia->google_Plus)) echo $socialmedia->google_Plus ?>" target="_blank"><i class="fa fa-google"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <form class="row" action="Update" method="post" enctype="multipart/form-data">

                                                <div class="form-group col-md-4 m-t-10">
                                                    <label> <?php echo $this->lang->line('PIN') ?> </label>
                                                    <input type="text" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> class="form-control form-control-line" placeholder="ID" name="eid" value="<?php echo $basic->em_code; ?>" required>
                                                </div>
                                                <div class="form-group col-md-4 m-t-10">
                                                    <label> <?php echo $this->lang->line('first_name') ?> </label>
                                                    <input type="text" class="form-control form-control-line" placeholder="Your first name" name="fname" value="<?php echo $basic->first_name; ?>" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> minlength="3" required>
                                                </div>
                                                <div class="form-group col-md-4 m-t-10">
                                                    <label> <?php echo $this->lang->line('last_name') ?> </label>
                                                    <input type="text" id="" name="lname" class="form-control form-control-line" value="<?php echo $basic->last_name; ?>" placeholder="Your last name" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> minlength="3" required>
                                                </div>
                                                <div class="form-group col-md-4 m-t-10">
                                                    <label> <?php echo $this->lang->line('boold_group') ?> </label>
                                                    <select name="blood" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> value="<?php echo $basic->em_blood_group; ?>" class="form-control custom-select">
                                                        <option value="<?php echo $basic->em_blood_group; ?>"><?php echo $basic->em_blood_group; ?></option>
                                                        <option value="O+">O+</option>
                                                        <option value="O-">O-</option>
                                                        <option value="A+">A+</option>
                                                        <option value="A-">A-</option>
                                                        <option value="B+">B+</option>
                                                        <option value="B-">B-</option>
                                                        <option value="AB+">AB+</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 m-t-10">
                                                    <label> <?php echo $this->lang->line('gender') ?> </label>
                                                    <select name="gender" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> class="form-control custom-select">

                                                        <option value="<?php echo $basic->em_gender; ?>"><?php echo $basic->em_gender; ?></option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                                <?php if ($isedit) { ?>
                                                    <div class="form-group col-md-4 m-t-10">
                                                        <label> <?php echo $this->lang->line('role') ?> </label>
                                                        <select name="role" class="form-control custom-select" required>
                                                            <option value="PHARMACIST" <?php echo $basic->em_role == "PHARMACIST" ? "selected" : "" ?>> <?php echo $this->lang->line('pharmacist') ?> </option>
                                                            <option value="ACCOUNTANT" <?php echo $basic->em_role == "ACCOUNTANT" ? "selected" : "" ?>> <?php echo $this->lang->line('accountant') ?> </option>
                                                            <option value="SUPER ADMIN" <?php echo $basic->em_role == "SUPER ADMIN" ? "selected" : "" ?>> <?php echo $this->lang->line('super_admin') ?> </option>
                                                        </select>
                                                    </div>
                                                <?php } ?>
                                                <?php if ($isedit) { ?>
                                                    <div class="form-group col-md-4 m-t-10">
                                                        <label> <?php echo $this->lang->line('status') ?> </label>
                                                        <select name="status" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> class="form-control custom-select" required>
                                                            <option value="ACTIVE" <?php echo $basic->status == "ACTIVE" ? "selected" : "" ?>> <?php echo $this->lang->line('active') ?> </option>
                                                            <option value="INACTIVE" <?php echo $basic->status == "INACTIVE" ? "selected" : "" ?>> <?php echo $this->lang->line('inactive') ?> </option>
                                                        </select>
                                                    </div>
                                                <?php } ?>
                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('date_of_birth') ?> </label>
                                                    <input type="date" id="example-email2" name="dob" class="form-control" placeholder="" value="<?php echo $basic->em_birthday; ?>" required>
                                                </div>

                                                <div class="form-group col-md-4 m-t-10">
                                                    <label> <?php echo $this->lang->line('contact_number') ?> </label>
                                                    <input type="text" class="form-control" placeholder="" name="contact" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> value="<?php echo $basic->em_phone; ?>" minlength="10" maxlength="15" required>
                                                </div>

                                                <div class="form-group col-md-4 m-t-10">
                                                    <label><?php echo $this->lang->line('email') ?></label>
                                                    <input type="email" id="example-email2" name="email" class="form-control" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> value="<?php echo $basic->em_email; ?>" placeholder="email@mail.com" minlength="7" required>
                                                </div>
                                                <div class="form-group col-md-12 m-t-10">
                                                    <?php if (!empty($basic->em_image)) { ?>
                                                        <img src="<?php echo base_url(); ?>assets/images/users/<?php echo $basic->em_image; ?>" class="img-circle" width="150" />
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>assets/images/users/user.png" class="img-circle" width="150" alt="<?php echo $basic->first_name ?>" title="<?php echo $basic->first_name ?>" />
                                                    <?php } ?>
                                                    <label><?php echo $this->lang->line('image') ?></label>
                                                    <?php if ($isprofile || $isedit) { ?>
                                                    <input type="file" name="image_url" class="form-control" value="">
                                                    <?php } ?>
                                                </div>
                                                <?php if ($isprofile || $isedit) { ?>
                                                    <div class="form-actions col-md-12">
                                                        <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">
                                                        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                                        <button type="button" class="btn btn-info"><?php echo $this->lang->line('cancel') ?></button>
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
                                    <h3 class="card-title">Permanent Contact Information</h3>
                                    <form class="row" action="Parmanent_Address" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-md-12 m-t-5">
                                            <label>Address</label>
                                            <textarea name="paraddress" value="<?php if (!empty($permanent->address)) echo $permanent->address  ?>" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> class="form-control" rows="3" minlength="7" required><?php if (!empty($permanent->address)) echo $permanent->address  ?></textarea>
                                        </div>
                                        <div class="form-group col-md-6 m-t-5">
                                            <label>City</label>
                                            <input type="text" name="parcity" class="form-control form-control-line" placeholder="" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> value="<?php if (!empty($permanent->city)) echo $permanent->city ?>" minlength="2" required>
                                        </div>
                                        <div class="form-group col-md-6 m-t-5">
                                            <label>Country</label>
                                            <input type="text" name="parcountry" class="form-control form-control-line" placeholder="" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> value="<?php if (!empty($permanent->country)) echo $permanent->country ?>" minlength="2" required>
                                        </div>
                                        <?php if ($isprofile || $isedit) { ?>
                                        
                                            <div class="form-actions col-md-12">
                                                <input type="hidden" name="emid" value="<?php echo $basic->em_id ?>">
                                                <input type="hidden" name="id" value="<?php if (!empty($permanent->id)) echo $permanent->id  ?>">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                            </div>
                                        <?php } ?>
                                    </form>

                                    <div class="">
                                        <h3 class="col-md-12">Present Contact Information</h3>
                                    </div>
                                    <hr>
                                    <form class="row" action="Present_Address" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-md-12 m-t-5">
                                            <label>Address</label>
                                            <textarea name="presaddress" value="<?php if (!empty($present->address)) echo $present->address  ?>" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> class="form-control" rows="3" minlength="7" required><?php if (!empty($present->address)) echo $present->address  ?></textarea>
                                        </div>
                                        <div class="form-group col-md-6 m-t-5">
                                            <label>City</label>
                                            <input type="text" name="prescity" class="form-control form-control-line" value="<?php if (!empty($present->address)) echo $present->city  ?>" placeholder=" City name" minlength="2" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> required>
                                        </div>
                                        <div class="form-group col-md-6 m-t-5">
                                            <label>Country</label>
                                            <input type="text" name="prescountry" class="form-control form-control-line" placeholder="" value="<?php if (!empty($present->address)) echo $present->country  ?>" minlength="2" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> required>
                                        </div>
                                        <?php if ($isprofile || $isedit) { ?>
                                        
                                            <div class="form-actions col-md-12">
                                                <input type="hidden" name="emid" value="<?php echo $basic->em_id ?>">
                                                <input type="hidden" name="id" value="<?php if (!empty($present->id)) echo $present->id  ?>">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                            </div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="social" role="tabpanel">
                            <div class="card-body">
                                <form class="row" action="Save_Social" method="post" enctype="multipart/form-data">
                                    <div class="form-group col-md-6 m-t-20">
                                        <label>Facebook</label>
                                        <input type="url" class="form-control" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> name="facebook" value="<?php if (!empty($socialmedia->facebook)) echo $socialmedia->facebook ?>" placeholder="www.facebook.com">
                                    </div>
                                    <div class="form-group col-md-6 m-t-20">
                                        <label>Twitter</label>
                                        <input type="text" class="form-control" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> name="twitter" value="<?php if (!empty($socialmedia->twitter)) echo $socialmedia->twitter ?>">
                                    </div>
                                    <div class="form-group col-md-6 m-t-20">
                                        <label>Google +</label>
                                        <input type="text" id="" name="google" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> class="form-control " value="<?php if (!empty($socialmedia->google_plus)) echo $socialmedia->google_plus ?>">
                                    </div>
                                    <div class="form-group col-md-6 m-t-20">
                                        <label>Skype</label>
                                        <input type="text" id="" name="skype" <?php if (!$isprofile && !$isedit) { ?> readonly <?php } ?> class="form-control " value="<?php if (!empty($socialmedia->skype_id)) echo $socialmedia->skype_id ?>">
                                    </div>
                                    <?php if ($isprofile || $isedit) { ?>
                                        <div class="form-actions col-md-12">
                                            <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">
                                            <input type="hidden" name="id" value="<?php if (!empty($socialmedia->id)) echo $socialmedia->id ?>">
                                            <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                        </div>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                        <?php if ($isedit) { ?>
                            <div class="tab-pane" id="password1" role="tabpanel">
                                <div class="card-body">
                                    <form class="row" action="Reset_Password_Hr" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-md-6 m-t-20">
                                            <label>Password</label>
                                            <input type="text" class="form-control" name="new1" value="" required minlength="6">
                                        </div>
                                        <div class="form-group col-md-6 m-t-20">
                                            <label>Confirm Password</label>
                                            <input type="text" id="" name="new2" class="form-control " required minlength="6">
                                        </div>
                                        <?php if ($isprofile || $isedit) { ?>
                                        
                                            <div class="form-actions col-md-12">
                                                <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">
                                                <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                            </div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($isprofile) { ?>
                            <div class="tab-pane" id="password" role="tabpanel">
                                <div class="card-body">
                                    <form class="row" action="Reset_Password" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-md-6 m-t-20">
                                            <label>Old Password</label>
                                            <input type="text" class="form-control" name="old" value="" placeholder="old password" required minlength="6">
                                        </div>
                                        <div class="form-group col-md-6 m-t-20">
                                            <label>Password</label>
                                            <input type="text" class="form-control" name="new1" value="" required minlength="6">
                                        </div>
                                        <div class="form-group col-md-6 m-t-20">
                                            <label>Confirm Password</label>
                                            <input type="text" id="" name="new2" class="form-control " required minlength="6">
                                        </div>
                                        <div class="form-actions col-md-12">
                                            <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">
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

        <?php $this->load->view('backend/footer'); ?>