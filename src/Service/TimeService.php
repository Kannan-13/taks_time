<?php

namespace Drupal\taks_time\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Security\TrustedCallbackInterface;

class TimeService {

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new TimeService object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory service.
   */
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }

  /**
   * Returns the formatted current time.
   *
   * @return array
   *   An array with formatted date and time.
   */
  public function getCurrentTimeFormatted() {
    $config = $this->configFactory->get('taks_time.settings');
    $timezone = $config->get('timezone') ?: 'UTC';

    $date = new DrupalDateTime('now', $timezone);
    return [
      'date' => $date->format('jS M Y'),
      'time' => $date->format('h:i A'),
      'day' => $date->format('l'),
    ];
  }

}
