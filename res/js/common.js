$(function(){
	$('.ajaxproxy').AjaxProxy();
	//提示删除
	$('.delone').click(function(){
		var url = $(this).attr('href');
		var self = this;
		layer.confirm('确定要执行当前操作？', {
			  btn: ['是','否'] //按钮
			}, function(){
				$.get(url, function(data) {
                    if ( data.state == 1 ) {
                    	layer.msg(data.message,{icon: data.state});
                        $(self).parents('tr').remove();
                    }else{
                    	layer.msg(data.message,{icon: data.state});
                    }
                }, 'json');
			});
		return false;
	});
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
    //自动计算数据列表表格的colspan
    $('.empty-table-td').each(function() {
        var th = $(this).parent().parent().prev().children(":first").children();
        $(this).attr('colspan', th.length);
    });
    //未选中的多选框 不会提交name 艹，一下解决办法
    $('.fanqie_ckb').on('change',function(){
    	var name = $(this).attr('name');
    	if($(this).is(':checked')){
    		if($(this).prev().attr('name')==name){
    			$(this).prev().remove();
    		}
    	}else{
    		$(this).before("<input type='hidden' name="+name+" value='0'>");
    	}
    });
    
//    $(document).pjax('a', 'body',{fragment:'body',timeout:10000})
});

//列表删除全部移除tr
function list_deletes(data){
	if(data.state==1){
		var d = data.data;
		for(var i=0;i<d.length;i++){
			$("#list_"+d[i]).remove();
		}
	}
	layer.msg(data.message,{icon: data.state});
}
