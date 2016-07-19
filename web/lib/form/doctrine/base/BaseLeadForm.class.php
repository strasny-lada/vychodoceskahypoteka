<?php

/**
 * Lead form base class.
 *
 * @method Lead getObject() Returns the current form's model object
 *
 * @package    vychodoceskahypoteka.cz
 * @subpackage form
 * @author     vychodoceskahypoteka.cz
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLeadForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'type'       => new sfWidgetFormInputText(),
      'amount'     => new sfWidgetFormInputText(),
      'name'       => new sfWidgetFormInputText(),
      'contact'    => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'type'       => new sfValidatorString(array('max_length' => 32)),
      'amount'     => new sfValidatorInteger(),
      'name'       => new sfValidatorString(array('max_length' => 128)),
      'contact'    => new sfValidatorString(array('max_length' => 128)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('lead[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Lead';
  }

}
