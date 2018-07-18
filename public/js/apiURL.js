function apiURL(name,param = null){
	var urls = {
		'sgt:color'		: '/api/sgt/color',
		'sgt:product'	: '/api/sgt/product',
		'sgt:productcode'	: '/api/sgt/product/code',
		'sgt:customer'	: '/api/sgt/customer',
		'sgt:export:code': '/api/sgt/export/code',
		'dt:stock'		: '/api/dt/stock',
		'dt:order'		: '/api/dt/order',
		'dt:report'		: '/api/dt/report/:param',
		'dt:export'		: '/api/dt/export',
		'dt:return'		: '/api/dt/return',
		'dt:invoice'	: '/api/dt/invoice',
		'dt:product'	: '/api/dt/product',
		'dt:customer'	: '/api/dt/customer',
		'dt:export:list': '/api/dt/export/:param/list',
		'dt:import:list': '/api/dt/import/:param/list',
		'dt:bill:list'	: '/api/dt/bill/:param/list',
		'dt:bill:paid:list'	 : '/api/dt/bill/paid/:param/list',
		'dt:exportbill:list' : '/api/dt/exportbill/:param/list',
		'dt:debt:list'  : '/api/dt/debt/:param/list',
		'customer:get' 	: '/api/customer/:param/get',
		'color:check'	: '/api/color/:param/check',
		'product:check'	: '/api/product/:param/check',
		'export:get'	: '/api/export/:param/get',
		'bill:get'		: '/api/bill/:param/get',
		'report:download' : '/reports/download/:param'
	};
	var url = (param !== null) ? urls[name].replace(':param',param) : urls[name];
	return url;
}

