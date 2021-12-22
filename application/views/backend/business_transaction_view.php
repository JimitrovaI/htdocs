<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-hard-of-hearing" style="color:#1976d2"></i><?php echo $business_transaction['business'] ?> <?php echo $this->lang->line('transactions') ?></h3>
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
        <?php if ($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'ACCOUNTANT') { ?>
            <?php if ($business_transaction['total_price'] > 0) { ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $this->lang->line('transaction_payment') ?>: (<?php echo $this->lang->line('total_price') ?>: <?php echo $business_transaction['total_price'] ?>, <?php echo $this->lang->line('balance') ?>: <?php echo $balance ?>)</h4>
                                <form class="row" action="savePayment" method="post" enctype="multipart/form-data">
                                    <div class="form-group col-md-4">
                                        <label><?php echo $this->lang->line('paid_date') ?></label>
                                        <input type="text" name="date_from" id="paid_date" class="form-control mydatetimepickerFull" placeholder="<?php echo $this->lang->line('paid_date') ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label><?php echo $this->lang->line('paid_amount') ?></label>
                                        <input type="text" name="paid_amount" id="paid_amount" class="form-control" placeholder="<?php echo $this->lang->line('paid_amount') ?>" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label><?php echo $this->lang->line('invoice') ?></label>
                                        <input type="file" name="invoice" id="paytype" class="form-control" placeholder="<?php echo $this->lang->line('invoice') ?>" required>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input type="hidden" name="added_amount" value="<?php echo $balance ?>">
                                        <input type="hidden" name="business_id" value="<?php echo $business_transaction['business_id'] ?>" required>
                                        <input type="submit" class="btn btn-success" value="<?php echo $this->lang->line('submit') ?>" id="add_payment">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        <div class="row m-b-10">
            <div class="col-12">
                <input type="hidden" id="filter_type" value="all">
                <button type="button" class="btn btn-primary filter_table" data-type="all" style="display:none;"><i class="fa fa-bars"></i> <?php echo $this->lang->line('all_transactions') ?></button>
                <button type="button" class="btn btn-primary filter_table" data-type="<?php echo $this->lang->line('pending') ?>"><i class="fa fa-bars"></i> <?php echo $this->lang->line('pending_transactions') ?></button>
                <button type="button" class="btn btn-primary filter_table" data-type="<?php echo $this->lang->line('completed') ?>"><i class="fa fa-bars"></i> <?php echo $this->lang->line('completed_transactions') ?> </button>
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
                                        <th><?php echo $this->lang->line('action') ?></th>
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
                                            <td class="text-center">
                                                <a href="<?php echo base_url(); ?>transaction/transaction_view?id=<?php echo base64_encode($transaction['id']) ?>" title="view" class="btn btn-sm btn-info waves-effect waves-light disiplinary" data-id="<?php echo $transaction['id']; ?>"><i class="fa fa-bars"></i></a>
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
                    var status = data[5]

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

                $('.filter_table').click(function() {
                    $('#filter_type').val($(this).attr('data-type'))
                    $('.filter_table').css('display', 'inline-block');
                    $(this).css('display', 'none');
                    table.draw()
                });

            });
        </script>