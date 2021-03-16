
    <div class="col-md-12 app-inner-layout__content card">
        <div class="pb-1 pl-1 pr-1 pt-3">
            <div class="tab-content">
                <div class="tab-pane active show" id="tab-faq-1">

                    <div id="accordion" class="accordion-wrapper mb-3">
						<div class="card">
                            <div id="headingTwo" class="b-radius-0 card-header">
                                <button type="button" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="text-left m-0 p-0 btn btn-link btn-block"><h5 class="m-0 p-0">
                                    如何收取费用 #1</h5></button>
                            </div>
                            <div data-parent="#accordion" id="collapseOne1" class="collapse">
                                <div class="card-body">
                                    修改头像收取0.0001AE;<br>
                                    修改昵称收取0.0001AE;<br>
                                    发帖收取0.0001AE;<br>
                                    评价收取0.0001AE;<br>
                                    点赞不收取任何费用（免费）。<br><br>
								注：除以上基础费用，另需支付小额矿工费。
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div id="headingOne" class="card-header">
                                <button type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne" class="text-left m-0 p-0 btn btn-link btn-block">
                                    <h5 class="m-0 p-0">为何收取费用 #2</h5>
                                </button>
                            </div>
                            <div data-parent="#accordion" id="collapseOne2" aria-labelledby="headingOne" class="collapse show">
                                <div class="card-body">
                                维持服务器及WeTrue更新、运维、推广等有序推进，我们选择适当收取费用.<br>
                                同时，为了过滤垃圾或无效信息，防止AE主网数据过度膨胀。<br><br>
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('footer'); ?>