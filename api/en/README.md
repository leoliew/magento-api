# API Document

## Project Info
    
    Test Address: http://120.24.64.28/
    
## API

### User

* [`Login`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#login)
* [`get login status`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#loginStatus)
* [`user register`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#register)
* [`user logout`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#logout)
* [`forgot password`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#forgotPassword)
* [`modify user info`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#updateUserInfo)
* [`modify user password`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#updatePassword)
* [`get user info(use for modify user info)`](https://github.com/leoliew/magento-api/tree/master/api/customer.md#getAccountInfo)


### Shopping Cart

* [`get a shopping cart of product quantity`](https://github.com/leoliew/magento-api/tree/master/api/cart.md#getCartNum)
* [`get the detail of product in shopping cart`](https://github.com/leoliew/magento-api/tree/master/api/cart.md#getCartInfo)
* [`add to cart`](https://github.com/leoliew/magento-api/tree/master/api/cart.md#addCart)
* [`edit your cart`](https://github.com/leoliew/magento-api/tree/master/api/cart.md#updateCart)
* [`delete product of your cart`](https://github.com/leoliew/magento-api/tree/master/api/cart.md#removeCart)



### Product

* [`get product detail`](https://github.com/leoliew/magento-api/tree/master/api/product.md#getProductDetail)
* [`get product's images list`](https://github.com/leoliew/magento-api/tree/master/api/product.md#getProductImages)
* [`get product's custome tags`](https://github.com/leoliew/magento-api/tree/master/api/product.md#getProductCustomeTags)
* [`get product's custome value`](https://github.com/leoliew/magento-api/tree/master/api/product.md#getProductCustomeValue)
* [`get other's browsing history`](https://github.com/leoliew/magento-api/tree/master/api/product.md#getOthersVisitProduct)
* [`list product's review list`](https://github.com/leoliew/magento-api/tree/master/api/product.md#listProductReview)
* [`get product's review detail`](https://github.com/leoliew/magento-api/tree/master/api/product.md#ProductReview)
* [`add product's review`](https://github.com/leoliew/magento-api/tree/master/api/product.md#addProductReview)


### Index

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
* [`根据banner item id获取商品列表`](https://github.com/leoliew/magento-api/tree/master/api/ads.md#findItemsByBannerItem)
* [`根据banner id 获取商品列表`](https://github.com/leoliew/magento-api/tree/master/api/ads.md#findItemListByBanner)

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


### 货币
* [`设置默认货币`](https://github.com/leoliew/magento-api/tree/master/api/currency.md#setCurrency)
* [`获取当前设置的货币`](https://github.com/leoliew/magento-api/tree/master/api/currency.md#getCurrency)


### 静态页面 (以下为静态页面的地址)
* [`法律-隐私声明`](https://github.com/leoliew/magento-api/tree/master/api/static.md#index)
* [`法律-条款`](https://github.com/leoliew/magento-api/tree/master/api/static.md#index)
* [`帮助信息`](https://github.com/leoliew/magento-api/tree/master/api/static.md#index)

