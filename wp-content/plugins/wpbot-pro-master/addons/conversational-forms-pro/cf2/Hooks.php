<?php


namespace qcformbuilderwp\qcformbuilderforms\cf2;


use qcformbuilderwp\qcformbuilderforms\cf2\Fields\FieldTypes\FileFieldType;
use qcformbuilderwp\qcformbuilderforms\cf2\Fields\Handlers\FileFieldHandler;
use qcformbuilderwp\qcformbuilderforms\cf2\Fields\RegisterFields;

class Hooks
{

    protected $container;
    protected $fileFieldHandler;


    public function __construct(QcformbuilderFormsV2Contract $container )
    {
        $this->container = $container;
        $this->fileFieldHandler = new FileFieldHandler($container);
    }

    /**
     * Subscribe to all events
     */
    public function subscribe()
    {
        $this->addFieldHandlers();
        $register = new RegisterFields(
        	$this->container->getFieldTypeFactory(),
			$this->container->getCoreDir()
		);
        add_filter('qcformbuilder_forms_get_field_types', [$register, 'filter' ], 2 );
    }


    /**
     * @return FileFieldHandler
     */
    public function getFileFieldHandler()
    {
        return $this->fileFieldHandler;
    }

    /**
     * Add field handlers filters
     *
     * @since 1.8.0
     */
    protected function addFieldHandlers()
    {

        $fieldType = FileFieldType::getCf1Identifier();
        add_filter("qcformbuilder_forms_process_field_$fieldType",[$this->getFileFieldHandler(),'processField'], 10, 3);
        add_filter("qcformbuilder_forms_save_field_$fieldType",[$this->getFileFieldHandler(),'saveField'], 10, 4);
        add_filter("qcformbuilder_forms_view_field_$fieldType",[$this->getFileFieldHandler(),'viewField'], 10, 4);
    }

}
