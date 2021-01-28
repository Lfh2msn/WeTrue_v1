<div class="app-main__inner">

<div class="row">
    <div class="col-md-12">
        <div class="card-hover-shadow profile-responsive card-border border-success mb-3 card">
            <div class="dropdown-menu-header">
                <div class="dropdown-menu-header-inner bg-success">
                    <div class="menu-header-content">
                        <div class="avatar-icon-wrapper mb-2 avatar-icon-xl">
                            <div class="avatar-icon rounded">
    							<img width="42" height="42" id="minPortrait" src="">
                            </div>
                        </div>
                        <div>
                        	<h5 class="menu-header-title" id="userName">WeTrue</h5>
                        	<a href="javascript:;" class="a-upload">
                                <input class="mr-1 ml-1" type="file" id="iconPath" accept="image/*" onclick="return portrait_check();"><n i18n="Avatar">选择头像</n>
                            </a>
                        </div>
                        <div class="menu-header-btn-pane">
                            <div role="group" class="btn-group text-center">
                                <div class="nav ">
		                    		<div class="input-group">
                                        <input name="password" id="sendPassword" placeholder="Password" type="password"
	                          					class="form-control" maxlength="20" style="width:120px" 
	                          					onkeyup="value=value.replace(/[^A-Za-z0-9.-]/g,'')">

                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" onclick="return pwd_check();" i18n="Release">提交</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h5 class="menu-header-title text-danger text-center"><div id="result"><n i18n="Consumption">消耗</n> <?php echo $toPortraitAmount/1e18?> ae</div></h5>
<div align="center" style="width:100%;">
<img id="maxPortrait" width="70%">
</div>

<?php $this->load->view('footer_SDK');?>
<?php $this->load->view('footer'); ?>

<script language="javascript">
    //初始化
    var storage = window.localStorage;
    var username = storage["username"];
    var portrait = storage["portrait"];
    document.getElementById("userName").innerHTML = username; //外层用户名
    document.getElementById("minPortrait").src = portrait; //头像
