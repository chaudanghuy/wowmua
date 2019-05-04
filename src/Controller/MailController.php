<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Cake\Event\Event;
use Cake\Core\Configure;
use Mailgun\Mailgun;


class MailController extends AppController {
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        
        $this->autoRender = false;
        
        $this->Auth->allow(['send','prepareData']);
    }
    
    /**
     * Send email with template
     * 
     */
    public function send() {
        try {
            /*
            $mgConfig = Configure::read('mailgun');
            
            $mgClient = new Mailgun($mgConfig['apiKey']);
            $result = $mgClient->sendMessage($mgConfig['domain'], [
                'from' => 'chaudanghuy@gmail.com',
                'to' => 'chaudanghuy@gmail.com',
                'subject' => 'Wowmua Order',
                'text' => 'Your email not support html',
                'html' => $this->prepareData()
            ]);
             */
        } catch (Exception $ex) {

        }
    }
    
    public function prepareData() {
        $content = 'A view variable';
        
        $builder = $this->viewBuilder();
        
        // Configure as needed
        $builder->layout('Email/html/mailgun');
        $builder->template('Email/html/mailgun');
        
        //
        $view = $builder->build(compact('content'));
        
        //
        $output = $view->render();
        
        return $output;
    }
}

