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
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">

        <div class="row m-b-10">
            <div class="col-12">
                <input type="hidden" id="filter_type" value="all">
                <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>attendance/Save_Attendance" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->lang->line('generate_transaction') ?> </a></button>
                <button type="button" class="btn btn-primary filter_table" data-type="all" style="display:none;"><i class="fa fa-bars"></i> <?php echo $this->lang->line('all_transactions') ?></button>
                <button type="button" class="btn btn-primary filter_table" data-type="<?php echo $this->lang->line('pending') ?>"><i class="fa fa-bars"></i> <?php echo $this->lang->line('pending_transactions') ?></button>
                <button type="button" class="btn btn-primary filter_table" data-type="<?php echo $this->lang->line('completed') ?>"><i class="fa fa-bars"></i> <?php echo $this->lang->line('completed_transactions') ?> </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $this->lang->line('search_transaction') ?></h4>
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
                        <h4 class="m-b-0 text-white"> <?php echo $this->lang->line('transaction_list') ?> </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="alltransactionstb" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('transaction_id') ?></th>
                                        <th><?php echo $this->lang->line('business') ?></th>
                                        <th><?php echo $this->lang->line('name') ?></th>
                                        <th><?php echo $this->lang->line('PIN') ?> </th>
                                        <th><?php echo $this->lang->line('date') ?></th>
                                        <th><?php echo $this->lang->line('bill') ?></th>
                                        <th><?php echo $this->lang->line('details') ?></th>
                                        <th><?php echo $this->lang->line('total_price') ?></th>
                                        <th><?php echo $this->lang->line('sell_by') ?></th>
                                        <th><?php echo $this->lang->line('status') ?></th>
                                        <th><?php echo $this->lang->line('pay_type') ?></th>
                                        <th><?php echo $this->lang->line('invoice') ?></th>
                                        <th><?php echo $this->lang->line('pay_by') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th><?php echo $this->lang->line('transaction_id') ?></th>
                                        <th><?php echo $this->lang->line('business') ?></th>
                                        <th><?php echo $this->lang->line('name') ?></th>
                                        <th><?php echo $this->lang->line('PIN') ?> </th>
                                        <th><?php echo $this->lang->line('date') ?></th>
                                        <th><?php echo $this->lang->line('bill') ?></th>
                                        <th><?php echo $this->lang->line('details') ?></th>
                                        <th><?php echo $this->lang->line('total_price') ?></th>
                                        <th><?php echo $this->lang->line('sell_by') ?></th>
                                        <th><?php echo $this->lang->line('status') ?></th>
                                        <th><?php echo $this->lang->line('pay_type') ?></th>
                                        <th><?php echo $this->lang->line('invoice') ?></th>
                                        <th><?php echo $this->lang->line('pay_by') ?></th>
                                        <th><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($transactions as $transaction) : ?>
                                        <tr>
                                            <th><?php echo $transaction['id'] ?></th>
                                            <th><?php echo $transaction['business'] ?></th>
                                            <th><?php echo $transaction['em_name'] ?></th>
                                            <th><?php echo $transaction['PIN'] ?> </th>
                                            <th><?php echo date('Y-m-d', strtotime($transaction['buy_date'])); ?></th>
                                            <th><?php echo $transaction['bill'] ?></th>
                                            <th><?php echo $transaction['details'] ?></th>
                                            <th><?php echo $transaction['cost'] ?></th>
                                            <th><?php echo $transaction['buy_staff'] ?></th>
                                            <th>
                                                <?php echo $transaction['status'] == "COMPLETE" ? "<span class='badge badge-success'>" . $this->lang->line('completed') . "</span>" : "<span class='badge badge-info'>" . $this->lang->line('pending') . "</span>" ?>
                                            </th>
                                            <th><?php echo $transaction['paytype'] ?></th>
                                            <th><?php echo $transaction['invoice'] ?></th>
                                            <th><?php echo $transaction['pay_staff'] ?></th>
                                            <td class="jsgrid-align-center ">
                                                <a href="<?php echo base_url(); ?>transaction/transaction_view?id=<?php echo base64_encode($transaction['id']) ?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light disiplinary" data-id="<?php echo $transaction['id']; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                                <a href="<?php echo base_url(); ?>transaction/transaction_view?id=<?php echo base64_encode($transaction['id']) ?>" title="View" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-bars"></i></a>
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
                    var filter_type = $('#filter_type').val();
                    var date_from = $('#date_from').val();
                    var date_to = $('#date_to').val();
                    var where = $('#business_id').val();
                    var business = data[1];
                    var date = Date.parse(data[4]);
                    var status = data[9]

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

                    if (filter_type != 'all' && filter_type != status) {
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

                // Event listener to the two range filtering inputs to redraw on input
                $('.filter_table').click(function() {
                    $('#filter_type').val($(this).attr('data-type'))
                    $('.filter_table').css('display', 'inline-block');
                    $(this).css('display', 'none');
                    table.draw()
                });

                $('#searchtransactionbtn').click(function() {
                    table.draw()
                })
            });
        </script>