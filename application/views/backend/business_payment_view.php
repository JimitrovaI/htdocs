<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-hard-of-hearing" style="color:#1976d2"></i><?php echo $business_payment['business'] ?> <?php echo $this->lang->line('payment') ?>: #<?php echo $business_payment['id'] ?> </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('business_payment_view') ?></li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $this->lang->line('payment_info') ?>(<?php echo date('Y-m-d', strtotime($business_payment['paid_date'])); ?>)</h4>
                        <div class="row">
                            <div class="col-md-3 com-sm-6">
                                <small class="text-muted"><?php echo $this->lang->line('paid_amount') ?> </small>
                                <h6><?php echo $business_payment['paid_amount']; ?></h6>
                            </div>
                            <div class="col-md-3 com-sm-6">
                                <small class="text-muted"><?php echo $this->lang->line('add') ?> </small>
                                <h6><?php echo $business_payment['added_amount']; ?></h6>
                            </div>
                            <div class="col-md-3 com-sm-6">
                                <small class="text-muted"><?php echo $this->lang->line('completed') ?> </small>
                                <h6><?php echo $completed; ?></h6>
                            </div>
                            <div class="col-md-3 com-sm-6">
                                <small class="text-muted"><?php echo $this->lang->line('balance') ?> </small>
                                <h6><?php echo $business_payment['balance']; ?></h6>
                            </div>
                        </div>

                        <form class="row m-t-20" action="savePayment" method="post" enctype="multipart/form-data">

                            <div class="form-group col-md-4">
                                <label><?php echo $this->lang->line('invoice') ?> </label>
                                <img src="<?php echo base_url(); ?>assets/images/invoices/<?php echo $business_payment['invoice']; ?>" class="bill_preview" width="100%" />
                                <?php if ($this->session->userdata('user_business') == "pharmacy" && $this->session->userdata('user_type') == "SUPER ADMIN") { ?>
                                    <input type="file" name="invoice" class="form-control" value="">
                                <?php } ?>
                            </div>

                            <div class="row col-md-8 align-self-start">
                                <div class="form-group col-md-6">
                                    <label><?php echo $this->lang->line('paid_date') ?></label>
                                    <input type="text" name="paid_date" id="paid_date" value="<?php echo date('Y-m-d', strtotime($business_payment['paid_date'])); ?>" class="form-control <?php echo $this->session->userdata('user_business') == "pharmacy" && $this->session->userdata('user_type') == "SUPER ADMIN"?'mydatetimepickerFull':''?>" placeholder="<?php echo $this->lang->line('paid_date') ?>" <?php echo $this->session->userdata('user_business') == "pharmacy" && $this->session->userdata('user_type') == "SUPER ADMIN"?'':'readonly'?>>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php echo $this->lang->line('add') ?></label>
                                    <input type="text" name="added_amount" id="added_amount" value="<?php echo $business_payment['added_amount']; ?>" class="form-control" placeholder="<?php echo $this->lang->line('paid_date') ?>" <?php echo $this->session->userdata('user_business') == "pharmacy" && $this->session->userdata('user_type') == "SUPER ADMIN"?'':'readonly'?>>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php echo $this->lang->line('paid_amount') ?></label>
                                    <input type="text" name="paid_amount" id="paid_amount" value="<?php echo $business_payment['paid_amount']; ?>" class="form-control" placeholder="<?php echo $this->lang->line('paid_amount') ?>" required <?php echo $this->session->userdata('user_business') == "pharmacy" && $this->session->userdata('user_type') == "SUPER ADMIN"?'':'readonly'?>>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><?php echo $this->lang->line('balance') ?></label>
                                    <input type="text" name="balance" id="balance" value="<?php echo $business_payment['balance']; ?>" class="form-control" placeholder="<?php echo $this->lang->line('balance') ?>" <?php echo $this->session->userdata('user_business') == "pharmacy" && $this->session->userdata('user_type') == "SUPER ADMIN"?'':'readonly'?>>
                                </div>
                            </div>

                            <?php if ($this->session->userdata('user_business') == "pharmacy" && $this->session->userdata('user_type') == "SUPER ADMIN") { ?>
                                <div class="col-md-12 form-group">
                                    <input type="hidden" name="id" value="<?php echo $business_payment['id'] ?>" required>
                                    <input type="hidden" name="business_id" value="<?php echo $business_payment['business_id'] ?>" required>
                                    <input type="submit" class="btn btn-success" value="<?php echo $this->lang->line('submit') ?>" id="add_payment">
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('transaction_list') ?> </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="alltransactionstb" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('name') ?></th>
                                        <th><?php echo $this->lang->line('date') ?></th>
                                        <th><?php echo $this->lang->line('details') ?></th>
                                        <th><?php echo $this->lang->line('total_price') ?></th>
                                        <th><?php echo $this->lang->line('sold_by') ?></th>
                                        <th><?php echo $this->lang->line('status') ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($transactions as $transaction) : ?>
                                        <tr>
                                            <th><?php echo $transaction['em_name'] ?></th>
                                            <th><?php echo date('Y-m-d', strtotime($transaction['buy_date'])); ?></th>
                                            <th><?php echo $transaction['details'] ?></th>
                                            <th><?php echo $transaction['cost'] ?></th>
                                            <th><?php echo $transaction['buy_staff'] ?></th>
                                            <th>
                                                <?php echo $transaction['status'] == "COMPLETE" ? "<span class='badge badge-success'>" . $this->lang->line('completed') . "</span>" : "<span class='badge badge-info'>" . $this->lang->line('pending') . "</span>" ?>
                                            </th>
                                        </tr>
                                    <?php endforeach; ?>
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
                var table = $('#alltransactionstb').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });

                $('input[type="file"]').change(function(event) {
                    $(this).prev().fadeIn("fast").attr('src', URL.createObjectURL(event.target.files[0]));
                })
            });
        </script>