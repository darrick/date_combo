<?php

namespace Drupal\date_combo\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'date_combo_datelist' widget.
 *
 * @FieldWidget(
 *   id = "date_combo_datelist",
 *   label = @Translation("Select list"),
 *   field_types = {
 *     "date_combo"
 *   }
 * )
 */
class DateComboDatelistWidget extends DateTimeDatelistWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    if ($this->getFieldSetting('collect_enddate')) {
     $element['value2'] = array(
         '#type' => 'datelist',
         '#date_increment' => $increment,
         '#date_part_order'=> $date_part_order,
       ) + $element['value2'];
   }

    return $element;
  }

}
