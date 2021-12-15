<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-hard-of-hearing" style="color:#1976d2"></i><?php echo $this->lang->line('payment_history') ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home') ?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('payment_history') ?></li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">

        <div class="row m-b-10">
            <div class="col-12">
                <input type="hidden" id="filter_type" value="all">
                <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>transaction/business_transaction" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->lang->line('generate_payment') ?> </a></button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $this->lang->line('search') ?></h4>
                        <div class="form-material row">
                            <div class="form-group col-md-3">
                                <input type="text" name="date_from" id="date_from" class="form-control mydatetimepickerFull" placeholder="<?php echo $this->lang->line('from') ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="date_to" id="date_to" class="form-control mydatetimepickerFull" placeholder="<?php echo $this->lang->line('to') ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <select class="form-control custom-select" tabindex="1" name="business_id" id="business_id">
                                    <option value=""><?php echo $this->lang->line('business') ?></option>
                                    <?php foreach ($businesses as $business) { ?>
                                        <option value="<?php echo $business->name ?>"><?php echo $business->name ?></option>
                                    <?php } ?>
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
                        <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('payment_list') ?> </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="alltransactionstb" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('id') ?></th>
                                        <th><?php echo $this->lang->line('business') ?></th>
                                        <th><?php echo $this->lang->line('paid_date') ?></th>
                                        <th><?php echo $this->lang->line('paid_amount') ?></th>
                                        <th><?php echo $this->lang->line('add') ?></th>
                                        <th><?php echo $this->lang->line('balance') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th><?php echo $this->lang->line('id') ?></th>
                                        <th><?php echo $this->lang->line('business') ?></th>
                                        <th><?php echo $this->lang->line('paid_date') ?></th>
                                        <th><?php echo $this->lang->line('paid_amount') ?></th>
                                        <th><?php echo $this->lang->line('add') ?></th>
                                        <th><?php echo $this->lang->line('balance') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($payments as $payment) : ?>
                                        <tr>
                                            <th><?php echo $payment['id'] ?></th>
                                            <th><?php echo $payment['business'] ?></th>
                                            <th><?php echo date('Y-m-d', strtotime($payment['paid_date'])); ?></th>
                                            <th><?php echo $payment['paid_amount'] ?></th>
                                            <th><?php echo $payment['added_amount'] ?></th>
                                            <th><?php echo $payment['balance'] ?></th>
                                            <td class="jsgrid-align-center ">
                                                <a href="<?php echo base_url(); ?>transaction/payment_detail_view?id=<?php echo base64_encode($payment['id']) ?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light disiplinary" data-id="<?php echo $payment['id']; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                                <a href="<?php echo base_url(); ?>transaction/payment_detail_view?id=<?php echo base64_encode($payment['id']) ?>" title="View" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-bars"></i></a>
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
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var date_from = $('#date_from').val();
                    var date_to = $('#date_to').val();
                    var where = $('#business_id').val();
                    var business = data[1];
                    var date = Date.parse(data[3]);
                   

                    var from = Date.parse(date_from);
                    var to = Date.parse(date_to);

                    if (date_from && date < from) {
                        return false;
                    }

                    if (date_to && date > to) {
                        return false;
                    }

                    if (where && business != where) {
                        return false;
                    }


                    return true;
                }
            );

            $(document).ready(function() {
                var table = $('#alltransactionstb').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });

                $('#searchtransactionbtn').click(function() {
                    table.draw()
                })
            });
        </script>