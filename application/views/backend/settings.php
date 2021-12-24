<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Settings</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Settings</li>
            </ol>
        </div>
    </div>
    <?php echo validation_errors(); ?>
    <?php echo $this->upload->display_errors(); ?>
    <?php echo $this->session->flashdata('formdata'); ?>

    <?php if (!empty($this->session->flashdata('feedback'))) { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><?php echo $this->session->flashdata('feedback'); ?></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Settings </h4>
                    </div>
                    <div class="card-body">
                        <div class="table_body">
                            <form action="Add_Settings" id="fileUploadForm" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                                <div class="form-group clearfix">
                                    <label for="" class="col-md-3">Site Logo</label>
                                    <div class="col-md-9">
                                        <div class="file_prev inb mb-2">
                                            <img src="<?php echo base_url(); ?>assets/images/background/logo.png" height="100">
                                        </div>
                                        <label for="logo" class="custom-file-upload"><i class="fa fa-camera" aria-hidden="true"></i> Upload Image</label>
                                        <input type="file" value="" class="" id="logo" name="logo" aria-describedby="fileHelp">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label for="" class="col-md-3">Logo Icon</label>
                                    <div class="col-md-9">
                                        <div class="file_prev inb mb-2">
                                            <img src="<?php echo base_url(); ?>assets/images/background/loginlogo.png" height="100">
                                        </div>
                                        <label for="iconlogo" class="custom-file-upload"><i class="fa fa-camera" aria-hidden="true"></i> Upload Image</label>
                                        <input type="file" value="" class="" id="iconlogo" name="iconlogo" aria-describedby="fileHelp">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label for="" class="col-md-3">Backgroupd</label>
                                    <div class="col-md-9">
                                        <div class="file_prev inb mb-2">
                                            <img src="<?php echo base_url(); ?>assets/images/background/login-register.png" width="100%">
                                        </div>
                                        <label for="background" class="custom-file-upload"><i class="fa fa-camera" aria-hidden="true"></i> Upload Image </label>
                                        <input type="file" value="" class="" id="background" name="background" aria-describedby="fileHelp">
                                    </div>
                                </div>


                                <div class="form-group clearfix">
                                    <label for="title" class="col-md-3">Site Title</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="title" value="<?php echo $settingsvalue->sitetitle; ?>" id="title" placeholder="Title..." required minlength="7" maxlength="120">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="description" class="col-md-3">Description</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" id="description" value="<?php echo $settingsvalue->description; ?>" name="description" rows="6" required minlength="20" maxlength="512"><?php echo $settingsvalue->description; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="copyright" class="col-md-3">Copyright</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="copyright" value="<?php echo $settingsvalue->copyright; ?>" id="copyright" placeholder="copyright...">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="contact" class="col-md-3">Contact</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" name="contact" value="<?php echo $settingsvalue->contact; ?>" id="contact" placeholder="contact...">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="currency" class="col-md-3">Currency</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="currency" value="<?php echo $settingsvalue->currency; ?>" id="currency" placeholder="currency...">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="currency" class="col-md-3">Symbol</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="symbol" value="<?php echo $settingsvalue->symbol; ?>" id="symbol" placeholder="symbol...">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="email" class="col-md-3">System Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email" id="email" value="<?php echo $settingsvalue->system_email; ?>" placeholder="email...">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="address" class="col-md-3">Address</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="address" id="address" value="<?php echo $settingsvalue->address; ?>" placeholder="address...">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="address" class="col-md-3">Address 2</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="address2" id="address2" value="<?php echo $settingsvalue->address2; ?>" placeholder="address more...">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-md-9 col-md-offset-3">
                                        <input type="hidden" name="id" value="<?php echo $settingsvalue->id; ?>" />
                                        <button type="submit" name="submit" id="btnSubmit" class="btn btn-custom">Submit</button>
                                        <span class="flashmessage"><?php echo $this->session->flashdata('feedback'); ?></span>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('backend/footer'); ?>

        <script>
            $(document).ready(function() {
                $('input[type="file"]').change(function(event) {
                    $(this).prev().prev().find('img').fadeIn("fast").attr('src', URL.createObjectURL(event.target.files[0]));
                })
            });
        </script>