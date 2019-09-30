<?php

namespace Drupal\drupacle\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Oracle Database connection entity.
 *
 * @ConfigEntityType(
 *   id = "drupacle_connection",
 *   label = @Translation("Oracle Database connection"),
 *   handlers = {
 *     "access" = "Drupal\drupacle\DrupacleConnectionAccessControlHandler",
 *     "list_builder" = "Drupal\drupacle\DrupacleConnectionListBuilder",
 *     "form" = {
 *       "add" = "Drupal\drupacle\Form\DrupacleConnectionForm",
 *       "edit" = "Drupal\drupacle\Form\DrupacleConnectionForm",
 *       "delete" = "Drupal\drupacle\Form\DrupacleConnectionDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\drupacle\DrupacleConnectionHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "drupacle_connection",
 *   admin_permission = "administer drupacle connections",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/drupacle/connection/add",
 *     "edit-form" = "/admin/drupacle/connection/{drupacle_connection}/edit",
 *     "delete-form" = "/admin/drupacle/connection/{drupacle_connection}/delete",
 *     "collection" = "/admin/drupacle/connections"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "db_name",
 *     "host",
 *     "port",
 *     "username",
 *     "password",
 *     "db_service_name",
 *   }
 * )
 */
class DrupacleConnection extends ConfigEntityBase implements DrupacleConnectionInterface {

  /**
   * The Oracle Database connection entity ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Oracle Database connection entity label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Database name.
   *
   * @var string
   */
  protected $db_name;

  /**
   * The Oracle Database connection host (localhost/IP).
   *
   * @var string
   */
  protected $host;

  /**
   * The Oracle Database connection port.
   *
   * @var int
   */
  protected $port;

  /**
   * The Oracle Database connection username.
   *
   * @var string
   */
  protected $username;

  /**
   * The Oracle Database connection password.
   *
   * @var string
   */
  protected $password;


  /**
   * The service name.
   *
   * @var array
   */
  protected $db_service_name;

  /**
   * {@inheritdoc}
   */
  public function getHostWithPortAndService() : string {
    if (!empty($this->db_service_name)) {
      return $this->host . ':' . $this->port . '/' . $this->db_service_name;
    }
    else {
      return $this->host . ':' . $this->port;
    }
  }

}
