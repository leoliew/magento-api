## 6.订单

<a name="getOrderList" />
### 获取订单列表

**`GET` `/mobileapi/order/getorderlist`**

获取订单列表，需要带`cookies`.

**_Paramers_**

* `status` - 订单状态,如果不传默认查询所有订单

**_Examples_**

```js
/mobileapi/order/getorderlist
```

**_Response_**

```js
{
    code: 0, //0是成功，非0都是失败
    msg: null, //返回信息
    model: [
        {
            entity_id: "196",
            order_id: "145000007",
            created_at: "2015-04-29 06:28:51",
            tax_amount: "0.0000",
            shipping_amount: "5.0000",
            discount_amount: "0.0000",
            subtotal: "55.0000",
            grand_total: "60.0000",
            total_qty_ordered: "1.0000",
            shipping_address_name: "leo liu",
            status: "Pending"
        },
        {
            entity_id: "195",    //数据唯一id
            order_id: "145000006", //订单id
            created_at: "2015-04-29 05:50:05",  //订单创建时间
            tax_amount: "0.0000",
            shipping_amount: "0.0000",
            discount_amount: "0.0000",
            subtotal: "1117.0000",
            grand_total: "1117.0000",   //订单金额
            total_qty_ordered: "6.0000",
            shipping_address_name: "leo liu", //收货人
            status: "Pending"  //订单状态
        }
    ]
}
```

---------------------------------------

<a name="getOrderDetail" />
### 获取订单详细信息

**`GET` `/mobileapi/order/getorder`**

获取订单详细信息，需要带`cookies`.

**_Paramers_**

* `orderid` - 订单id

**_Examples_**

```js
/mobileapi/order/getorder?orderid=145000006
```

**_Response_**

```js
{
    code: 0,
    msg: null,
        model: {
            order_id: "145000006", //订单id
            created_at: "2015-04-29 05:50:05", //创建时间
            full_tax_info: [                  //税金信息
                {
                    hidden: "0",
                    amount: "4.6200",
                    base_amount: "4.6200",
                    base_real_amount: "4.6200",
                    rates: [
                        {
                            code: "US-All States-TaxableGoodsRate",
                            title: "US-All States-TaxableGoodsRate",
                            percent: 8.25,
                            position: "0",
                            priority: "0"
                        }
                    ],
                    percent: 8.25,
                    id: "US-All States-TaxableGoodsRate"
                }
            ], 
            customer_name: "leo liu",           //用户名
            shipping_address_name: "leo liu",   //收货人
            grand_total: "1117.0000",           //总金额
            status_label: "Pending",            //订单状态
            shipping_method: "freeshipping_freeshipping",       //配送方式
            canShip: true,          //能否配送
            shipping_address: {     //配送详细地址
                entity_id: "429",
                parent_id: "220",
                customer_address_id: "106",
                quote_address_id: null,
                region_id: "5",
                customer_id: "137",
                fax: "524521",
                region: "Armed Forces Middle East",
                postcode: "002",
                lastname: "wei",
                street: "xinhuajie",
                city: "guangzhou",
                email: "zliu@kalengo.com",
                telephone: "123222",
                country_id: "10",
                firstname: "terry",
                address_type: "shipping",
                prefix: null,
                middlename: null,
                suffix: null,
                company: "kalengo",
                vat_id: null,
                vat_is_valid: null,
                vat_request_id: null,
                vat_request_date: null,
                vat_request_success: null,
                giftregistry_item_id: null 
            },   
            billing_address: {       //账单详细地址
                entity_id: "428",
                parent_id: "220",
                customer_address_id: "106",
                quote_address_id: null,
                region_id: "5",
                customer_id: "137",
                fax: "524521",
                region: "Armed Forces Middle East",
                postcode: "002",
                lastname: "wei",
                street: "xinhuajie",
                city: "guangzhou",
                email: "zliu@kalengo.com",
                telephone: "123222",
                country_id: "10",
                firstname: "terry",
                address_type: "billing",
                prefix: null,
                middlename: null,
                suffix: null,
                company: "kalengo",
                vat_id: null,
                vat_is_valid: null,
                vat_request_id: null,
                vat_request_date: null,
                vat_request_success: null,
                giftregistry_item_id: null
            },
            payment_method: {            //支付方式
                title: "Cash On Delivery",
                code: "cashondelivery",
                card_storage: null,
                cards: { }
            },
            order_currency: {         //订单货币
                currency_code: "USD"
            },
            subtotal: 1117,           //最终付款金额
            items: [                  //订单商品
                {
                    created_at: "2015-04-29 05:50:05",   //创建时间
                    updated_at: "2015-04-29 05:50:05",   //更新时间
                    product_id: "378",   //商品id
                    sku: "hdb000",      //商品编号
                    product_type: "simple",     //商品类型
                    name: "Body Wash with Lemon Flower Extract and Aloe Vera",      //商品名称
                    price: "28.0000",   //商品价格
                    qty: "1.0000",      //商品数量
                    pic_url: "http://120.24.64.28/media/catalog/product/cache/1/thumbnail/250x/9df78eab33525d08d6e5fb8d27136e95/h/d/hdb000_1.jpg",//商品图片
                    option: null        //商品选项
                },
                {
                    created_at: "2015-04-29 05:50:05",
                    updated_at: "2015-04-29 05:50:05",
                    product_id: "425",
                    sku: "wsd015",
                    product_type: "configurable",
                    name: "Lafayette Convertible Dress",
                    price: "340.0000",
                    qty: "1.0000",
                    pic_url: "http://120.24.64.28/media/catalog/product/cache/1/thumbnail/250x/9df78eab33525d08d6e5fb8d27136e95/w/s/wsd013t.jpg",
                    option: [
                        {
                            label: "Color",
                            value: "Blue"
                        },
                        {
                            label: "Size",
                            value: "6"
                        }
                    ]
                },
            ]
        }
}
```
