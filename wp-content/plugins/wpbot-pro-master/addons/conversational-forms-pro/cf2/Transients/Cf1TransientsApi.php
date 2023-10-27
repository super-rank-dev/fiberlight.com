<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2\Transients;

use qcformbuilderwp\qcformbuilderforms\cf2\Exception;

/**
 * Class Cf1TransientsApi
 *
 * Thin wrapper over CF 1.5+ Transients API wrapper
 *
 * @package qcformbuilderwp\qcformbuilderforms\cf2\Transients
 */
class Cf1TransientsApi implements TransientApiContract
{ /**
 * @inheritdoc
 * @since 1.8.0
 */
    public  function getTransient($id){
        return \Qcformbuilder_Forms_Transient::get_transient($id);
    }
    /**
     * @inheritdoc
     * @since 1.8.0
     */
    public  function setTransient($id, $data, $expires = null)
    {
        return  \Qcformbuilder_Forms_Transient::set_transient($id,$data,$expires);
    }
    /**
     * @inheritdoc
     * @since 1.8.0
     */
    public  function deleteTransient($id){
        return \Qcformbuilder_Forms_Transient::delete_transient($id);
    }



}