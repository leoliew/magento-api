## 2.购物车

<a name="getCartNum" />
### 获取购物车商品数量

**`GET` `/mobileapi/cart/getQty`**

获取购物车数量接口，需要带`cookies`.

**_Paramers_**

* `null`

**_Examples_**

```js
/mobileapi/cart/getQty
```

**_Response_**

```js
{
    code: 0, //0是成功，非0都是失败
    msg: null, //返回信息
    model: {
        num: 1 //购物车数量
    }
}
```

---------------------------------------

<a name="getCartInfo" />
### 获取购物车具体商品

**`GET` `/mobileapi/cart/getCartInfo`**

获取购物车数量接口，区分为普通商品和组合商品两种(具体看'product_type'属性)，需要带`cookies`.

**_Paramers_**

* `null`

**_Examples_**

```js
/mobileapi/cart/getCartInfo
```

**_Response_**

```js
{
    code: 0,
    msg: null,
    model: {
        is_virtual: false,
        cart_items: [
            {
                cart_item_id: "2647",
                sku: "wbk012c-Pink-M",              //购物车id
                currency: "USD",                    //商品价格单位
                product_type: "configurable",       //商品类型
                item_id: "421",                     //商品id
                item_title: "Elizabeth Knit Top",   //商品标题
                qty: 3,  //商品数量
                thumbnail_pic_url: "http://120.24.64.28/media/catalog/product/cache/4/thumbnail/250x/9df78eab33525d08d6e5fb8d27136e95/w/b/wbk012t.jpg",
                custom_option: [    //商品选项
                    {
                        label: "Color",
                        value: "Pink"
                    },
                    {
                        label: "Size",
                        value: "M"
                    }
                ],
                    item_price: 210
            },
            {
                bundle_option: [   //组合商品选项
                    {
                        label: "Media Player",
                        value: "1 x Madison 8GB Digital Media Player 150"
                    },
                    {
                        label: "Audio Output",
                        value: "1 x Madison Overear Headphones 125"
                    }
                ],
                cart_item_id: "2657",
                sku: "hde014-hde012-hde011",
                currency: "USD",
                product_type: "bundle",
                item_id: "446",
                item_title: "MP3 Player with Audio",
                qty: 1,
                thumbnail_pic_url: "http://120.24.64.28/media/catalog/product/cache/4/thumbnail/250x/9df78eab33525d08d6e5fb8d27136e95/h/d/hde012_2.jpg",
                custom_option: [ ],
                item_price: 275  //商品单价
            }
        ],
        cart_items_count: 4,  //购物车商品数量
        payment_methods: [ ], //支付方式
        allow_guest_checkout: true //判断是否允许顾客下单
    }
}
```

---------------------------------------

<a name="addCart" />
### 加入购物车

**`GET` `/mobileapi/cart/add`**

加入购物车，需要带`cookies`.

**_Paramers_**

* `product_id` - 商品id
* `qty` - 商品数量
* `super_attribute` - 商品选项属性
    

**_Examples_**

```js
/mobileapi/cart/add?product_id=421&qty=5&super_attribute[92]=22&super_attribute[180]=80
```

**_Response_**

```js
{
    code: 0, //0是成功，非0都是失败
    msg: null, //显示返回信息
    model: {
        items_qty: 5 //购物车数量
    }
}
```

---------------------------------------

<a name="updateCart" />
### 更新购物车

**`GET` `/mobileapi/cart/update`**

更新购物车，需要带`cookies`.

**_Paramers_**

* `cart_item_id` - 购物车id
* `qty` - 商品数量
    

**_Examples_**

```js
/mobileapi/cart/update?cart_item_id=2509&qty=2
```

**_Response_**

```js
{
    code: 0, //0是成功，非0都是失败
    msg: null, //返回信息
    model: {
        is_virtual: false,
        cart_items: [ //购物车商品信息
            {
                cart_item_id: "2526", //购物车id
                currency: "USD", //商品价格单位
                entity_type: "simple", //商品类型
                item_id: "337", //商品id
                item_title: "Aviator Sunglasses", //商品标题
                qty: 1, //商品数量
                thumbnail_pic_url: "http://120.24.64.28/media/catalog/product/cache/1/thumbnail/75x/9df78eab33525d08d6e5fb8d27136e95/a/c/ace000a_1.jpg", //商品图片链接
                custom_option: [ //商品选项
                    {
                        label: "Color", 
                        value: "Red"
                    },
                    {
                        label: "Size",
                        value: "L"
                    }
                ],
                item_price: 295 //商品单价
            }
        ],
        cart_items_count: 1,//购物车商品数量
        payment_methods: [ ],//支付方式
        allow_guest_checkout: true //判断是否允许顾客下单
    }
}
```

---------------------------------------

<a name="removeCart" />
### 删除购物车商品

**`GET` `/mobileapi/cart/removeCart`**

删除购物车商品接口，需要带`cookies`.

**_Paramers_**

* `cart_item_id` - 购物车id


**_Examples_**

```js
/mobileapi/cart/removeCart?cart_item_id=2531
```

**_Response_**

```js
{
    code: 0,  //0是成功，非0都是失败
    msg: { }, //显示返回信息
    model: null 
}
```



