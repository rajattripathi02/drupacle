<?php

namespace Drupal\drupacle\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DrupacleConnectionForm.
 */
class DrupacleConnectionForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    /** @var \Drupal\drupacle\Entity\DrupacleConnectionInterface $database_connection */
    $database_connection = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $database_connection->label(),
      '#description' => $this->t("Label for the Oracle Database connection."),
      '#required' => TRUE,
    ];
    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $database_connection->id(),
      '#machine_name' => [
        'exists' => '\Drupal\drupacle\Entity\DrupacleConnection::load',
      ],
      '#disabled' => !$database_connection->isNew(),
    ];

    $form['db_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Database Name'),
      '#placeholder' => 'mydb',
      '#size' => 60,
      '#default_value' => $database_connection->get('db_name'),
      '#required' => TRUE,
    ];

    $form['host'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Host'),
      '#placeholder' => '100.100.100.100',
      '#size' => 60,
      '#default_value' => $database_connection->get('host'),
      '#required' => TRUE,
    ];
    $form['port'] = [
      '#type' => 'number',
      '#title' => $this->t('Port (optional)'),
      '#placeholder' => '123456',
      '#min' => 0,
      '#max' => 65535,
      '#default_value' => $database_connection->get('port'),
    ];
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#placeholder' => 'Username',
      '#size' => 60,
      '#default_value' => $database_connection->get('username'),
      '#required' => TRUE,
    ];
    $form['password'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Password'),
      '#placeholder' => 'Password',
      '#size' => 60,
      '#default_value' => $database_connection->get('password'),
      '#required' => TRUE,
    ];

    $form['db_service_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Service Name / SID'),
      '#placeholder' => 'service',
      '#size' => 60,
      '#default_value' => $database_connection->get('db_service_name'),
      '#required' => FALSE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $database_connection = $this->entity;
    $status = $database_connection->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Oracle Database connection entity.', [
          '%label' => $database_connection->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Oracle Database connection entity.', [
          '%label' => $database_connection->label(),
        ]));
    }
    $form_state->setRedirectUrl($database_connection->toUrl('collection'));
  }

}
