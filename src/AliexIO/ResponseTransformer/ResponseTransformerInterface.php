<?php

namespace CLC\AliexApi;


interface ResponseTransformerInterface
{
    public function transform($response);
}
