<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    function _initCaptcha() {
        //Zend_Session::start();
        $frontendOpts = array(
            'caching' => true,
            'lifetime' => 1800,
            'automatic_serialization' => true
        );

        $backendOpts = array(
            'servers' => array(
                array(
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 1
                )
            ),
            'compression' => false
        );
        $cache = Zend_Cache::factory('Core', 'Memcached', $frontendOpts, $backendOpts);
        Zend_Registry::set('Memcache', $cache);
    }

}

