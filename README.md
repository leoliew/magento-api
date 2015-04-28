
magento-android-web-api

This is a small module that adds the ability to remotely work with the Magento via the REST API


Install<br>

1. Copy web-api.php to root Magento folder<br>
2. Set key parametr for access to functionality this script<br>

Examples of use
* /web-api.php?route=feed/web_api/categories&parent=0&level=2&key=key1
  Return Categories tree information

* /web-api.php?route=feed/web_api/products&category=4&key=key1
  Return Products list in category

* /web-api.php?route=feed/web_api/product&id=800&key=key1
  Return product item

* /web-api.php?route=feed/web_api/random&limit=4&key=key1
  Return Random Products list



License
-------

This software is distributed under the [GNU GPL V3](http://www.gnu.org/licenses/gpl.html) License.

# magento-web-api
Magento REST API


