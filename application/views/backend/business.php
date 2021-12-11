<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-cubes" style="color:#1976d2"></i> <?php echo $this->lang->line('business') ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('business') ?></li>
            </ol>
        </div>
    </div>
    <div class="message"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5">
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
                            <form method="post" action="<?php echo base_url(); ?>business/update" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $this->lang->line('business_name') ?></label>
                                                <input type="text" name="name" id="firstName" value="<?php echo $editbusiness->name; ?>" class="form-control" placeholder="">
                                                <input type="hidden" name="id" value="<?php echo $editbusiness->id; ?>">
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

            <div class="col-lg-7">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo $this->lang->line('business_list') ?></h4>
                    </div>
                    <?php echo $this->session->flashdata('delsuccess'); ?>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('business_name') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th><?php echo $this->lang->line('business_name') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                    <?php foreach ($businesses as $value) { ?>
                                        <tr>
                                            <td><?php echo $value->name; ?></td>
                                            <td class="jsgrid-align-center ">
                                                <a href="<?php echo base_url(); ?>business/edit/<?php echo $value->id; ?>" title="<?php echo $this->lang->line('edit') ?>" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
                                                <a onclick="return confirm('<?php echo $this->lang->line('are_you_sure_to_delete_this') ?>?')" href="<?php echo base_url(); ?>business/delete/<?php echo $value->id; ?>" title="<?php echo $this->lang->line('delete') ?>" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
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