<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-file" style="color:#1976d2"></i> <?php echo $this->lang->line('transaction') ?> #<?php echo $transaction['id']; ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('transaction') ?></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-xlg-12 col-md-12">

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
                                    <div class="card-body">
                                        <small class="text-muted"><?php echo $this->lang->line('email') ?> </small>
                                        <h6><?php echo $basic->em_email; ?></h6>
                                        <small class="text-muted p-t-30 db"><?php echo $this->lang->line('phone') ?></small>
                                        <h6><?php echo $basic->em_phone; ?></h6>
                                        <small class="text-muted p-t-30 db"><?php echo $this->lang->line('job_title') ?></small>
                                        <h6><?php echo $basic->em_job_title; ?></h6>
                                        <small class="text-muted p-t-30 db"><?php echo $this->lang->line('credit') ?></small>
                                        <h6><?php echo $this->lang->line('approved_credit') ?>: <?php echo empty($basic->em_credit) ? (empty($basic->role_credit)? $basic->default_credit : $basic->role_credit) : $basic->em_credit; ?></h6>
                                        <h6><?php echo $this->lang->line('pending_credit') ?>: <?php echo $basic->pending_credit; ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <form class="row" action="saveTransaction" method="post" enctype="multipart/form-data">

                                    <div class="form-group col-md-4 m-t-10">
                                        <label><?php echo $this->lang->line('purchase_date') ?> </label>
                                        <input type="text" name="buy_date" class="form-control mydatetimepickerFull" placeholder="<?php echo $this->lang->line('date') ?>" value="<?php echo date('Y-m-d', strtotime($transaction['buy_date'])); ?>" required>
                                    </div>

                                    <div class="form-group col-md-4 m-t-10">
                                        <label><?php echo $this->lang->line('total_price') ?></label>
                                        <input type="number" name="cost" value="<?php echo $transaction['cost']; ?>" class="form-control" id="recipient-name1" required>
                                    </div>

                                    <div class="form-group col-md-4 m-t-10">
                                        <label><?php echo $this->lang->line('sold_by') ?> </label>
                                        <select name="buy_staff_id" class="form-control custom-select">
                                            <?php foreach ($staffs as $staff) { ?>
                                                <option <?php if ($transaction['buy_staff_id'] == $staff->id) echo "Selected" ?> value="<?php echo $staff->id ?>"><?php echo $staff->first_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12 m-t-10">
                                        <label class="control-label"><?php echo $this->lang->line('details') ?></label>
                                        <textarea class="form-control" name="details" id="message-text1" required rows="4"><?php echo $transaction['details']; ?></textarea>
                                    </div>
                                   
                                    <div class="form-group col-md-6 m-t-10">
                                        <label><?php echo $this->lang->line('bill') ?> </label>
                                        <img src="<?php echo base_url(); ?>assets/images/bills/<?php echo $transaction['bill']; ?>" class="bill_preview" width="100%" />
                                        <input type="file" name="bill" class="form-control" value="">
                                    </div>

                                    <?php if ($this->session->userdata('user_type') == 'EMPLOYEE') { ?>
                                    <?php } else { ?>
                                        <div class="form-actions col-md-12">
                                            <input type="hidden" name="id" value="<?php echo $transaction['id']; ?>">
                                            <input type="hidden" name="emp_id" value="<?php echo $transaction['emp_id']; ?>">
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
            <!-- Column -->
        </div>
        <script>
            $(document).ready(function() {
                $('input[type="file"]').change(function(event) {
                    $(this).prev().fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
                })
            })

        </script>
        <?php $this->load->view('backend/footer'); ?>