<?php 

namespace AliexApi\Operations;

class GetProductDetail extends AbstractOperation
{
    public function getName()
    {
        return 'getPromotionProductDetail';
    }

    public function setFields($fields)
    {
        $this->parameter['fields'] = $fields;
        return $this;
    }
    public function setProductId($productId)
    {
        $this->parameter['productId'] = $productId;
        return $this;
    }

    /**
     * @param string $language Lower case,total 17 languages supported(en,pt,ru,es,fr,id,it,nl,tr,vi,th,de,ko,ja,ar,pl,he)
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->parameter['language'] = $language;
        return $this;
    }
}
