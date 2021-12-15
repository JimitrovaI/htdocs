<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<style type="text/css">
    .business-select2 .select2-container {
        width: 100% !important;
    }

    .business-select2 .select2-container .select2-selection--single {
        height: 38px;
        padding-top: 5px;
        border: 1px solid #d9d8d8;
    }

    .business-select2 .select2-container--default .select2-selection--single .select2-selection__arrow {
        margin-top: 5px;
    }
</style>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-file" style="color:#1976d2"></i> <?php echo $this->lang->line('add_transaction') ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('add_transaction') ?></li>
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

                                            <img src="<?php echo base_url(); ?>assets/images/users/user.png" class="img-circle employee_img" width="150" />

                                            <h4 class="card-title m-t-10 business_employee_name"></h4>
                                            <h6 class="card-subtitle business_name"></h6>

                                        </center>
                                    </div>
                                    <div>
                                        <hr>
                                    </div>
                                    <div class="card-body">
                                        <small class="text-muted"><?php echo $this->lang->line('email') ?> </small>
                                        <h6 class="em_email"></h6>
                                        <small class="text-muted p-t-30 db"><?php echo $this->lang->line('phone') ?></small>
                                        <h6 class="em_phone"></h6>
                                        <small class="text-muted p-t-30 db"><?php echo $this->lang->line('job_title') ?></small>
                                        <h6 class="em_job_title"></h6>
                                        <small class="text-muted p-t-30 db"><?php echo $this->lang->line('credit') ?></small>
                                        <h6 class="em_credit"></h6>
                                        <h6 class="pending_credit"></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <form class="row" action="saveTransaction" method="post" enctype="multipart/form-data">

                                    <div class="form-group col-md-4 m-t-10 business-select2">
                                        <label><?php echo $this->lang->line('business') ?> </label>
                                        <select class="select2 form-control" data-placeholder="Choose a Category" tabindex="1" id="business_id" name="business_id" required>
                                            <option value=""><?php echo $this->lang->line('select_business') ?></option>
                                            <?php foreach ($businesses as $business) { ?>
                                                <option value="<?php echo $business->id ?>"><?php echo $business->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-8 m-t-10 business-select2">
                                        <label><?php echo $this->lang->line('employee') ?> </label>
                                        <select class="select2 form-control" data-placeholder="Choose a Category" tabindex="1" id="business_employee" name="emp_id" required>
                                            <option value=""><?php echo $this->lang->line('select_employee') ?></option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4 m-t-10">
                                        <label><?php echo $this->lang->line('purchase_date') ?> </label>
                                        <input type="text" name="buy_date" class="form-control mydatetimepickerFull" placeholder="<?php echo $this->lang->line('date') ?>" value="" required>
                                    </div>

                                    <div class="form-group col-md-4 m-t-10">
                                        <label><?php echo $this->lang->line('total_price') ?></label>
                                        <input type="number" name="cost" value="" class="form-control" id="recipient-name1" required>
                                    </div>

                                    <div class="form-group col-md-4 m-t-10">
                                        <label><?php echo $this->lang->line('sold_by') ?> </label>
                                        <select name="buy_staff_id" class="form-control custom-select">
                                            <?php foreach ($staffs as $staff) { ?>
                                                <option value="<?php echo $staff->id ?>"><?php echo $staff->first_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12 m-t-10">
                                        <label class="control-label"><?php echo $this->lang->line('details') ?></label>
                                        <textarea class="form-control" name="details" id="message-text1" required rows="4"></textarea>
                                    </div>


                                    <div class="form-group col-md-6 m-t-10">
                                        <label><?php echo $this->lang->line('bill') ?> </label>
                                        <img src="" class="bill_preview" width="100%" />
                                        <input type="file" name="bill" class="form-control" value="">
                                    </div>

                                    <?php if ($this->session->userdata('user_type') == 'EMPLOYEE') { ?>
                                    <?php } else { ?>
                                        <div class="form-actions col-md-12">
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
                    $(this).prev().fadeIn("fast").attr('src', URL.createObjectURL(event.target.files[0]));
                })

                $("#business_id").on("change", function(event) {

                    $('#business_employee').html('<option value=""><?php echo $this->lang->line('select_employee') ?></option>');
                    var business_id = $('#business_id').val();

                    if (business_id !== "") {
                        $.ajax({
                            url: "getemployeesbybusiness",
                            type: "POST",
                            data: {
                                business_id: business_id
                            },
                            dataType: 'json',
                            success: function(response) {
                                $('#business_employee').append(response.data);
                            }
                        });
                    }
                    $('#business_employee').select2();

                });

                $("#business_employee").on("change", function(event) {

                    var employee_id = $('#business_id').val();

                    $('.business_employee_name').html('');
                    $('.business_name').html('');
                    $('.employee_img').attr('src', "<?php echo base_url(); ?>assets/images/users/user.png");
                    $('.em_email').html('');
                    $('.em_phone').html('');
                    $('.em_job_title').html('');
                    $('.em_credit').html('');
                    $('.pending_credit').html('');

                    if (business_id !== "") {
                        $.ajax({
                            url: "getEmployeeDatabyId",
                            type: "POST",
                            data: {
                                employee_id: employee_id
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.data) {
                                    $('.business_employee_name').html(response.data.name);
                                    $('.business_name').html(response.data.business);
                                    $('.employee_img').attr('src', response.data.img);
                                    $('.em_email').html(response.data.email);
                                    $('.em_phone').html(response.data.phone);
                                    $('.em_job_title').html(response.data.job_title);
                                    $('.em_credit').html("<?php echo $this->lang->line('approved_credit') ?>: "+response.data.credit);
                                    $('.pending_credit').html("<?php echo $this->lang->line('pending_credit') ?>: "+response.data.pending_credit);
                                }
                            }
                        });
                    }
                });
            })
        </script>
        <?php $this->load->view('backend/footer'); ?>