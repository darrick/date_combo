<?php

namespace Drupal\datetime\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Plain' formatter for 'date_combo' fields.
 *
 * @FieldFormatter(
 *   id = "date_combo_plain",
 *   label = @Translation("Plain"),
 *   field_types = {
 *     "date_combo"
 *   }
 * )
 */
class DateComboPlainFormatter extends DateTimePlainFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $output = '';
      if (!empty($item->date)) {
        /** @var \Drupal\Core\Datetime\DrupalDateTime $date */
        $date = $item->date;

        if ($this->getFieldSetting('datetime_type') == 'date') {
          // A date without time will pick up the current time, use the default.
          datetime_date_default_time($date);
        }
        else {
        }
        $this->setTimeZone($date);

        $output = $this->formatDate($date);
      }

      if (!empty($item->date2)) {
        /** @var \Drupal\Core\Datetime\DrupalDateTime $date */
        $date2 = $item->date2;

        if ($this->getFieldSetting('datetime_type') == 'date') {
          // A date without time will pick up the current time, use the default.
          datetime_date_default_time($date2);
        }

        $output = $this->t('@date to @date2', [
          '@date' => $this->formatDate($date),
          '@date2' => $this->formatDate($date2),
        ]);
      }
      $elements[$delta] = [
        '#cache' => [
          'contexts' => [
            'timezone',
          ],
        ],
        '#markup' => $output,
      ];
    }

    return $elements;
  }

}
