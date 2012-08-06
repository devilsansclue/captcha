<?php

class CaptchaController extends Zend_Controller_Action {

    public function init() {
        $this->cache = Zend_Registry::get('Memcache');
    }

    public function indexAction() {
        // action body
    }

    public function generateAction() {
        
        $host = $this->getRequest()->getServer('HTTP_HOST');
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
        $captcha->render();
        $data->id = $captcha->generate();
        $data->word = $captcha->getWord();
        $this->cache->save($data,"captcha_{$data->id}");
        $this->view->captcha = array(
            'path'  => "http://$host{$captcha->getImgUrl()}{$captcha->getId()}.png",
            'id'    => $captcha->getId()
        );
    }

    public function verifyAction() {
        
        if (isset($_POST['cid'])) {
            $capId = trim($_POST['cid']);
            $capSession = $this->cache->load("captcha_{$capId}");
            $this->view->human = $_POST['captcha'] == $capSession->word;
            $this->cache->remove("captcha_{$capId}");
        }
    }

}

