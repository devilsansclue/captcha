<?php

class CaptchaController extends Zend_Controller_Action {

    public function init() {
        $this->cache = Zend_Registry::get('Memcache');
    }

    public function indexAction() {
        // action body
    }

    public function generateAction() {
        

        $captcha = new Zend_Captcha_Image();
        $captcha->setImgDir(APPLICATION_PATH . '/../public/img/captcha/');
        $captcha->setImgUrl($this->view->baseUrl('/img/captcha/'));
        $captcha->setFont(APPLICATION_PATH . '/../public/css/LeagueGothic/league_gothic-webfont.ttf');
        $captcha->setWordlen(4);
        $captcha->setFontSize(34);
        $captcha->setLineNoiseLevel(3);
        $captcha->setDotNoiseLevel(3);
        $captcha->setWidth(190);
        $captcha->setHeight(64);
        
        $data->id = $captcha->generate();
        $data->word = $captcha->getWord();
        $this->cache->save($data,"captcha_{$data->id}");
        $this->view->captcha = $captcha;
    }

    public function verifyAction() {
        
        if (isset($_POST['cid'])) {
            $capId = trim($_POST['cid']);
            $capSession = $this->cache->load("captcha_{$capId}");
            if ($_POST['captcha'] == $capSession->word) {
                //succesful  test - probably a human
                $this->view->human = 1;

                return;  // end action execution here
            }
        }
    }

}

