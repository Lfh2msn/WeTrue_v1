 <div class="app-main__inner">

        <div class="main-card mb-3 card">
            <div class="card-body mb-5">
                <div class="card-header">
                    <div class="media flex-wrap w-100 align-items-center">
                        <div class="d-block text-right">
                            <span i18n="ContentTips">Aeternity 记你所想</span>
                        </div>
                        <div class="media-body ml-2"></div>
                        <div class="text-muted small"></div>
                    </div>
                </div>
                    <textarea maxlength="15000" onchange="this.value=this.value.substring(0, 15000)" onkeydown="this.value=this.value.substring(0, 15000)" onkeyup="this.value=this.value.substring(0, 15000)"  id="payload" class="form-control autosize-input" rows="4" style="max-height: 600px;" placeholder="说点什么吧..."></textarea>
                    <br>
                <div class="input-group">
                    <a href="javascript:;" class="upload_img">
                        <img id="maxImg"  src="">
                        <input type="file" id="ImgPath" accept="image/*" onclick="return portrait_check();">+
                    </a>
                <div class="input-group ml-2" style="width:200px">
                    <input name="password" id="sendPassword" placeholder="Password" type="text"
                            class="form-control" maxlength="20" onkeyup="value=value.replace(/[^A-Za-z0-9.-]/g,'')" onfocus="this.type=password">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" id="sendAePost" style="height:38px" onclick="return pwd_check();" i18n="Release">提交</button>
                    </div>
                </div>
                </div>
                </div>
                <span class="text-danger" id="result"></span>
            </div>
        </div>
</div>

<?php $this->load->view('footer_inside');?>
<?php $this->load->view('footer_SDK');?>

<script language="javascript">
localStorage.setItem("PostsImg","");

function portrait_check(Effect){
    var eleFile = document.querySelector('#ImgPath');
    // 压缩图片需要的一些元素和对象,获取图片的尺寸，控制尺寸大小
    var reader = new FileReader(), 
        img = new Image();
    // 选择的文件对象
    var file = null;
    // 缩放图片需要的canvas
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    // base64地址图片加载完毕后
    img.onload = function () {
        thisimg = this;
    	const imgWidth = this.width;
		const imgHeight = this.height;

		var maximg = ImgCompress(imgWidth,imgHeight,1080,0.9);
    	var imgsize = getImgSize(maximg);

		if (imgHeight > Math.round(imgWidth*3)){
			var LG = 1;
			var maximg = ImgCompress(imgWidth,imgHeight,1080,0.9,LG);
        	var imgsize = getImgSize(maximg);
		}
        if(imgHeight > Math.round(imgWidth*3) && imgsize>180){
        	var maximg = ImgCompress(imgWidth,imgHeight,1080,0.7,LG);
        	var imgsize = getImgSize(maximg);
        }
        if(imgHeight > Math.round(imgWidth*3) && imgsize>180){
        	var maximg = ImgCompress(imgWidth,imgHeight,1080,0.5,LG);
        	var imgsize = getImgSize(maximg);
        }
        var maximg = ImgCompress(imgWidth,imgHeight,1080,0.9);
    	var imgsize = getImgSize(maximg);
        if(imgsize>=180){
        	//判断大小改压缩率0.7
            var maximg = ImgCompress(imgWidth,imgHeight,1080,0.7);
            var imgsize = getImgSize(maximg);
            if(imgsize>=180){
            	//再次判断大小改分辨率为960
                var maximg = ImgCompress(imgWidth,imgHeight,960,0.7);
                var imgsize = getImgSize(maximg);
	            if(imgsize>=180){
	            	//再次判断大小改压缩率0.6
	                var maximg = ImgCompress(imgWidth,imgHeight,960,0.6);
	                var imgsize = getImgSize(maximg);
		            if(imgsize>=180){
		            	//再次判断大小改分辨率为720
		                var maximg = ImgCompress(imgWidth,imgHeight,720,0.7);
		                var imgsize = getImgSize(maximg);
		                if(imgsize>=180){
		                	//再次判断大小改压缩率0.5
			                var maximg = ImgCompress(imgWidth,imgHeight,720,0.5);
		            	}
		            }
	            }
            }
        }
        
        localStorage.setItem("PostsImg", maximg);
        const s = window.localStorage;
		const s_img = s["PostsImg"];
        $("#maxImg").attr("src",s_img);
    };


    async function sendPimg(){//发送到WeT SDK处理
        const Password = document.getElementById('sendPassword').value;
        const s = window.localStorage;
		const s_img = await s["PostsImg"];

        if(s_img!="" && s_img!=null && s_img!='undefined'){
            const imgPayload = [];
            imgPayload.push(payload.value);
            imgPayload.push(s_img);
            sendAeTch(Password,imgPayload,'sendContent');
        }else{
            const newPayload = [];
            newPayload.push(payload.value);
            newPayload.push("");
            sendAeTch(Password,newPayload,'sendContent');
        }
    };

    if(Effect == "sendPimg"){
        sendPimg();
    }
    
    // 文件base64化，以便获知图片原始尺寸
    reader.onload = function(e) {
        img.src = e.target.result;
    };

    eleFile.addEventListener('change', function (event) {
        file = event.target.files[0];
        // 选择的文件是图片
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

	function ImgCompress(originWidth,originHeight,doWidthHeight,doCompress,LongGraph){
		var imgBase = "";
		var maxWidth = doWidthHeight, maxHeight = doWidthHeight;
		var targetWidth = originWidth, targetHeight = originHeight;
		if (originWidth > maxWidth || originHeight > maxHeight){
		    if (originHeight > Math.round(originWidth*3) && LongGraph == 1){
		    	targetWidth  = 540;
		    	targetHeight = Math.round(540 * (originHeight / originWidth));
		    }else if (originWidth / originHeight > maxWidth / maxHeight){
		        targetWidth  = maxWidth;
		        targetHeight = Math.round(maxWidth * (originHeight / originWidth));
		    }else{
		        targetHeight = maxHeight;
		        targetWidth  = Math.round(maxHeight * (originWidth / originHeight));
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
		//context.clearRect(0, 0, targetWidth, targetHeight);
		context.drawImage(thisimg, 0, 0, targetWidth, targetHeight);
		var type = 'image/jpeg';
		var imgBase = canvas.toDataURL(type,doCompress);
		return imgBase;
	}

}

function getImgSize(str){
    let strLength = str.length;
    let fileLength = parseInt(strLength - (strLength / 8)*2);
    let size = "";
    size = (fileLength / 1024 * 1.334).toFixed(2);
    return parseInt(size);
}

function pwd_check(){
    document.getElementById("result").innerHTML  = "";
    var payload = document.getElementById('payload');
        if(payload.value.length<1){
            document.getElementById("result").innerHTML = "不能发送空内容";
            payload.focus();
        return false;
        }
        if(payload.value.length<2){
            document.getElementById("result").innerHTML = "内容最低要求2字";
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
    $.toast("上链中...",0);
    portrait_check('sendPimg');
}
</script>