<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2\RestApi\File;


use qcformbuilderwp\qcformbuilderforms\cf2\RestApi\Endpoint;

abstract class File extends Endpoint
{

    const URI = 'file';
    /** @inheritdoc */
    protected function getUri()
    {
        return self::URI;
    }
}