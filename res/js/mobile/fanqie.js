/*! layer 封装弹层组件  By chaituan */

function layer_msg(content,style){
	style = style?'':'bottom:0'; //框架中是在底部，这里设置成默认显示在中间
	return layer.open({content: content,skin:'msg',time:2,style:style});
}

function layer_load(content){
	content = content||''; 
	return layer.open({type: 2,content: content});
}
//询问框
function layer_confirm(content){
	layer.open({
	    content: content,
	    btn: ['是', '否'],
	    yes: function(index){
	      layer.close(index);
	    }
	});
}



//表格检测
function Ct_checkFrom(formId){
	//do form check here, if you want proxy form submition
	var __form = new JForm({formId : formId});
	if (!__form.checkFormData()) {	return false; }
	return true;
}
//全选事件
var form = document.getElementById('J_ListForm');
if ( form != null ) {
    var elements = form.elements;
    var length = elements.length;
    $('#check-all').on('change.radiocheck', function(e) {
    //获取事件对象
    var target = e.target;
    for ( var i = 0; i < length; i++ ) {
        if ( elements[i].type != 'checkbox' || (elements[i].name != 'ids[]') ) continue;
	        if ( target.checked == true ) {
	        	$(elements[i]).prop('checked',true);
	        } else {
	        	$(elements[i]).prop('checked',false);
            }
        }
    });
}

//加载更多的ajax
function load_ajax(data){
	$.ajax({
		url:data.url,
		type:'post',
		data:data.data,
		dataType:'json',
		success:function(d){
			if(d.state==1){
				if(d.data.items.length){
					load_list(d.data.items);//写在页面里面的方法
					$('html, body').animate({
			            scrollTop: $('#dianji_load_wait').offset().top
			        }, 1000);
					if(d.data.page_end){
						$('#dianji_load').show();
						$('#dianji_load_wait').hide();
						$('#wrapper_load').data('page',data.data.page+1);
					}else{
						load_ajax_error('数据全部加载完毕');
					}
				}else{
					load_ajax_error('数据全部加载完毕');
				}
			}else{
				load_ajax_error('数据加载异常，请刷新');
			}
		}
	});
}
function load_ajax_error(d){
	$('#dianji_load').html('<a href="javascript:;"  class="weui-btn weui-btn_default" style="font-size: 14px;margin: 10px;color: #9a9a9a;">'+d+'</a>');
	$('#dianji_load').show();
	$('#dianji_load_wait').hide();
}

$(function(){
	//点击加载更多
	$('#dianji_load_click').click(function(){
		$('#dianji_load').hide();
		$('#dianji_load_wait').show();
		pullUpAction();
	});
	
	//启用异步代理
	$('.ajaxproxy').AjaxProxy();
});

//获取屏幕的大小
function getPageSize() {
    var xScroll, yScroll;
    if (window.innerHeight && window.scrollMaxY) {
        xScroll = window.innerWidth + window.scrollMaxX;
        yScroll = window.innerHeight + window.scrollMaxY;
    } else {
        if (document.body.scrollHeight > document.body.offsetHeight) { // all but Explorer Mac    
            xScroll = document.body.scrollWidth;
            yScroll = document.body.scrollHeight;
        } else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari    
            xScroll = document.body.offsetWidth;
            yScroll = document.body.offsetHeight;
        }
    }
    var windowWidth, windowHeight;
    if (self.innerHeight) { // all except Explorer    
        if (document.documentElement.clientWidth) {
            windowWidth = document.documentElement.clientWidth;
        } else {
            windowWidth = self.innerWidth;
        }
        windowHeight = self.innerHeight;
    } else {
        if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode    
            windowWidth = document.documentElement.clientWidth;
            windowHeight = document.documentElement.clientHeight;
        } else {
            if (document.body) { // other Explorers    
                windowWidth = document.body.clientWidth;
                windowHeight = document.body.clientHeight;
            }
        }
    }       
    // for small pages with total height less then height of the viewport    
    if (yScroll < windowHeight) {
        pageHeight = windowHeight;
    } else {
        pageHeight = yScroll;
    }    
    // for small pages with total width less then width of the viewport    
    if (xScroll < windowWidth) {
        pageWidth = xScroll;
    } else {
        pageWidth = windowWidth;
    }
    arrayPageSize = new Array(pageWidth, pageHeight, windowWidth, windowHeight);
    return arrayPageSize;
}