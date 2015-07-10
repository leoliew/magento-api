## 8.APP广告

<a name="rollingAds" />
### 滚动广告

**`GET` `/mobileapi/banner/getbanner`**

首页滚动广告.图片资源位置:http://www.(域名).com/media/(image_url)
type类型的意思： 1(跳转到页面) 2(单个商品) 3(商品列表)

**_Paramers_**

* `identifier` - 要获取的广告内容

**_Examples_**

```js
    /mobileapi/banner/getbanner?identifier=rolling
```

**_Response_**

```js
{
    code: 0,
    msg: "get banners success!",
    model: {
        title: "banner1",
        content: null,
        width: "360",
        height: "240",
        delay: "0",
        status: "1",
        active_from: null,
        active_to: null,
        create_time: "2015-05-22 03:03:23",
        banner_items: [
            {
                banner_item_id: "2",
                title: "index2",
                image: "easybanner/52de4be03cd020bfd948fbbda3c504cc.jpg",  
                image_url: "http://www.hao123.com/",
                thumb_image: "",
                thumb_image_url: "http://www.hao123.com/",
                content: "http://www.hao123.com/",
                link_url: "http://www.hao123.com/"
            },
            {
                banner_item_id: "3",
                title: "banner3",
                image: "easybanner/31d03274deb233455aa1e57a702408a9.jpg",
                image_url: "http://www.163.com/",
                thumb_image: "easybanner/31d03274deb233455aa1e57a702408a9_1.jpg",
                thumb_image_url: "http://www.163.com/",
                content: "http://www.163.com/",
                link_url: "http://www.163.com/"
            },
            {
                banner_item_id: "1",
                title: "banner1",
                image: "easybanner/cd0c321d2fa68986979385562af5805c.jpg",
                image_url: "http://www.hao123.com/",
                thumb_image: "easybanner/cd0c321d2fa68986979385562af5805c_1.jpg",
                thumb_image_url: "http://www.hao123.com/",
                content: null,
                link_url: "http://www.hao123.com/"
            }
        ]
    }
}
```

---------------------------------------

<a name="recommend" />
### 推荐给你的商品

**`GET` `/mobileapi/banner/getbanner`**

推荐给你的商品.图片资源位置:http://www.(域名).com/media/(image_url)

**_Paramers_**

* `identifier` - 要获取的广告内容

**_Examples_**

```js
    /mobileapi/banner/getbanner?identifier=recommend
```

**_Response_**

```js
{
    code: 0,
    msg: "get banners success!",
    model: {
        title: "banner1",
        content: null,
        width: "360",
        height: "240",
        delay: "0",
        status: "1",
        active_from: null,
        active_to: null,
        create_time: "2015-05-22 03:03:23",
        banner_items: [
            {
                banner_item_id: "2",
                title: "index2",
                image: "easybanner/52de4be03cd020bfd948fbbda3c504cc.jpg",
                image_url: "http://www.hao123.com/",
                thumb_image: "",
                thumb_image_url: "http://www.hao123.com/",
                content: "http://www.hao123.com/",
                link_url: "http://www.hao123.com/"
            },
            {
                banner_item_id: "3",
                title: "banner3",
                image: "easybanner/31d03274deb233455aa1e57a702408a9.jpg",
                image_url: "http://www.163.com/",
                thumb_image: "easybanner/31d03274deb233455aa1e57a702408a9_1.jpg",
                thumb_image_url: "http://www.163.com/",
                content: "http://www.163.com/",
                link_url: "http://www.163.com/"
            },
            {
                banner_item_id: "1",
                title: "banner1",
                image: "easybanner/cd0c321d2fa68986979385562af5805c.jpg",
                image_url: "http://www.hao123.com/",
                thumb_image: "easybanner/cd0c321d2fa68986979385562af5805c_1.jpg",
                thumb_image_url: "http://www.hao123.com/",
                content: null,
                link_url: "http://www.hao123.com/"
            }
        ]
    }
}
```

<a name="magnetAds" />
### 列表磁帖

**`GET` `/mobileapi/banner/getbanner`**

列表磁帖.图片资源位置:http://www.(域名).com/media/(image_url)

**_Paramers_**

* `identifier` - 要获取的广告内容

**_Examples_**

```js
    /mobileapi/banner/getbanner?identifier=magnet
```

**_Response_**

