<?php

namespace Atelier\AndreaBundle\Services;

use Symfony\Component\Form\FormInterface;

class FormService
{
    /**
     * get Error Messages From Form.
     * @param \Symfony\Component\Form\FormInterface $form
     * @return array
     */
    public function getErrorMessages(FormInterface $form)
    {
        $errors = [];
        if ($form->count () > 0) {
            foreach ($form->all () as $child) {
                if (!$child->isValid ()) {
                    $errors[$child->getName ()] = (String)$form[$child->getName ()]->getErrors ();
                }
            }
        }
        return $errors;
    }
}
