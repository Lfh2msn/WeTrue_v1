function dget(id) {
    return document.getElementById(id);
}

var getConfig = $("#WETConfig");
var WeTrue = getConfig.attr("WeTrue");
var toConAmount = getConfig.attr("toConAmount");
var toComAmount = getConfig.attr("toComAmount");
var toNameAmount = getConfig.attr("toNameAmount");
var toRecid = getConfig.attr("toRecid");
var toSendNode = getConfig.attr("toSendNode");
var toPortraitAmount = getConfig.attr("toPortraitAmount");


var storage = window.localStorage;
var publicKey = storage["publicKey"];
var username = storage["username"];
var portrait = storage["portrait"];
if (publicKey!="" && publicKey!=null && publicKey!='undefined'){

    dget("addTch").style.display = "block";
    dget("WalletId1").innerHTML = '<a href="/Wallet/ID/'+publicKey+'">'+ publicKey.substring(0, 3) + "****" + publicKey.substr(-4) + '</a>';
    dget("WalletId2").innerHTML = '<a href="/Wallet/ID/'+publicKey+'">'+ publicKey.substring(0, 3) + "****" + publicKey.substr(-4) + '</a>';

    if (username=="" && username==null && username=='undefined'){
        dget("ueserName_1").innerHTML = '匿名';
        dget("ueserName_2").innerHTML = '匿名';
    }else{
        dget("ueserName_1").innerHTML = username;
        dget("ueserName_2").innerHTML = username
                                    +'<a href="/NickName/"><button class="btn btn-outline-alternate ml-1">'
                                    +'修改</button></a>';
    }
    if (portrait=="" && portrait==null && portrait=='undefined'){
        let img_url = "/assets/images/avatars/null.jpg";
        dget("portrait_1").src = img_url;
        dget("portrait_2").src = img_url;
        dget("UserPortrait").src = img_url;
    }else{
        dget("portrait_1").src = portrait;
        dget("portrait_2").src = portrait;
    }
    
    dget("loginout").style.display="none";
    dget("logout").style.display="block";
    dget("userCenter").style.display="block";
    dget("userCenterurl").href='/Wallet/ID/'+publicKey;
    publicKeyToBalance(publicKey);

}

async function publicKeyToBalance(publicKey) {
    const node = await Ae.Node({ url: toSendNode});
    const client = await Ae.Wallet({
        nodes: [{ name: "WeTrue", instance: node }]
    });
    try{
        const balanceNumber = await client.balance(publicKey);
        const balanceS = balanceDC(balanceNumber);
            if(balanceS <= 0.001){
                dget("sendAePost").innerHTML = "AE不足";
                dget('sendAePost').disabled ='disabled';
                dget('sendAePost').class = "btn-shadow btn btn-secondary";
            }
        dget("balance").innerHTML = balanceS + " AE";
    }catch(err){
        dget("balance").innerHTML = "无链上记录";
        dget("sendAePost").innerHTML = "AE不足";
        dget('sendAePost').disabled ='disabled';
        dget('sendAePost').class = "btn-shadow btn btn-secondary";
        
    }
}

