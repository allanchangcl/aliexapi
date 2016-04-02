<?php 

namespace AliexApi\Operations;

class GetLinks extends AbstractOperation
{
    public function getName()
    {
        return 'getPromotionLinks';
    }

    public function setFields($fields)
    {
        $this->parameter['fields'] = $fields;
        return $this;
    }
    public function setTrackingId($trackingId)
    {
        $this->parameter['trackingId'] = $trackingId;
        return $this;
    }

    public function setUrls($urls)
    {
        $this->parameter['urls'] = $urls;
        return $this;        
    }
}