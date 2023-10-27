<?php


/**
 * Class Qcformbuilder_Forms_Email_Resend
 */
class Qcformbuilder_Forms_Email_Resend {

	/**
	 * Form config
	 *
	 * @since 1.5.2
	 *
	 * @var array
	 */
	protected $form;

	/**
	 * Entry ID
	 *
	 * @since 1.5.2
	 *
	 * @var int
	 */
	protected $entry_id;

	/**
	 * Submission data
	 *
	 * @since 1.5.2
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Qcformbuilder_Forms_Email_Resend constructor.
	 *
	 * @since 1.5.2
	 *
	 * @param int $entry_id Entry ID
	 * @param array $form Form config
	 */
	public function __construct( $entry_id, array  $form ){
		$this->entry_id = $entry_id;
		$this->form = $form;
	}

	/**
	 * Do resend
	 *
	 * @since 1.5.2
	 */
	public function resend(){
        $this->add_magic_hooks();
        $this->apply_conditional_recipients();
		
		global  $form;
 		$form = $this->form;

		global  $form;
		$form = $this->form;
		/**
		 * Runs right before email resending is sent to emailer
		 *
		 * @since 1.5.2
		 *
		 * @param array $form Form config
		 * @param int $entry_id Entry ID
		 * @param array $data Submission data
		 *
		 */
		do_action( 'qcformbuilder_forms_pre_email_resend', $this->form, $this->entry_id, $this->get_data() );
        $this->remove_magic_hooks();
        $this->form['mailer'][ 'recipients' ] = Qcformbuilder_Forms::do_magic_tags($this->form['mailer'][ 'recipients' ], $this->entry_id, $this->data );
        $this->add_magic_hooks();
		Qcformbuilder_Forms_Save_Final::do_mailer( $this->form, $this->entry_id, $this->get_data() );
        $this->remove_magic_hooks();
    }

	/**
	 * Find and prepare saved submission data
	 *
	 * @since 1.5.2
	 *
	 * @return array|WP_Error
	 */
	protected function get_data(){
		if ( empty( $this->data ) ) {
			$this->data = Qcformbuilder_Forms::get_submission_data( $this->form, $this->entry_id );
			foreach ( $this->data as $id => $datum ){
				$this->data[ $id ] = Qcformbuilder_Forms_Magic_Doer::maybe_implode_opts( $datum );
			}
		}

		return $this->data;

	}

	/**
	 * Provide the magic tag parser the right form config
	 *
	 * @uses "qcformbuilder_forms_magic_form" filter
	 *
	 * @since 1.5.2
	 *
	 * @param array $form
	 * @param array $entry_id
	 *
	 * @return array
	 */
	public function provide_form( $form, $entry_id ){
		if( $entry_id === $this->entry_id ){
			return $this->form;
		}

		return $form;
	}

	/**
	 * Provide the magic tag parser the right data
	 *
	 * @uses "qcformbuilder_forms_magic_parser_data" filter
	 *
	 * @since 1.5.2
	 *
	 * @param array $data
	 * @param array $form
	 *
	 * @return array|WP_Error
	 */
	public function provide_data( $data, $form ){
		if( $form[ 'ID' ] === $this->form[ 'ID' ] ){
			return $this->get_data();
		}

		return $data;
	}

	/**
	 * Apply conditional recipients processor's logic, if needed
	 *
	 * @since 1.5.2
	 */
	protected function apply_conditional_recipients(){
		//This is to make sure processors are loaded properly, which they should be, but...
		Qcformbuilder_Forms_Processor_Load::get_instance()->get_processors();

		$conditional_recipient_processors = array();
		if ( ! empty( $this->form[ 'processors' ] ) ) {
			foreach ( $this->form[ 'processors' ] as $processor_id => $processor ) {
				if ( 'conditional_recipient' === $processor[ 'type' ] ) {
					if ( isset( $processor[ 'conditions' ] ) && ! empty( $processor[ 'conditions' ][ 'type' ] ) ) {
						if ( ! Qcformbuilder_Forms::check_condition( $processor[ 'conditions' ], $this->form, $this->entry_id ) ) {
							continue;
						}
					}

					$conditional_recipient_processors[] = $processor;

				}

			}

		}

		if ( ! empty( $conditional_recipient_processors ) ) {
			foreach ( $conditional_recipient_processors as $processor ) {
				Qcformbuilder_Forms_Processor_Conditional_Recipient::post_processor( $processor[ 'config' ] );
			}

		}

	}

    /**
     * Add the hooks to filter magic tags when resending emails
     *
     * @since 1.7.3
     */
    protected function add_magic_hooks()
    {
        add_filter('qcformbuilder_forms_magic_form', array($this, 'provide_form'), 10, 2);
        add_action('qcformbuilder_forms_magic_parser_data', array($this, 'provide_data'), 10, 2);
    }

    /**
     * Remove the hooks to filter magic tags when resending emails
     *
     * @since 1.7.3
     */
    protected function remove_magic_hooks()
    {
        remove_filter('qcformbuilder_forms_magic_form', array($this, 'provide_form'), 10);
        remove_filter('qcformbuilder_forms_magic_parser_data', array($this, 'provide_data'), 10);
    }

}
