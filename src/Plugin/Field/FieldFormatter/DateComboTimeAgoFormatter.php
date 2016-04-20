<?php

namespace Drupal\datetime\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'Time ago' formatter for 'date_combo' fields.
 *
 * @FieldFormatter(
 *   id = "date_combo_time_ago",
 *   label = @Translation("Time ago"),
 *   field_types = {
 *     "date_combo"
 *   }
 * )
 */
class DateComboTimeAgoFormatter extends DateTimeTimeAgoFormatter implements ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $date = $item->date;
      $date2 = $item->date2;
      $output = [];
      // Base the timeago calculation off of the end date, if it exists.
      if (!empty($item->date2)) {
        if ($this->getFieldSetting('datetime_type') == 'date') {
          // A date without time will pick up the current time, use the default.
          datetime_date_default_time($date2);
        }
        $output = $this->formatDate($date2);
      }
      elseif (!empty($item->date)) {
        if ($this->getFieldSetting('datetime_type') == 'date') {
          // A date without time will pick up the current time, use the default.
          datetime_date_default_time($date);
        }
        $output = $this->formatDate($date);
      }
      $elements[$delta] = $output;
    }

    return $elements;
  }

}
