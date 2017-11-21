var navs = [{
	"title": "域名管理",
	"icon": "fa-table",
	"spread": false,
	"children": [{
		"title": "域名列表",
		"icon": "&#xe63c;",
		"href": "domain_list.php",
		"onclick":"OnClickNav('span_domain_list');"
	}, {
		"title": "域名流量",
		"icon": "&#xe63c;",
		"href": "stat_domain_qqs.php",
		"onclick":"OnClickNav('span_domain_qqs');"
	}, {
		"title": "域名重载",
		"icon": "&#xe63c;",
		"href": "cleancache.php",
		"onclick":"OnClickNav('span_cleancache');"
	}]
}, {
	"title": "套餐管理",
	"icon": "&#xe62a;",
	"href": "",
	"spread": false,
	"children": [{
		"title": "产品套餐",
		"icon": "&#xe63c;",
		"href": "product_list.php",
		"onclick":"OnClickNav('span_product_list');"
	}, {
		"title": "已买套餐",
		"icon": "&#xe63c;",
		"href": "buy_list.php",
		"onclick":"OnClickNav('span_buy_list');"
	}, {
		"title": "套餐流量",
		"icon": "&#xe63c;",
		"href": "stat_buy_product_bandwidth.php",
		"onclick":"OnClickNav('span_buy_product_bandwidth');"
	}]
}, {
	"title": "财务管理",
	"icon": "fa-book",
	"spread": false,
	"children": [{
		"title": "订单列表",
		"icon": "&#xe63c;",
		"href": "order_list.php",
		"onclick":"OnClickNav('span_order_list');"
	}, {
		"title": "在线充值",
		"icon": "&#xe63c;",
		"href": "alipay_recharge.php",
		"onclick":"OnClickNav('span_alipay_recharge');"
	}, {
		"title": "充值记录",
		"icon": "&#xe63c;",
		"href": "recharge_list.php",
		"onclick":"OnClickNav('span_recharge_list');"
	}, {
		"title": "消费记录",
		"icon": "&#xe63c;",
		"href": "buy_history.php",
		"onclick":"OnClickNav('span_buy_history');"
	}]
}, {
	"title": "系统设置",
	"icon": "fa-cog",
	"spread": false,
	"children": [{
		"title": "个人资料",
		"icon": "&#xe63c;",
		"href": "client_info.php",
		"onclick":"OnClickNav('span_client_info');"
	},{
		"title": "密码修改",
		"icon": "&#xe63c;",
		"href": "modifypasswd.php",
		"onclick":"OnClickNav('span_modifypasswd');"
	}]
}];