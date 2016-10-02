<?php

class Application_Form_UserDetails extends Zend_Form
{
    /**
     * @throws Zend_Form_Exception
     */
    public function init()
    {
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('class', 'pure-form pure-form-aligned');

        $this->addElement('text', 'email', array(
            'label' => 'Your email address:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));

        $upload = new Zend_Form_Element_File('upload');
        $upload->setLabel('Upload CSV:')
            ->setDestination(APPLICATION_PATH . '/../upload')
            ->setRequired(true)
            ->addValidator('NotEmpty')
            ->addValidator('Count', false, 1)
            ->addValidator('Size', false, 102400)
            ->addValidator('Extension', false, 'csv');

        $this->addElement($upload);
        $this->addElement('submit', 'Save');
    }
}

