<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2\RestApi;


interface QcformbuilderRestApiContract
{
    /**
     * Get the namespace for Chatbot Form Builder REST API
     *
     * @since 1.8.0
     *
     * @return string
     */
    public function getNamespace();

    /**
     * Initialize the endpoints
     *
     * @since 1.8.0
     *
     * @return $this
     *
     */
    public function initEndpoints();
}