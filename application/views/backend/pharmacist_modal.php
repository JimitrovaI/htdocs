                        <!-- sample modal content -->
                        <div class="modal fade" id="PharmacistViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="card mb-0 pb-5">
                                        <div class="card-body">
                                            <center class="m-t-30">
                                                <?php if (!empty($pharmacist->em_image)) { ?>
                                                    <img src="<?php echo base_url(); ?>assets/images/users/<?php echo $pharmacist->em_image; ?>" class="img-circle" width="150" />
                                                <?php } else { ?>
                                                    <img src="<?php echo base_url(); ?>assets/images/users/user.png" class="img-circle" width="150" alt="<?php echo $pharmacist->first_name ?>" title="<?php echo $pharmacist->first_name ?>" />
                                                <?php } ?>
                                                <h4 class="card-title m-t-10"><?php echo $pharmacist->first_name . ' ' . $pharmacist->last_name; ?></h4>
                                                <h6 class="card-subtitle"><?php  ?></h6>
                                            </center>
                                        </div>
                                        <div>
                                            <hr>
                                        </div>
                                        <div class="card-body"> <small class="text-muted"><?php echo $this->lang->line('email'); ?> </small>
                                            <h6><?php echo $pharmacist->em_email; ?></h6> <small class="text-muted p-t-30 db"><?php echo $this->lang->line('phone'); ?></small>
                                            <h6><?php echo $pharmacist->em_phone; ?></h6>
                                            <small class="text-muted p-t-30 db"><?php echo $this->lang->line('social_media'); ?></small>
                                            <br />
                                            <?php if (!empty($socialmedia->facebook)) { ?>
                                                <a class="btn btn-circle btn-secondary" href="<?php echo $socialmedia->facebook ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                            <?php } ?>
                                            <?php if (!empty($socialmedia->twitter)) { ?>
                                            <a class="btn btn-circle btn-secondary" href="<?php echo $socialmedia->twitter ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                            <?php } ?>
                                            <?php if (!empty($socialmedia->skype_id)) { ?>
                                            <a class="btn btn-circle btn-secondary" href="<?php echo $socialmedia->skype_id ?>" target="_blank"><i class="fa fa-skype"></i></a>
                                            <?php } ?>
                                            <?php if (!empty($socialmedia->google_Plus)) { ?>
                                            <a class="btn btn-circle btn-secondary" href="<?php echo $socialmedia->google_Plus ?>" target="_blank"><i class="fa fa-google"></i></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>