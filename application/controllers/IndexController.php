<?php

class IndexController extends Zend_Controller_Action
{
    public function init()
    {
    }

    /**
     * @param $file_path
     * @return array
     */
    public function csvParse($file_path)
    {
        return array_map('str_getcsv', array_slice(file($file_path), 1));
    }

    /**
     * @param $content
     * @return mixed
     */
    public function nameSort($content)
    {
        $b = usort($content, function ($a, $b) {
            return strcmp($a[1], $b[1]);
        });
        return $content;
    }

    /**
     * @throws Zend_Form_Exception
     */
    public function indexAction()
    {
        $form = new Application_Form_UserDetails();
        $view = new Zend_View();
        $view->setScriptPath(APPLICATION_PATH . '/views/scripts/index');

        if (!$this->_request->isPost()) {
            $this->view->form = $form;
            return;
        }

        $formData = $this->_request->getPost();

        if (!$form->isValid($formData)) {
            $form->populate($formData);
            $this->view->form = $form;
            return;
        }

        $uploadedData = $form->getValues();
        $file_path = APPLICATION_PATH . '/../upload/' . $uploadedData['upload'];

        if (!is_file($file_path)) {
            echo "Uploaded file not found at : " . $file_path;
            return;
        }

        $view->message = "Thank you " . $uploadedData['email'] . ". The result of the sorting is:";
        $view->result = $this->nameSort($this->csvParse($file_path));

        echo $view->render('result.phtml');
    }
}