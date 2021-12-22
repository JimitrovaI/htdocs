        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <?php
                $id = $this->session->userdata('user_login_id');
                if ($this->session->userdata('user_business') == 'pharmacy') {
                    $basicinfo = $this->employee_model->GetBasic($id);
                } else {
                    $basicinfo = $this->business_model->GetEmployeeById($id);
                }

                ?>
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="profile-img">
                        <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                            <img src="<?php echo base_url(); ?>assets/images/users/<?php echo $basicinfo->em_image ?? 'user.png'; ?>" alt="user" />
                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>assets/images/<?php echo $basicinfo->em_image ? 'business/' . $basicinfo->em_image : 'users/user.png'; ?>" alt="user" />
                        <?php } ?>

                        <!-- this is blinking heartbit-->
                        <!-- <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div> -->
                    </div>

                    <!-- User profile text-->
                    <div class="profile-text">
                        <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                            <h5><?php echo $basicinfo->first_name . ' ' . $basicinfo->last_name; ?></h5>
                        <?php } else { ?>
                            <h5><?php echo $basicinfo->full_name; ?></h5>
                        <?php } ?>
                        <?php if ($this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                            <a href="<?php echo base_url(); ?>settings/Settings" class="dropdown-toggle u-dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a>
                        <?php } ?>
                        <a href="<?php echo base_url(); ?>login/logout" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li> <a href="<?php echo base_url(); ?>"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a></li>

                        <?php if ($this->session->userdata('user_business') == 'pharmacy') { ?>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i style="padding-top: 4.75px; padding-bottom: 4.75px;" class="fa fa-building-o"></i><span class="hide-menu"><?php echo $this->lang->line('business') ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?php echo base_url(); ?>business/business"><?php echo $this->lang->line('business') ?> </a></li>
                                    <?php if ($this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                                        <li><a href="<?php echo base_url(); ?>business/business_role"><?php echo $this->lang->line('business_role') ?> </a></li>
                                    <?php } ?>
                                    <li><a href="<?php echo base_url(); ?>business/business_employees"><?php echo $this->lang->line('business_employees') ?></a></li>
                                </ul>
                            </li>

                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-clipboard-text"></i><span class="hide-menu"><?php echo $this->lang->line('transactions') ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?php echo base_url(); ?>transaction/transactions"><?php echo $this->lang->line('transactions') ?> </a></li>
                                    <li><a href="<?php echo base_url(); ?>transaction/business_transaction"><?php echo $this->lang->line('transactions_by_business') ?> </a></li>
                                    <li><a href="<?php echo base_url(); ?>transaction/business_payments"><?php echo $this->lang->line('payment_history') ?> </a></li>
                                </ul>
                            </li>

                            <?php if ($this->session->userdata('user_type') == 'SUPER ADMIN') { ?>

                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i style="padding-top: 4.75px; padding-bottom: 4.75px;" class="fa fa-hospital-o"></i><span class="hide-menu"><?php echo $this->lang->line('pharmacy') ?> </span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="<?php echo base_url(); ?>employee/Employees"><?php echo $this->lang->line('staffs')?> </a></li>
                                        <li><a href="<?php echo base_url(); ?>employee/Inactive_Employee"><?php echo $this->lang->line('inactive_user')?> </a></li>
                                    </ul>
                                </li>
                            <?php } ?>

                            <?php if ($this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                                <li> <a href="<?php echo base_url(); ?>settings/Settings"><i class="mdi mdi-settings"></i><span class="hide-menu">Settings <span class="hide-menu"></a></li>
                            <?php } ?>

                        <?php } else { ?>

                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i style="padding-top: 4.75px; padding-bottom: 4.75px;" class="fa fa-building-o"></i><span class="hide-menu"><?php echo $this->lang->line('business') ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?php echo base_url(); ?>business/business_role"><?php echo $this->lang->line('business_role') ?> </a></li>
                                    <li><a href="<?php echo base_url(); ?>business/business_employees"><?php echo $this->lang->line('business_employees') ?></a></li>
                                </ul>
                            </li>

                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-clipboard-text"></i><span class="hide-menu"><?php echo $this->lang->line('transactions') ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?php echo base_url(); ?>transaction/transactions"><?php echo $this->lang->line('transactions') ?> </a></li>
                                    <li><a href="<?php echo base_url(); ?>transaction/business_payments"><?php echo $this->lang->line('payment_history') ?> </a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>