async function sendAeTch(password, payload,Effect){
    const logStorage = window.localStorage;
    const publicKey = logStorage["publicKey"];
    try{
        sendErrorTimeout();
        const secretKey = await keyStoreToSecretKey(password);
        const node = await Ae.Node({ url: toSendNode });
        const client = await Ae.Wallet({
            nodes: [{ name: "WeTrue", instance: node }],
            accounts: [
                Ae.MemoryAccount({
                    keypair: {
                        secretKey: secretKey,
                        publicKey: publicKey
                    }
                })
            ],
            address: publicKey
        });


        const strPayload = JSON.stringify(payload);
        async function sendContent(){
            const toAmount = toConAmount;
            const conPayload = JSON.stringify(payload[0]);
            const imgPayload = JSON.stringify(payload[1]);
            const res = await client.spend(
                toAmount,
                toRecid,
                {
                    payload:'{'
                            +'"WeTrue":"'+ WeTrue +'"'
                            +',"content_type":"Content"'
                            +',"wet_content":'+conPayload
                            +',"img_list":'+ imgPayload
                            +'}'
                }
            );
            const { blockHeight, hash, tx } = res;
            const amount = tx.amount;
            const txpayload = tx.payload;
            const dcamount = balanceDC(tx.amount);
            const fee = balanceDC(tx.fee);
            const amountFeeAe = dcamount + fee;

            $.ajax({
                type:"POST",
                url:"/Content/insertContent/",
                data:{hash},
                cache:false,
                success:function(data){
                    dget('payload').value="";
                    localStorage.setItem("PostsImg", "");
                    ajaxSuccess(amountFeeAe);
                },
                error:function(XMLHttpRequest,textStatus,errorThrown){
                    localStorage.setItem("PostsImg", "");
                    ajaxError(XMLHttpRequest,XMLHttpRequest,hash);
                }
            });
        };

        async function sendComment(){
            
            const toHash = comm_to_hash.value;
            const toAmount = toComAmount;
            const res = await client.spend(
                toAmount,
                toRecid,
                {
                    payload:'{'
                            +'"WeTrue":"' + WeTrue
                            +'","content_type":"Comment"'
                            +',"to_hash":"' + toHash + '"'
                            +',"wet_content":' + strPayload
                            +'}'
                }
            );

            const { blockHeight, hash, tx } = res;
            const amount = tx.amount;
            const txpayload = tx.payload;
            const dcamount = balanceDC(tx.amount);
            const fee = balanceDC(tx.fee);
            const amountFeeAe = dcamount + fee;

            $.ajax({
                type:"POST",
                url:"/Comment/insertComment/",
                data:{hash},
                cache:false,
                success:function(data){
                    $.removetoast();
                    dget('sendPassword').value="";
                    dget('payload').value="";
                    $.confirm("成功上链","本次消耗: " +amountFeeAe.toFixed(5)+"ae<br>返回上页?");
                    fytx_isok=function(){
                        window.history.back(-1);
                    }
                    fytx_iscancel=function(){
                        location.reload();
                    }
                },
                error:function(XMLHttpRequest,textStatus,errorThrown){
                    ajaxError(XMLHttpRequest,XMLHttpRequest,hash);
                }
            });
        };

        async function sendUserName(){

            const toAmount = toNameAmount;
            const res = await client.spend(
                toAmount,
                toRecid,
                {
                    payload:'{'
                            +'"WeTrue":"' + WeTrue +'"'
                            +',"content_type":"UserName"'
                            +',"wet_user":' + strPayload 
                            + '}'
                }
            );

            const { blockHeight, hash, tx } = res;
            const amount = tx.amount;
            const txpayload = tx.payload;
            const dcamount = balanceDC(tx.amount);
            const fee = balanceDC(tx.fee);
            const amountFeeAe = dcamount + fee;

            $.ajax({
                type:"POST",
                url:"/NickName/insertNickName/",
                data:{hash},
                cache:false,
                success:function(data){
                    localStorage.setItem("username", payload);
                    ajaxSuccess(amountFeeAe);
                },
                error:function(XMLHttpRequest,textStatus,errorThrown) {
                    ajaxError(XMLHttpRequest,XMLHttpRequest,hash);
                }
            });
        };

        async function sendPortrait(){
            var min_img = $.parseJSON(payload);
            const toAmount = toPortraitAmount;
            const res = await client.spend(
                toAmount,
                toRecid,
                {
                    payload:'{'
                            +'"WeTrue":"' + WeTrue + '"'
                            +',"content_type":"Portrait"'
                            +',"img_list":[' + payload + ']'
                            +'}'
                }
            );

            const { blockHeight, hash, tx } = res;
            const amount = tx.amount;
            const txpayload = tx.payload;
            const dcamount = balanceDC(tx.amount);
            const fee = balanceDC(tx.fee);
            const amountFeeAe = dcamount + fee;

            $.ajax({
                type:"GET",
                url:"/Portrait/insertPortrait/" + hash,
                cache:false,
                success:function(data){
                    localStorage.setItem("portrait", min_img.minimg);
                    ajaxSuccess(amountFeeAe);
                    
                },
                error:function(XMLHttpRequest,textStatus,errorThrown){
                    ajaxError(XMLHttpRequest,XMLHttpRequest,hash);
                }
            });
        };

        if(Effect == "sendContent"){
            sendContent();
        }else if(Effect == "sendComment"){
            sendComment();
        }else if(Effect == "sendUserName"){
            sendUserName();
        }else if(Effect == "sendPortrait"){
            sendPortrait();
        }

    }catch(err){
        dget("result").innerHTML = err+"<br>未登录、密码错误、余额不足等原因";
        $.removetoast();
    }
};


