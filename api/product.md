## 3.商品

<a name="getProductDetail" />
### 商品详情

**`GET` `/mobileapi/products/getproductdetail`**

商品详情接口，不需要带`cookies`.

**_Paramers_**

* `productid` - 商品id


**_Examples_**

```js
/mobileapi/products/getproductdetail?product_id=421
```

**_Response_**

```js
{
    code: 0, //0是成功，非0都是失败
    msg: null, //返回信息，null代表没有
    model: [
        {
            entity_id: "284", //商品id
            sku: "wbk002L", //商品编号
            name: "Black NoLIta Cami", //商品名称
            rating_summary: "100", //总体评分（100分为满分）
            reviews_count: "3", //多少人评论
            in_wishlist:true, //是否在用户的心愿清单里
            news_from_date: "2013-05-08 00:00:00", //新品开始时间
            news_to_date: null, //新品结束时间
            special_from_date: "2013-03-05 00:00:00", //特价开始时间
            special_to_date: null, //特价结束时间
            image_url: "http://120.24.64.28/media/catalog/product/cache/1/image/265x/9df78eab33525d08d6e5fb8d27136e95/w/b/wbk002t.jpg", //图片链接
            url_key: "http://120.24.64.28/nolita-cami-590.html", //商品url
            regular_price_with_tax: "150.00", //原价
            final_price_with_tax: "120.00", //当前商品价格，在特价周期内的价格，不在周期内为原价，0则表示没有特价
            description: "Gunmetal frame with crystal gradient polycarbonate lenses in grey. ", //商品描述
            symbol: "$" //货币符号
        }
    ］
}
```

---------------------------------------

<a name="getProductImages" />
### 商品图片列表

---------------------------------------

<a name="getProductCustomeTags" />
### 获取商品自定义选项

---------------------------------------

<a name="getProductCustomeValue" />
### 获取商品自定义属性

---------------------------------------

<a name="getOthersVisitProduct" />
### 获取其他用户浏览记录

---------------------------------------

<a name="listProductReview" />
### 获取商品评论列表

**`GET` `/mobileapi/review/list`**

根据某一商品ID获取商品评论.

**_Paramers_**

* `product_id` - 商品id


**_Examples_**

```js
    /mobileapi/review/list?product_id=418
```

**_Response_**

```js
{
    code: 0, //0是成功，非0都是失败
    msg: 'get reviews success!', //返回信息，null代表没有
    model: {
        total_results: 1,  //评论总数
        trade_rates: [
            {
                uname: "leo",   //评论人
                item_id: "418",   //评论的商品ID
                rate_score: 0,      //商品评分
                rate_content: "1234567897987",       //评论内容
                rate_date: "2015-05-12 06:48:04",    //评论时间
                rate_title: "is good test "          //评论标题
            }
        ]
    }
}
```

---------------------------------------

<a name="addProductReview" />
### 添加商品评论

**`POST` `/mobileapi/review/post`**

根据商品ID添加评论和评分.

**_Paramers_**

* `product_id` - 商品id
    
**_Form_**

* `ratings[1]` - Price评分
* `ratings[2]` - Value评分 (需要加上5分)
* `ratings[3]` - Quality评分 (需要加上10分)
* `nickname` - 评论人名称
* `title` - 标题
* `detail` - 内容
* `validate_rating` - 验证是否打分，无需传入


**_Examples_**

```js
/mobileapi/review/post
    Form:  nickname=leoo
           title=haha
           detail=abcdefghi
           validate_rating=
           ratings[1]=5
           ratings[2]=10
           ratings[3]=15
```

**_Response_**

```js
{
    "code":0,   //0是成功，非0都是失败
    "msg":"Your review has been accepted for moderation.", //返回信息，null代表没有
    "model":true  //添加结果，true 代表添加成功
}
```