## 货币

<a name="setCurrency" />
### 设置默认货币

**`get` `/mobileapi/currency/switch`**

添加用户地址,须带`cookies`.

**_Paramers_**

* `currency` - 货币缩写
    
**_Form_**

* `null`

**_Examples_**

```js
/mobileapi/currency/switch?currency=EUR
```

**_Response_**

```js
{
    code: 0,
    msg: "set current currency code success!",
    model: null
}
```

---------------------------------------

<a name="getCurrency" />
### 获取当前设置的货币

**`get` `/mobileapi/currency/get`**

添加用户地址,须带`cookies`.

**_Paramers_**

* `null` 
    
**_Form_**

* `null`

**_Examples_**

```js
/mobileapi/currency/get
```

**_Response_**

```js
{
    code: 0,
    msg: "set current currency code success!",
    model: {
        currency_code: "USD",
        currency_symbol: "$",
        currency_name: "US Dollar"
    }
}
```