function ajaxSuccess(amountFeeAe) {
    $.removetoast();
    dget('sendPassword').value="";
    $.confirm("成功上链","本次消耗: " +amountFeeAe.toFixed(5)+"ae<br>返回首页?");
        fytx_isok=function(){
            window.location.href="/";
        }
        fytx_iscancel=function(){
            location.reload();
        }
}

function ajaxError(XMLHttpRequest,XMLHttpRequest,hash){
    $.removetoast();
    dget("result").innerHTML =
        '服务器中断<br>'+
        '请勿重新发帖，收到此信息证明已经成功上链<br>'+
        '通常您不需要做任何处理，我们将在48小时内恢复<br>'+
        '您可将下方信息复制保存，超过48小时未恢复请提交给管理员：<br><br>' +
        '<br>status:' + XMLHttpRequest.status +
        '<br>readyState:' + XMLHttpRequest.readyState +
        '<br>ErrHash: ' + hash;
}

function sendErrorTimeout(){
    setTimeout(function () {
        $.removetoast();
         $.alert("上传失败","超过90秒,上链失败");
      }, 90000);
}

function balanceDC(balance) {
    const balanceNumber = balance;
    const balanceNumberDC = balanceNumber/1000000000000000000;
    const balanceDC = balanceNumberDC.toFixed(5);
    const banlnceDCReturn = parseFloat(balanceDC);
    return banlnceDCReturn;
}

function Create_MMWords_check() {
    const words = Ae.HdWallet.generateMnemonic();
    dget("createMMW").innerHTML = words;
    const publicKey = Ae.HdWallet.getHdWalletAccountFromMnemonic(words,0).publicKey;
    dget("CreateAccount_show").innerHTML = publicKey;
    return;
}

async function Login_click() {
    const strWords = dget("words").value;
    const strPass = dget("examplePassword").value;
    const publicKeyInsecretKey = Ae.HdWallet.getHdWalletAccountFromMnemonic(strWords,0);
    const publicKey = publicKeyInsecretKey.publicKey;
    const secretKey = publicKeyInsecretKey.secretKey;
    wordKeyToIsKs(strPass, secretKey);
    $.ajax({
        type:"post",
        url:"/Login/GET/",
        data:{publicKey},
        cache:false, //不缓存此页面
        success:function(data){
            const min_img = $.parseJSON(data);
            localStorage.setItem("username", min_img.username);
            localStorage.setItem("portrait", min_img.portrait);
            localStorage.setItem("publicKey", publicKey);
            window.location.reload();
            window.location.href = "/";
        },error:function(e){
            localStorage.setItem("username", '错误信息');
            window.location.reload();
            window.location.href = "/";
        }});
}

function wordKeyToIsKs(password, secretKey) {
    Ae.Keystore.dump("WeTrueWallet", password, secretKey).then(Keystore => {
        localStorage.setItem("Keystore", JSON.stringify(Keystore));
    });
}

function keyStoreToSecretKey(password) {
    const logStorage = window.localStorage;
    const Keystore = JSON.parse(localStorage.getItem("Keystore"));
    return Ae.Keystore.recover(password, Keystore).then(strhex => {
        return strhex;
    });
}

function LogoutBtn_click() {
    localStorage.clear();
    window.location.reload();
}

$(document).on("click",".love",function(){
    const love = $(this);
    const txhash = love.attr("id");
    const sender_id = publicKey;
    if(sender_id==null || sender_id=="" || sender_id=='undefined'){
        $.toast("未登录",2);
        return false;
    }
    love.fadeOut(300);
    $.ajax({
        type:"POST",
        url:"/Love/Content/",
        data:{txhash,sender_id},
        cache:false,
        success:function(data){
            love.html('<span style="font-size:15px">'+data+'</span>');
            love.fadeIn(300);
        }
    });
    return false;
});

$(document).on("click",".CommentLove",function(){
    const commlove = $(this);
    const txhash = commlove.attr("id");
    const sender_id = publicKey;
    if(sender_id==null || sender_id=="" || sender_id=='undefined'){
        $.toast("未登录",2);
        return false;
    }
    commlove.fadeOut(300);
    $.ajax({
        type:"POST",
        url:"/Love/Comment/",
        data:{txhash,sender_id},
        cache:false,
        success:function(data){
            commlove.html('<span style="font-size:15px">'+data+'</span>');
            commlove.fadeIn(300);
        }
    });
    return false;
});

