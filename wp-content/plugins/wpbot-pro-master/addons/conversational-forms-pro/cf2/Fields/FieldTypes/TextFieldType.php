<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2\Fields\FieldTypes;


use qcformbuilderwp\qcformbuilderforms\cf2\Fields\FieldType;

class TextFieldType extends FieldType
{

    /** @inheritdoc */
    public static function getType()
    {
        return 'text';
    }
    /** @inheritdoc */
    public static function getCf1Identifier()
    {
        return 'cf2_text';
    }

	/** @inheritdoc */
    public static function getCategory ()
	{
		return __( 'Basic', 'qcformbuilder-forms' );
	}

	/** @inheritdoc */
	public static function getDescription ()
	{
		return __( 'Text Field With Super Powers', 'qcformbuilder-forms' );
	}

	/** @inheritdoc */
	public static function getName ()
	{
		__( 'Text Field (CF2)', 'qcformbuilder-forms' );
	}
}
