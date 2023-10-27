<?php


namespace qcformbuilderwp\QcformbuilderContainers\Exceptions;

use Psr\Container\ContainerExceptionInterface;

/**
 * Class NotFoundException
 *
 * Exception to throw when container does not contain service
 */
class NotFoundException extends Exception implements ContainerExceptionInterface
{



}
