<?php echo template('mobile/header');?>
<div id="wrapper_load">  
  <ul id="list">  
	<li>系统加载中...</li>  
  
  </ul>  
</div> 
<div id="dianji_load">
	<a href="javascript:;" id="dianji_load_click" class="weui-btn weui-btn_default" style="font-size: 14px;margin: 10px;color: #9a9a9a;">点击加载更多...</a>
</div>
<div id="dianji_load_wait" style="display: none">
  	<a href="javascript:;" class="weui-btn weui-btn_default weui-btn_loading" style="font-size: 14px;margin: 10px;color: #9a9a9a;"><i class="weui-loading"></i>玩命加载中...</a>
</div>
<?php echo template('mobile/script');?>
<script type="text/javascript">
//上拉要执行的方法
function pullUpAction(){
	setTimeout(function(){
		load_ajax({url:"/mobile/cat/list_load",page:1});
	},10);
}
//组合输出的列表
function load_list(d){
	var li, i;
	for (i = 0,li = ""; i < d.length; i++) {
		li += "<li>" + "new Add " + d[i]['time'] + " ！" + "</li>";
	}
	$('#list').append(li);
}
</script>
</body>
</html>
