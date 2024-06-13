CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Installation
 * Usage
 * Configuration
 * Maintainers


INTRODUCTION
------------

	This module serves two primary functions within a headless application:

	1. CSV Data Upload and REST API Generation: It facilitates uploading CSV data and automatically generates a corresponding REST API for interacting with the data.
	2. Sequential Data Updates: Users are empowered to update the data incrementally through the generated API.
	   Context and Expandability:

	It's important to note that this module is just a component of a larger data structure framework. This framework is designed to handle:

	Multiple Datasets: It can manage and manipulate various datasets simultaneously.
	Data Collation and Validation: The framework can gather data from multiple sources (databases and APIs) and validate it before integration.
	This improved structure separates the core functionalities and adds context about the module's role within the larger framework.

INSTALLATION
------------

 * Install the Node Export module as you would normally install a
   contributed Drupal module. Visit
   https://www.drupal.org/node/1897420 for further information.
   
 * create a folder processapi_files under \sites\default\files\
 
 * under the folder processapi_files, create an empty file data.txt


USAGE
------

 1. create a csv file with the following header
 - name
 - position
 - department
 
 NOTE: A sample csv is attached in this module (sampledata.csv).
 
 2. Login as admin 
 3. Navigate to /admin/processapi_demo
 4. Upload the CSV
    a. Select date of the document
    b. Select the data format
    c. Select the file to upload	
 
 5. Call the API via /processapi_apidemo.


CONFIGURATION
-------------

 No Configuration for this demo.


MAINTAINERS
-----------

 * Edgar Sotero Estor - https://www.linkedin.com/in/ecestor/
