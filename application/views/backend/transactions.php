<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-hard-of-hearing" style="color:#1976d2"></i><?php echo $this->lang->line('transactions') ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('transactions') ?></li>
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
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">

        <div class="row m-b-10">
            <div class="col-12">
                <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>transaction/addTransaction" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->lang->line('generate_transaction') ?> </a></button>
                <?php } ?>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $this->lang->line('search_transaction') ?></h4>
                        <div class="form-material row">
                            <div class="form-group col-md-3">
                                <input type="text" name="date_from" id="date_from" class="form-control mydatetimepickerFull" placeholder="<?php echo $this->lang->line('from') ?>" value="<?php echo $from ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="date_to" id="date_to" class="form-control mydatetimepickerFull" placeholder="<?php echo $this->lang->line('to') ?>" value="<?php echo $to ?>">
                            </div>
                            <?php if ($by_business || $by_employee) {
                            } else { ?>
                                <div class="form-group col-md-3">
                                    <select class="form-control custom-select" tabindex="1" name="business_id" id="business_id">
                                        <option value=""><?php echo $this->lang->line('business') ?></option>
                                        <?php foreach ($businesses as $business) { ?>
                                            <option <?php echo $business_id == $business->id ? 'selected' : "" ?> value="<?php echo $business->name ?>"><?php echo $business->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <div class="form-group col-md-3">
                                <select class="form-control custom-select" tabindex="1" name="transaction_status" id="transaction_status">
                                    <option value=""><?php echo $this->lang->line('status') ?></option>
                                    <option value="COMPLETE" <?php echo $status=='COMPLETE'?'selected': "" ?>> <?php echo $this->lang->line('completed') ?></option>
                                    <option value="PENDING"  <?php echo $status=='PENDING'?'selected': "" ?>> <?php echo $this->lang->line('pending') ?></option>
                                    <option value="OVERDUE"  <?php echo $status=='OVERDUE'?'selected': "" ?>> <?php echo $this->lang->line('overdue') ?></option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <input type="button" class="btn btn-success" value="<?php echo $this->lang->line('search') ?>" id="searchtransactionbtn">
                            </div>
                        </div>
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
                                        <th><?php echo $this->lang->line('id') ?></th>
                                        <th><?php echo $this->lang->line('business') ?></th>
                                        <th><?php echo $this->lang->line('name') ?></th>
                                        <th><?php echo $this->lang->line('date') ?></th>
                                        <th><?php echo $this->lang->line('total_price') ?></th>
                                        <th><?php echo $this->lang->line('sold_by') ?></th>
                                        <th><?php echo $this->lang->line('status') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th><?php echo $this->lang->line('id') ?></th>
                                        <th><?php echo $this->lang->line('business') ?></th>
                                        <th><?php echo $this->lang->line('name') ?></th>
                                        <th><?php echo $this->lang->line('date') ?></th>
                                        <th><?php echo $this->lang->line('total_price') ?></th>
                                        <th><?php echo $this->lang->line('sold_by') ?></th>
                                        <th><?php echo $this->lang->line('status') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </tfoot> -->
                                <tbody>
                                    <?php foreach ($transactions as $transaction) : ?>
                                        <tr>
                                            <th><?php echo $transaction['id'] ?></th>
                                            <th><?php echo $transaction['business'] ?></th>
                                            <th><?php echo $transaction['em_name'] ?></th>
                                            <th><?php echo date('Y-m-d', strtotime($transaction['buy_date'])); ?></th>
                                            <th><?php echo $transaction['cost'] ?></th>
                                            <th><?php echo $transaction['buy_staff'] ?></th>
                                            <th>
                                                <?php echo $transaction['status'] == "COMPLETE" ? "<span class='badge badge-success'>" . $this->lang->line('completed') . "</span>" : "<span class='badge badge-info'>" . $this->lang->line('pending') . "</span>" ?>
                                            </th>
                                            <td class="text-center ">
                                                <a href="<?php echo base_url(); ?>transaction/transaction_view?id=<?php echo base64_encode($transaction['id']) ?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light disiplinary" data-id="<?php echo $transaction['id']; ?>">
                                                    <?php if ($this->session->userdata('user_business') == 'pharmacy' && $this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    <?php } else { ?>
                                                        <i class="fa fa-bars"></i>
                                                    <?php } ?>
                                                </a>
                                                <?php if ($this->session->userdata('user_business') == 'pharmacy' && $this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                                                    <a onclick="return confirm('<?php echo $this->lang->line('are_you_sure_to_delete_this'); ?>\n<?php echo $this->lang->line('cannot_be_undone'); ?>')" href="<?php echo base_url(); ?>transaction/deleteTransaction?id=<?php echo base64_encode($transaction['id']) ?>" title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
                                                <?php } ?>

                                            </td>
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


                $('#searchtransactionbtn').click(function() {
                    var geturl = "<?php echo base_url(); ?>transaction/transactions?";
                    var from = $('#date_from').val();
                    var to = $('#date_to').val();
                    <?php if (!$by_employee && !$by_business) { ?>
                        var business_id = $('#business_id').val();
                    <?php } ?>
                    var status = $('#transaction_status').val();
                    <?php if ($by_employee) { ?>
                        geturl += "emp_id=<?php echo $emp_id ?>";
                        geturl += "&from=" + from;

                    <?php } else {  ?>
                        geturl += "&from=" + from;
                    <?php }  ?>
                    geturl += "&to=" + to;
                    <?php if (!$by_employee && !$by_business) { ?>
                        geturl += "&business_id=" + business_id;
                    <?php } ?>
                    geturl += "&status=" + status;

                    window.location.href = geturl;
                })
            });
        </script>