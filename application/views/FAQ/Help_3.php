    <div class="col-md-12 app-inner-layout__content card">
        <div class="pb-1 pl-1 pr-1 pt-3">
            <div class="tab-content">
                <div class="tab-pane active show" id="tab-faq-1">

                    <div id="accordion" class="accordion-wrapper mb-3">
                        <div class="card">
                            <div id="headingOne" class="card-header">
                                <button type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block">
                                    <h5 class="m-0 p-0">Wetrue等级</h5>
                                </button>
                            </div>
                            <div data-parent="#accordion" id="collapseOne1" aria-labelledby="headingOne" class="collapse show">
                                <div class="card-body">
						你的Wetrue等级将与在你Wetrue的活跃程度（即活跃度）密切相关，具体如下：<br><br>
                        LV1：<50活跃度；<br>
                        LV2：50-99活跃度；<br>
                        LV3：100-499活跃度；<br>
                        LV4：500-1999活跃度；<br>
                        LV5：2000-4999活跃度；<br>
                        LV6：>=5000活跃度<br>
                        LV7：>=10000活跃度
                                                        
                           </div>
                            </div>
                        </div>
                        <div class="card">
                            <div id="headingTwo" class="b-radius-0 card-header">
                                <button type="button" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="text-left m-0 p-0 btn btn-link btn-block">
                                	<h5 class="m-0 p-0">提高你的活跃度</h5>
                                </button>
                            </div>
                            <div data-parent="#accordion" id="collapseOne2" class="collapse">
                                <div class="card-body">
                        你的Wetrue活跃度将与你在Wetrue发帖、评价、点赞等行为密切相关，具体如下：<br><br>
                            发帖 +<?php echo $contentActive?><br>
                            评价 +<?php echo $commentActive?><br>
                            点赞 +<?php echo $loveActive?><br>
							头像 +<?php echo $userNameActive?><br>
                            昵称 +<?php echo $portraitActive?><br>
                            违规 -<?php echo $reportActive?>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('footer'); ?>