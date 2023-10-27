<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2\Fields\Handlers;


use qcformbuilderwp\qcformbuilderforms\cf2\QcformbuilderFormsV2Contract;

abstract class FieldHandler implements FieldHandlerContract
{
    /**
     * CF2 Container
     *
     * @since 1.8.0
     *
     * @var QcformbuilderFormsV2Contract
     */
    protected $container;


    /**
     * FieldHandler constructor.
     *
     * @since 1.8.0
     *
     * @param QcformbuilderFormsV2Contract $container
     */
    public function __construct(QcformbuilderFormsV2Contract $container)
    {
        $this->container = $container;
    }
}