function portrait_check(Effect){
    var eleFile = document.querySelector('#iconPath');
    // 压缩图片需要的一些元素和对象,获取图片的尺寸，控制尺寸大小
    var Orientation = null;
    var reader = new FileReader(), 
        img = new Image();
    // 选择的文件对象
    var file = null;
    // 缩放图片需要的canvas
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    // base64地址图片加载完毕后
    img.onload = function () {
        // 图片原始尺寸
        var originWidth = this.width;
        var originHeight = this.height;
        // 最大尺寸限制
        var maxWidth = 100, maxHeight = 100;
        // 目标尺寸
        var targetWidth = originWidth, targetHeight = originHeight;

        if (originWidth > maxWidth || originHeight > maxHeight) {
            if (originWidth / originHeight > maxWidth / maxHeight) {
                targetWidth = maxWidth;
                targetHeight = Math.round(maxWidth * (originHeight / originWidth));
            } else {
                targetHeight = maxHeight;
                targetWidth = Math.round(maxHeight * (originWidth / originHeight));
            }
        }

        // canvas对图片进行缩放
        var degree = 0, width, height;
        canvas.width = width = targetWidth;
        canvas.height = height = targetHeight;

        //判断图片方向，重置canvas大小，确定旋转角度，iphone默认的是home键在右方的横屏拍摄方式
        switch (Orientation) {
            //iphone横屏拍摄，此时home键在左侧 
            case 3:
                degree = 180;
                targetWidth = -width;
                targetHeight = -height;
                break;
            //iphone竖屏拍摄，此时home键在下方(正常拿手机的方向) 
            case 6:
                canvas.width = height;
                canvas.height = width;
                degree = 90;
                targetWidth = width;
                targetHeight = -height;
                break;
            //iphone竖屏拍摄，此时home键在上方 
            case 8:
                canvas.width = height;
                canvas.height = width;
                degree = 270;
                targetWidth = -width;
                targetHeight = height;
                break;
        }
        //使用canvas旋转校正
        context.rotate(degree * Math.PI / 180);
        context.fillStyle = "#fff";
        context.fillRect(0, 0, targetWidth, targetHeight);
        context.drawImage(this, 0, 0, targetWidth, targetHeight);
        var type = 'image/jpeg';
        //将canvas元素中的图像转变为DataURL
        var minimg = canvas.toDataURL(type,0.9);
        
        //创建大图片
        var originWidth = this.width;
        var originHeight = this.height;
        // 最大尺寸限制
        var maxWidth = 720, maxHeight = 720;
        // 目标尺寸
        var targetWidth = originWidth, targetHeight = originHeight;
        // 图片尺寸超过960x960的限制
        if (originWidth > maxWidth || originHeight > maxHeight) {
            if (originWidth / originHeight > maxWidth / maxHeight) {
                targetWidth = maxWidth;
                targetHeight = Math.round(maxWidth * (originHeight / originWidth));
            } else {
                targetHeight = maxHeight;
                targetWidth = Math.round(maxHeight * (originWidth / originHeight));
            }
        }
        var degree = 0, width, height;
        canvas.width = width = targetWidth;
        canvas.height = height = targetHeight;
        switch (Orientation) {
            case 3:
                degree = 180;
                targetWidth = -width;
                targetHeight = -height;
                break;
            case 6:
                canvas.width = height;
                canvas.height = width;
                degree = 90;
                targetWidth = width;
                targetHeight = -height;
                break;
            case 8:
                canvas.width = height;
                canvas.height = width;
                degree = 270;
                targetWidth = -width;
                targetHeight = height;
                break;
        }
        context.rotate(degree * Math.PI / 180);
        context.fillStyle = "#fff";
        context.fillRect(0, 0, targetWidth, targetHeight);
        context.drawImage(this, 0, 0, targetWidth, targetHeight);
        var type = 'image/jpeg';
        var maximg = canvas.toDataURL(type,0.5);

        var bin = atob(maximg.split(',')[1]);
        var buffer = new Uint8Array(bin.length);

        for (var i = 0; i < bin.length; i++) {
            buffer[i] = bin.charCodeAt(i);
        }

        var blob = new Blob([buffer.buffer], {type: type});
        var url = window.URL.createObjectURL(blob);
        $("#maxPortrait").attr("src",url);
        $("#minPortrait").attr("src",minimg);

        return payload = '{"minimg":"' + minimg + '","maximg":"' + maximg +'"}';
    };


    function sendPimg(){
    	let Password = document.getElementById('sendPassword').value;
        $.toast("上链中...",0);
		sendAeTch(Password,payload,'sendPortrait');
	};

	if(Effect == "sendPimg"){
    	sendPimg();
    }

    reader.onload = function(e) {
        img.src = e.target.result;
    };

    eleFile.addEventListener('change', function (event) {
        file = event.target.files[0];

        if (file.type.indexOf("image") == 0) {
            getOrientation(file, function(orientation) {
                Orientation = orientation;
                document.getElementById("result").innerHTML = "";
                reader.readAsDataURL(file);
            });
        }else{
        	document.getElementById("result").innerHTML = "这不是图片";
            }
    });


}

function getImgSize(str){
    //获取base64图片大小，返回KB数字
    let strLength = str.length;
    let fileLength = parseInt(strLength - (strLength / 8)*2);
    // 由字节转换为KB
    let size = "";
    size = (fileLength / 1024 * 1.334).toFixed(2);
    return parseInt(size);
  }

function pwd_check(){
    document.getElementById("result").innerHTML  = "";
    let exFile = document.querySelector('#iconPath');
	    if(exFile.value < 5){
			document.getElementById("result").innerHTML  = "还没选图片";
			return false;
	    }
    let pwd_key=document.getElementById('sendPassword');
        if(pwd_key.value.length<3){
            document.getElementById("result").innerHTML = "密码不可能小于3位";
            pwd_key.value="";
            pwd_key.focus();
        return false;
        }
    portrait_check('sendPimg');
}

</script>