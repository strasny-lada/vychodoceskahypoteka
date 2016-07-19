<?php

/**
 * Base project form.
 * 
 * @package    vanilka
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
  /**
   * Vraci HTML pro formularove prvky
   *
   * @param unknown_type $name
   * @return unknown
   */
  public function renderField($name, $label = null)
  {
    $field = $this->offsetGet($name);
    
    // radia
    if ($field->getWidget() instanceof sfWidgetFormChoice && $field->getWidget()->getOption('expanded')) {
      return $this->renderRadios($field, $label);
    }
    // checkbox
    if ($field->getWidget() instanceof sfWidgetFormInputCheckbox) {
      return $this->renderCheckbox($field, $label);
    }
    // captcha
    if ($field->getWidget() instanceof og3WidgetFormCaptcha) {
      $label = $this->getWidgetSchema()->getLabel($field->getName()).' '.$field->getWidget()->renderImage();
    }
    
    $output = $field->renderLabel($label).'<br />';
    $class = $field->getWidget() instanceof sfWidgetFormTextarea ? 'textarea' : 'inputText';
    $output .= '<span class="'.$class;
    if ($class = $field->getWidget()->getAttribute('class')) {
      $output .= ' '.$class;
      $field->getWidget()->setAttribute('class', null);
    }
    if ($field->hasError()) {
      $output .= ' inputTextError';
    }
    $output .= '">'.$field;
    if ($field->hasError()) {
      $output .= '<span class="val valKo"></span>';
      $output .= $field->renderLabel($field->getError(), array('class' => 'error'));
    }
    $output .= '</span><br />';
    return $output;
  }
  
  /**
   * Vraci HTML pro radia ve formulari
   *
   * @param sfFormField $field
   */
  public function renderRadios(sfFormField $field, $label = null)
  {
    $output = '<strong>'.($label ? $label : $this->getWidgetSchema()->getLabel($field->getName())).'</strong>';
    $output .= $field;
    return $output;
  }

  /**
   * Vraci HTML pro checkbox ve formulari
   *
   * @param sfFormField $field
   */
  public function renderCheckbox(sfFormField $field, $label = null)
  {
    $output = $field->renderLabel($field.' '.($label ? $label : $this->getWidgetSchema()->getLabel($field->getName())), array('class' => 'checkbox'));
    if ($field->hasError()) {
      $output .= '<span class="val valKo"></span>';
      $output .= $field->renderLabel($field->getError(), array('class' => 'error'));
    }
    
    return $output;
  }
}
