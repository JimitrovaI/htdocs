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

    .business_info_small {
        min-width: 130px;
        display: inline-block;
    }
</style>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-fax" style="color:#1976d2"> </i> <?php echo $this->lang->line('business_employees') ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('business_employees') ?></li>
            </ol>
        </div>
    </div>

    <?php if (!empty($this->session->flashdata('delsuccess'))) { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><?php echo $this->session->flashdata('delsuccess'); ?></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

    <div class="container-fluid">
        <div class="row m-b-10">
            <?php if ($this->session->userdata('user_business') != 'pharmacy' || ($this->session->userdata('user_business') == 'pharmacy' && $this->session->userdata('user_type') == 'SUPER ADMIN')) { ?>
                <div class="col-12">
                    <button type="button" id="add_business_employee_btn" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>business/add_employee" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->lang->line('add_employee') ?></a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="#" class="text-white" data-toggle="modal" data-target="#Bulkmodal"><i class="" aria-hidden="true"></i> <?php echo $this->lang->line('add_bulk_employee') ?></a></button>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo $this->lang->line('business_employee_list') ?></h4>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                                        <form method="post" action="" id="businessform" class="form-material row">
                                            <div class="form-group col-md-3 business-select2">
                                                <select class="select2 form-control" data-placeholder="Choose a Category" tabindex="1" id="businessid" name="businessid" required>
                                                    <option value="#"><?php echo $this->lang->line('select_business') ?></option>
                                                    <option value="all" selected><?php echo $this->lang->line('all_business') ?></option>
                                                    <?php foreach ($businesses as $business) { ?>
                                                        <option value="<?php echo $business->id ?>"><?php echo $business->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </form>
                                    <?php } else { ?>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h3><?php echo $business['name'] ?></h3>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="business_info_small"> <?php echo $this->lang->line('contact') ?> </small> : <?php echo $business['contact_person'] ?> <br>
                                                <small class="business_info_small"><?php echo $this->lang->line('email') ?> </small> : <?php echo $business['contact_email'] ?> <br>
                                                <small class="business_info_small"> <?php echo $this->lang->line('phone') ?> </small> : <?php echo $business['contact_phone'] ?>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="business_info_small"> <?php echo $this->lang->line('payment_agreement') ?> </small> : <?php if ($business['payment_agreement'] == "MONTH") {
                                                                                                                                                        echo $this->lang->line('1st_of_month');
                                                                                                                                                    } elseif ($business['payment_agreement'] == "TWICE") {
                                                                                                                                                        echo $this->lang->line('twice_a_month');
                                                                                                                                                    } else {
                                                                                                                                                        echo $this->lang->line('every_friday');
                                                                                                                                                    } ?><br>
                                                <small class="business_info_small"><?php echo $this->lang->line('next_date') ?> </small> : <?php if ($business['payment_agreement'] == "MONTH") {
                                                                                                                                                echo date('Y-m-01', strtotime(date('Y-m-d') . " 1 month"));
                                                                                                                                            } elseif ($business['payment_agreement'] == "TWICE") {
                                                                                                                                                if (date('j') <= 15) {
                                                                                                                                                    echo date('Y-m-15');
                                                                                                                                                } elseif (date('t') < 30) {
                                                                                                                                                    echo date('Y-m-t');
                                                                                                                                                } else {
                                                                                                                                                    echo date('Y-m-30');
                                                                                                                                                }
                                                                                                                                            } else {
                                                                                                                                                echo date('Y-m-d', strtotime(date('Y-m-d') . ((5 - date('w') < 0) ? 7 + 5 - date('w') : 5 - date('w')) . " day"));
                                                                                                                                            } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="business_employee_tbl" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('business') ?></th>
                                        <th><?php echo $this->lang->line('name') ?></th>
                                        <th><?php echo $this->lang->line('PIN') ?></th>
                                        <th><?php echo $this->lang->line('email') ?></th>
                                        <th><?php echo $this->lang->line('phone') ?></th>
                                        <th><?php echo $this->lang->line('role') ?></th>
                                        <th><?php echo $this->lang->line('credit') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th><?php echo $this->lang->line('business') ?></th>
                                        <th><?php echo $this->lang->line('employee_name') ?></th>
                                        <th><?php echo $this->lang->line('PIN') ?></th>
                                        <th><?php echo $this->lang->line('email') ?></th>
                                        <th><?php echo $this->lang->line('phone') ?></th>
                                        <th><?php echo $this->lang->line('role') ?></th>
                                        <th><?php echo $this->lang->line('credit') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </tfoot>
                                <tbody class="employees">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->session->userdata('user_business') != 'pharmacy' || ($this->session->userdata('user_business') == 'pharmacy' && $this->session->userdata('user_type') == 'SUPER ADMIN')) { ?>
            <div id="Bulkmodal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="import" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('add_employee') ?></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <h4 class="text-right"><a href="<?php echo base_url(); ?>assets/images/samplefiles/importbusinessemployeesampledata.csv" download><?php echo $this->lang->line('download_sample_csv_file') ?> <i class="fa fa-download"></i></a></h4>
                                <?php if ($this->session->userdata('user_business') == 'pharmacy' && $this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                                    <div class="form-group m-t-20">
                                        <label><?php echo $this->lang->line('business') ?></label>
                                        <select name="business_id" value="" class="form-control custom-select" required>
                                            <option value=""><?php echo $this->lang->line('select_business') ?> </option>
                                            <?Php foreach ($businesses as $business) : ?>
                                                <option value="<?php echo $business->id ?>"><?php echo $business->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php } ?>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line('import_excel') ?> </label>
                                    <input type="file" name="csv_file" class="form-control" id="csv_file" accept=".csv" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info waves-effect">Save</button>
                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        <?php } ?>
        <script>
            function searchemployeebybusiness() {
                $('#business_employee_tbl').DataTable().destroy();

                var businessid = <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>$('#businessid').val() <?php } else {
                                                                                                                                echo $this->session->userdata('user_business');
                                                                                                                            } ?>;
                if (businessid == "#") {
                    $('.employees').html('');
                } else {
                    $.ajax({
                        url: "Get_BusinessDetails?business_id=" + businessid,
                        type: "GET",
                        data: 'data',
                        success: function(response) {
                            $('.employees').html(response);
                            $('#business_employee_tbl').DataTable({
                                dom: 'Bfrtip',
                                buttons: [
                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                ]
                            });
                        }
                    });
                }
            }
            $(document).ready(function() {
                searchemployeebybusiness();
                $("#businessid").on("change", function(event) {
                    searchemployeebybusiness()
                });
            });
        </script>
        <?php $this->load->view('backend/footer'); ?>