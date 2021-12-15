<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<style>
    .searchbox {
        border: solid 2px #ddd;
        padding: 0px;
        border-radius: 50px;
        padding-left: 20px;
    }

    .searchbox .form-control {
        outline: 0 !important;
        border: none !important;
        box-shadow: none;
    }

    .searchbox .form-control:focus {
        outline: 0 !important;
        border: none !important;
        box-shadow: none;
    }

    .searchbox .btn {
        border: solid 0px;
        padding: 9px 15px;
        border-radius: 2px 50px 50px 2px !important;
    }
</style>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>&nbsp <?php echo $this->lang->line('dashboard'); ?></hh3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('dashboard'); ?></li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">
                                    <?php
                                    $this->db->where('status', 'ACTIVE');
                                    $this->db->from("employee");
                                    echo $this->db->count_all_results();
                                    ?>
                                    <?php echo $this->lang->line('staffs') ?>
                                </h3>
                                <a href="<?php echo base_url(); ?>employee/Employees" class="text-muted m-b-0"><?php echo $this->lang->line('view_all') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">
                                    <?php
                                    $this->db->from("business");
                                    echo $this->db->count_all_results();
                                    ?> <?php echo $this->lang->line('businesses') ?>
                                </h3>
                                <a href="<?php echo base_url(); ?>business/business" class="text-muted m-b-0"><?php echo $this->lang->line('view_all') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-danger"><i class="ti-calendar"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">
                                    <?php
                                    $this->db->where('status', 'ACTIVE');
                                    $this->db->from("business_employees");
                                    echo $this->db->count_all_results();
                                    ?> <?php echo $this->lang->line('employees') ?>
                                </h3>
                                <a href="<?php echo base_url(); ?>business/business_employees" class="text-muted m-b-0"><?php echo $this->lang->line('view_all') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row">
                            <div class="round align-self-center round-success"><i class="ti-settings"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0">
                                    <?php
                                    $this->db->where('status', 'Granted');
                                    $this->db->from("loan");
                                    echo $this->db->count_all_results();
                                    ?> Loan
                                </h3>
                                <a href="<?php echo base_url(); ?>Loan/View" class="text-muted m-b-0">View Loan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->
        <!-- Row -->

        <div class="row ">
            <!-- Column -->
            <?php foreach ($businesses as $business) { ?>
                <div class="col-md-6 col-lg-3 col-xlg-3">
                    <div class="card card-inverse card-info">
                        <div class="box <?php echo $bgs[rand(0, 6)] ?> text-center">
                            <h1 class="font-light text-white">
                                <?= $business['employees'] ?>
                            </h1>
                            <h6 class="text-white"><?= $business['name'] ?></h6>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Column -->
        </div>
        <!-- ============================================================== -->
    </div>
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row pr-5">
                            <div class="col-md-6">
                                <h4 class="card-title my-2"><i class="fa fa-credit-card"></i> <?php echo $this->lang->line('credit_shop') ?></h4>
                            </div>
                            <div class="input-group col-md-6 searchbox">
                                <input class="form-control py-2" type="search" value="" id="businessemployeesearch" placeholder="Name, Email, Phone, PIN, Job Title, Business...">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary searchbtn" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive slimScrollDiv border" style="height:600px;overflow-y:scroll">
                            <table class="table table-hover earning-box ">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('business') ?></th>
                                        <th><?php echo $this->lang->line('PIN') ?></th>
                                        <th><?php echo $this->lang->line('name') ?></th>
                                        <th><?php echo $this->lang->line('email') ?></th>
                                        <th><?php echo $this->lang->line('phone') ?></th>
                                        <th><?php echo $this->lang->line('job_title') ?></th>
                                        <th><?php echo $this->lang->line('approved_credit') ?></th>
                                        <th><?php echo $this->lang->line('pending_credit') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody class="employeelist">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Notice Board</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive slimScrollDiv" style="height:600px;overflow-y:scroll">
                            <table class="table table-hover earning-box ">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>File</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Holidays
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="height:600px;overflow-y:scroll">
                            <table class="table table-hover earning-box">
                                <thead>
                                    <tr>
                                        <th>Holiday Name</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
        <?php $this->load->view('backend/credit_shop_modal'); ?>
        <script>
            function creditshop(emp_id) {
                var business = $('.td_business_' + emp_id).html();
                var name = $('.td_name_' + emp_id).html();
                var pin = $('.td_pin_' + emp_id).html();
                var email = $('.td_email_' + emp_id).html();
                var phone = $('.td_phone_' + emp_id).html();
                var credit = $('.td_credit_' + emp_id).html();
                var pending_credit = $('.td_pending_credit_' + emp_id).html();
                var jobtitle = $('.td_jobtitle_' + emp_id).html();

                $('.modal_employee_pin').html(pin);
                $('.modal_employee_name').html(name);
                $('.modal_employee_email').html(email);
                $('.modal_employee_phone').html(phone);
                $('.modal_employee_business').html(business);
                $('.modal_employee_credit').html(credit);
                $('.modal_pending_credit').html(pending_credit);
                $('.modal_employee_jobtitle').html(jobtitle);

                $('.bill_preview').attr('src', '');
                $('#credit_sold_cost').attr('max', credit-pending_credit);
                
                $('#modal_bill_file').val('');
                $('#modal_emp_id').val(emp_id);
                $('#creditshopmodel').modal('show');
            }

            function searchEmployeesByFullText() {
                var searchtearm = $('#businessemploysearch').val();
                $.ajax({
                    url: "search_employees",
                    type: "POST",
                    data: {
                        search: searchtearm
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#businessemploysearch').val('<?php echo $this->lang->line('loading') ?>')
                        $('#businessemploysearch').attr('disabled', true)
                        $(".searchbtn").attr('disabled', true)
                    },
                    success: function(response) {
                        $('#businessemploysearch').val(searchtearm)
                        $('#businessemploysearch').attr('disabled', false)
                        $(".searchbtn").attr('disabled', false)
                        $('.employeelist').html(response.data)
                    },
                    error: function(error) {
                        $('#businessemploysearch').val(searchtearm)
                        $('#businessemploysearch').attr('disabled', false)
                        $(".searchbtn").attr('disabled', false)
                        console.log(error);
                        alert('<?php $this->lang->line('error_occured') ?>');
                    }
                });
            }
            $(document).ready(function() {
                searchEmployeesByFullText();
                $(".searchbtn").on("click", function(event) {
                    searchEmployeesByFullText();
                });

                $('#businessemployeesearch').keypress(function(e) {
                    var key = e.which;
                    if (key == 13) // the enter key code
                    {
                        searchEmployeesByFullText();
                    }
                });

                $('#modal_bill_file').change(function(event) {
                    $(".bill_preview").fadeIn("fast").attr('src', URL.createObjectURL(event.target.files[0]));
                })
            });
        </script>

        <?php $this->load->view('backend/footer'); ?>