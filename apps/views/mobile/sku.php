<Sku :keys="keys" :values="paths"></Sku>

<script src="<?php echo JS_PATH.'sku/vue.js'?>"></script>
<script src="<?php echo JS_PATH.'sku/sku.js'?>"></script>
<script>
 		Vue.config.devtools = true
		let vue = new Vue({
			data: {
				titles: <?php echo $item['is_sku']?$item['sku_titles']:'[]';?>,
				options: <?php echo $item['is_sku']?$item['sku_options']:'[]';?>,
				stock: <?php echo $item['is_sku']?$item['sku_stock']:'[]';?>,
				price: <?php echo $item['is_sku']?$item['sku_price']:'[]';?>,
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
									stock: parseInt(stock[path.map(v=>v[0]).sort().join(SKU_SEP)]),
									price: parseFloat(price[path.map(v=>v[0]).sort().join(SKU_SEP)])
								}
								
							}
							path.pop()
						}
					}
					func(arr, 0)
					return paths
				},
			},
		}).$mount("#sku");
</script>


