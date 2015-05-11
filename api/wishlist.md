## 9.心愿清单

<a name="getWishlist" />
### 获取wishlist

**`GET` `/mobileapi/wishlist/get`**

获取wishlist，需要带`cookies`.

**_Paramers_**

* `null`

**_Examples_**

```js
/mobileapi/wishlist/get
```

**_Response_**

```js
{
    code: 0,
    msg: "get 1 items success!",
    model: {
    products: [
        {
            wishlist_id: "163",
            entity_id: "374",
            sku: "abl004",
            name: "Houston Travel Wallet",
            news_from_date: null,
            news_to_date: null,
            special_from_date: null,
            special_to_date: null,
            image_url: "http://120.24.64.28/media/catalog/product/cache/1/image/265x/9df78eab33525d08d6e5fb8d27136e95/a/b/abl004a_1.jpg",
            url_key: "http://120.24.64.28/rolls-travel-wallet.html",
            regular_price_with_tax: "210.00",
            final_price_with_tax: "0.00",
            symbol: "$"
        }
    ],
    count: 1   //心愿清单数量
    }
}
```

---------------------------------------

<a name="addWishlist" />
### 加入wishlist

**`GET` `/mobileapi/wishlist/add`**

加入wishlist，需要带`cookies`.

**_Paramers_**

* `product_id` - 商品id

**_Examples_**

```js
/mobileapi/wishlist/add?product_id=374
```

**_Response_**

```js
{
    code: 0,
    msg: "your product has been added in wishlist",
    model: { }
}
```

---------------------------------------

<a name="removeWishlist" />
### 删除wishlist
**`GET` `/wishlist/custom/del`**

删除wishlist，需要带`cookies`.

**_Paramers_**

* `wishlist_id` - 愿望商品id

**_Examples_**

```js
/wishlist/custom/del?wishlist_id=162
```

**_Response_**

```js
{
    code: 0,
    msg: "delete success!",
    model: null
}
```