```js
{
    code: 0,
    msg: "get banners success!",
    model: {
        title: "banner1",
        content: null,
        width: "360",
        height: "240",
        delay: "0",
        status: "1",
        active_from: null,
        active_to: null,
        create_time: "2015-05-22 03:03:23",
        banner_items: [
            {
                banner_item_id: "2",
                title: "index2",
                image: "easybanner/52de4be03cd020bfd948fbbda3c504cc.jpg",
                image_url: "http://www.hao123.com/",
                thumb_image: "",
                thumb_image_url: "http://www.hao123.com/",
                content: "http://www.hao123.com/",
                link_url: "http://www.hao123.com/"
            },
            {
                banner_item_id: "3",
                title: "banner3",
                image: "easybanner/31d03274deb233455aa1e57a702408a9.jpg",
                image_url: "http://www.163.com/",
                thumb_image: "easybanner/31d03274deb233455aa1e57a702408a9_1.jpg",
                thumb_image_url: "http://www.163.com/",
                content: "http://www.163.com/",
                link_url: "http://www.163.com/"
            },
            {
                banner_item_id: "1",
                title: "banner1",
                image: "easybanner/cd0c321d2fa68986979385562af5805c.jpg",
                image_url: "http://www.hao123.com/",
                thumb_image: "easybanner/cd0c321d2fa68986979385562af5805c_1.jpg",
                thumb_image_url: "http://www.hao123.com/",
                content: null,
                link_url: "http://www.hao123.com/"
            }
        ]
    }
}
```

---------------------------------------

<a name="staticAds" />
### 静态广告

**`GET` `/mobileapi/banner/getbanner`**

静态广告.图片资源位置:http://www.(域名).com/media/(image_url)

**_Paramers_**

* `identifier` - 要获取的广告内容

**_Examples_**

```js
    /mobileapi/banner/getbanner?identifier=static
```

**_Response_**

```js
{
    code: 0,
    msg: "get banners success!",
    model: {
        title: "banner1",
        content: null,
        width: "360",
        height: "240",
        delay: "0",
        status: "1",
        active_from: null,
        active_to: null,
        create_time: "2015-05-22 03:03:23",
        banner_items: [
            {
                banner_item_id: "2",
                title: "index2",
                image: "easybanner/52de4be03cd020bfd948fbbda3c504cc.jpg",
                image_url: "http://www.hao123.com/",
                thumb_image: "",
                thumb_image_url: "http://www.hao123.com/",
                content: "http://www.hao123.com/",
                link_url: "http://www.hao123.com/"
            },
            {
                banner_item_id: "3",
                title: "banner3",
                image: "easybanner/31d03274deb233455aa1e57a702408a9.jpg",
                image_url: "http://www.163.com/",
                thumb_image: "easybanner/31d03274deb233455aa1e57a702408a9_1.jpg",
                thumb_image_url: "http://www.163.com/",
                content: "http://www.163.com/",
                link_url: "http://www.163.com/"
            },
            {
                banner_item_id: "1",
                title: "banner1",
                image: "easybanner/cd0c321d2fa68986979385562af5805c.jpg",
                image_url: "http://www.hao123.com/",
                thumb_image: "easybanner/cd0c321d2fa68986979385562af5805c_1.jpg",
                thumb_image_url: "http://www.hao123.com/",
                content: null,
                link_url: "http://www.hao123.com/"
            }
        ]
    }
}
```

---------------------------------------

<a name="otherVisits" />
### 其他用户浏览

**`GET` `/mobileapi/banner/getbanner`**

其他用户浏览.图片资源位置:http://www.(域名).com/media/(image_url)

**_Paramers_**

* `identifier` - 要获取的广告内容

**_Examples_**

```js
    /mobileapi/banner/getbanner?identifier=other_visit
```

**_Response_**

```js
{
    code: 0,
    msg: "get banners success!",
    model: {
        title: "banner1",
        content: null,
        width: "360",
        height: "240",
        delay: "0",
        status: "1",
        active_from: null,
        active_to: null,
        create_time: "2015-05-22 03:03:23",
        banner_items: [
            {
                banner_item_id: "2",
                title: "index2",
                image: "easybanner/52de4be03cd020bfd948fbbda3c504cc.jpg",
                image_url: "http://www.hao123.com/",
                thumb_image: "",
                thumb_image_url: "http://www.hao123.com/",
                content: "http://www.hao123.com/",
                link_url: "http://www.hao123.com/"
            },
            {
                banner_item_id: "3",
                title: "banner3",
                image: "easybanner/31d03274deb233455aa1e57a702408a9.jpg",
                image_url: "http://www.163.com/",
                thumb_image: "easybanner/31d03274deb233455aa1e57a702408a9_1.jpg",
                thumb_image_url: "http://www.163.com/",
                content: "http://www.163.com/",
                link_url: "http://www.163.com/"
            },
            {
                banner_item_id: "1",
                title: "banner1",
                image: "easybanner/cd0c321d2fa68986979385562af5805c.jpg",
                image_url: "http://www.hao123.com/",
                thumb_image: "easybanner/cd0c321d2fa68986979385562af5805c_1.jpg",
                thumb_image_url: "http://www.hao123.com/",
                content: null,
                link_url: "http://www.hao123.com/"
            }
        ]
    }
}
```

