## 支付流程 

<a name="getBillingAddressList" />
### 获取可用的账单地址列表


**`GET` `/mobileapi/checkout/getAddressList`**

获取当前用户可用的账单地址列表，需要带`cookies`.返回的字段说明请参照[地址](https://github.com/leoliew/magento-api/tree/master/api/address.md#getAddressList)API文档

**_Paramers_**

* `null`

**_Examples_**

```js
/mobileapi/checkout/getAddressList
```

**_Response_**

```js
{
	code: 0,
	msg: "get order address success!",
	model: [
		{
			entity_id: "106",
			entity_type_id: "2",
			name: "terry wei",
			country: "AT",
			attribute_set_id: "0",
			parent_id: "137",
			created_at: "2015-05-21 07:34:01",
			updated_at: "2015-05-28 16:54:24",
			is_active: "1",
			firstname: "terry",
			lastname: "wei",
			company: "kalengo",
			city: "guangzhou",
			region: "Salzburg",
			postcode: "002",
			country_id: "AT",
			telephone: "123222",
			fax: "524521",
			region_id: 98,
			street: [
				"xinhuajie"
			],
			customer_id: "137",
			is_default_billing: true,//用户的默认账单地址
			is_default_shipping: true,
			is_quote_shipping: true, 
			is_quote_billing: true //在当前支付流程中选择
		}
	]
}
```

---------------------------------------

<a name="getShippingAddressList" />
### 获取可用的配送地址列表


**`GET` `/mobileapi/checkout/getAddressList`**

获取当前用户可用的配送地址列表，需要带`cookies`.返回的字段说明请参照[地址](https://github.com/leoliew/magento-api/tree/master/api/address.md#getAddressList)API文档

**_Paramers_**

* `null`

**_Examples_**

```js
/mobileapi/checkout/getAddressList
```

**_Response_**

```js
{
	code: 0,
	msg: "get order address success!",
	model: [
		{
			entity_id: "106",
			entity_type_id: "2",
			name: "terry wei",
			country: "AT",
			attribute_set_id: "0",
			parent_id: "137",
			created_at: "2015-05-21 07:34:01",
			updated_at: "2015-05-28 16:54:24",
			is_active: "1",
			firstname: "terry",
			lastname: "wei",
			company: "kalengo",
			city: "guangzhou",
			region: "Salzburg",
			postcode: "002",
			country_id: "AT",
			telephone: "123222",
			fax: "524521",
			region_id: 98,
			street: [
				"xinhuajie"
			],
			customer_id: "137",
			is_default_billing: true,
			is_default_shipping: true,//用户的默认配送地址
			is_quote_shipping: true, //在当前支付流程中选择
			is_quote_billing: true 
		}
	]
}
```

---------------------------------------

<a name="getQuoteAddress" />
### 获取当前用户已选择的配送地址和账单地址


**`GET` `/mobileapi/Cart/useCoupon`**

获取当前用户已选择的配送地址和账单地址，需要带`cookies`.返回的字段说明请参照[地址](https://github.com/leoliew/magento-api/tree/master/api/address.md#getAddressList)API文档

**_Paramers_**

* `null`

**_Examples_**

```js
/mobileapi/checkout/getAddressByQuote
```

**_Response_**

```js
{
	code: 0,
	msg: " get quote address success!",
	model: {
		shipping_address: {
			address_id: "106",
			customer_id: "137",
			address_type: "shipping",
			email: "zliu@kalengo.com",
			firstname: "terry",
			lastname: "wei",
			company: "kalengo",
			street: [
				"xinhuajie"
			],
			city: "guangzhou",
			region: "Salzburg",
			region_id: "98",
			postcode: "002",
			country_id: "AT",
			telephone: "123222",
			fax: "524521",
			shipping_method: "ups_XDM",
			shipping_description: "United Parcel Service - Worldwide Express Plus",
			weight: "1.0000",
			subtotal: "275.0000",
			base_subtotal: "275.0000",
			subtotal_with_discount: 275,
			base_subtotal_with_discount: 275,
			tax_amount: "0.0000",
			base_tax_amount: "0.0000",
			shipping_amount: "156.9600",
			base_shipping_amount: "156.9600",
			shipping_tax_amount: "0.0000",
			base_shipping_tax_amount: "0.0000",
			discount_amount: "0.0000",
			base_discount_amount: "0.0000",
			grand_total: "431.9600",
			base_grand_total: "431.9600"
		},
		billing_address: {
			address_id: "106",
			customer_id: "137",
			address_type: "billing",
			email: "zliu@kalengo.com",
			firstname: "terry",
			lastname: "wei",
			company: "kalengo",
			street: [
				"xinhuajie"
			],
			city: "guangzhou",
			region: "Salzburg",
			region_id: "98",
			postcode: "002",
			country_id: "AT",
			telephone: "123222",
			fax: "524521"
		}
	}
}
```

---------------------------------------

<a name="getShippingMethod" />
### 获取当前系统可以选择的配送方式


**`GET` `/mobileapi/checkout/getShippingMethodsList`**

获取当前系统可以选择的配送方式接口，需要带`cookies`.

**_Paramers_**

* `null` 

**_Examples_**

```js
/mobileapi/checkout/getShippingMethodsList
```

**_Response_**

```js
{
	code: 0,
	msg: "get shipping method list success!",
	model: {
		Flat Rate: [
			{
				carrier: "flatrate",
				carrier_title: "Flat Rate",
				code: "flatrate_flatrate",
				method: "flatrate",
				method_title: "Fixed",
				price: "5.0000",
				method_description: null
			}
		],
		Free Shipping: [
			{
				carrier: "freeshipping",
				carrier_title: "Free Shipping",
				code: "freeshipping_freeshipping",
				method: "freeshipping",
				method_title: "Free",
				price: "0.0000",
				method_description: null
			}
		],
		United Parcel Service: [
			{
				carrier: "ups",
				carrier_title: "United Parcel Service",
				code: "ups_XPD",
				method: "XPD",
				method_title: "Worldwide Expedited",
				price: "101.7800",
				method_description: null
			},
			{
				carrier: "ups",
				carrier_title: "United Parcel Service",
				code: "ups_WXS",
				method: "WXS",
				method_title: "Worldwide Express Saver",
				price: "111.4000",
				method_description: null
			},
			{
				carrier: "ups",
				carrier_title: "United Parcel Service",
				code: "ups_XPR",
				method: "XPR",
				method_title: "Worldwide Express",
				price: "115.1600",
				method_description: null
			},
			{
				carrier: "ups",
				carrier_title: "United Parcel Service",
				code: "ups_XDM",
				method: "XDM",
				method_title: "Worldwide Express Plus",
				price: "156.9600",
				method_description: null,
				is_selected: true //在当前支付流程中选择
			}
		]
	}
}
```

---------------------------------------

<a name="getPaymentMethod" />
### 获取当前系统可以选择的支付方式


**`GET` `/mobileapi/checkout/getPayMethodsList`**

获取当前系统可以选择的支付方式接口，需要带`cookies`.

**_Paramers_**

* `null`

**_Examples_**

```js
/mobileapi/checkout/getPayMethodsList
```

**_Response_**

```js
{
	code: 0,
	msg: "get payment methods success!",
	model: {
		cashondelivery: {
			title: "Cash On Delivery",
			code: "cashondelivery",
			is_selected: true
		},
		payu: {
			title: "PayU",
			code: "payu"
		}
	}
}
```

---------------------------------------

<a name="setShippingAddress" />
### 设置配送地址


**`POST` `/mobileapi/checkout/setShipping`**

设置配送地址接口，需要带`cookies`,字段说明请参照[地址](https://github.com/leoliew/magento-api/tree/master/api/address.md#getAddressList)API文档.

**_Paramers_**

* `null` 

**_Form_**

* `shipping_address_id` - 配送地址id
* `shipping[address_id]` - 配送地址id
* `shipping[firstname]`
* `shipping[lastname]`
* `shipping[company]`
* `shipping[street][]`
* `shipping[street][]`
* `shipping[city]`
* `shipping[region_id]`
* `shipping[region]`
* `shipping[country_id]`
* `shipping[telephone]`
* `shipping[fax]`
* `shipping[use_for_shipping]`

**_Examples_**

```js
/mobileapi/checkout/setShipping
```

**_Response_**

```js
{
	"code":0,
	"msg":"set shipping address success!",
	"model":{
		"goto_section":"shipping_method"
	}
}
```

---------------------------------------

<a name="setBillingAddress" />
### 设置账单地址


**`POST` `/mobileapi/checkout/setBilling`**

设置账单地址接口，需要带`cookies`,字段说明请参照[地址](https://github.com/leoliew/magento-api/tree/master/api/address.md#getAddressList)API文档.

**_Paramers_**

* `null` 

**_Form_**

* `billing_address_id` - 账单地址id
* `billing[address_id]` - 账单地址id
* `billing[firstname]`
* `billing[lastname]`
* `billing[company]`
* `billing[street][]`
* `billing[street][]`
* `billing[city]`
* `billing[region_id]`
* `billing[region]`
* `billing[country_id]`
* `billing[telephone]`
* `billing[fax]`
* `billing[use_for_shipping]`

**_Examples_**

```js
/mobileapi/checkout/setBilling
```

**_Response_**

```js
{
	"code":0,
	"msg":"set billing address success!",
	"model":{
		"goto_section":"shipping"
	}
}
```

---------------------------------------

<a name="setShippingMethod" />
### 设置配送方式


**`GET` `/mobileapi/checkout/setShippingMethod`**

设置配送方式接口，需要带`cookies`.

**_Paramers_**

* `null`

**_Form_**

* `shipping_method` - 配送方式

**_Examples_**

```js
/mobileapi/checkout/setShippingMethod
	Form:
		shipping_method=ups_XPD
```

**_Response_**

```js
{
	"code":0,
	"msg":"save shipping method success!",
	"model":[]
}
```

---------------------------------------

<a name="setPaymentMethod" />
### 设置支付方式


**`GET` `/mobileapi/checkout/setPayMethod`**

设置支付方式，需要带`cookies`.

**_Paramers_**

* `null`

**_Form_**

* `payment[method]` - 支付方式

**_Examples_**

```js
/mobileapi/checkout/setPayMethod
	Form:
		payment[method]=payu
```

**_Response_**

```js
{
	"code":0,
	"msg":"save payment method success!",
	"model":null
}
```

---------------------------------------

<a name="orderReview" />
### 订单预览


**`GET` `/mobileapi/Cart/useCoupon`**

在购物车中使用coupon优惠劵接口，需要带`cookies`.

**_Paramers_**

* `coupon_code` - 优惠劵code


**_Examples_**

```js
/mobileapi/Cart/useCoupon?coupon_code=25OFF
```

**_Response_**

```js
{
    code: 0,
    msg: "Coupon code "25OFF" was applied.",
    model: {
        subtotal: 905,
        grand_total: 970,
        discount: -158,
        tax: "",
        coupon_code: "25OFF",
        coupon_rule: {
            rule_id: "42",
            name: "25% off Apparel for General customers",
            description: "25% off any product from the apparel category",
            from_date: "2013-05-03",
            to_date: null,
            uses_per_customer: "999999",
            is_active: "1",
            is_advanced: "1",
            product_ids: null,
            simple_action: "by_percent",
            discount_amount: "25.0000",
            discount_qty: null,
            discount_step: "0",
            simple_free_shipping: "0",
            apply_to_shipping: "0",
            times_used: "0",
            is_rss: "1",
            coupon_type: "2",
            use_auto_generation: "0",
            uses_per_coupon: null
        }
    }
}
```

---------------------------------------

<a name="createOrder" />
### 根据设置生成订单


**`GET` `/mobileapi/Cart/useCoupon`**

在购物车中使用coupon优惠劵接口，需要带`cookies`.

**_Paramers_**

* `coupon_code` - 优惠劵code


**_Examples_**

```js
/mobileapi/Cart/useCoupon?coupon_code=25OFF
```

**_Response_**

```js
{
    code: 0,
    msg: "Coupon code "25OFF" was applied.",
    model: {
        subtotal: 905,
        grand_total: 970,
        discount: -158,
        tax: "",
        coupon_code: "25OFF",
        coupon_rule: {
            rule_id: "42",
            name: "25% off Apparel for General customers",
            description: "25% off any product from the apparel category",
            from_date: "2013-05-03",
            to_date: null,
            uses_per_customer: "999999",
            is_active: "1",
            is_advanced: "1",
            product_ids: null,
            simple_action: "by_percent",
            discount_amount: "25.0000",
            discount_qty: null,
            discount_step: "0",
            simple_free_shipping: "0",
            apply_to_shipping: "0",
            times_used: "0",
            is_rss: "1",
            coupon_type: "2",
            use_auto_generation: "0",
            uses_per_coupon: null
        }
    }
}
```

---------------------------------------


