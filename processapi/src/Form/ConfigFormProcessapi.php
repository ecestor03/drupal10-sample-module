<?php

/**
 * @file
 * Contains \Drupal\mydeliveries\Form\ConfigFormProcessapi.
 */

namespace Drupal\processapi\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Component\Utility\SafeMarkup;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ConfigFormProcessapi extends ConfigFormBase {


  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'processapi_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['processapi.form'];
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

	 $form['file_upload_details'] = array(
      '#markup' => t('<b>Upload Data</b>'),
    );
	
	$form['prapi_data_date'] = array(
	  '#type' => 'datetime',
	  "#title" => t("Select date of the document."), 
	  '#date_date_element' => 'date',
	  '#date_time_element' => 'none',
	  '#date_year_range' => '2010:+3',
	  '#date_timezone' => 'Asia/Kolkata',
	  '#required' => TRUE,
	);
	
	$form["prapi_options"] = array(
		"#type" => "select", 
		"#title" => t("Select data format."), 
		"#options" => array(
			"prapi_formatpdf" => t("GOLD"), 
			"prapi_formattxt" => t("GREEN"),
			"prapi_formatcsv" => t("RED"),
		),
		"#description" => t("Select Format."),
	);
	
    $validators = array(
      'file_validate_extensions' => array('csv'),
    );
	
    $form['prapi_file'] = array(
      '#type' => 'managed_file',
      '#name' => 'prapi_file',
      '#title' => t('File'),
      '#size' => 20,
      '#description' => t('PDF / TXT / CSV format only'),
      '#upload_validators' => $validators,
      '#upload_location' => 'public://processapi_files/',
	  '#required' => TRUE,
    );
    
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save and Process'),
      '#button_type' => 'primary',
    );

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
      '#attributes' => array(
        'id' => 'returnformsubmit',
      )
    );
    return $form;

  }
  
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {    
    if ($form_state->getValue('prapi_file') == NULL) {
		$form_state->setErrorByName('prapi_file', $this->t('File.'));
		\Drupal::messenger()->addMessage('You must upload a file.');
    } 
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
	  $fid = $form_state->getValue('prapi_file');
	  $filename = \Drupal\file\Entity\File::load($fid[0]);
	  $latestfilename = $filename->getFilename();
    // Display success message.
	\Drupal::messenger()->addMessage('Upload complete your file is saved under public://processapi_files/.');

    // Redirect.
	$form_state->setRedirect('processapi.startprocessapi', ['filename' => $latestfilename]);
	
  }

}