$(document).on("click",".report",function(){
    const lols = window.localStorage;
    const informant = lols["publicKey"];
    const report = $(this);
    const rp_sender_id = report.attr("id");
    const rp_hash = report.attr("hash");
    if(informant==null || informant=="" || informant=='undefined'){
        $.toast("未登录",2);
        return false;
    }
    $.toast("举报中",5);
    $.ajax({
        type:"GET",
        url:"/Report/Tx/",
        data:{rp_hash,rp_sender_id,informant},
        cache:false,
        success:function(data){
            $.removetoast();
            $.toast(data,1);
        },error:function(e){
            $.removetoast();
            $.toast(e.status+" "+e.statusText,2);
        }
    });
    return false;
});

function HexPayload(payload){
    const paystr = payload.substr(3);
    const hextopay = Ae.Crypto.decodeBase64Check(paystr);
    const paytostr = hextopay.toString();
    return paytostr;
}

function hex2str(hex) {
    var trimedStr = hex.trim();
    var rawStr = trimedStr.substr(0,2).toLowerCase() === "0x" ? trimedStr.substr(2) : trimedStr;
    var len = rawStr.length;
    if(len % 2 !== 0) {
        alert("Illegal Format ASCII Code!");
        return "";
    }
    var curCharCode;
    var resultStr = [];
    for(var i = 0; i < len;i = i + 2) {
        curCharCode = parseInt(rawStr.substr(i, 2), 16);
        resultStr.push(String.fromCharCode(curCharCode));
    }
    return resultStr.join("");
}

function str2hex(str) {
　　if(str === "")
　　　　return "";
　　var hexCharCode = [];
　　hexCharCode.push("0x"); 
　　for(var i = 0; i < str.length; i++) {
　　　　hexCharCode.push((str.charCodeAt(i)).toString(16));
　　}
　　return hexCharCode.join("");
}

function stampToTime(stamp){
    const data = Number(stamp);
    const d = new Date(data);
    const newtime = d.getFullYear() + '-' 
                + (d.getMonth()+1) + '-' 
                + d.getDate() + ' ' 
                + d.getHours() + ':' 
                + d.getMinutes() + ':' 
                + d.getSeconds();
    return newtime;
}

function autoScroll(){
    get_content();

    function scrollTop(){
        return Math.max(
            window.pageYOffset,
            document.body.scrollTop,
            document.documentElement.scrollTop);
    }

    function documentHeight(){
        return Math.max(document.body.scrollHeight,document.documentElement.scrollHeight);
    }

    function windowHeight(){
         return (document.compatMode == "CSS1Compat")?
         document.documentElement.clientHeight:
         document.body.clientHeight;
    }
    
    $(window).scroll(function(){
        if((scrollTop() + windowHeight()) - documentHeight() >= -100 && pageNum <= max_page){
            $('#getMore').show();
            setTimeout(function(){
                get_content();
            },300);
        }
    });
}

function PostLoad(str){
    pageNum++;
    $("#list_box").append(str);
    autosize($('.autosize-input'));
    imgloadingStart();
    if(max_page>=pageNum){
        document.getElementById('getContentEnd').innerHTML = '<a class="btn btn-dark" href="javascript:get_content();"> 手动加载更多 </a>';
    }else{
        document.getElementById('getContentEnd').innerHTML = '--- END ---';
    }
    $('#getMore').hide();
}

function getOrientation(file, callback){
	var reader = new FileReader();
	reader.onload = function(event) {
    var view = new DataView(event.target.result);
    if (view.getUint16(0, false) != 0xFFD8) return callback(-2);
		var length = view.byteLength,
			offset = 2;
		while (offset < length) {
		var marker = view.getUint16(offset, false);
		offset += 2;
		if (marker == 0xFFE1){
			if (view.getUint32(offset += 2, false) != 0x45786966) {
				return callback(-1);
			}
			var little = view.getUint16(offset += 6, false) == 0x4949;
			offset += view.getUint32(offset + 4, little);
			var tags = view.getUint16(offset, little);
			offset += 2;
			for (var i = 0; i < tags; i++)
				if (view.getUint16(offset + (i * 12), little) == 0x0112)
				return callback(view.getUint16(offset + (i * 12) + 8, little));
		}
		else if ((marker & 0xFF00) != 0xFF00) break;
		else offset += view.getUint16(offset, false);
		}
		return callback(-1);
	};
	reader.readAsArrayBuffer(file.slice(0, 64 * 1024));
};

function keyup_submittop(e){ 
	var evt = window.event || e; 
	if (evt.keyCode == 13){
		var suid = document.getElementById('suid').value;
		window.open('/Search/KeyWord/'+suid);
	}
}