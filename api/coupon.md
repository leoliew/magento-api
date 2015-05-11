## 结帐 

<a name="getCouponDetail" />
### 查看购物车coupon优惠劵使用情况


**`GET` `/mobileapi/Cart/getCouponDetail`**

查看购物车coupon优惠劵使用情况,优惠劵由后台发放，需要带`cookies`.

**_Paramers_**

* `null`


**_Examples_**

```js
/mobileapi/Cart/getCouponDetail
```

**_Response_**

```js
{
    code: 0,
    msg: "get coupon detail success",
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

<a name="useCoupon" />
### 在购物车中使用coupon优惠劵


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

<a name="removeCoupon" />
### 在购物车中取消coupon优惠劵


**`GET` `/mobileapi/Cart/useCoupon`**

在购物车中取消coupon优惠劵接口，需要带`cookies`.

**_Paramers_**

* `remove` - 标志要删除优惠劵


**_Examples_**

```js
/mobileapi/Cart/useCoupon?remove=true
```

**_Response_**

```js
{
    code: 0,
    msg: "get coupon detail success",
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

