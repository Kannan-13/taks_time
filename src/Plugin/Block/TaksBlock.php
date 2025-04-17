<?php

namespace Drupal\taks_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\taks_time\Service\TimeService;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides a Taks Time Block.
 *
 * @Block(
 *   id = "taks_block",
 *   admin_label = @Translation("Taks Time Block"),
 *   category = @Translation("Custom")
 * )
 */
class TaksBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The time service.
   *
   * @var \Drupal\taks_time\Service\TimeService
   */
  protected $timeService;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a TaksBlock object.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TimeService $timeService, ConfigFactoryInterface $configFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->timeService = $timeService;
    $this->configFactory = $configFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('taks_time.time_service'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->get('taks_time.settings');
    $timezone = $config->get('timezone') ?: 'UTC';
    $initial_time = $this->timeService->getCurrentTimeFormatted();
  
    return [
      '#theme' => 'taks_block',
      '#city' => $config->get('city'),
      '#country' => $config->get('country'),
      '#time' => $initial_time['time'],
      '#date' => $initial_time['date'],
      '#day' => $initial_time['day'], // Make sure this is included
      '#attached' => [
        'library' => ['taks_time/dynamic_time'],
        'drupalSettings' => [
          'taksTime' => [
            'timezone' => $timezone,
            'serverTime' => time(), // Current server timestamp
          ]
        ]
      ],
      '#cache' => [
        'max-age' => 86400,
        'contexts' => ['timezone'],
        'tags' => ['config:taks_time.settings'],
      ],
    ];
  }

}
