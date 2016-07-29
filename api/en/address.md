## 用户地址

<a name="create" />
### 添加用户地址

**`POST` `/mobileapi/address/create`**

添加用户地址,须带`cookies`.

**_Paramers_**

* `null`
    
**_Form_**

* `address_type`
* `lastname`
* `firstname`
* `telephone`
* `company`
* `fax`
* `postcode`
* `city`
* `address1`
* `address2`
* `country_id`
* `state` - 省份

**_Examples_**

```js
/mobileapi/address/create
    Form:  address_type=billing,shipping //是否设置默认账单和默认配送地址
               lastname=leo
               firstname=liew
               telephone=13631841987
               company=kalengo
               fax=524521
               postcode=123456
               city=GuangZhou
               address1=Yiyuan
               address2=Street10
               country_id=US
               state=GUANGDONG
```

**_Response_**

```js
{
    "code":0,
    "msg":"save or update user address success!",
    "model":null
}
```

---------------------------------------

<a name="update" />
### 更新用户地址

**`POST` `/mobileapi/address/create`**

修改用户地址,须带`cookies`.

**_Paramers_**

* `null`
    
**_Form_**

* `address_type`
* `lastname`
* `firstname`
* `telephone`
* `company`
* `fax`
* `postcode`
* `city`
* `address1`
* `address2`
* `country_id`
* `state`   - 省份
* `address_book_id` - 要更新的地址id

**_Examples_**

```js
    /mobileapi/address/create
        Form:  address_type=billing,shipping //是否设置默认账单和默认配送地址
               lastname=leo
               firstname=liew
               telephone=13631841987
               company=kalengo
               fax=524521
               postcode=123456
               city=GuangZhou
               address1=Yiyuan
               address2=Street109
               country_id=US
               state=GUANGDONG
               address_book_id=137
```

**_Response_**

```js
    {
        "code":0,
        "msg":"save or update user address success!",
        "model":null
    }
```

---------------------------------------

<a name="getAddress" />
### 获取用户单个地址详情

**`GET` `/mobileapi/address/getAddress`**

获取用户单个地址详情,须带上`cookies`.

**_Paramers_**

* `address_id` - 用户地址ID

**_Examples_**

```js
    /mobileapi/address/getAddress?address_id=106
```

**_Response_**

```js
    {
        code: 0,
        msg: "get user address success!",
        model: {
            entity_id: "106",
            entity_type_id: "2",
            name: "terry wei",
            country: "AT",
            attribute_set_id: "0",
            parent_id: "137",
            created_at: "2015-05-20T10:34:01-07:00",
            updated_at: "2015-05-20 02:34:01",
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
            is_default_shipping: true
        }
    }
```

---------------------------------------

<a name="delete" />
### 删除用户地址

**`GET` `/mobileapi/address/delete`**

删除用户地址,调用接口都须带上`cookies`.

**_Paramers_**

* `address_id` - 用户地址ID

**_Examples_**

```js
    /mobileapi/address/delete?address_id=111
```

**_Response_**

```js
    {
        code: 0,
        msg: null,
        model: true   //删除成功
    }
```

---------------------------------------

<a name="getAddressList" />
### 获取用户地址列表

**`GET` `/mobileapi/address/getAddressList`**

获取用户地址列表,须带上`cookies`.

**_Paramers_**

* `null`

**_Examples_**

```js
    /mobileapi/address/getAddressList
```

**_Response_**

```js
{
    code: 0,
    msg: "get user address list success!",
    model: [
        {
            entity_id: "106",
            entity_type_id: "2",
            name: "terry wei",
            country: "10",
            attribute_set_id: "0",
            parent_id: "137",
            created_at: "2015-05-21 07:34:58",
            updated_at: "2015-05-20 01:47:31",
            is_active: "1",
            firstname: "terry",
            lastname: "wei",
            company: "kalengo",
            city: "guangzhou",
            region: "Armed Forces Middle East",
            postcode: "002",
            country_id: "10",
            telephone: "123222",
            fax: "524521",
            region_id: 5,
            street: [
                "xinhuajie"
            ],
            customer_id: "137"
        }
    ]
}
```

---------------------------------------
