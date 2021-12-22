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

    .dashboard-title:hover {
        opacity: 0.8;
        cursor: pointer !important
    }

    .dashboard-title svg {
        width: 60px;
        opacity: 0.7;
    }

    .flex-grow-1 {
        flex-grow: 1;
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

        <div class="row ">
            <!-- Column -->
            <div class="col-sm-6 col-md-3 col-lg-3 col-xlg-3">
                <div class="card card-inverse card-info">
                    <a href="<?php echo base_url(); ?>business/business_employees">
                        <div class="box bg-info dashboard-title d-flex px-3 py-3">

                            <div class="flex-grow-1">
                                <h4 class="text-white">
                                    <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                                        <b><?= $this->lang->line('business') ?></b>
                                    <?php } else { ?>
                                        <b><?= $business_name ?></b>
                                    <?php } ?>
                                </h4>
                                <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                                    <h6 class="text-white"><?= $this->lang->line('total_count') ?> : <?= $business_count ?></h6>
                                    <h6 class="text-white"><?= $this->lang->line('employees') ?> : <?= $active_employee_count ?></h6>
                                <?php } else { ?>
                                    <h6 class="text-white"><?= $this->lang->line('employees') ?> : <?= $active_employee_count ?></h6>
                                    <h6 class="text-white"> &nbsp;</h6>
                                <?php } ?>
                            </div>
                            <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>

                                <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="building" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-building fa-w-14 fa-fw fa-2x">
                                    <path fill="white" d="M192 107v40c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12zm116-12h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12v-40c0-6.627-5.373-12-12-12zm-128 96h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12v-40c0-6.627-5.373-12-12-12zm128 0h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12v-40c0-6.627-5.373-12-12-12zm-128 96h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12v-40c0-6.627-5.373-12-12-12zm128 0h-40c-6.627 0-12 5.373-12 12v40c0 6.627 5.373 12 12 12h40c6.627 0 12-5.373 12-12v-40c0-6.627-5.373-12-12-12zm140 205v20H0v-20c0-6.627 5.373-12 12-12h20V24C32 10.745 42.745 0 56 0h336c13.255 0 24 10.745 24 24v456h20c6.627 0 12 5.373 12 12zm-64-12V32H64v448h128v-85c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v85h128z" class=""></path>
                                </svg>

                            <?php } else { ?>


                                <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="users" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-users fa-w-20 fa-fw fa-2x">
                                    <path fill="white" d="M544 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-128c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zM320 256c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm0-192c44.1 0 80 35.9 80 80s-35.9 80-80 80-80-35.9-80-80 35.9-80 80-80zm244 192h-40c-15.2 0-29.3 4.8-41.1 12.9 9.4 6.4 17.9 13.9 25.4 22.4 4.9-2.1 10.2-3.3 15.7-3.3h40c24.2 0 44 21.5 44 48 0 8.8 7.2 16 16 16s16-7.2 16-16c0-44.1-34.1-80-76-80zM96 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-128c26.5 0 48 21.5 48 48s-21.5 48-48 48-48-21.5-48-48 21.5-48 48-48zm304.1 180c-33.4 0-41.7 12-80.1 12-38.4 0-46.7-12-80.1-12-36.3 0-71.6 16.2-92.3 46.9-12.4 18.4-19.6 40.5-19.6 64.3V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-44.8c0-23.8-7.2-45.9-19.6-64.3-20.7-30.7-56-46.9-92.3-46.9zM480 432c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16v-44.8c0-16.6 4.9-32.7 14.1-46.4 13.8-20.5 38.4-32.8 65.7-32.8 27.4 0 37.2 12 80.2 12s52.8-12 80.1-12c27.3 0 51.9 12.3 65.7 32.8 9.2 13.7 14.1 29.8 14.1 46.4V432zM157.1 268.9c-11.9-8.1-26-12.9-41.1-12.9H76c-41.9 0-76 35.9-76 80 0 8.8 7.2 16 16 16s16-7.2 16-16c0-26.5 19.8-48 44-48h40c5.5 0 10.8 1.2 15.7 3.3 7.5-8.5 16.1-16 25.4-22.4z" class=""></path>
                                </svg>
                            <?php } ?>

                        </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xlg-3">
                <div class="card card-inverse card-info">
                    <a href="<?php echo base_url(); ?>transaction/transactions?status=COMPLETE">
                        <div class="box bg-success dashboard-title d-flex px-4 py-3">
                            <div class="flex-grow-1">
                                <h4 class="text-white">
                                    <b><?= $this->lang->line('completed') ?></b>
                                </h4>
                                <h6 class="text-white"><?= $this->lang->line('total_count') ?> : <?= $completed_transaction_count ?></h6>
                                <h6 class="text-white"><?= $this->lang->line('total_price') ?> : <?= $completed_transaction_price ?></h6>
                            </div>
                            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="calendar-check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-calendar-check fa-w-14 fa-fw fa-2x">
                                <path fill="white" d="M400 64h-48V12c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v52H160V12c0-6.627-5.373-12-12-12h-40c-6.627 0-12 5.373-12 12v52H48C21.49 64 0 85.49 0 112v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm-6 400H54a6 6 0 0 1-6-6V160h352v298a6 6 0 0 1-6 6zm-52.849-200.65L198.842 404.519c-4.705 4.667-12.303 4.637-16.971-.068l-75.091-75.699c-4.667-4.705-4.637-12.303.068-16.971l22.719-22.536c4.705-4.667 12.303-4.637 16.97.069l44.104 44.461 111.072-110.181c4.705-4.667 12.303-4.637 16.971.068l22.536 22.718c4.667 4.705 4.636 12.303-.069 16.97z" class=""></path>
                            </svg>

                        </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xlg-3">
                <div class="card card-inverse card-info">
                    <a href="<?php echo base_url(); ?>transaction/transactions?status=PENDING">
                        <div class="box bg-warning dashboard-title d-flex px-4 py-3">
                            <div class="flex-grow-1">
                                <h4 class="text-white">
                                    <b><?= $this->lang->line('pending') ?></b>
                                </h4>
                                <h6 class="text-white"><?= $this->lang->line('total_count') ?> : <?= $pending_transaction_count ?></h6>
                                <h6 class="text-white"><?= $this->lang->line('total_price') ?> : <?= $pending_transaction_price ?></h6>
                            </div>
                            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="calendar-minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-calendar-minus fa-w-14 fa-fw fa-2x">
                                <path fill="white" d="M124 328c-6.6 0-12-5.4-12-12v-24c0-6.6 5.4-12 12-12h200c6.6 0 12 5.4 12 12v24c0 6.6-5.4 12-12 12H124zm324-216v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48zm-48 346V160H48v298c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xlg-3">
                <div class="card card-inverse card-info">
                    <a href="<?php echo base_url(); ?>transaction/transactions?status=OVERDUE">
                        <div class="box bg-danger dashboard-title d-flex px-4 py-3">
                            <div class="flex-grow-1">
                                <h4 class="text-white">
                                    <b><?= $this->lang->line('overdue') ?></b>
                                </h4>
                                <h6 class="text-white"><?= $this->lang->line('total_count') ?> : <?= $overdue_transaction_count ?></h6>
                                <h6 class="text-white"><?= $this->lang->line('total_price') ?> : <?= $overdue_transaction_price ?></h6>
                            </div>
                            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="calendar-times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-calendar-times fa-w-14 fa-fw fa-2x">
                                <path fill="white" d="M311.7 374.7l-17 17c-4.7 4.7-12.3 4.7-17 0L224 337.9l-53.7 53.7c-4.7 4.7-12.3 4.7-17 0l-17-17c-4.7-4.7-4.7-12.3 0-17l53.7-53.7-53.7-53.7c-4.7-4.7-4.7-12.3 0-17l17-17c4.7-4.7 12.3-4.7 17 0l53.7 53.7 53.7-53.7c4.7-4.7 12.3-4.7 17 0l17 17c4.7 4.7 4.7 12.3 0 17L257.9 304l53.7 53.7c4.8 4.7 4.8 12.3.1 17zM448 112v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48zm-48 346V160H48v298c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>

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
                $('#credit_sold_cost').attr('max', credit - pending_credit);

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