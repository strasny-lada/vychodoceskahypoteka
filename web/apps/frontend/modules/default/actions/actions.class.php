<?php
/**
 * default actions.
 *
 * @package        orangegate-demo
 * @subpackage default
 * @author         Your name here
 * @version        SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions
{
   /**
    * Homepage
    * @param sfRequest $request A request object
    */
    public function executeHomepage(sfWebRequest $request)
    {
        $this->form = new LeadForm();
        $this->getUser()->setFlash('form_successful', null);
    }

    /**
     * Lead form process
     * @param sfRequest $request A request object
     */
    public function executeLeadProcess(sfWebRequest $request)
    {
        $this->form = new LeadForm();

        if ($this->getRequest()->isMethod(sfWebRequest::POST)) {
            $conn = Doctrine_Manager::getInstance()->getCurrentConnection();
            $conn->beginTransaction();

            if ($request->isXmlHttpRequest()) {
                $ajaxResponse = array(
                    'success' => false,
                    'data' => array(),
                );
            }

            $this->form->bind($this->getRequest()->getParameter(str_replace('[%s]', '', $this->form->getWidgetSchema()->getNameFormat())));

            if ($this->form->isValid()) {
                $this->form->save();
                $conn->commit();

                $values = $this->form->getValues();

                $message = $this->getMailer()->compose(
                    'no-reply@vychodoceskahypoteka.cz',
                    sfConfig::get('app_emails_lead'),
                    'Nový lead na vychodoceskahypoteka.cz',
                    <<<EOF
Jméno: {$values['name']}
Kontakt: {$values['contact']}

Výše hypotéky: {$values['amount']}
Typ poptávky: {$values['type']}
EOF
                );
                $this->getMailer()->send($message);

                $this->getUser()->setFlash('form_successful', true);

                if ($request->isXmlHttpRequest()) {
                    $ajaxResponse['success'] = true;
                } else {
                    $this->getContext()->getController()->redirect($this->getRequest()->getReferer());
                }
            }

            if ($request->isXmlHttpRequest()) {
                $ajaxResponse['data']['template'] = $this->getPartial('default/leadForm', array('form' => $this->form));
                $this->getResponse()->setContentType('text/json; charset=utf-8');
                return $this->renderText(json_encode($ajaxResponse));
            } else {
                $this->setTemplate('homepage');
            }
        }
    }

   /**
    * 404
    * @param sfRequest $request A request object
    */
    public function executeError404(sfWebRequest $request)
    {
    }
}
