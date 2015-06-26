# API 文档

## 项目信息
    
    测试地址: http://120.24.64.28/
    
## API

### 用户

* [`登录`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#login)
* [`获取登录状态`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#loginStatus)
* [`用户注册`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#register)
* [`退出登录`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#logout)
* [`忘记密码`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#forgotPassword)
* [`修改用户信息`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#updateUserInfo)
* [`修改密码`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#updatePassword)
* [`获取用户信息(用于修改用户信息)`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#getAccountInfo)


### 购物车

* [`获取购物车商品数量`](https://github.com/leoliew/magento-api/tree/master/api/cart.md#getCartNum)
* [`获取购物车具体商品`](https://github.com/leoliew/magento-api/tree/master/api/cart.md#getCartInfo)
* [`加入购物车`](https://github.com/leoliew/magento-api/tree/master/api/cart.md#addCart)
* [`更新购物车`](https://github.com/leoliew/magento-api/tree/master/api/cart.md#updateCart)
* [`删除购物车商品`](https://github.com/leoliew/magento-api/tree/master/api/cart.md#removeCart)



### 商品

* [`商品详情`](https://github.com/leoliew/magento-api/tree/master/api/product.md#getProductDetail)
* [`商品图片列表`](https://github.com/leoliew/magento-api/tree/master/api/product.md#getProductImages)
* [`获取商品自定义选项`](https://github.com/leoliew/magento-api/tree/master/api/product.md#getProductCustomeTags)
* [`获取商品自定义属性`](https://github.com/leoliew/magento-api/tree/master/api/product.md#getProductCustomeValue)
* [`获取其他用户浏览记录`](https://github.com/leoliew/magento-api/tree/master/api/product.md#getOthersVisitProduct)
* [`获取商品评论列表`](https://github.com/leoliew/magento-api/tree/master/api/product.md#listProductReview)
* [`获取商品评论详情`](https://github.com/leoliew/magento-api/tree/master/api/product.md#ProductReview)
* [`添加商品评论`](https://github.com/leoliew/magento-api/tree/master/api/product.md#addProductReview)


### 首页

* [`限时秒杀`](https://github.com/leoliew/magento-api/tree/master/api/index.md#dailySale)
* [`热卖商品`](https://github.com/leoliew/magento-api/tree/master/api/index.md#bestSale)
* [`预售新品`](https://github.com/leoliew/magento-api/tree/master/api/index.md#comingSoonSale)
* [`指定目录的产品列表`](https://github.com/leoliew/magento-api/tree/master/api/index.md#catelogSale)
* [`搜索产品`](https://github.com/leoliew/magento-api/tree/master/api/index.md#indexSearch)
* [`搜索结果数量`](https://github.com/leoliew/magento-api/tree/master/api/index.md#getSearchNum)
* [`获取主菜单`](https://github.com/leoliew/magento-api/tree/master/api/index.md#getMainMenu)
* [`获取二级菜单的商品`](https://github.com/leoliew/magento-api/tree/master/api/index.md#getSecProduct)


### 店铺

* [`获取店铺信息`](https://github.com/leoliew/magento-api/tree/master/api/store.md#storeInfo)


### 订单

* [`获取订单列表`](https://github.com/leoliew/magento-api/tree/master/api/order.md#getOrderList)
* [`获取订单详细信息`](https://github.com/leoliew/magento-api/tree/master/api/order.md#getOrderDetail)
* [`获取订单物流信息`](https://github.com/leoliew/magento-api/tree/master/api/order.md#getOrderLogistics)


### 用户地址

* [`添加用户地址`](https://github.com/leoliew/magento-api/tree/master/api/address.md#create)
* [`更新用户地址`](https://github.com/leoliew/magento-api/tree/master/api/address.md#update)
* [`获取用户单个地址详情`](https://github.com/leoliew/magento-api/tree/master/api/address.md#getAddress)
* [`删除用户地址`](https://github.com/leoliew/magento-api/tree/master/api/address.md#delete)
* [`获取用户地址列表`](https://github.com/leoliew/magento-api/tree/master/api/address.md#getAddressList)


### APP广告

* [`滚动广告`](https://github.com/leoliew/magento-api/tree/master/api/ads.md#rollingAds)
* [`推荐给你的商品`](https://github.com/leoliew/magento-api/tree/master/api/ads.md#recommend)
* [`列表磁帖(包含商品列表)`](https://github.com/leoliew/magento-api/tree/master/api/ads.md#magnetAds)
* [`静态广告`](https://github.com/leoliew/magento-api/tree/master/api/ads.md#staticAds)
* [`其他用户浏览`](https://github.com/leoliew/magento-api/tree/master/api/ads.md#otherVisits)
* [`你浏览过的商品`](https://github.com/leoliew/magento-api/tree/master/api/ads.md#yourVisits)


### 心愿清单

* [`获取wishlist`](https://github.com/leoliew/magento-api/tree/master/api/wishlist.md#getWishlist)
* [`加入wishlist`](https://github.com/leoliew/magento-api/tree/master/api/wishlist.md#addWishlist)
* [`删除wishlist`](https://github.com/leoliew/magento-api/tree/master/api/wishlist.md#deleteWishlist)


### coupon优惠券

* [`获取购物车中总金额以及优惠劵的使用情况`](https://github.com/leoliew/magento-api/tree/master/api/coupon.md#getCouponDetail)
* [`在购物车中使用coupon优惠劵`](https://github.com/leoliew/magento-api/tree/master/api/coupon.md#useCoupon)
* [`在购物车中取消coupon优惠劵`](https://github.com/leoliew/magento-api/tree/master/api/coupon.md#removeCoupon)


### 支付流程

* [`获取可用的账单地址列表`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#getBillingAddressList)
* [`获取可用的配送地址列表`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#getShippingAddressList)
* [`获取当前用户已选择的配送地址和账单地址`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#getQuoteAddress)
* [`获取当前系统可以选择的配送方式`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#getShippingMethod)
* [`获取当前系统可以选择的支付方式`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#getPaymentMethod)
* [`设置配送地址`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#setShippingAddress)
* [`设置账单地址`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#setBillingAddress)
* [`设置配送方式`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#setShippingMethod)
* [`设置支付方式`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#setPaymentMethod)
* [`订单预览`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#orderReview)
* [`根据设置生成订单`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#createOrder)
* [`根据设置生成订单流程`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#payFlow)
* [`获取订单完成后的成功信息`](https://github.com/leoliew/magento-api/tree/master/api/checkout.md#getSuccessInfo)


### 其他
* [`获取页面提交FormKey`](https://github.com/leoliew/magento-api/tree/master/api/other.md#getFormKey)

