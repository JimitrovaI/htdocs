<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-cubes" style="color:#1976d2"></i> <?php echo $this->lang->line('business') ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('home') ?></a></li>
                <?php if (isset($editbusiness)) { ?>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>business/business"><?php echo $this->lang->line('business') ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line('edit') ?></li>
                <?PHP } else { ?>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line('business') ?></li>
                <?PHP } ?>
            </ol>
        </div>
    </div>
    <div class="message"></div>
    <div class="container-fluid">
        <div class="row">
            <?php if ($this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                <div class="col-lg-4">
                    <?php if (isset($editbusiness)) { ?>
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><?php echo $this->lang->line('edit_business') ?></h4>
                            </div>
                            <div class="form-header-info">
                                <span class="error_msg"><?php echo validation_errors(); ?></span>
                                <span class="error_msg"><?php echo $this->upload->display_errors(); ?></span><br>
                                <?php echo $this->session->flashdata('feedback'); ?>
                            </div>

                            <div class="card-body">
                                <form method="post" action="<?php echo base_url(); ?>business/save" enctype="multipart/form-data">
                                    <div class="form-body">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('business_name') ?></label>
                                                    <input type="text" name="business" id="business" value="<?php echo $editbusiness['name']; ?>" class="form-control" placeholder="">
                                                    <input type="hidden" name="id" value="<?php echo $editbusiness['id']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('government_id') ?></label>
                                                    <input type="text" name="government_id" id="government_id" value="<?php echo $editbusiness['government_id']; ?>" class="form-control" placeholder="" minlength="3" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('payment_agreement') ?></label>
                                                    <select name="payment_agreement" id="payment_agreement" class="form-control">
                                                        <option <?php echo $editbusiness['payment_agreement'] == "WEEK" ? "selected" : ""; ?> value="WEEK"><?php echo $this->lang->line('every_friday') ?></option>
                                                        <option <?php echo $editbusiness['payment_agreement'] == "TWICE" ? "selected" : ""; ?> value="TWICE"><?php echo $this->lang->line('twice_a_month') ?></option>
                                                        <option <?php echo $editbusiness['payment_agreement'] == "MONTH" ? "selected" : ""; ?> value="MONTH"><?php echo $this->lang->line('1st_of_month') ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('contact_person') ?></label>
                                                    <input type="text" name="contact_person" id="contact_person" value="<?php echo $editbusiness['contact_person']; ?>" class="form-control" placeholder="" minlength="3" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('contact_email') ?></label>
                                                    <input type="email" name="contact_email" id="contact_email" value="<?php echo $editbusiness['contact_email']; ?>" class="form-control" placeholder="" minlength="3" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('contact_phone') ?></label>
                                                    <input type="text" name="contact_phone" id="contact_phone" value="<?php echo $editbusiness['contact_phone']; ?>" class="form-control" placeholder="" minlength="3" required>
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
                                <h4 class="m-b-0 text-white"><?php echo $this->lang->line('add_business') ?></h4>
                            </div>

                            <?php echo validation_errors(); ?>
                            <?php echo $this->upload->display_errors(); ?>
                            <?php echo $this->session->flashdata('feedback'); ?>


                            <div class="card-body">
                                <form method="post" action="save" enctype="multipart/form-data">
                                    <div class="form-body">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('business_name') ?></label>
                                                    <input type="text" name="business" id="firstName" value="" class="form-control" placeholder="" minlength="3" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('government_id') ?></label>
                                                    <input type="text" name="government_id" id="government_id" value="" class="form-control" placeholder="" minlength="3" required>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('payment_agreement') ?></label>
                                                    <select name="payment_agreement" id="payment_agreement" class="form-control">
                                                        <option value="WEEK"><?php echo $this->lang->line('every_friday') ?></option>
                                                        <option value="TWICE"><?php echo $this->lang->line('twice_a_month') ?></option>
                                                        <option value="MONTH"><?php echo $this->lang->line('1st_of_month') ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('contact_person') ?></label>
                                                    <input type="text" name="contact_person" id="contact_person" value="" class="form-control" placeholder="" minlength="3" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('contact_email') ?></label>
                                                    <input type="email" name="contact_email" id="contact_email" value="" class="form-control" placeholder="" minlength="3" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $this->lang->line('contact_phone') ?></label>
                                                    <input type="text" name="contact_phone" id="contact_phone" value="" class="form-control" placeholder="" minlength="3" required>
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

            <?php } ?>

            <div class="<?php echo $this->session->userdata('user_type') == 'SUPER ADMIN' ? "col-lg-8" : "col-lg-12" ?>">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo $this->lang->line('business_list') ?></h4>
                    </div>
                    <?php echo $this->session->flashdata('delsuccess'); ?>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="businessList" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('business') ?></th>
                                        <th><?php echo $this->lang->line('contact') ?></th>
                                        <th><?php echo $this->lang->line('payment_agreement') ?></th>
                                        <th><?php echo $this->lang->line('next_date') ?></th>
                                        <?php if ($this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                                            <th><?php echo $this->lang->line('action') ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th><?php echo $this->lang->line('business') ?></th>
                                        <th><?php echo $this->lang->line('contact') ?></th>
                                        <th><?php echo $this->lang->line('payment_agreement') ?></th>
                                        <th><?php echo $this->lang->line('next_date') ?></th>
                                        <?php if ($this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                                            <th><?php echo $this->lang->line('action') ?></th>
                                        <?php } ?>
                                    </tr>
                                </tfoot>

                                <tbody>
                                    <?php foreach ($businesses as $value) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $value['name']; ?><br>
                                                <small><?php echo $this->lang->line('government_id') ?>: <?php echo $value['government_id']; ?></small>
                                            </td>
                                            <td>
                                                <?php echo $value['contact_person']; ?><br>
                                                <small><?php echo $this->lang->line('email') ?>: <?php echo $value['contact_email']; ?></small><br>
                                                <small><?php echo $this->lang->line('phone') ?>: <?php echo $value['contact_phone']; ?></small>
                                            </td>
                                            <td>
                                                <?php if ($value['payment_agreement'] == "MONTH") {
                                                    echo $this->lang->line('1st_of_month');
                                                } elseif ($value['payment_agreement'] == "TWICE") {
                                                    echo $this->lang->line('twice_a_month');
                                                } else {
                                                    echo $this->lang->line('every_friday');
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if ($value['payment_agreement'] == "MONTH") {
                                                    echo date('Y-m-01', strtotime(date('Y-m-d') . " 1 month"));
                                                } elseif ($value['payment_agreement'] == "TWICE") {
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
                                            </td>
                                            <?php if ($this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                                                <td class="jsgrid-align-center ">
                                                    <a href="<?php echo base_url(); ?>business/edit/<?php echo $value['id']; ?>" title="<?php echo $this->lang->line('edit') ?>" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
                                                    <a onclick="return confirm('<?php echo $this->lang->line('are_you_sure_to_delete_this') ?>?')" href="<?php echo base_url(); ?>business/delete/<?php echo $value['id']; ?>" title="<?php echo $this->lang->line('delete') ?>" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                            <?php } ?>
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
            $(document).ready(function() {
                var table = $('#businessList').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });
        </script>