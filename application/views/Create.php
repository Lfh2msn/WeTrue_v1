

<div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100 bg-plum-plate bg-animation">
                <div class="d-flex h-80 justify-content-center align-items-center">
                    <div class="mx-auto app-login-box col-md-8">
                        <div class="app-logo-inverse mx-auto mb-3"></div>
                        <div class="modal-dialog w-100 mx-auto">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="h5 modal-title text-center">
                                        <h4 class="mt-0">
                                            <div><n i18n="Create">请稍后</n> <n i18n="Account">...</n></div>
                                        </h4>
                                    </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <span><n i18n="Create">载入</n><n i18n="Account">SDK中...</n></span><br>
                                                    <textarea class="form-control alert alert-info show text_BandFrame" rows="2" id="CreateAccount_show" readonly>ak_****</textarea>
                                                <span i18n="MnemonicTips">...</span><br><br>
                                                <div class="position-relative form-group">
                                                    <textarea class="form-control alert alert-info show text_BandFrame" rows="3" style="background-color:white;" placeholder="请保存好助记词,丢失无法找回。" onclick="this.select();" id="createMMW" readonly></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="divider"></div>
                                    <h6 class="mb-0"><a href="/Login" class="text-primary"><n i18n="Mnemonic">助记词</n><n i18n="login">登录</n></a></h6>
                                </div>
                                <div class="modal-footer clearfix">
                                    <div class="float-right">
                                        <button class="btn btn-primary btn-lg" onclick="return Create_MMWords_check();" i18n="Create">请稍后...</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center text-white opacity-8 mt-3">Copyright © WeTrue</div>
                    </div>
                </div>
            </div>
        </div>
</div>


<?php $this->load->view('footer_SDK'); ?>