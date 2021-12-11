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
            <h3 class="text-themecolor"><i class="fa fa-fax" style="color:#1976d2"> </i> <?php echo $this->lang->line('business_employees') ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('business_employees') ?></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" id="add_business_employee_btn" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>business/add_employee" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->lang->line('add_employee') ?></a></button>
            </div>
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
                                    <form method="post" action="" id="businessform" class="form-material row">
                                        <div class="form-group col-md-3 business-select2">
                                            <select class="select2 form-control" data-placeholder="Choose a Category" tabindex="1" id="businessid" name="businessid" required>
                                                <option value="#"><?php echo $this->lang->line('select_business') ?></option>
                                                <option value="all"><?php echo $this->lang->line('all_business') ?></option>
                                                <?php foreach ($businesses as $business) { ?>
                                                    <option value="<?php echo $business->id ?>"><?php echo $business->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <input type="submit" class="btn btn-success" value="<?php echo $this->lang->line('submit') ?>" name="submit" id="BtnSubmit">
                                        </div>
                                    </form>
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
                                        <th><?php echo $this->lang->line('employee_name') ?></th>
                                        <th><?php echo $this->lang->line('PIN') ?></th>
                                        <th><?php echo $this->lang->line('email') ?></th>
                                        <th><?php echo $this->lang->line('phone') ?></th>
                                        <th><?php echo $this->lang->line('employee_type') ?></th>
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
                                        <th><?php echo $this->lang->line('employee_type') ?></th>
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
        <script>
            $(document).ready(function() {
                $("#BtnSubmit").on("click", function(event) {
                    $('#business_employee_tbl').DataTable().destroy();
                    event.preventDefault();

                    var businessid = $('#businessid').val();
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

                });
            });
        </script>
        <?php $this->load->view('backend/footer'); ?>