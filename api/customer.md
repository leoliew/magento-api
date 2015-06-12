## 1.用户

<a name="login" />
### 登录

**`GET` `/mobileapi/customer/login`**

用户登录接口，登录后返回用户`cookies`，`cookies`名称`frontend`,所有调用关于用户的接口都必须带上这个`cookies`.

**_Paramers_**

* `username` - 用户登录账户
* `password` - 用户登录密码

**_Examples_**

```js
    /mobileapi/customer/login?username=zliu@kalengo.com&password=kalengo2013
```

**_Response_**

```js
    {
        code: 0, //0是成功，非0都是失败
        msg: null, //返回信息
        model: {
            name: "leo liu",  //用户名
            email: "zliu@kalengo.com", //邮箱
            avatar: null,  //头像图片url
            tel: null,  //联系电话
            session: "6urtol84os63pp67k926ncqdh1" //前端cookies frontend的值
        }
    }
```

---------------------------------------

<a name="loginStatus" />
### 获取登录状态

**`GET` `/mobileapi/customer/status`**

检查用户登录是否过期，要带上用户`cookies`.

**_Paramers_**

* `null`

**_Examples_**

```js
    /mobileapi/customer/status
```

**_Response_**


```js
{
    code: 0, //0是成功，非0都是失败
    msg: null, //返回信息
    model: {
        name: "leo liu",  //用户名
        email: "zliu@kalengo.com", //邮箱
        avatar: null,  //头像图片url
        tel: null,  //联系电话
        session: "6urtol84os63pp67k926ncqdh1" //前端cookies frontend的值
    }
}
```

---------------------------------------

<a name="register" />
### 用户注册

**`GET` `/mobileapi/customer/register`**

用户注册

**_Paramers_**

* `username` - 用户账户
* `pwd` - 用户密码
* `firstname` 
* `lastname` 
* `default_mobile_number` - 电话号码

**_Examples_**

```js
/mobileapi/customer/register?pwd=kalengo2013&email=zwei245@kalengo.com&firstname=terryZ&lastname=terry&default_mobile_number=12345678912
```
**_Response_**

```js
{
    code: 0, //0是成功，非0都是失败
    msg: null, //显示返回信息
    model: {
    }
}
```

---------------------------------------

<a name="logout" />
### 退出登录

**`GET` `/mobileapi/customer/logout`**

退出登录接口，需要带`cookies`

**_Paramers_**

* `null`

**_Examples_**

```js
/mobileapi/customer/logout
```

**_Response_**

```js
{
    code: 0,
    msg: null,
    model: [ ]
}
```

---------------------------------------

<a name="forgotPassword" />
### 忘记密码

---------------------------------------

<a name="updateUserInfo" />
### 修改用户信息

**`GET` `/mobileapi/customer/updateAccount`**

修改用户信息

**_Paramers_**

* `firstname`
* `lastname`
* `email`

**_Examples_**

```js
/mobileapi/customer/updateAccount?firstname=leo&lastname=liuu&email=zliu@kalengo.com
```

**_Response_**

```js
{
    code: 0,
    msg: "get customer success!",
    model: {
        email: "zliu@kalengo.com",
        firstname: "leo",
        lastname: "liu"
    }
}
```

---------------------------------------

<a name="updatePassword" />
### 修改密码

**`GET` `/mobileapi/customer/updatePassword`**

用户修改密码

**_Paramers_**

* `password` - 用户密码

**_Examples_**

```js
/mobileapi/customer/updatePassword?password=123456
```

**_Response_**

```js
{
    code: 0,
    msg: "success",
    model: [ ]
}
```

---------------------------------------

<a name="getAccountInfo" />
### 获取用户信息(用于修改用户信息)

**`GET` `/mobileapi/customer/getAccountInfo`**

获取用户信息(用于修改用户信息)

**_Paramers_**

* `null`

**_Examples_**

```js
/mobileapi/customer/getAccountInfo
```

**_Response_**

```js
{
    code: 0,
    msg: "get customer success!",
    model: {
        email: "zliu@kalengo.com",
        firstname: "leo",
        lastname: "liu"
    }
}
```
