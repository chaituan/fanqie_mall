
// es7 取对象属性值集合
Object.values = obj => {
	return Object.keys(obj).map(key => obj[key])
}

// 属性symbol分割符
const SKU_SEP = ','

// 组合选择的属性symbol路径
function getPath(selIds) {
	return selIds.sort().join(SKU_SEP)
}

let Sku = Vue.extend({
	data() {
		let active = {}
		Object.keys(this.keys).forEach(key => active[key] = null)
		return {
			active,
		}
	},
	computed: {
		// 选择的属性symbol集合
		selIds() {
			let sel = []
			for(let optionName in this.active) this.active[optionName] && sel.push(this.keys[optionName][this.active[optionName]])
			return sel
		},
		// 选择的属性symbol路径
		selPath() {
			return getPath(this.selIds)
		},
		// 选择的属性值集合
		selOptionsName() {
			let sel = []
			for(let a in this.active) if(this.active[a]) sel.push(this.active[a])
			
			return sel
		},
		// 价格范围
		price() {
			let obj = this.skus[this.selPath]
			
			let prices = obj && obj.prices
			if(prices) {
				let maxPrice = Math.max.apply(Math, prices)
	            let minPrice = Math.min.apply(Math, prices)
	            return maxPrice > minPrice ? '￥'+minPrice + "-" + maxPrice : '￥'+maxPrice
			} else {
				return $('#price').html();
			}
		},
		goods_img(){//产品图片
			return $('#goods_img').html();
		},
		// 库存（有可能是总库存）
		stock() {
			let obj = this.skus[this.selPath]
			return obj && '库存'+obj.stock+'件' || $('#stock').html();
		},
		stocks() {//判断用
			let obj = this.skus[this.selPath]
			return obj && obj.stock || 0;
		},
		skus() {
			let res = {}, addRes = (k, s) => {
					if (res[k]){						
			          res[k].stock += s.stock, res[k].prices.push(s.price)
			        } else {
			          res[k] = { stock: s.stock, prices: [s.price], }
			        }
				}, combine = (skas, n, s) => {
					let len = skas.length
					skas.forEach((key, i) => {
						for(let j = i + 1; j < len; ++j) if(j + n <= len) {
							let tmp = skas.slice(j, j + n), gk = getPath(tmp.concat(key))
							addRes(gk, s)
						}
					})
				}, keys = Object.keys(this.values)
				
				for(let key of keys) {
					let s = this.values[key]
					let skas = key.split(SKU_SEP).sort()
					let len = skas.length
					for(let j = 0; j < len; ++j) {
						addRes(skas[j], s)
						j > 0 && j < len-1 && combine(skas, j, s); 
					}
					res[getPath(key.split(SKU_SEP))] = {
						stock:s.stock,
						prices:[s.price],
					}
				}
			return res
		},
	},
	// 组件接收配置参数
	props: ['keys', 'values', ],
	methods: {
		// 点击事件
		select(symbol, name, title) {
			
			if(this.active[title] === name) this.active[title] = null
			else this.active[title] = name
		},
		// 判断是否可点击
		canClick(symbol, name, title) {
			console.log(symbol)
			// 如果元素本身已选中， 则可以点击（让用户取消选择）
			if(this.selIds.indexOf(symbol) !== -1)
				return true
			let self = this
			// 过滤已选中的当前选项层的所有属性值的symbol的集合
			let notSiblingsSelIds = this.selIds.filter(v => v !== symbol).filter(v => Object.values(self.keys[title]).indexOf(v) === -1)
			let sku = this.skus[getPath(notSiblingsSelIds.concat(symbol))]
			return sku && sku.stock > 0
		},
		sku_sub(keys,stock,price,sub,selPath){
			let is_title = $.trim($('#is_title').html());
			let title_ttl = Object.keys(keys).length;//总规格数量
			let num = $('#xz_num').val();//选择的数量
			if(title_ttl===0){
				result(sub,selPath,num,'',$('#goods_id').val(),$('#names').html(),$('#goods_img img').attr('src'),price);
			}else if(is_title!='请选规格'){
				let title_xz = is_title.split(' + ').sort();//选择的规格数量
				if(title_ttl == title_xz.length){
					if(stock>0&&stock>=num){
						result(sub,selPath,num,is_title,$('#goods_id').val(),$('#names').html(),$('#goods_img img').attr('src'),price);
					}else{
						layer_msg('抱歉库存不足，请联系商家',true);
					}
				}else{
					layer_msg('请先选择规格！',true);
				}
			}else{
				layer_msg('请先选择规格',true);
			}
			
			function result(sub,selPath,num,is_title,id,names,thumb,price){
				if(sub===1){
					$.post('/mobile/cart/add_cart.html', {selPath:selPath,num:num,options:is_title,id:id,names:names,thumb:thumb,price:price,shopid:$('#shopid').val()},function(d){
						layer_msg(d.message);
					},'json');
				}else{
					let l = layer_load('玩命为您加载中...');
					$.post('/mobile/order/save_goods.html', {selPath:selPath,num:num,options:is_title,id:id,names:names,thumb:thumb,price:price},function(d){
						if(d.state==1){
							window.location.href = d.data.url;
						}else{
							layer.close(l);
							layer_msg(d.message);
						}
					},'json');
				}
				//关闭sku
				$('#iosActionsheet').removeClass('weui-actionsheet_toggle');
				$('.goods_sku .header img').css("margin-top",'0');
				$('#iosMask').fadeOut(200);
			}
		}
	},
	watch: {
		"keys"() {
			let active = {}
			Object.keys(this.keys).forEach(key => active[key] = null)
			this.active = active
		},
	},
	template: `
			<div >
				<div class="weui-actionsheet__cell header" >
					<div class="weui-flex">
			            <div class="weui-flex__item" style="flex:1 1 35%;"><span v-html='goods_img'>{{ goods_img }}</span></div>
			            <div class="weui-flex__item" style="flex:1 1 60%;">
			            	<p class='price'>{{ price }}</p>
			            	<p class='stock'>{{ stock }}</p>
			            	<template v-if="Object.keys(keys).length>0">
			            		<p class='title_xz' id='is_title'> {{ selOptionsName.join(' + ')? '已选：'+selOptionsName.join(' + ') : '请选规格' }}</p>
			            	</template>
			            </div>
			            <div class="weui-flex__item" style="flex:1 1 5%;">
				            <span id="iosActionsheetCancel" class='pull-right' style="margin:-5px -5px 0 0">
								<svg class="icon" style="font-size: 30px;" aria-hidden="true"><use xlink:href="#icon-guanbi"></use></svg>
							</span>
			            </div>
			        </div>
				</div> 
				<template v-if="Object.keys(keys).length>0">
					<div class='weui-actionsheet__cell main'>
						<div v-for="(options, title) in keys" >
							<p class='title'>{{ title }}</p>
							<p>
								<button :class="{selected: active[title] === name}" @click="select(symbol, name, title)" :disabled="!canClick(symbol, name, title)" v-for="(symbol, name) in options" class="weui-btn weui-btn_mini weui-btn_default">
									{{ name }}
								</button>
							</p>
						</div>
					</div>
				</template>
				<div class="weui-actionsheet__cell">
					<div class="weui_cell">
						<div class="weui_cell_bd weui_cell_primary text-left">购买数量</div>
						<div style="font-size: 0px;" class="weui_cell_ft">
						<a class="weui-number weui-number-sub needsclick">-</a>
						<input pattern="[0-9]*" class="weui-number-input" style="width: 50px;" id='xz_num' readonly value="1" data-min="1" data-max="1000" data-step="1">
						<a class="weui-number weui-number-plus needsclick">+</a> 
						</div> <div class="weui_cell_ft" style="display: none;"> 0 </div> 
				    </div>
    			</div>
				<div class="weui-actionsheet__cell footer" id='sub_1'  @click="sku_sub(keys,stocks,price,1,selPath)">
        			确 认 
        		</div>
        		<div class="weui-actionsheet__cell footer" id='sub_2'  @click="sku_sub(keys,stocks,price,2,selPath)">
        			确 认 
        		</div>
			</div>
	`,
})
//{{ name }} ({{ symbol }})
//<p>选择路径：{{ selPath || '-' }}</p>