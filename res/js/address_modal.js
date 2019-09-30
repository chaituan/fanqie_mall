$(function (){	
	location.hash = 'paypage';
	window.onhashchange=function(){
		var hash = window.location.hash;
		var id = hash.substr(1);
		showPage(id);
	};
 	function showPage(id){
		$("#_"+id).show();
		$("div[id^='_']").not("#_"+id).hide();
	}
 	
 	$('#distpicker1').distpicker('reset', true);
	var not = $('.notAddress').click(function(){  
		if($(".cur_name").html()){   //弹出列表框
			location.hash="addressList";
			showList();
		}else{
			editaddress();   //去微信
		}
	});
	
	$('#fromWei').click(function(){
		editaddress();  //去微信
	});
	
	//弹出列表框	
	$('.hasAddress').click(function(){  //有地址的时候
		$("#m-loading").removeClass('hide');
		location.hash="addressList";
		showList();
	});
	
	//选择地址
	$("#addrlist").on("click",'.addressItem',function(e){
		var valId = $(this).find(".valId").val(),
			defatip = $(this).find(".defatip").html(),
			name = $(this).find(".name").html(),
			mobile = $(this).find(".mobile").html(),
			province = $(this).find(".province").html(),
			city = $(this).find(".city").html(),
			district = $(this).find(".district").html(),
			detailed = $(this).find(".detailed").html();
			set_address(valId,defatip,name,mobile,province,city,district,detailed);
			location.hash = "paypage";
	});
	
	//添加地址
	$('#addAddress').click(function(){
		location.hash = "addAddressPage";
	})
	
	//确认添加
	$('#address_add').click(function (){
		var is = Ct_checkFrom("address_add_form");
		if(!is){return false;}
		var l = layer_load('玩命加载中...');
		$.ajax({
			type:'post',
			url:"/mobile/address/insert.html",
			data:$('#address_add_form').serialize(),
			dataType:'JSON',
			success:function(data){
				if(data.state==1){
					layer_msg(data.message);
					datas = data.data;
					var defatip="";
					if(datas.default){
						defatip="[默认]";
					}
//					set_address(datas.id,defatip,datas.names,datas.mobile,datas.province,datas.city,datas.district,datas.detailed);
					setTimeout(function(){
						location.hash="addressList";
						showList();
						$("input[type=reset]").trigger("click");
						$('#distpicker1').distpicker('reset', true);
					},1000);
					//$('.notAddress').attr('data-ids','1');
				}else{
					layer_msg(data.message);
				} 
				layer.colse(l);
			}
		});	
	});
	//编辑
	$("#addrlist").on("click",'.editBtn' ,function(e){
		e.stopPropagation();
		var $thisItem = $(this).parents(".addressItem");
		var name = $thisItem.find(".name").html(),
		 	mobile = $thisItem.find(".mobile").data('mobile'),
		 	prov = $thisItem.find(".province").html(),
			city = $thisItem.find(".city").html(),
			district = $thisItem.find(".district").html(),
		 	detailed = $thisItem.find(".detailed").html(),
			valId = $thisItem.find(".valId").val();
			isdefault = $thisItem.find(".defatip").html();
			isdefault?$("#switchCPs").prop('checked',true):$("#switchCPs").prop('checked',false);
			$("#edit-names").val(name);
			$("#edit-mobile").val(mobile);
			$("#edit-detailed").val(detailed);	
			$('#edit-id').val(valId);
			$("#distpicker2").distpicker('destroy');
			$("#distpicker2").distpicker({province: prov, city: city, district: district});
	});
	//确认修改
	$('#address_updata').click(function (){
		var is = Ct_checkFrom("address_edit_form" );
		if(!is){return false;}
		var l = layer_load('玩命加载中...');
		$.ajax({
			type:'post',
			url:"/mobile/address/edit.html",
			data:$('#address_edit_form').serialize(),
			dataType:'JSON',
			success:function(data){
				if(data.state==1){
					layer_msg(data.message);
					datas = data.data;
					var defatip="";
					if(datas.default){
						defatip="[默认]";
					}
//					set_address(datas.id,defatip,datas.names,datas.mobile,datas.province,datas.city,datas.district,datas.detailed);
					setTimeout(function(){
						location.hash="addressList";
						showList();
					},1000);
				}else{
					layer_msg(data.message);
				}
				layer.close(l);
			}
		});
	});

	//删除
	$("#addrlist").on("click",'.delones',function(){
		var url = $(this).attr('href');
		var self = this;
			 layer.open({
				    content: "您真的要删除该地址吗？",
				    btn: ['是', '否'],
				    yes: function(index){
				    	 $.get(url,function(data){
							   if ( data.state == 1 ) {
								   $(self).parents('.addressItem').remove();
								   //set_address(null,null,null,null,null);
							   }
							   layer_msg(data.message);
						  },'json');
				    	 layer.close(index);
				    }
			});
		return false;
	});

	function set_address(valId,defatip,name,mobile,province,city,district,detailed){
		$('.no_add').hide();
		$('.ok_add').show();
		$(".cur_name").html(name);
		$(".cur_phone").html(mobile);
		$(".cur_address").html(province+city+district+detailed);
		$("#buy_name").val(name);
		$("#buy_mobile").val(mobile);
		$("#buy_address").val(province+city+district+detailed);
	}
	
	function showList(){
		var addressHTML="";
		var isdefault = "";
		var l = layer_load('玩命加载中...');
		$.ajax({
			type:'post',
			url:"/mobile/address/lists.html",
			dataType:'json',
			success:function(data){
				if(data.state==1){
					datas = data.data;
					for (var i = 0; i < datas.length; i++) { 
						if(datas[i].isdefa){
							isdefault = '[默认]';
						}else{
							isdefault = '';
						}
						if(!datas[i].district){datas[i].district=''}
									
						addressHTML+='<div class=" weui-cell_address addressItem">'	
									+'	<input type="hidden" value="'+datas[i].id+'" class="valId">'
									+'	<div class="media">'
									+'		<div class="media-body">'
									+'			<div class="addressText">'
									+'				<div class="m-marb5 m-fs16"><span class="name">'+datas[i].names+'</span>&nbsp;&nbsp;<span class="mobile" data-mobile="' +datas[i].mobile+'">' +datas[i].mobile+'</span></div>'
									+'				<div class="co-bd"><span class="co-ED0506 defatip">'+isdefault+'</span> <span class="province">'+datas[i].province+'</span><span class="city">'+datas[i].city+'</span><span class="district">'+datas[i].district+'</span><span class="detailed">'+datas[i].detailed+'</span></div>'		
									+'			</div>'	
									+'		</div>'
									+'		<div class="media-right media-middle">'
									+'			<a href="#editAddressPage" class="editBtn"><svg class="icon" aria-hidden="true"><use xlink:href="#icon-bianji"></use></svg></a>'		
									+'		</div>'
									+'	</div>'
									+'	<a href="/mobile/address/del/id-'+datas[i].id+'" class="delones"><svg class="icon" aria-hidden="true"><use xlink:href="#icon-shanchu"></use></svg></a>'
									+'</div>'
					 }; 
					 $('#addrlist').html(addressHTML);
					 initdelete();
					 $("#m-loading").addClass('hide');
					 layer.close(l);
				}
			}
		});
	}

	//触摸滑动显示删除按钮
	function initdelete(){
		$(".addressItem").width($(window).width());
		var lines = $(".addressItem .media");
		lines.width($(window).width());

		var len = lines.length; 
		var lastX, lastXForMobile;

		var pressedObj;
		var start;
	
		for (var i = 0; i < len; ++i) {
			lines[i].addEventListener('touchstart', function(e){
				
				lastXForMobile = e.changedTouches[0].pageX;
				pressedObj = this; // 记录被按下的对象 
	
				// 记录开始按下时的点
				var touches = event.touches[0];
				start = { 
					x: touches.pageX, // 横坐标
					y: touches.pageY  // 纵坐标
				};
				
			});
	
			lines[i].addEventListener('touchmove',function(e){
				
				// 计算划动过程中x和y的变化量
				var touches = event.touches[0];
				delta = {
					x: touches.pageX - start.x,
					y: touches.pageY - start.y
				};
	
				// 横向位移大于纵向位移，阻止纵向滚动
				if (Math.abs(delta.x) > Math.abs(delta.y)) {
					event.preventDefault();
				}
			});
	
			lines[i].addEventListener('touchend', function(e){
				
				var diffX = e.changedTouches[0].pageX - lastXForMobile;
				if (diffX < -10) {
					$(pressedObj).animate({"margin-left":"-78px"}, 500); // 左滑
					$(pressedObj).siblings('.delones').animate({"right":"0px"}, 500);
				} else if (diffX > 10) {
					$(pressedObj).animate({"margin-left":"0"}, 500); // 右滑
					$(pressedObj).siblings('.delones').animate({"right":"-78px"}, 500);
				}
			});
		}		
	}

});
