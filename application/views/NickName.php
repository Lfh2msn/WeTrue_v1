
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
                                            <div>WeTrue <n i18n="NickName">昵称</n></div>
                                        </h4>
                                    </div>
                                    <form>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <span id="Tips"><n i18n="NickName">昵称</n> (3-16 <n i18n="Bits">位</n>)</span>
                                                <div class="position-relative form-group"><input name="registerName" id="registerName" placeholder="Personalized nickname" 
                                                    type="UserName" class="form-control" onkeyup="value=value.replace(/[^a-zA-Z\d\u4e00-\u9fa5\u0800-\u4e00_.-]/g,'');" AUTOCOMPLETE="off" maxlength="16">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <span id="pwd_digit"><n i18n="Password">密码</n></span>
                                                <div class="position-relative form-group">
                                                <input name="password" id="sendPassword" placeholder="Password..." type="password" class="form-control" 
                                                maxlength="20" onkeyup="value=value.replace(/[^A-Za-z0-9.-]/g,'')"></div>
                                            </div>
                                        </div>
                                    </form>
                                    <font color="red"><div id="result"></div></font>
                                    <div class="divider"></div>
                                    <h6 class="mb-0"><n i18n="Consumption">消耗</n> <?php echo $toNameAmount/1e18?> ae</h6>
		                    	</div>
                                
                                <div class="modal-footer clearfix">
                                    
                                    <div class="float-right">
                                        <button class="btn btn-primary btn-lg" style="display:none" id="dname_check" onclick="return name_check();" i18n="Release">确定
                                        </button>
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

<?php $this->load->view('footer_inside');?>
<?php $this->load->view('footer');?>

<script type="text/javascript">
	//先将提示展示出来
	$("#Tips").show();
	$(function() {
        dget("result").innerHTML = "result: " + publicKey;
	//当键盘按键被松开时触发事件:通过AJAX将input中的数据传递给后端，在后端验证是否已存在该用户名
		$("#registerName").keyup(
				function() {
					var registerName = $(this).val();
					registerName = $.trim(registerName);
					if (registerName != "") {
						var url = "/NickName/checkName/" + registerName;
						//$.get()方法能够返回一个JQuery XMLHttpRequest对象
						var jqxhr = $.get(url, callback);
						//若执行JQuery出现错误则提示错误信息
						//在JQuery3.0以后需要用done()、fail()、alwayls()代替success()、error()、complete();
						jqxhr.fail(function(xhr, error, throwerror) {
							dget("dname_check").style.display="none";//隐藏
							$("#Tips").html("error" + xhr.status + " 请联系管理");
						});
					}
				});
		//当输入注册名的输入框失去焦点后就先隐藏提示语,这个隐藏提示语可根据具体需求决定是否隐藏
		$("#registerName").blur(function cls() {
			let blocknone = dget("regnm").innerText;
			if(blocknone=="Good" && publicKey!="" && publicKey!=null && publicKey!='undefined'){
				dget("dname_check").style.display="block";//显示按键
			}else{
				dget("dname_check").style.display="none";//隐藏按键
			}
		});
	});
	//ajax的回调函数
	function callback(data, status) {
		$("#Tips").show();
		$("#Tips").html(data);
	}

function name_check(){
    var name_key=document.getElementById('registerName');
        if(name_key.value.length<2){
            document.getElementById("Tips").style.color="red";
            document.getElementById("Tips").innerHTML = '昵称要求2字节 - 支持中英日';
            name_key.focus();
        return false;
    }
    var pwd_key=document.getElementById('sendPassword');
        if(pwd_key.value.length<3){
        	document.getElementById("pwd_digit").style.color="red";
            document.getElementById("pwd_digit").innerHTML = "密码不可能小于3位";
            pwd_key.value="";
            pwd_key.focus();
        return false;
        }
    document.getElementById("pwd_digit").innerHTML  = "OK";
    $.toast("上链中...",0);
    sendAeTch(sendPassword.value,registerName.value,'sendUserName');
}
</script>