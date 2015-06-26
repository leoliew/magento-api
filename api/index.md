## 4.首页

<a name="dailySale" />
### 限时秒杀

**`GET` `/mobileapi/index/index`**

特卖商品接口，不需要带`cookies`.

**_Paramers_**

* `cmd` - 后台参数
* `page` - 页数
* `limit` - 每页限制商品数量


**_Examples_**

```js
/mobileapi/index/index?cmd=daily_sale&page=1&limit=1
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
            news_from_date: "2013-05-08 00:00:00", //新品开始时间
            news_to_date: null, //新品结束时间
            special_from_date: "2013-03-05 00:00:00", //特价开始时间
            special_to_date: null, //特价结束时间
            image_url: "http://120.24.64.28/media/catalog/product/cache/1/image/265x/9df78eab33525d08d6e5fb8d27136e95/w/b/wbk002t.jpg", //图片链接
            url_key: "http://120.24.64.28/nolita-cami-590.html", //商品url
            regular_price_with_tax: "150.00", //原价
            final_price_with_tax: "120.00", //降价后的价格，0代表没有降价
            symbol: "$" //货币符号
        }
    ］
}
```

---------------------------------------

<a name="bestSale" />
### 热卖商品

**`GET` `/mobileapi/index/index`**

热销商品接口，不需要带`cookies`.

**_Paramers_**

* `cmd` - 后台参数
* `page` - 页数
* `limit` - 每页限制商品数量


**_Examples_**

```js
/mobileapi/index/index?cmd=best_seller&page=1&limit=1
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
            news_from_date: "2013-05-08 00:00:00", //新品开始时间
            news_to_date: null, //新品结束时间
            special_from_date: "2013-03-05 00:00:00", //特价开始时间
            special_to_date: null, //特价结束时间
            image_url: "http://120.24.64.28/media/catalog/product/cache/1/image/265x/9df78eab33525d08d6e5fb8d27136e95/w/b/wbk002t.jpg", //图片链接
            url_key: "http://120.24.64.28/nolita-cami-590.html", //商品url
            regular_price_with_tax: "150.00", //原价
            final_price_with_tax: "120.00", //当前商品价格，在特价周期内的价格，不在周期内为原价，0则表示没有特价
            symbol: "$" //货币符号
        }
    ］
}
```

---------------------------------------

<a name="comingSoonSale" />
### 预售新品

**`GET` `/mobileapi/index/index`**

促销商品接口，不需要带`cookies`.

**_Paramers_**

* `cmd` - 后台参数
* `page` - 页数
* `limit` - 每页限制商品数量

**_Examples_**

```js
/mobileapi/index/index?cmd=coming_soon&page=1&limit=1
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
            news_from_date: "2013-05-08 00:00:00", //新品开始时间
            news_to_date: null, //新品结束时间
            special_from_date: "2013-03-05 00:00:00", //特价开始时间
            special_to_date: null, //特价结束时间
            image_url: "http://120.24.64.28/media/catalog/product/cache/1/image/265x/9df78eab33525d08d6e5fb8d27136e95/w/b/wbk002t.jpg", //图片链接
            url_key: "http://120.24.64.28/nolita-cami-590.html", //商品url
            regular_price_with_tax: "150.00", //原价
            final_price_with_tax: "120.00", //当前商品价格，在特价周期内的价格，不在周期内为原价，0则表示没有特价
            symbol: "$" //货币符号
        }
    ］
}
```

---------------------------------------

<a name="catelogSale" />
### 指定目录的产品列表(二级类目)

**`GET` `/mobileapi/index/index`**

指定目录的产品列表接口，可排序，不需要带`cookies`.

**_Paramers_**

* `cmd` - 后台参数
* `page` - 页数
* `limit` - 每页限制商品数量
* `order` - 排序字段，商品id`entity_id`(默认)
* `dir` - 排序，`asc`升序，`desc`降序（默认）
* `category_id` - 目录id


**_Examples_**

