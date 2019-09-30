Oracle Database Connection Tool for Drupal.
Free for commercial and non-commercial use (Apache License or GPL 2).

How to use
===========

####Prerequisite###
Your server should must have OCI driver's (Oracle Driver) latest version installed and enabled. You can install Oracle driver in your server by referring this link - https://www.oracle.com/technetwork/articles/dsl/technote-php-instant-12c-2088811.html


Step 1: Use following namespace in your own controller
use Drupal\drupacle\Controller\DrupacleController;

Step 2: Copy the short code from listing page and use as follows - 

Short code - 
=============

$entity_storage = \Drupal::entityTypeManager()->entityManager->getStorage("drupacle_connection"); 
$entity = $entity_storage->load("machine_name"); 
$connObj = \Drupal::service("drupacle.connection_service")->drupalConnectionCallback($entity);
$Sql = oci_parse($connObj["machine_name"], "YOUR QUERY"); 

Short code (with dependency injection) - 
========================================

$entity_storage = $this->entityManager->getStorage('drupacle_connection');
$entity = $entity_storage->load("machine_name");
$connObj = $this->drupacleService->drupalConnectionCallback($entity);
$Sql = oci_parse($connObj["machine_name"], "select * from table");