---------------------------------------

<a name="yourVisits" />
### 你浏览过的商品

**`GET` `/mobileapi/banner/getbanner`**

你浏览过的商品.图片资源位置:http://www.(域名).com/media/(image_url)

**_Paramers_**

* `identifier` - 要获取的广告内容

**_Examples_**

```js
    /mobileapi/banner/getbanner?identifier=your_visits
```

**_Response_**

```js
{
    code: 0,
    msg: "get banners success!",
    model: {
        title: "banner1",
        content: null,
        width: "360",
        height: "240",
        delay: "0",
        status: "1",
        active_from: null,
        active_to: null,
        create_time: "2015-05-22 03:03:23",
        banner_items: [
            {
                banner_item_id: "2",
                title: "index2",
                image: "easybanner/52de4be03cd020bfd948fbbda3c504cc.jpg",
                image_url: "http://www.hao123.com/",
                thumb_image: "",
                thumb_image_url: "http://www.hao123.com/",
                content: "http://www.hao123.com/",
                link_url: "http://www.hao123.com/"
            },
            {
                banner_item_id: "3",
                title: "banner3",
                image: "easybanner/31d03274deb233455aa1e57a702408a9.jpg",
                image_url: "http://www.163.com/",
                thumb_image: "easybanner/31d03274deb233455aa1e57a702408a9_1.jpg",
                thumb_image_url: "http://www.163.com/",
                content: "http://www.163.com/",
                link_url: "http://www.163.com/"
            },
            {
                banner_item_id: "1",
                title: "banner1",
                image: "easybanner/cd0c321d2fa68986979385562af5805c.jpg",
                image_url: "http://www.hao123.com/",
                thumb_image: "easybanner/cd0c321d2fa68986979385562af5805c_1.jpg",
                thumb_image_url: "http://www.hao123.com/",
                content: null,
                link_url: "http://www.hao123.com/"
            }
        ]
    }
}
```

---------------------------------------

<a name="findItemsByBanner" />
### 根据banner id获取商品列表或商品

**`GET` `/mobileapi/banner/getitembybanner`**

你浏览过的商品.图片资源位置:http://www.(域名).com/media/(image_url)

**_Paramers_**

* `banner_id` - banner id

**_Examples_**

```js
    /mobileapi/banner/getitembybanner?banner_id=2
```

**_Response_**

```js
{
    code: 0,
    msg: "get products success!",
    model: [
        {
            entity_id: "448",
            sku: "hbm000",
            name: "A Tale of Two Cities",
            rating_summary: null,
            reviews_count: null,
            news_from_date: null,
            news_to_date: null,
            special_from_date: null,
            special_to_date: null,
            image_url: "http://120.24.64.28/media/catalog/product/cache/1/image/265x/9df78eab33525d08d6e5fb8d27136e95/t/a/tale_two_cities_1_1.jpg",
            url_key: "http://120.24.64.28/a-tale-of-two-cities.html",
            price: "10.00",
            regular_price_with_tax: "10.00",
            final_price_with_tax: "0.00",
            symbol: "$"
        },
        {
            entity_id: "425",
            sku: "wsd013c",
            name: "Lafayette Convertible Dress",
            rating_summary: "100",
            reviews_count: "3",
            news_from_date: "2013-03-01 00:00:00",
            news_to_date: null,
            special_from_date: "2013-03-01 00:00:00",
            special_to_date: null,
            image_url: "http://120.24.64.28/media/catalog/product/cache/1/image/265x/9df78eab33525d08d6e5fb8d27136e95/w/s/wsd013t.jpg",
            url_key: "http://120.24.64.28/lafayette-convertible-dress.html",
            price: "340.00",
            regular_price_with_tax: "340.00",
            final_price_with_tax: "0.00",
            symbol: "$"
        }
    ]
}
```


