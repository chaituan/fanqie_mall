<?php $data['definedcss'] = array(CSS_PATH.'menu/menu'); echo template('admin/header',$data);echo template('admin/sider'); ?>
<!-- content -->
<script src="<?php echo JS_PATH.'/menu/modernizr.js'?>"></script>
<script src="<?php echo JS_PATH.'/menu/jquery.js'?>"></script>
<div id="content" class="app-content animated fadeIn" role="main">
	<div class="app-content-body ">
		<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="app.settings.asideFolded = false;app.settings.asideDock = false;">
			<!-- main -->
			<div class="col">
				<!-- / main header -->
				<div class="wrapper-md" >
					<!-- / service -->
					<div class="row">
						<div class="col-sm-12 connected" >
							<div class="panel panel-success" id="divMain">
								<div class="panel-heading">创建公众号菜单</div>
								<div class="panel-body" data-bind="with:Menus" id="divMenu" style="display: none;">
				                        <div style="height: 200px;" data-bind="foreach:newArray(3)">
				                            <div class="list-group col-xs-4 clearFill bn">
				                                <!--ko if:($parent.button.length>0 && $parent.button[$index()]!=undefined && $parent.button[$index()].sub_button!=undefined ) -->
				                                <!--ko foreach:newArray((4-$parent.button[$index()].sub_button.length)) -->
				                                <div class="list-group-item bn"></div>
				                                <!--/ko-->
				                                <!--ko if:$parent.button[$index()].sub_button.length<5 -->
				                                <div class="list-group-item" data-bind="click:function (){$root.AddMenu($index())}">
				                                    <i class="fa fa-plus"></i>
				                                </div>
				                                <!--/ko-->
				                                <!--ko foreach:($parent.button[$index()].sub_button) -->
				                                <div class="list-group-item" data-bind="text:name,attr:{'bottonIndex':$parent.value,'subbottonIndex':$index()},click:function (){$root.EditMenu($data,$parent.value,$index())}"></div>
				                                <!--/ko-->
				                                <!--/ko -->
				                                <!--ko if: $parent.button[$index()]!=undefined && $parent.button[$index()].sub_button==undefined -->
				                                <div class="list-group-item bn"></div>
				                                <div class="list-group-item bn"></div>
				                                <div class="list-group-item bn"></div>
				                                <div class="list-group-item bn"></div>
				                                <div class="list-group-item" data-bind="click:function (){$root.AddMenu($index())}">
				                                    <i class="fa fa-plus"></i>
				                                </div>
				                                <!--/ko-->
				                                <!--ko if: $parent.button[$index()]==undefined -->
				                                <div class="list-group-item bn"></div>
				                                <div class="list-group-item bn"></div>
				                                <div class="list-group-item bn"></div>
				                                <div class="list-group-item bn"></div>
				                                <div class="list-group-item bn"></div>
				                                <!--/ko-->
				                            </div>
				                        </div>
				                        <!--ko foreach:button -->
				                        <div class="col-xs-4 list-group-item list-group-item-danger" data-bind="text:name,attr:{'bottonindex':$index()},click:function (){$root.EditMenu($data,$index(),-1)}"></div>
				                        <!--/ko-->
				                        <!--ko if:button.length < 3 -->
				                        <div class="col-xs-4 list-group-item" data-bind="click:function (){$root.AddMenu();}">
				                            <i class="fa fa-plus"></i>
				                        </div>
				                        <!--/ko-->
				                        <div class="clearfix"></div>
				                        <div class="col-xs-12" style="border: 1px solid #EEEEEE; padding-top: 15px; margin-top: 15px;" data-bind="with:$root.Menu,visible:($root.Menu()!=undefined)">
				                            <form id="MenuForm" onsubmit="return false;">
				                                <div class="form-group col-xs-4">
				                                    <input type="text" class="form-control" name="name"  data-placement="top" data-toggle="popover"  placeholder="请输入名称" data-bind="value:name,event:{'keyup':$root.EventNameErrorMessage},attr:{'data-content':$root.NameErrorMessage}">
				                                </div>
				                                <div class="form-group col-xs-4">
				                                    <select class="form-control" onchange="$('#txtMenuButtonValue').attr('placeholder', $(this).find('option:selected').attr('pl'))" data-bind="value:type">
				                                        <option value="view" pl="请输入Url">跳转URL</option>
				                                        <option value="click" pl="请输入Key">点击推事件</option>
				                                        <option value="scancode_push" pl="请输入Key">扫码推事件</option>
				                                        <option value="scancode_waitmsg" pl="请输入Key">扫码推事件且弹出“消息接收中”提示框</option>
				                                        <option value="pic_sysphoto" pl="请输入Key">弹出系统拍照发图</option>
				                                        <option value="pic_photo_or_album" pl="请输入Key">弹出拍照或者相册发图</option>
				                                        <option value="pic_weixin" pl="请输入Key"> 弹出微信相册发图器</option>
				                                        <option value="location_select" pl="请输入Key">弹出地理位置选择器</option>
				                                    </select>
				                                </div>
				                                <div class="form-group col-xs-8">
				                                    <input type="text" id="txtMenuButtonValue" name="value" class="form-control" placeholder="请输入Url" data-placement="top" data-toggle="popover" data-bind="value:value,event:{'keyup':$root.EventValueErrorMessage},attr:{'data-content':$root.ValueErrorMessage}">
				                                </div>
				                                <div class="form-group col-xs-12">
				                                    <button type="submit" class="btn btn-primary" data-bind="click:$root.MenuSave">确定</button>
				                                    <button type="submit" class="btn btn-danger" data-bind="visible:$root.isEditMenu,click:$root.DeleteMenu">删除</button>
				                                    <button type="button" class="btn btn-default" title="上移" data-bind="visible:$root.isEditMenu(),disable:!$root.IsUp(),click:$root.Up"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></button>
				                                    <button type="button" class="btn btn-default" title="下移" data-bind="visible:$root.isEditMenu(),disable:!$root.IsDown(),click:$root.Down"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></button>
				                                    <button type="button" class="btn btn-default" title="左移" data-bind="visible:$root.isEditMenu(),disable:!$root.IsLeft(),click:$root.Left"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></button>
				                                    <button type="button" class="btn btn-default" title="右移" data-bind="visible:$root.isEditMenu(),disable:!$root.IsRight(),click:$root.Right"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
				                                    <button type="button" class="btn btn-default" title="复制菜单" data-bind="visible:$root.isEditMenu(),click:$root.Copy">复制</button>
				                                    <button type="button" class="btn btn-default" title="粘贴菜单" data-bind="click:$root.Paste">粘贴</button>
				                                    <button type="submit" class="btn btn-default" data-bind="click:$root.CancelMenuSave">关闭</button>
				                                </div>
				                            </form>
				                        </div>
				                        <div class="clearfix"></div>
				                    </div>
				                    <div class="panel-footer" data-bind="with:Menus">
				                        <button id="btnSubmitMenu" type="button" class="btn btn-primary" data-bind="click:$root.SaveMenus" data-toggle="tooltip" data-placement="top" title="发布到微信"><i class="fa fa-upload" aria-hidden="true"></i> 保存并发布</button>
				                        <button id="btnQueryMenu" type="button" class="btn btn-default" data-bind="click:function (){$root.EditMenus(true)}" data-toggle="tooltip" data-placement="top" title="查询微信现有菜单"><i class="fa fa-download" aria-hidden="true"></i> 拉取微信菜单</button>
				                    </div>
				                </div>
				                <div class="panel panel-default">
				                    <div class="panel-heading">实时JSON（技术使用）</div>
				                    <div class="panel-body">
				                    <pre id="jsonShow" style="padding:0;border:none;background-color:#fff;" data-bind="html:JSON.stringify($root.NewMenu(),null,4)"></pre>
				                </div>
				                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script src="<?php echo JS_PATH.'layer/layer.js'?>"></script>
<script src="<?php echo JS_PATH.'jquery/bootstrap/dist/js/bootstrap.min.js';?>"></script>
<script src="<?php echo JS_PATH.'/menu/jquery.validate.js'?>"></script>
<script src="<?php echo JS_PATH.'/menu/jquery.validate.unobtrusive.js'?>"></script>
<script src="<?php echo JS_PATH.'/menu/menu.js'?>"></script>
<script src="<?php echo JS_PATH.'ui-nav.js';?>"></script>
</div>
</body>
</html>