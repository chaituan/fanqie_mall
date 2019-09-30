(function($) {
	$.fn.__AjaxProxy = function(options) {
		var defaults = {
			callbackDelay: 50, /* callback delay */
			threadLock: true, /* 是否开启线程锁定，防止短时间内多次点击 */
			timeInterval: 3000, /* 两次操作的时间间隔， 如果没有开启线程锁定，则此项无效*/
			errorBox: null, /* 错误处理显示的dom id, 默认使用的是弹出tip的形式，则此参数默认无效 */
			method: 'get', /* 默认数据传输方式 */
			dataType: 'json', /* 默认返回的数据格式 */
			formId: null, /* 表单的默认ID */
			callBefore: function () {        /* 在执行ajax操作之前的调用函数 */
				//do nothing here
				return true;
			},
			callBack : function (data) {   /* 执行ajax之后的回调函数 */
				try {
					layer_msg(data.message);
				} catch(e) {
					layer_msg(data.message);
				}
			},
			formCheckHandler : function(formId) {
				//do form check here, if you want proxy form submition
				var __form = new JForm({formId : formId});
				if (!__form.checkFormData()) {	return false; }
				return true;
			}
		}

		//merge parameters
		options = $.extend(defaults,options);

		$(this).on('click', function (e) {
			e.stopPropagation();
			var params = getParams(this);
			/* 再次合并参数 */
			options = $.extend(options, params);
			/* 请求发送之前的调用函数 */
			if ( !options.callBefore($(this).attr('data-content')) ) return false;
			
			if(options.tips=='ok'){
				layer.open({
					content: "您真的要执行该操作吗？", 
					btn: ['是', '否'],
					yes: function(index){
						if (options.method == 'get') {
							ajaxGet(options, this);  //发送get请求
						} else {
							ajaxPost(options, this); //发送post请求
						}
						layer.close(index);
					}
				});
				return false;
			}else{
				if (options.method == 'get') {
					ajaxGet(options, this);  //发送get请求
				} else {
					ajaxPost(options, this); //发送post请求
				}

			}
			return false;
		});

		/**
		 * 根据元素的属性获取参数
		 * @param       obj     当前点击的元素
		 */
		function getParams(obj) {
			var paramStr = $(obj).attr('proxy');    /* 获取代理属性 */
			var href = $(obj).attr('href');         /* 获取href属性 */
			var params = {};
			if (paramStr) {
				params = $.parseJSON(paramStr);     /* 解析json数据格式 */
				//创建回调函数
				if ($.type(params.callBefore) == 'string') params.callBefore = new Function("data", 'return '+params.callBefore);
				if ($.type(params.callBack) == 'string') params.callBack = new Function("data", params.callBack);
			}
			params.url = href;
			return params;
		}

		/**
		 * 以get方式发送请求并处理返回参数
		 * @param       params   请求参数
		 * @param       obj     当前被点击的对象
		 */
		function ajaxGet(params, obj) {

			if ( params.threadLock ) {       /* 锁定线程，防止多次点击 */
				btnLoading(obj);
			}
			var loads = layer_load("玩命加载中...");
			$.get(params.url, {run: Math.random()}, function (result) {
				switch ( params.dataType ) {
					case 'html':
						layer.close(loads);
						if ( params.errorBox ) {
							$('#' + params.errorBox).html(result);
						} else {
							params.callBack(result);
						}
						break;

					case 'json':
						var data = $.parseJSON(result);
						layer.close(loads);
						params.callBack(data);
						location(data);
						break;
					default :
						layer_msg('不支持的数据格式');
				}

				if ( params.threadLock ) {       /* 解除锁定 */
					setTimeout(function () {
						btnReset(obj);
					}, options.timeInterval);
				}
			}).fail(function(){
				layer_msg('网络异常，请联系客服');
			});
		}

		/**
		 * 以post方式发送请求,通常要处理表单
		 * @param   params   请求参数
		 * @param   obj     当前被点击的对象
		 * @return boolean
		 */
		function ajaxPost(params, obj) {
			
			//if a from validation function, form data validation is performed.
			if ( params.formId && typeof params.formCheckHandler == "function" ) {
				if ( !params.formCheckHandler(params.formId) )  return false;
			}
			
			//locking thread to prevent multiple clicks.
			if ( params.threadLock ) {
				btnLoading(obj);
			}

			//collect form data
			var formData = $('#' + params.formId).serialize();
			var loads = layer_load("玩命加载中...");
			$.post(params.url, formData, function (result) {
				switch ( params.dataType ) {
					case 'html':
						layer.close(loads);
						if ( params.errorBox ) {
							$('#' + params.errorBox).html(result);
						} else {
							params.callBack(result);
						}
						break;
					case 'json':
						var data = $.parseJSON(result);
						layer.close(loads);
						params.callBack(data);
						location(data);
						break;
					default :
						layer_msg('不支持的数据格式');
				}
				if ( params.threadLock ) {       /* 解除锁定 */
					setTimeout(function () {
						btnReset(obj);
					}, params.timeInterval);
				}
			}).fail(function(){
				layer_msg('网络异常，请联系客服');
			});
		}

		//使按钮进入加载状态
		function btnLoading(obj) {
			try {
				$(obj).css("pointer-events",'none');
			} catch (e) {alert('sss');
				$(obj).attr('disabled', true);
			}
		}

		//恢复按钮状态
		function btnReset(obj) {
			try {
				$(obj).removeAttr("style");
			} catch (e) {
				$(obj).attr('disabled', false);
			}
		}

		//处理回调后的跳转
		function location(data) {
			var location = options.location;
			if ( location && data.state == '1' ) {
				if ( location == 'reload' ) { //刷新页面
					setTimeout(function() {
						window.location.reload();
					}, options.callbackDelay);
				} else if ( location == 'reset' ) {
					document.getElementById(options.formId).reset();
				}else if ( location == 'goback' ) {
					history.go(-1);
				} else {
					setTimeout(function() {
						window.location.replace(location);   //跳转
					}, options.callbackDelay);
				}
			}
		}
	}

	$.fn.AjaxProxy = function(options) {
		$(this).each(function(index, element) {
			$(element).__AjaxProxy(options);
		});
	}
	

})(jQuery);
