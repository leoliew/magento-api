# API Document

## Project Info
    
    Test Address: http://120.24.64.28/
    
## API

### User

* [`Login`](https://github.com/leoliew/magento-api/tree/master/api/en/customer.md#login)
* [`get login status`](https://github.com/leoliew/magento-api/tree/master/api/en/customer.md#loginStatus)
* [`user register`](https://github.com/leoliew/magento-api/tree/master/api/en/customer.md#register)
* [`user logout`](https://github.com/leoliew/magento-api/tree/master/api/en/customer.md#logout)
* [`forgot password`](https://github.com/leoliew/magento-api/tree/master/api/en/customer.md#forgotPassword)
* [`modify user info`](https://github.com/leoliew/magento-api/tree/master/api/en/customer.md#updateUserInfo)
* [`modify user password`](https://github.com/leoliew/magento-api/tree/master/api/en/customer.md#updatePassword)
* [`get user info(use for modify user info)`](https://github.com/leoliew/magento-api/tree/master/api/en/customer.md#getAccountInfo)


### Shopping Cart

* [`get a shopping cart of product quantity`](https://github.com/leoliew/magento-api/tree/master/api/en/cart.md#getCartNum)
* [`get the detail of product in shopping cart`](https://github.com/leoliew/magento-api/tree/master/api/en/cart.md#getCartInfo)
* [`add to cart`](https://github.com/leoliew/magento-api/tree/master/api/en/cart.md#addCart)
* [`edit your cart`](https://github.com/leoliew/magento-api/tree/master/api/en/cart.md#updateCart)
* [`delete product of your cart`](https://github.com/leoliew/magento-api/tree/master/api/en/cart.md#removeCart)



### Product

* [`get product detail`](https://github.com/leoliew/magento-api/tree/master/api/en/product.md#getProductDetail)
* [`get product's images list`](https://github.com/leoliew/magento-api/tree/master/api/en/product.md#getProductImages)
* [`get product's custome tags`](https://github.com/leoliew/magento-api/tree/master/api/en/product.md#getProductCustomeTags)
* [`get product's custome value`](https://github.com/leoliew/magento-api/tree/master/api/en/product.md#getProductCustomeValue)
* [`get other's browsing history`](https://github.com/leoliew/magento-api/tree/master/api/en/product.md#getOthersVisitProduct)
* [`list product's review list`](https://github.com/leoliew/magento-api/tree/master/api/en/product.md#listProductReview)
* [`get product's review detail`](https://github.com/leoliew/magento-api/tree/master/api/en/product.md#ProductReview)
* [`add product's review`](https://github.com/leoliew/magento-api/tree/master/api/en/product.md#addProductReview)


### Index

* [`special offer`](https://github.com/leoliew/magento-api/tree/master/api/en/index.md#dailySale)
* [`hot sale`](https://github.com/leoliew/magento-api/tree/master/api/en/index.md#bestSale)
* [`advance sale`](https://github.com/leoliew/magento-api/tree/master/api/en/index.md#comingSoonSale)
* [`category's product list`](https://github.com/leoliew/magento-api/tree/master/api/en/index.md#catelogSale)
* [`search product`](https://github.com/leoliew/magento-api/tree/master/api/en/index.md#indexSearch)
* [`get quantity of products on search`](https://github.com/leoliew/magento-api/tree/master/api/en/index.md#getSearchNum)
* [`get main menu`](https://github.com/leoliew/magento-api/tree/master/api/en/index.md#getMainMenu)
* [`get product of sub menu`](https://github.com/leoliew/magento-api/tree/master/api/en/index.md#getSecProduct)


### Store

* [`get store info`](https://github.com/leoliew/magento-api/tree/master/api/en/store.md#storeInfo)


### Order

* [`get order's list`](https://github.com/leoliew/magento-api/tree/master/api/en/order.md#getOrderList)
* [`get order's detail`](https://github.com/leoliew/magento-api/tree/master/api/en/order.md#getOrderDetail)
* [`get order's logistics`](https://github.com/leoliew/magento-api/tree/master/api/en/order.md#getOrderLogistics)


### User Address

* [`create user address`](https://github.com/leoliew/magento-api/tree/master/api/en/address.md#create)
* [`update user address`](https://github.com/leoliew/magento-api/tree/master/api/en/address.md#update)
* [`get user address`](https://github.com/leoliew/magento-api/tree/master/api/en/address.md#getAddress)
* [`delete user address`](https://github.com/leoliew/magento-api/tree/master/api/en/address.md#delete)
* [`get user address list`](https://github.com/leoliew/magento-api/tree/master/api/en/address.md#getAddressList)


### app ads

* [`rolling ads`](https://github.com/leoliew/magento-api/tree/master/api/en/ads.md#rollingAds)
* [`recommend products`](https://github.com/leoliew/magento-api/tree/master/api/en/ads.md#recommend)
* [`magent ads`](https://github.com/leoliew/magento-api/tree/master/api/en/ads.md#magnetAds)
* [`static ads`](https://github.com/leoliew/magento-api/tree/master/api/en/ads.md#staticAds)
* [`other's visits`](https://github.com/leoliew/magento-api/tree/master/api/en/ads.md#otherVisits)
* [`your visits`](https://github.com/leoliew/magento-api/tree/master/api/en/ads.md#yourVisits)
* [`find items by banner' item id`](https://github.com/leoliew/magento-api/tree/master/api/en/ads.md#findItemsByBannerItem)
* [`find items list by banner id`](https://github.com/leoliew/magento-api/tree/master/api/en/ads.md#findItemListByBanner)

### Wishlist

* [`get wishlist`](https://github.com/leoliew/magento-api/tree/master/api/en/wishlist.md#getWishlist)
* [`add wishlist`](https://github.com/leoliew/magento-api/tree/master/api/en/wishlist.md#addWishlist)
* [`delete wishlist`](https://github.com/leoliew/magento-api/tree/master/api/en/wishlist.md#deleteWishlist)


### coupon

* [`获取购物车中总金额以及优惠劵的使用情况`](https://github.com/leoliew/magento-api/tree/master/api/en/coupon.md#getCouponDetail)
* [`在购物车中使用coupon优惠劵`](https://github.com/leoliew/magento-api/tree/master/api/en/coupon.md#useCoupon)
* [`在购物车中取消coupon优惠劵`](https://github.com/leoliew/magento-api/tree/master/api/en/coupon.md#removeCoupon)


### 支付流程

* [`获取可用的账单地址列表`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#getBillingAddressList)
* [`获取可用的配送地址列表`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#getShippingAddressList)
* [`获取当前用户已选择的配送地址和账单地址`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#getQuoteAddress)
* [`获取当前系统可以选择的配送方式`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#getShippingMethod)
* [`获取当前系统可以选择的支付方式`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#getPaymentMethod)
* [`设置配送地址`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#setShippingAddress)
* [`设置账单地址`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#setBillingAddress)
* [`设置配送方式`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#setShippingMethod)
* [`设置支付方式`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#setPaymentMethod)
* [`订单预览`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#orderReview)
* [`根据设置生成订单`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#createOrder)
* [`根据设置生成订单流程`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#payFlow)
* [`获取订单完成后的成功信息`](https://github.com/leoliew/magento-api/tree/master/api/en/checkout.md#getSuccessInfo)


### 其他
* [`获取页面提交FormKey`](https://github.com/leoliew/magento-api/tree/master/api/en/other.md#getFormKey)


### 货币
* [`设置默认货币`](https://github.com/leoliew/magento-api/tree/master/api/en/currency.md#setCurrency)
* [`获取当前设置的货币`](https://github.com/leoliew/magento-api/tree/master/api/en/currency.md#getCurrency)


### 静态页面 (以下为静态页面的地址)
* [`法律-隐私声明`](https://github.com/leoliew/magento-api/tree/master/api/en/static.md#index)
* [`法律-条款`](https://github.com/leoliew/magento-api/tree/master/api/en/static.md#index)
* [`帮助信息`](https://github.com/leoliew/magento-api/tree/master/api/en/static.md#index)

