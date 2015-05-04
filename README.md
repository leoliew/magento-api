# magento-api
Magento REST API


This is a small module that adds the ability to remotely work with the Magento via the REST API

## Installation

### Magento CE 1.9.x

Install with [modgit](https://github.com/jreinke/modgit):

    $ cd /path/to/magento
    $ modgit init
    $ modgit clone magento-api https://github.com/leoliew/magento-api.git
    
or download package manually:

* Download latest version [here](https://github.com/leoliew/magento-api/archive/master.zip)
* Unzip in Magento root folder
* Clear cache

##Examples of use

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




