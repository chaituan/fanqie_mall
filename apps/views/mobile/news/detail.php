<?php echo template('mobile/header');?>
<div class="page article js_show">
    <div class="page__bd">
        <article class="weui-article">
            <h1><?php echo $item['title'];?></h1>
            <section>
                    <h3 style="color:#8c8c8c"><?php echo format_time($item['addtime'],'Y-m-d');?> <a href="#" style="color: #4395f5">番茄官网</a></h3>
                    <p>
                        <?php echo $item['content'];?>
                    </p>
            </section>
            <div class="weui-flex" style="color: #8c8c8c;margin-top: 50px;">
	            <div class="weui-flex__item ">阅读 <?php echo $item['hits'];?></div>
	            <div class="weui-flex__item text-right " id="ts">投诉</div>
        	</div>
        </article>
    </div>
</div>
<div class="weui-loadmore weui-loadmore_line" >
   <span class="weui-loadmore__tips">小伙伴留言</span>
</div>
<?php if($comment_items){?>
<div id="wrapper_load" data-page="<?php echo $pagemenu['start'];?>">  
	<div class="weui-cells" id='list'>
           	<?php foreach ($comment_items as $vs){ ?>
			<div class="weui-cell" >
				<div class="weui-cell__hd"><img src="<?php echo $vs['thumb'];?>" class="img_r40"></div>
				<div class="weui-cell__bd">
				<p class="nickname"><?php echo $vs['nickname'];?></p>
				<p class="content"><?php echo $vs['content'];?></p>
				</div>
			</div>
			<?php } ?>
	</div>
</div> 
<?php if($pagemenu['end']){ ?>
<div id="dianji_load" style="overflow: hidden;">
	<a href="javascript:;" id="dianji_load_click" class="weui-btn weui-btn_default" style="font-size: 14px;margin: 10px;color: #9a9a9a;">点击加载更多...</a>
</div>
<div id="dianji_load_wait" style="overflow: hidden;display: none">
  	<a href="javascript:;" class="weui-btn weui-btn_default weui-btn_loading" style="font-size: 14px;margin: 10px;color: #9a9a9a;"><i class="weui-loading"></i>玩命加载中...</a>
</div>
<?php }}else{ ?>
<div class="text-center p-tb-10 no_data">暂无数据</div>
<?php }?>

<?php echo template('mobile/script');?>
<script type="text/javascript">
//上拉要执行的方法
function pullUpAction(){
	setTimeout(function(){
		load_ajax({url:"/mobile/news/get_message",data:{page:$('#wrapper_load').data('page'),nid:'<?php echo $item['id']?>'}});
	},500);
}
//组合输出的列表
function load_list(d){
	var li, i;
	for (i = 0,li = ""; i < d.length; i++) {
		li += '<div class="weui-cell" >' 
			+ '<div class="weui-cell__hd"><img src="'+ d[i]['thumb'] +'" class="img_r40"></div>'
 			+ '<div class="weui-cell__bd">'
			+ '<p class="nickname">'+ d[i]['nickname']+'</p>'
			+ '<p class="content">'+ d[i]['content']+'</p>'
 			+ "</div>"
			+ "</div>";
	}
	$('#list').append(li);
}
$(function(){
	$('body').css('background-color','#fff');
	$('#ts').click(function(){
		layer.open({
			content: '投诉已提交，我们会尽快处理',btn: '关闭'
		});
	});
	$('#message').click(function(){
		layer.open({
			content:'<form id="F_ListForms">'
				+'	<input type="hidden" name="data[nid]" value="<?php echo $item['id']?>">'
				+'	<textarea rows="6" name="data[content]" class="fq_textarea" placeholder="请输入留言" min-length="3" max-length="100" required></textarea>'
				+'	<a href="<?php echo site_url('mobile/news/message')?>" class="weui-btn weui-btn_primary ajaxproxy" proxy=&#123;"formId":"F_ListForms","method":"post","location":"#"&#125;>提交留言</a>'
				+'</form>',
			success: function(elem){
				 $('.ajaxproxy').AjaxProxy();
			}  
		});
	});
});
</script>
<?php echo template('mobile/news_footer');?>
