#aliexapi
[![Build Status](https://travis-ci.org/clchangnet/aliexapi.svg?branch=master)](https://travis-ci.org/clchangnet/aliexapi) [![Latest Stable Version](https://poser.pugx.org/clchangnet/aliexapi/v/stable)](https://packagist.org/packages/clchangnet/aliexapi) [![Total Downloads](https://poser.pugx.org/clchangnet/aliexapi/downloads)](https://packagist.org/packages/clchangnet/aliexapi) 

AliexApi is a PHP library for AliExpress Affiliate API program. You can use it to fetch product data. It interfaces with Aliexpress API functions such as listPromotionProduct, getPromotionProductDetail and getPromotionLinks. For more info on the API, visit [http://portals.aliexpress.com/help/help_center_API.html](http://portals.aliexpress.com/help/help_center_API.html). To see a working demo site, goto [cheap card phone](http://denwa.iopenshop.net).

This Library based on Jan Eichhorn's [Amazon Product Advertising API](https://github.com/Exeu/apai-io). 

## AliExpress Affiliate Program

To signup and join the program, goto http://portals.aliexpress.com/, you need to apply for API Key to get access.

## Installation

### Composer

Add the package 'clchangnet/aliexapi' to composer.json file:

```js
{
    "require": {
        "clchangnet/aliexapi": "~1.0"
    }
}
```

Update composer of the new package and download.
Once done, you should see a folder 'clchangnet' under 'vendor' folder.

``` bash
$ composer update
$ composer install
```

This will update the autoloader file and the library would be found once you include it in your code.

##Basic Usage:

Here is an example how to use Aliexpress API listPromotionProduct to search for products using keywords.

###Search Products

*Note:*
To search by category. uncomment 'categoryId' and comment 'keywords' in searchItems and listPromotionProduct

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use AliexApi\Configuration\GenericConfiguration;
use AliexApi\AliexIO;
use AliexApi\Operations\ListProducts;

class AliapiController extends Controller
{
    public function aliconfig($conf)
    {
        $conf
            ->setApiKey('ALI_API_KEY')
            ->setTrackingKey('ALI_TRACKING_ID')
            ->setDigitalSign('ALI_DIGITAL_SIGNATURE');
            return $conf;
    }

    public function index()
    {
        $this->searchItems();
    }

    public function searchItems()
    {
        $lppfields = [
            // 'categoryId' => '1501',
            'keywords' => 'baby shoes',
            ];
        $array = $this->listPromotionProduct($lppfields);
        dd($array);           
    }

    public function listPromotionProduct($lppfields)
    {
        $conf = new GenericConfiguration();
        $this->aliconfig($conf);
        $aliexIO = new AliexIO($conf);

        $listproducts = new ListProducts();
        $listproducts->setFields('productId,productTitle,productUrl,imageUrl');
        $listproducts->setKeywords($lppfields['keywords']);
        // $listproducts->setCategoryId($lppfields['categoryId']);
        $listproducts->setHighQualityItems('true');

        $formattedResponse = $aliexIO->runOperation($listproducts);
        $array = json_decode($formattedResponse, true);

        $array = array_merge($array, $lppfields);

        return $array;
       
    }    
}

```

###Get Affiliate Links

```php
    public function getPromotionLinks()
    {
        $conf = new GenericConfiguration();
        $this->aliconfig($conf);
        $aliexIO = new AliexIO($conf);

        $listproducts = new GetLinks();
        $listproducts->setFields('url,promotionUrl');
        $listproducts->setTrackingId('ALI_TRACKING_ID');
        $listproducts->setUrls('http://url1, http://url2');

        $formattedResponse = $aliexIO->runOperation($listproducts);
        $array = json_decode($formattedResponse, true);
        return $array;
    }
```

Example Workflow: 
Use ListProducts to search using keywords and set what fields to return.
Use GetLinksTo convert product urls to your affiliate link.


##Webservice Documentation:

To find out about what fields can be return through API request, goto http://portals.aliexpress.com/help/help_center_API.html