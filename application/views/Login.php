
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
                                        <h4 class="mt-2">
                                            <div><n i18n="WeTrue">请稍后</n> <n i18n="login">...</n></div>
                                        </h4>
                                    </div>
                                    <form class="">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <span id="words_digit" i18n="ImportCreate">Loading SDK...</span>
                                                <div class="position-relative form-group">
                                                    <textarea 
														class="form-control alert alert-info show text_BandFrame" 
														rows="3" 
														style="background-color:white;" 
														id="words" 
														placeholder="one two three four..." 
														onkeyup="value=value.replace(/[^A-Za-z ]/g,'')" 
														autocomplete="off"
													></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <span id="pwd_digit" i18n="Setpassword">...</span>
                                                <div class="position-relative form-group">
                                                <input 
												name="password" 
												id="examplePassword" 
												placeholder="Password..." 
												type="text" 
												class="form-control" 
                                                maxlength="20" 
												onkeyup="value=value.replace(/[^A-Za-z0-9.-]/g,'')" 
												>
												</div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="divider"></div>
                                    <h6 class="mb-0"><a href="/Create" class="text-primary"><n i18n="Create">生成</n><n i18n="Mnemonic">助记词</n></a></h6>
                                </div>
                                <div class="modal-footer clearfix">
                                    <div class="float-right">
                                        <button class="btn btn-primary btn-lg" onclick="return pwd_check();" i18n="login">请稍后</button>
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
<?php $this->load->view('footer'); ?>

<script type="text/javascript">
function pwd_check(){
    var words_key=document.getElementById('words');
        if(words_key.value.length<1){
            let MnemonicTips = '助记词不能为空,一般为12个单词(空格间隔)';
            document.getElementById("words_digit").style.color="red";
            document.getElementById("words_digit").innerHTML = MnemonicTips;
            words_key.value="";
            words_key.focus();
        return false;
    }
    //校验助记词
    var str_Words = words_key.value;
        try{
            Ae.HdWallet.generateSaveHDWallet(str_Words,0);
            document.getElementById("words_digit").innerHTML = '助记词正确';
        }catch(err){
            document.getElementById("words_digit").style.color="red";
            document.getElementById("words_digit").innerHTML = '无效助记词';
            return false;
        }
    var pwd_key=document.getElementById('examplePassword');
        if(pwd_key.value.length<3){
            document.getElementById("words_digit").style.color="";
            document.getElementById("pwd_digit").style.color="red";
            document.getElementById("pwd_digit").innerHTML = '临时密码要求3-20位';
            pwd_key.value="";
            pwd_key.focus();
        return false;
    }
    Login_click();
}
</script>