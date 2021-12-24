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
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-cubes" style="color:#1976d2"></i> <?php echo $this->lang->line('business_role') ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('business_role') ?></li>
            </ol>
        </div>
    </div>
    <div class="message"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <?php if (isset($editrole)) { ?>
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><?php echo $this->lang->line('edit_business_role') ?></h4>
                        </div>
                        <div class="form-header-info">
                            <span class="error_msg"><?php echo validation_errors(); ?></span>
                            <span class="error_msg"><?php echo $this->upload->display_errors(); ?></span><br>
                            <?php echo $this->session->flashdata('feedback'); ?>
                        </div>

                        <div class="card-body">
                            <form method="post" action="<?php echo base_url(); ?>business/update_role" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row ">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('business') ?></label>
                                                <select name="business_id" value="" class="form-control custom-select" required <?php echo $this->session->userdata('user_business') != 'pharmacy' ? "disabled" : "" ?>>
                                                    <option value=""><?php echo $this->lang->line('select_business') ?> </option>
                                                    <?Php foreach ($businesses as $business) : ?>
                                                        <option <?php echo $editrole['business_id'] === $business->id ? "selected" : "" ?> value="<?php echo $business->id ?>"><?php echo $business->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('role') ?></label>
                                                <input type="text" name="role" id="role" value="<?php echo $editrole['role']; ?>" class="form-control" placeholder="" <?php if ($editrole['role'] === "Manager" || $editrole['role'] === "Default") {
                                                                                                                                                                            echo "readonly";
                                                                                                                                                                        } ?>>
                                                <input type="hidden" name="id" value="<?php echo $editrole['id']; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('credit') ?></label>
                                                <input type="text" name="credit" id="role_credit" value="<?php echo $editrole['credit']; ?>" class="form-control" placeholder="" required>
                                            </div>
                                        </div>

                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } else { ?>

                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><?php echo $this->lang->line('add_business_role') ?></h4>
                        </div>

                        <?php echo validation_errors(); ?>
                        <?php echo $this->upload->display_errors(); ?>
                        <?php echo $this->session->flashdata('feedback'); ?>


                        <div class="card-body">
                            <form method="post" action="save_role" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('business') ?></label>
                                                <select name="business_id" value="" class="form-control custom-select" required <?php echo $this->session->userdata('user_business') != 'pharmacy' ? "disabled" : "" ?>>
                                                    <option value=""><?php echo $this->lang->line('select_business') ?> </option>
                                                    <?Php foreach ($businesses as $business) : ?>
                                                        <option <?php echo $this->session->userdata('user_business') != 'pharmacy' && $business_id === $business->id ? "selected" : "" ?> value="<?php echo $business->id ?>"><?php echo $business->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('role') ?></label>
                                                <input type="text" name="role" id="role" value="" class="form-control" placeholder="" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('credit') ?></label>
                                                <input type="text" name="credit" id="role_credit" value="" class="form-control" placeholder="" required>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> <?php echo $this->lang->line('save') ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="col-lg-8">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo $this->lang->line('business_role') ?></h4>
                    </div>
                    <?php echo $this->session->flashdata('delsuccess'); ?>
                    <div class="card-body">
                        <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                            <div class="form-group business-select2">
                                <select class="select2 form-control" data-placeholder="Choose a Category" tabindex="1" id="businessid" name="businessid" required>
                                    <option value="all"><?php echo $this->lang->line('all_business') ?></option>
                                    <?php foreach ($businesses as $business) { ?>
                                        <option value="<?php echo $business->name ?>"><?php echo $business->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>

                        <div class="table-responsive ">
                            <table id="employee_role_table" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                                            <th><?php echo $this->lang->line('business') ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('role') ?></th>
                                        <th><?php echo $this->lang->line('credit') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                                            <th><?php echo $this->lang->line('business') ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('role') ?></th>
                                        <th><?php echo $this->lang->line('credit') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </tfoot> -->

                                <tbody>
                                    <?php foreach ($business_roles as $value) { ?>
                                        <tr>
                                            <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                                                <td>
                                                    <?php echo $value['business']; ?>
                                                </td>
                                            <?php } ?>
                                            <td>
                                                <?php echo $value['role']; ?>
                                            </td>
                                            <td>
                                                <?php echo $value['credit']; ?>
                                            </td>
                                            <td class="jsgrid-align-center ">
                                                <a href="<?php echo base_url(); ?>business/edit_role/<?php echo $value['id']; ?>" title="<?php echo $this->lang->line('edit') ?>" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
                                                <?php if ($value['role'] === "Manager" || $value['role'] === "Default") {
                                                } else { ?>
                                                    <a onclick="return confirm('<?php echo $this->lang->line('are_you_sure_to_delete_this') ?>?')" href="<?php echo base_url(); ?>business/delete_role/<?php echo $value['id']; ?>" title="<?php echo $this->lang->line('delete') ?>" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('backend/footer'); ?>

        <script>
            <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {

                        var where = $('#businessid').val();
                        var business = data[0];

                        if (where != 'all' && where != business) {
                            return false;
                        }

                        return true;
                    }
                );
            <?php } ?>

            $(document).ready(function() {
                // Event listener to the two range filtering inputs to redraw on input
                var table = $('#employee_role_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [],
                    "aaSorting": [],
                });

                $('#businessid').change(function() {
                    table.draw()
                })
            });
        </script>