<?php

/**
 * Lead form.
 *
 * @package    symfony
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LeadForm extends BaseLeadForm
{
    public function configure()
    {
        unset($this['id']);
        unset($this['created_at']);
        unset($this['updated_at']);

        $this->setWidget('type', new sfWidgetFormInputHidden(array(), array('data-value-buy' => Lead::TYPE_BUY, 'data-value-refinance' => Lead::TYPE_REFINANCE)));
        $this->setWidget('amount', new sfWidgetFormInputHidden());
        $this->setWidget('answer_to_the_ultimate_question_of_life_the_universe_and_everything', new sfWidgetFormInputHidden());

        $this->setValidator('type', new sfValidatorChoice(array(
            'choices' => array(
                Lead::TYPE_BUY,
                Lead::TYPE_REFINANCE,
            ),
        )));
        $this->setValidator('name', new sfValidatorString(array(
            'min_length' => 3,
            'max_length' => 128
        ), array(
            'required' => 'Zadejte Vaše jméno.',
            'min_length' => 'Jméno je příliš krátké.',
            'max_length' => 'Jméno je příliš dlouhé.',
        )));
        $this->setValidator('contact', new sfValidatorPass());

        $this->mergePostValidator(new sfValidatorCallback(array(
            'callback' => array($this, 'checkContact')
        ), array(
            'required' => 'Zadejte Váš e-mail nebo telefon.',
            'invalid' => 'Zadaný kontakt není platný e-mail nebo telefon.',
        )));

        $this->mergePostValidator(new sfValidatorCallback(array(
            'callback' => array($this, 'checkUltimateQuestion')
        ), array(
            'invalid' => 'It must be a bot.',
        )));

        $this->setDefault('type', Lead::TYPE_BUY);

        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', false);
    }

    public function checkContact($validator, $values) {
        $emailPattern = '/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i';
        $phonePattern = '/^(\+420\s?)?(\d\s?){9,}$/';

        if (!$values['contact'] || (!preg_match($emailPattern, $values['contact']) && !preg_match($phonePattern, $values['contact']))) {
            throw new sfValidatorErrorSchema($validator, array(
                'contact' => new sfValidatorError($validator, $values['contact'] ? 'invalid' : 'required')
            ));
        }

        return $values;
    }

    public function checkUltimateQuestion($validator, $values) {
        if ($values['answer_to_the_ultimate_question_of_life_the_universe_and_everything'] != '42') {
            throw new sfValidatorErrorSchema($validator, array(
                'answer_to_the_ultimate_question_of_life_the_universe_and_everything' => new sfValidatorError($validator, 'invalid')
            ));
        }
        return $values;
    }
}
