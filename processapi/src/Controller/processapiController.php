<?php
/**
 * @file
 * Contains \Drupal\procesapi\Controller\processapiController.
 */

namespace Drupal\processapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Drupal\user\Entity\User;

class processapiController extends ControllerBase {
   
   /**
   *   Start the process of the csv uploaded in the site folder
   *   Get latest uploaded file and extract one by one for validation
   *   @return array
   *   Return markup JSON.
   */
	public function internalapiprocess($filename) {
		$intextData = [];
		$csvFile = fopen('public://processapi_files/'.$filename, 'r');
		$counter = 0;
		if ($csvFile !== FALSE) {
			// loop ove the csv file and validate the data.
			while (($csvArray = fgetcsv($csvFile, 100, ',')) !== FALSE) {
				$dataid = strtoupper(uniqid(5));
				$counter++;
				$subarray_finance = [];
				if($counter != 1) {
					// Validation process, you can add multiple adjustment in the data within part before 
					// proceeding to creating the final API
					if($csvArray[2] == 'finance') {
						$subarray_finance[] = [
							'financedept'		=> $csvArray[2],
							'finance_subone'    => '100',
							'finance_subtwo'    => '100',
						];
					} else {
						$subarray_finance[] = $csvArray[2];
					}
					// Saving the final Json for API
					$intextData[] = [
							'did' 			=> $dataid,
							'name' 			=> $csvArray[0],
							'position' 		=> $csvArray[1],
							'department' 	=> $subarray_finance,
						];
				}
			}
			fclose($csvFile);
		}
		
		// save the data in txt file since  for demo purpose I didnt save to DB 
		// Extract the data from the data container if there is existing.
		$existingjson = file_get_contents('public://processapi_files/data.txt', true);
		$oldData = json_decode($existingjson);
		
		// Merging the old data with the new one. 
		// Included here is condition if this is the first data to save or there is an old data existing
		if($oldData !==  null) {
			//merge the json together then save in data.txt
			$datamerge = array_merge($oldData, $intextData);
			$jsonDatamerge = json_encode($datamerge);
			
			$fp = fopen('public://processapi_files/data.txt', 'w');
			fwrite($fp, $jsonDatamerge);
			fclose($fp);
			
		} else {
			// Process the data if this is the initial json save in data.txt
			$fp = fopen('public://processapi_files/data.txt', 'w');
			fwrite($fp, json_encode($intextData));
			fclose($fp);
		}
		
		return [
		  '#type' => 'markup',
		  //'#markup' => json_encode($intextData),
		  '#markup' => $this->t('Pocess Completed')
		];
	}
	
	
	/**
   * Extract data from the data.txt 
   *
   * @return array
   *   Return markup JSON.
   */
	public function createapi() {
		$data_api = file_get_contents('public://processapi_files/data.txt', true);
		
		if(empty($data_api)){
		  http_response_code(204); //no content errot code
		}else{
		  http_response_code(201);
		}
		die($data_api);
		
	}	
}