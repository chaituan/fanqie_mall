<div class="modal fade skuModal" role="dialog" aria-labelledby="skuModal" data-backdrop="static" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	<div class="modal-body">
    	<div class="wrapper-md"> 
      	<div class="panel panel-default" id="sku" >
			<div class="panel-heading font-bold">
				<a style="cursor: pointer;" @click="addKey" class="btn m-b-xs btn-sm btn-success btn-addon"><i class="fa fa-plus fa-fw"></i>添加规格</a>
				<span class="help_block">（点击下面规格或者规格属性即可删除）</span>
			</div>
		
			<div class="row wrapper">
				<div v-for="(title, i) in titles" class="col-sm-12 m-b-xs">
						<span style="cursor: pointer;" @click="delKey(i)" class="btn btn-sm btn-info m-r-lg padder-md">{{ title }}</span>
						<span class="btn-group">
							<button @click="delOption(i, j)" v-for="(name, j) in options[i]" class="btn btn-sm btn-default">
								{{ name }}
							</button>
							<a @click="addOption(i)" style="cursor: pointer;" class="btn btn-sm btn-default" title="添加规格属性"><i class="fa fa-plus fa-fw"></i></a>
						</span>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped b-t b-light" style="margin-bottom: 0;">
					<thead>
						<tr>
							<th>ID</th>
							<th v-for="title in titles">{{ title }}</th>
							<th>价格</th>
							<th>库存</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="path in paths">
							<td>{{ path.symbols.join(SKU_SEP) }}</td>	
							<td v-for="opt in path.values">
								{{ opt }}
							</td>
							<td>
								<input v-model="path.price" type="number" step="0.01"  class="form-control input-sm"/>
							</td>
							<td>
								<input v-model="path.stock" type="number" class="form-control input-sm"/>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- 明天插入的时候根据 编号获取价格和库存 -->
				<div  id='s_price' class="hide">{<template v-for="path in paths">"{{ path.symbols.join(SKU_SEP) }}":"{{ path.price }}",</template>}</div>
				<div  id='s_stock' class="hide">{<template v-for="path in paths">"{{ path.symbols.join(SKU_SEP) }}":"{{ path.stock }}",</template>}</div>
				<div  id='s_titles' class="hide"><template v-for="path in paths">{{ JSON.stringify(path.titles) }}-</template></div>
				<div  id='s_options' class="hide"><template v-for="path in paths">{{ JSON.stringify(path.s_options) }}-</template></div>
			</div>
		</div>
		</div>
		</div>
		<div class="modal-footer" style="text-align: center;">
	        <button type="button" class="btn btn-primary" id="sku_save">保存规格</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    	</div>
    </div>
    
  </div>
</div>
<!-- 	<sku :keys="keys" :values="paths"></sku> -->
<script src="<?php echo JS_PATH.'sku/vue.js'?>"></script>
<script src="<?php echo JS_PATH.'sku/sku.js'?>"></script>
<script>
 		Vue.config.devtools = true
		let vue = new Vue({
			data: {
				titles: JSON.parse(document.getElementById("sku_titles").value)||[],
				options: JSON.parse(document.getElementById("sku_options").value)||[],
				stock: JSON.parse(document.getElementById("sku_stock").value)||[],
				price: JSON.parse(document.getElementById("sku_price").value)||[],
				SKU_SEP,
			},
			components: {
				Sku,
			},
			computed: {
				keys() {
					let keys = {}
					let symbol = 0
					for(let i in this.titles) {
						let option = {}
						for(let j in this.options[i]) {
							option[this.options[i][j]] = symbol++
						}
						keys[this.titles[i]] = option
					}
					return keys
				},
				paths() { 
					let arr = this.titles.map( (v, k) => this.options[k].map((l, k) => [this.keys[v][l], l, v, ]) );
					let stock = this.stock;
					let price = this.price;
					let path = [], paths = {}, len = arr.length
					let func = (arr, n) => {
						if(typeof(arr[n])=="undefined")return;
						for(let i of arr[n]) {
							path.push(i)
							if(n !== len - 1) {
								func(arr, n + 1)
							} else {
								
								paths[path.map(v=>v[0]).sort().join(SKU_SEP)] = {
									symbols: path.map(v=>v[0]),
									values: path.map(v=>v[1]),
									titles: path.map(v=>v[2]),
									stock: stock[path.map(v=>v[0]).sort().join(SKU_SEP)]||document.getElementById("stock").value,
									price: price[path.map(v=>v[0]).sort().join(SKU_SEP)]||document.getElementById("price").value,
									s_options:this.options,
								}
							}
							path.pop()
						}
					}
					func(arr, 0)
					return paths
				},
			},
			methods: {
				addOption(i) {
					var my = this;
					layer.prompt({title:'请输入规格属性（如：红色等）'},function(value, index, elem){
						  my.options[i].push(value)
						  layer.close(index);
					});
				},
				delOption(i, j) {
					var my = this;
					layer.confirm('确定要删除？',function(index){
						my.options[i].splice(j, 1)
						layer.close(index);
					});
				},
				delKey(i) {
					var my = this;
					layer.confirm('确定要删除？',function(index){
						my.titles.splice(i, 1)
						my.options.splice(i, 1)
						layer.close(index);
					});
				},
				addKey() {
					var my = this;
					layer.prompt({title:'请输入规格（如：颜色等）',vars:this},function(value, index, elem){
						my.titles.push(value)
						my.options.push([])
						layer.close(index);
					});
				},
			},
		}).$mount("#sku");
</script>


