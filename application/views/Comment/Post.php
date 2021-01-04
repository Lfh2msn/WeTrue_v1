
 <div class="app-main__inner">

        <div class="main-card mb-3 card">
            <div class="card-body mb-5">
                <div class="card-header">
                    <div class="media flex-wrap align-items-center">
                        <span><n i18n="Comment">评论</n> To：</span>
                    </div>
                </div>
                    <textarea class="form-control text_BandFrame alert alert-info show autosize-input" style="max-height: 60px;background-color:white;" id="comm_to_hash" rows="1" readonly><?php echo $tohash;?></textarea>

                    <textarea maxlength="15000" onchange="this.value=this.value.substring(0, 15000)" onkeydown="this.value=this.value.substring(0, 15000)" onkeyup="this.value=this.value.substring(0, 15000)"  id="payload" class="form-control autosize-input" rows="4" style="max-height: 500px;" placeholder="说点什么吧..."></textarea>
                    <br>                
                    <div class="input-group" style="width:200px">
                        <input name="password" id="sendPassword" placeholder="Password" type="text"
                                class="form-control" maxlength="20" onkeyup="value=value.replace(/[^A-Za-z0-9.-]/g,'')" onfocus="this.type=password">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" id="sendAePost" onclick="return pwd_check();" i18n="Release">提交</button>
                        </div>
                    </div>                
                <span class="text-danger" id="result"></span>
            </div>
        </div>
</div>

        
<script type="text/javascript">
function pwd_check(){
    document.getElementById("result").innerHTML  = "";
    var payload = document.getElementById('payload');
        if(payload.value.length<1){
            document.getElementById("result").innerHTML = "不能空内容评论";
            payload.focus();
        return false;
        }
    var pwd_key=document.getElementById('sendPassword');
        if(pwd_key.value.length<3){
            document.getElementById("result").innerHTML = "密码不可能小于3位";
            pwd_key.value="";
            pwd_key.focus();
        return false;
        }
    $.toast("上链中...",0);//显示上链中
    sendAeTch(sendPassword.value,payload.value,'sendComment');
}
</script>
<?php $this->load->view('footer_inside');?>
<?php $this->load->view('footer'); ?>