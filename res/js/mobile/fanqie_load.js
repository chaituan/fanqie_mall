/**
 * 番茄 滚动加载
 * www.wonuwo.com
 */
var myScroll,
wrapper_load = $('#wrapper_load'),
pullUp = $("#pullUp_load"),
container = $('#list'),
loadingStep = 0;//加载状态0默认，1显示加载状态，2执行加载数据，只有当为0时才能再次加载，这是防止过快拉动刷新



//滚动的方式
//myScroll = new IScroll("#wrapper_load", {
//	scrollbars: true,
//	scrollY:true,
//	bindToWrapper:true
//});
//
//myScroll.on("scrollEnd",function(){
//	if(loadingStep == 0 ){
//		console.log(this.maxScrollY);
//		if(this.maxScrollY<0&&this.y == this.maxScrollY){//上拉加载更多
//			
//			layer_load("玩命加载中...");
//			loadingStep = 1;
//			pullUpAction();
//		}
//	}
//});

//$('body').bind("touchmove",function(e){  
//    e.preventDefault();  
//});

//function pullUpAction(){
//	setTimeout(function(){
//		var li, i;
//		for (i = 0,li = ""; i < 3; i++) {
//			li += "<li>" + "new Add " + new Date().toLocaleString() + " ！" + "</li>";
//		}
//		container.append(li);
//		layer.closeAll();
//// 		loadingStep = 0;
//// 		myScroll.scrollTo(0,myScroll.maxScrollY+20,1000);
//		$('html, body').animate({
//            scrollTop: $('#dianji_load').offset().top
//        }, 1000);
//	},1000);
//}

document.addEventListener('touchmove', function (e) { e.preventDefault(); }, isPassive() ? {
	capture: false,
	passive: false
} : false);

function isPassive() {
    var supportsPassiveOption = false;
    try {
        addEventListener("test", null, Object.defineProperty({}, 'passive', {
            get: function () {
                supportsPassiveOption = true;
            }
        }));
    } catch(e) {}
    return supportsPassiveOption;
}