```js
/mobileapi/index/index?cmd=catalog&page=1&limit=5&order=entity_id&dir=desc&category_id=10
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
            rating_summary: "100", //总体评分（100分为满分）
            reviews_count: "3", //多少人评论
            name: "Black NoLIta Cami", //商品名称
            news_from_date: "2013-05-08 00:00:00", //新品开始时间
            news_to_date: null, //新品结束时间
            special_from_date: "2013-03-05 00:00:00", //特价开始时间
            special_to_date: null, //特价结束时间
            image_url: "http://120.24.64.28/media/catalog/product/cache/1/image/265x/9df78eab33525d08d6e5fb8d27136e95/w/b/wbk002t.jpg", //图片链接
            url_key: "http://120.24.64.28/nolita-cami-590.html", //商品url
            regular_price_with_tax: "150.00", //原价
            final_price_with_tax: "120.00", //当前商品价格，在特价周期内的价格，不在周期内为原价，0则表示没有特价
            symbol: "$" //货币符号
        }
    ］
}
```

---------------------------------------

<a name="indexSearch" />
### 搜索产品

**`GET` `/mobileapi/search/index`**

搜索产品接口，不需要带`cookies`.

**_Paramers_**

* `q` - 搜索条件，按商品名称搜索


**_Examples_**

```js
/mobileapi/search/index?q=Oxford
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
            news_from_date: "2013-05-08 00:00:00", //新品开始时间
            news_to_date: null, //新品结束时间
            special_from_date: "2013-03-05 00:00:00", //特价开始时间
            special_to_date: null, //特价结束时间
            image_url: "http://120.24.64.28/media/catalog/product/cache/1/image/265x/9df78eab33525d08d6e5fb8d27136e95/w/b/wbk002t.jpg", //图片链接
            url_key: "http://120.24.64.28/nolita-cami-590.html", //商品url
            regular_price_with_tax: "150.00", //原价
            final_price_with_tax: "120.00", //当前商品价格，在特价周期内的价格，不在周期内为原价，0则表示没有特价
            symbol: "$" //货币符号
        }
    ］
}
```

---------------------------------------

<a name="indexSearch" />
### 搜索结果数量

**`GET` `/mobileapi/search/index`**

搜索产品接口，不需要带`cookies`.

**_Paramers_**

* `q` - 搜索条件，按商品名称搜索


**_Examples_**

```js
/mobileapi/search/index?q=Oxford
```

**_Response_**

```js
{
    code: 0, //0是成功，非0都是失败
    msg: null, //错误信息，null代表没有
    model: [
        {
            entity_id: "284", //商品id
            sku: "wbk002L", //商品编号
            name: "Black NoLIta Cami", //商品名称
            news_from_date: "2013-05-08 00:00:00", //新品开始时间
            news_to_date: null, //新品结束时间
            special_from_date: "2013-03-05 00:00:00", //特价开始时间
            special_to_date: null, //特价结束时间
            image_url: "http://120.24.64.28/media/catalog/product/cache/1/image/265x/9df78eab33525d08d6e5fb8d27136e95/w/b/wbk002t.jpg", //图片链接
            url_key: "http://120.24.64.28/nolita-cami-590.html", //商品url
            regular_price_with_tax: "150.00", //原价
            final_price_with_tax: "120.00", //当前商品价格，在特价周期内的价格，不在周期内为原价，0则表示没有特价
            symbol: "$" //货币符号
        }
    ］
}
```

---------------------------------------

<a name="getMainMenu" />
### 获取主菜单

**`GET` `/mobileapi/index/index`**

获取主菜单，不需要带`cookies`.

**_Paramers_**

* `cmd` - 后台参数

**_Examples_**

```js
/mobileapi/index/index?cmd=menu
```

**_Response_**

```js
{
    code: 0, //0是成功，非0都是失败
    msg: null, //错误信息，null代表没有
    model: [
        {
            category_id: "4",//主类目id
            name: "Women",//对应的名称
            is_active: "1",//目录是否在使用
            position : "2",//当前目录所在的位置
            level : "2",//层级
            url_key: "women.html",//目录链接
            thumbnail_url: null,//图片链接
            image_url: false,//是否展示图片
            child: {//包含的二级菜单
                10: "New Arrivals",
                11: "Tops & Blouses",
                12: "Pants & Denim",
                13: "Dresses & Skirts"
            }
        }
    ］
}
```

---------------------------------------
