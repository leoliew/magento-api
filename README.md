# magento-api
Magento REST API


This is a small module that adds the ability to remotely work with the Magento via the REST API

## Installation

### Magento CE 1.9.x

Install with [modgit](https://github.com/jreinke/modgit):

    $ cd /path/to/magento
    $ modgit init
    $ modgit clone magento-api https://github.com/leoliew/magento-api.git
    
clone from other branch:
    
    $ modgit clone -b dev  magento-api  https://github.com/leoliew/magento-api.git
    
or download package manually:

* Download latest version [here](https://github.com/leoliew/magento-api/archive/master.zip)
* `Unzip` in Magento `root` folder
* Clear cache

##Examples of use

  * user login

        GET /mobileapi/customer/login?username=username&password=password
            Return Login user information

## API 

see english documentation [here](https://github.com/leoliew/magento-api/tree/master/api/en/#api-文档)
see chinese documentation [here](https://github.com/leoliew/magento-api/tree/master/api/cn/#api-文档)


License
-------

This software is distributed under the [GNU GPL V3](http://www.gnu.org/licenses/gpl.html) License.




