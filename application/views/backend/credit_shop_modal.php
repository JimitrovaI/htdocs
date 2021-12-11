<style type="text/css">
    @media (min-width: 768px) and (max-width: 991px){
     .modal-lg {
        max-width: 700px;
    }}
</style>
<div class="modal fade" id="creditshopmodel" tabindex="-1" role="dialog" aria-labelledby="creditshopModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="creditshopModalLabel">Credit Shop</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" action="addcreditshop" id="creditshopform" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 px-4 mb-5">
                            <div class="row align-items-center" style="box-shadow: 0px 5px 20px rgb(0 0 0 / 5%); margin: 0px;">
                                <div class="col-md-4 py-3">
                                    <img src="<?php echo base_url(); ?>assets/images/users/user.png" class="img-circle" width="100%" />
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted pt-2 db"><?php echo $this->lang->line('business') ?> </small>
                                    <h6 class="modal_employee_name"></h6>
                                    <small class="text-muted pt-2 db"><?php echo $this->lang->line('PIN') ?> </small>
                                    <h6 class="modal_employee_pin"></h6>
                                    <small class="text-muted pt-2 db"><?php echo $this->lang->line('business') ?></small>
                                    <h6 class="modal_employee_business"></h6>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted pt-2 db"><?php echo $this->lang->line('email') ?> </small>
                                    <h6 class="modal_employee_email"></h6>
                                    <small class="text-muted pt-2 db"><?php echo $this->lang->line('phone') ?></small>
                                    <h6 class="modal_employee_phone"></h6>
                                    <small class="text-muted pt-2 db"><?php echo $this->lang->line('job_title') ?></small>
                                    <h6 class="modal_employee_jobtitle"></h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <img src="" class="bill_preview" width="100%" style="display:none;" />
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('bill') ?></label>
                                <input type="file" id="modal_bill_file" name="bill" value="" class="form-control" id="recipient-name1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('details') ?></label>
                                <textarea class="form-control" name="details" id="message-text1" required minlength="14" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Date</label>
                                <input type="text" name="buy_date" value="" class="form-control mydatepicker" id="recipient-name1">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo $this->lang->line('prices') ?> (<?php echo $this->lang->line('approved_credit') ?>:<span class="modal_employee_credit"></span>)</label>
                                <input type="number" name="cost" value="" class="form-control" id="recipient-name1" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="modal_emp_id" name="emp_id" value="" required>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>