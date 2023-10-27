<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2\Fields\FieldTypes;


use qcformbuilderwp\qcformbuilderforms\cf2\Fields\FieldType;

class FileFieldType extends FieldType
{

    /** @inheritdoc */
    public static function getType()
    {
        return 'file';
    }
    /** @inheritdoc */
    public static function getCf1Identifier()
    {
        return 'cf2_file';
    }
	/** @inheritdoc */
	public static function getCategory ()
	{
		return __( 'File', 'qcformbuilder-forms' );
	}

	/** @inheritdoc */
	public static function getDescription ()
	{
		return __( 'File upload field with more features than standard HTML5 input.', 'qcformbuilder-forms' );
	}

	/** @inheritdoc */
	public static function getName ()
	{
		return __( 'Advanced File Uploader (2.0)', 'qcformbuilder-forms' );
	}

	/** @inheritdoc */
	public static function getIcon()
	{
		return qcformbuilder_forms_get_v2_container()->getCoreUrl() . 'assets/images/cloud-upload.svg';
	}
}
