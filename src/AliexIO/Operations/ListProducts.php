<?php 

namespace AliexApi\Operations;

class ListProducts extends AbstractOperation
{
    public function getName()
    {
        return 'listPromotionProduct';
    }

    public function setFields($fields)
    {
        $this->parameter['fields'] = $fields;
        return $this;
    }
    public function setKeywords($keywords)
    {
        $this->parameter['keywords'] = $keywords;
        return $this;
    }
    public function setCategoryId($categoryId)
    {
        $this->parameter['categoryId'] = $categoryId;
        return $this;
    }
    public function setOriginalPriceFrom($originalPriceFrom)
    {
        $this->parameter['originalPriceFrom'] = $originalPriceFrom;
        return $this;
    }
    public function setOriginalPriceTo($originalPriceTo)
    {
        $this->parameter['originalPriceTo'] = $originalPriceTo;
        return $this;
    }
    public function setVolumeFrom($volumeFrom)
    {
        $this->parameter['volumeFrom'] = $volumeFrom;
        return $this;
    }
    public function setVolumeTo($volumeTo)
    {
        $this->parameter['volumeTo'] = $volumeTo;
        return $this;
    }
    public function setPageNo($pageNo)
    {
        $this->parameter['pageNo'] = $pageNo;
        return $this;
    }
    public function setPageSize($pageSize)
    {
        $this->parameter['pageSize'] = $pageSize;
        return $this;
    }
    public function setSort($sort)
    {
        $this->parameter['sort'] = $sort;
        return $this;
    }
    public function setStartCreditScore($startCreditScore)
    {
        $this->parameter['startCreditScore'] = $startCreditScore;
        return $this;
    }
    public function setEndCreditScore($endCreditScore)
    {
        $this->parameter['endCreditScore'] = $endCreditScore;
        return $this;
    }
    public function setHighQualityItems($highQualityItems)
    {
        $this->parameter['highQualityItems'] = $highQualityItems;
        return $this;
    }
    public function setLocalCurrency($localCurrency)
    {
        $this->parameter['localCurrency'] = $localCurrency;
        return $this;
    }    
}