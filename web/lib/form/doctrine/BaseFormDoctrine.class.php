<?php

/**
 * Project form base class.
 *
 * @package    challenger
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormBaseTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class BaseFormDoctrine extends sfFormDoctrine
{
  public function setup()
  {
  }

  /*
   * Workaround to patch duplicate storing of related records
   */
  public function updateObject($values = null)
  {
    if (null === $values) {
      $values = $this->values;
    }

    $values = $this->processValues($values);

    $objectValues = $values;
    foreach ($this->embeddedForms as $name => $embeddedForm) {
      if (array_key_exists($name, $values)) {
        unset($objectValues[$name]);
      }
    }
  
    $this->doUpdateObject($objectValues);

    $this->updateObjectEmbeddedForms($values);

    return $this->getObject();
  }
}
