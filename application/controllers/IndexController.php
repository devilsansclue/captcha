<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       $host = $this->getRequest()->getServer('HTTP_HOST');
        $tmpCaptcha = file_get_contents("http://$host/captcha/generate");
        $captcha = json_decode($tmpCaptcha);
        $this->view->captcha = $captcha;
        if(isset($_POST['cid'])){
            //we have an attempt.
            //send off a verification request
            $client = new Zend_Http_Client();
            $client->setUri("http://$host/captcha/verify");
            $client->setConfig(array(
                'maxredirects' => 0,
                'timeout'      => 30));
            $client->setParameterPost(array(
                'captcha'  => $_POST['captcha'],
                'cid'   => $_POST['cid'],
            ));
            //get the result
            $response = $client->request("POST");
            var_dump($response->getBody());
            //decode it
            //if human, write success
            //else write failure
        }
    }

    public function generateAction()
    {
        // action body
    }

    public function verifyAction()
    {
        // action body
    }


}





