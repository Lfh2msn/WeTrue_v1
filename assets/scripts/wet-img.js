// 图片懒加载
imgloadingStart();
// 当页面开始滚动的时候,遍历图片,如果图片出现在视窗中,就加载图片
var clock; //函数节流
$(window).on('scroll',function(){
    if(clock){
        clearTimeout(clock);
    }
    clock = setTimeout(function(){
        imgloadingStart()
    },200)
})
function imgloadingStart(){
    $('.imgLoading img').not('[data-isLoading]').each(function () {
        if (isShow($(this))) {
            loadImg($(this));
        }
    })
}
 
 // 判断图片是否出现在视窗的函数
function isShow($node){
    return $node.offset().top <= $(window).height()+$(window).scrollTop();
    }
// 加载图片的函数,就是把自定义属性data-src 存储的真正的图片地址,赋值给src
function loadImg($img){
//如果src==空,才加载
	if ($img.attr('src') == "/assets/images/wet-loading.jpg") {
		$img.attr('src', $img.attr('data-src'));
		// 已经加载的图片,我给它设置一个属性,值为WET,作为标识
		// 滚动的时候只遍历哪些还没有加载的图片,不遍历所有图片
		$img.attr('data-isLoading','WeTrue');
	}
}

//解决遮罩层滚动穿透问题，分别在遮罩层弹出后和关闭前调用
//ModalHelper.afterOpen(); 开启
//ModalHelper.beforeClose(); 关闭
const ModalHelper = ( (bodyCls) =>{
    let scrollTop;
    return {
        afterOpen: function () {
            scrollTop = document.scrollingElement.scrollTop;
            document.body.classList.add(bodyCls);
            document.body.style.top = -scrollTop + 'px';
        },
        beforeClose: function () {
            document.body.classList.remove(bodyCls);
            // scrollTop lost after set position:fixed, restore it back.
            document.scrollingElement.scrollTop = scrollTop;
        }
    };
})('dialog-open');

//缩放图片
$(document).click(function() {
    $(".clickMaxImg").zoomify();
});
