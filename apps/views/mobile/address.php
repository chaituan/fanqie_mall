<div class="fanqie_address">

<!--地址列表-->
<div class="padb60" id="_addressList" style="display:none;">
	<div class="fanqie_top_bar" >
			<div class="fanqie_top_pull_left" onclick="javascript:location.hash = 'paypage'">
			  	<svg class="icon" aria-hidden="true"><use xlink:href="#icon-fanhui"></use></svg>
			</div>
			<div class="fanqie_top_title">地址管理</div>
	</div>
    <div id="addrlist" class="weui-cells"></div>
    <div style="height: 50px;"></div>
    <div class="weui-tab goods_footer"  style="bottom: 0;width: 100%;position: fixed;height: 0;z-index: 510">
		<div class="weui-tabbar footer">
		   <a href="javascript:void(0);" class="weui-tabbar__item buy " id="addAddress" > + 添加收货地址 + </a>
		</div>
	</div>
</div>

<!--添加地址-->
<div id="_addAddressPage" style="display:none;">
	<div class="fanqie_top_bar" >
			<div class="fanqie_top_pull_left" onclick="javascript:location.hash = 'addressList'">
			  	<svg class="icon" aria-hidden="true"><use xlink:href="#icon-fanhui"></use></svg>
			</div>
			<div class="fanqie_top_title">地址管理</div>
	</div>
    <form id="address_add_form" autocomplete="off">
    	<div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">收货人</label></div>
                <div class="weui-cell__bd">
                    <input type="text" class="weui-input" name="names" cname='收货人' max-length='4' required>
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">手机号码</label></div>
                <div class="weui-cell__bd">
                    <input type="text" class="weui-input"  name="mobile" cname='手机号码' dtype="mobile" required>
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <div id="distpicker1">
		                <select name="province" data-province="- 省 -" cname="省" class="weui-select" required></select>
		                <select name="city" data-city="- 市 -" cname="市" class="weui-select" required></select>
		                <select name="district" data-district="- 区 -" cname="区" class="weui-select" required></select>
		            </div>
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">详细地址</label></div>
                <div class="weui-cell__bd">
                    <input type="text" class="weui-input"  name="detailed" cname='详细地址' required>
                </div>
            </div>
            <div class="weui-cell weui-cell_switch">
                <div class="weui-cell__bd">
                    	设为默认地址
                </div>
                <div class="weui-cell__ft">
                    <label for="switchCP" class="weui-switch-cp">
                    <input type="hidden" name="default" value="0">
                        <input id="switchCP" class="weui-switch-cp__input" name="default" type="checkbox" />
                        <div class="weui-switch-cp__box"></div>
                    </label>
                </div>
            </div>
     	</div>
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" id="address_add">确认添加</a>
            <input type="reset" name="reset" style="display: none;" />
        </div>
    </form>
</div>

<!--地址编辑-->
<div id="_editAddressPage" style="display:none;">
	<div class="fanqie_top_bar" >
			<div class="fanqie_top_pull_left" onclick="javascript:location.hash = 'addressList'">
			  	<svg class="icon" aria-hidden="true"><use xlink:href="#icon-fanhui"></use></svg>
			</div>
			<div class="fanqie_top_title">地址管理</div>
	</div>
    <form id="address_edit_form" autocomplete="off">
    	<div class="weui-cells weui-cells_form">
	        <input type="hidden" name="id" id="edit-id">
	        <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">收货人</label></div>
                <div class="weui-cell__bd">
                    <input type="text" class="weui-input" name="data[names]" cname='收货人' id="edit-names" max-length='4' required>
                </div>
            </div>
	        <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">手机号码</label></div>
                <div class="weui-cell__bd">
                    <input type="text" class="weui-input" id="edit-mobile"  name="data[mobile]" cname='手机号码' dtype="mobile" required>
                </div>
            </div>	
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <div data-toggle="distpicker" id="distpicker2">
		                <select name="data[province]"  cname="省" class="weui-select" required></select>
		                <select name="data[city]"  cname="市" class="weui-select" required></select>
		                <select name="data[district]"  cname="区" class="weui-select" required></select>
		            </div>
                </div>
            </div>	         
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">详细地址</label></div>
                <div class="weui-cell__bd">
                    <input type="text" class="weui-input" id="edit-detailed"  name="data[detailed]" cname='详细地址' required>
                </div>
            </div>   
        	<div class="weui-cell weui-cell_switch">
                <div class="weui-cell__bd">
                    	设为默认地址
                </div>
                <div class="weui-cell__ft">
                    <label for="switchCPs" class="weui-switch-cp">
                    	<input type="hidden" name="default" value="0">
                        <input type="checkbox" id="switchCPs" class="weui-switch-cp__input"  name="default" value="1"  />
                        <div class="weui-switch-cp__box"></div>
                    </label>
                </div>
            </div>
        </div>
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" id="address_updata">确认编辑</a>
        </div>
    </form>
</div>
</div>
<script src="<?php echo JS_PATH.'distpicker/distpicker.data.min.js'?>"></script>
<script src="<?php echo JS_PATH.'distpicker/distpicker.min.js'?>"></script>
<script src="<?php echo JS_PATH.'address_modal.js'?>"></script>
