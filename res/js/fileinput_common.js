$(function(){
	//上传图片start
    var filecommon = {resizeImage:true,resizePreference: 'width',uploadUrl:HTTP_HOST+"/images/upload",showRemove:false,showUpload:false,showClose:false,language: 'zh',allowedFileExtensions : ['jpg','png','gif'],previewClass:'hide'}
    //单张上传图片
    if(fileinput_edit){//判断是否编辑页面
    	$.extend(filecommon,{previewClass: ''});//去掉隐藏
    }
	$('.file-one').fileinput(
			filecommon
	).on('change',function(){
		$(this).parent().parent().parent().siblings('.file-preview').removeClass('hide');
	}).on('fileselect',function(){
		$(this).parent().parent().parent().siblings('.file-preview').removeClass('hide');
		getcount(this,1);//为了修改插件的bug 因为上传一个后可以继续上传
	}).on("filepredelete",function(){//预览时候的删除按钮，删除链接在html
		return del(this);
	}).on("fileuploaded",function(event, data){
		seturl(data,this);
	}).on("filesuccessremove", function (event, id) { //上传成功够的删除按钮
		var abort = false;
		if(confirm("确认删除吗？")){
			var key = $('#thumburl-'+$(this).data('bs'));
			$.post(HTTP_HOST+"/images/upload/del/",{key:key.val()});
			key.val('');
			abort = true;
		}
		
		return abort;
	});
    
	//多张图片上传
	$('.file-multi').fileinput(
			filecommon
	).on('change',function(event, data){
	    	$(this).parent().parent().parent().siblings('.file-preview').removeClass('hide');
	    	getcount(this,$(this).data('max-file-count'));//为了修改插件的bug 因为上传一个后可以继续上传
	}).on("filepredelete",function(event, key){
		var abort = true;
		if(confirm("确认删除？")){
			var keyarr = $('#thumburl-'+$(this).data('bs')).val().split(',');//转数组
			keyarr.splice($.inArray(key,keyarr),1);//踢出
			$('#thumburl-'+$(this).data('bs')).val(keyarr.join(','));//拼合赋值
			abort = false;
		}
		return abort;
	}).on("fileuploaded",function(event, data){
			seturl(data,this);
	}).on("filesuccessremove", function (event, id,d) {
		var abort = false;
		if(confirm("确认删除？")){
			var cache = $(this).data("okthumb").split(',');
			var keyarr = $('#thumburl-'+$(this).data('bs')).val().split(',');
			var string = cache[d];
			$.post(HTTP_HOST+"/images/upload/del/",{key:string});
			keyarr.splice($.inArray(string,keyarr),1);
			$('#thumburl-'+$(this).data('bs')).val(keyarr.join(','));
			abort = true;
		}
		return abort;
	});
	
    //公用方法
	function del(my,d){
		var abort = true;
		if(confirm("确认删除是吗？")){
			$('#thumburl-'+$(my).data('bs')).val('');
			abort = false;
		}
		return abort;
	}
	
	function seturl(data,my){//上传完毕复制url
		if(data.response.state==1){
			var id = $(my).data('bs');
			var url = $('#thumburl-'+id).val();
			if(url){
				$('#thumburl-'+id).val(url+',/'+data.response.data.url);
				$(my).data('okthumb',url+',/'+data.response.data.url);
			}else{
				$('#thumburl-'+id).val('/'+data.response.data.url);
				$(my).data('okthumb','/'+data.response.data.url);
		    }
		}
	}

	function getcount(my,count){//id和上传的总数
		var val = $('#thumburl-'+$(my).data('bs')).val();
		if(val){
			var num = val.split(',').length;
			if(num>=count){				
				$(my).fileinput('reset');
				layer.msg("上传的文件数量超过了限制",{icon:2});
			}
		}
	}
	
	//上传图片end
});
