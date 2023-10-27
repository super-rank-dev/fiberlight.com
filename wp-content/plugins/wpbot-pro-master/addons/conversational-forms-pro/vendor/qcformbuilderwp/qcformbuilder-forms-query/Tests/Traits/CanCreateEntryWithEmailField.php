<?php


namespace qcformbuilderwp\QcformbuilderFormsQuery\Tests\Traits;

/**
 * Trait CreatesEntryWithEmailField
 *
 * Helper functions for testing entry by email
 */
trait CanCreateEntryWithEmailField
{
	use \Qcformbuilder_Forms_Has_Mock_Form;

	/**
	 * Create an entry associated with an email
	 *
	 * @param string $email
	 *
	 * @return int
	 */
	protected function createEntryWithEmail($email = 'hiroy@hiroy.club')
	{
		$fieldData = [];
		$emailFieldConfig = $this->getEmailField();
		foreach ($this->mock_form[ 'fields' ] as $fieldId => $fieldConfig) {
			if ($fieldId === $emailFieldConfig[ 'ID']) {
				$fieldData[ $fieldId ] = $email;
			} else {
				$fieldData[ $fieldId ] = rand() . $fieldId;
			}
		}

		return \Qcformbuilder_Forms_Save_Final::create_entry($this->mock_form, $fieldData);
	}

	/**
	 * Get the email field's config array
	 *
	 * @return array|bool
	 */
	protected function getEmailField()
	{
		return \Qcformbuilder_Forms_Field_Util::get_field_by_slug('email', $this->mock_form);
	}

	/**
	 * Get slug of email field
	 *
	 * @return string
	 */
	protected function getEmailFieldSlug()
	{
		return $this->getEmailField()[ 'slug' ];
	}
}
