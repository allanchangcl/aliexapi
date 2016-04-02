<?php 

namespace AliexApi\Tests;

use AliexApi\Configuration\GenericConfiguration;
use AliexApi\AliexIO;
use AliexApi\Operations\ListProducts;
 
class AliexIOTest extends \PHPUnit_Framework_TestCase {

    public function aliconfig($conf)
    {
        $conf
            ->setApiKey('12345')
            ->setTrackingKey('trackkey')
            ->setDigitalSign('dummydigitalsign');
            return $conf;

    }
 
    public function testAliexIO()
    {
        $conf = new GenericConfiguration();
        $this->aliconfig($conf);
        $aliexIO = new AliexIO($conf);

        $listproducts = new ListProducts();
        $listproducts->setFields('productId,productTitle,productUrl,imageUrl');
        $listproducts->setKeywords('card phone');
        $listproducts->setCategoryId('509');
        $listproducts->setHighQualityItems('true');
        $formattedResponse = $aliexIO->runOperation($listproducts);

    }
 
}