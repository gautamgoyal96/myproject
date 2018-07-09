<!-- Page -->
<div class="page animsition">
    <div class="page-content container-fluid">
        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <div class="col-lg-3 col-sm-6">
                <!-- Widget Linearea One-->
                <div class="widget widget-shadow dash" id="widgetLineareaOne">
                    <div class="widget-content">
                        <a href="<?php echo base_url();?>user/allOwners">
                        <div class="padding-20 padding-top-10">
                            <div class="clearfix">
                                <div class="grey-800 pull-left padding-vertical-10">
                                    <i class="icon md-account grey-600 font-size-24 vertical-align-bottom margin-right-5"></i><span>Total Owner</span>
                                </div>
                                <span class="pull-right grey-700 font-size-30"><?php echo $ownersCount;?></span>
                            </div>
                            <div class="margin-bottom-20 grey-500">
                                <!-- <i class="icon md-long-arrow-up green-500 font-size-16"></i> -->
                            </div>
                            <div class="ct-chart height-50"></div>
                        </div>
                        </a>
                    </div>
                </div>
                <!-- End Widget Linearea One -->
            </div>
            <div class="col-lg-3 col-sm-6">
                <!-- Widget Linearea Two -->
                <div class="widget widget-shadow dash" id="widgetLineareaTwo">
                    <div class="widget-content">
                        <a href="<?php echo base_url();?>user/allCustomers">
                        <div class="padding-20 padding-top-10">
                            <div class="clearfix">
                                <div class="grey-800 pull-left padding-vertical-10">
                                    <i class="icon md-account grey-600 font-size-24 vertical-align-bottom margin-right-5"></i><span>Total Customer</span>
                                </div>
                                <span class="pull-right grey-700 font-size-30"><?php echo $customersCount;?></span>
                            </div>
                            <div class="margin-bottom-20 grey-500">
                                <!-- <i class="icon md-long-arrow-up green-500 font-size-16"></i> -->
                            </div>
                            <div class="ct-chart height-50"></div>
                        </div>
                        </a>
                    </div>
                </div>
                <!-- End Widget Linearea Two -->
            </div>
            <div class="col-lg-3 col-sm-6">
                <!-- Widget Linearea Three -->
                <div class="widget widget-shadow dash" id="widgetLineareaThree">
                    <div class="widget-content">
                        <a href="<?php echo base_url();?>user/allCategory">
                        <div class="padding-20 padding-top-10">
                            <div class="clearfix">
                                <div class="grey-800 pull-left padding-vertical-10">
                                    <i class="icon md-chart grey-600 font-size-24 vertical-align-bottom margin-right-5"></i><span>Total Category</span>
                                </div>
                                <span class="pull-right grey-700 font-size-30"><?php echo $categoryCount;?></span>
                            </div>
                            <div class="margin-bottom-20 grey-500">
                                <!-- <i class="icon md-long-arrow-down red-500 font-size-16"></i> -->
                            </div>
                            <div class="ct-chart height-50"></div>
                        </div>
                        </a>
                    </div>
                </div>
                <!-- End Widget Linearea Three -->
            </div>
            <div class="col-lg-3 col-sm-6">
                <!-- Widget Linearea Three -->
                <div class="widget widget-shadow dash" id="widgetLineareaFour">
                    <div class="widget-content">
                        <a href="<?php echo base_url();?>user/allProduct">
                        <div class="padding-20 padding-top-10">
                            <div class="clearfix">
                                <div class="grey-800 pull-left padding-vertical-10">
                                    <i class="icon md-chart grey-600 font-size-24 vertical-align-bottom margin-right-5"></i><span>Total Product</span>
                                </div>
                                <span class="pull-right grey-700 font-size-30"><?php echo $productCount;?></span>
                            </div>
                            <div class="margin-bottom-20 grey-500">
                                <!-- <i class="icon md-long-arrow-down red-500 font-size-16"></i> -->
                            </div>
                            <div class="ct-chart height-50"></div>
                        </div>
                        </a>
                    </div>
                </div>
                <!-- End Widget Linearea Three -->
            </div>
        </div>
    </div>
</div>
<!-- End Page -->
