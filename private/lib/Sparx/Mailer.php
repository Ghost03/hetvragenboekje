<?php

/**
 * Sparx_Mailer
 * Uitbreiding op de zend mailer die je makkelijk templates en views laat mailen
 * 
 * Gebruik:
 * $mail = new Sparx_Mailer();
 * 
 * // zet een variabele in de template
 * $mail->view->firstname = 'frank';
 * $mail->render('user/reset.phtml');   // zet de setHtmlBody();
 * 
 * $mail->addTo('fbroersen@gmail.com');
 * // standaard mail shizle, bcc etc.
 * $mail->send();
 */
class Sparx_Mailer extends Zend_Mail {
    
    /**
     * View object
     * @var Zend_View
     */
    public $view;
        
    public function __construct($charset = null) {
        parent::__construct($charset);
                
        // initialize content
        $this->view = new Zend_View();
        $this->view->setScriptPath(APP_PATH . 'views/emails/');
        
        // initialize layout
        $this->view->layout = new Zend_Layout();
        $this->view->layout->setLayoutPath(APP_PATH . 'views/emails');
        
        // default form address
        $config = Zend_Registry::get('config');
        $this->setFrom($config->mailer->email,$config->mailer->from);
    }
        
    /**
     * Render the template and set it as the email content
     * @param type $view    The name of the view
     * @param type $layout  The name of the template
     */
    public function render($view = '',$layout = 'template') 
    {               
        if($view == '')
            throw new Sparx_MailerException('No view set');
        
        $this->view->layout->content = $this->view->render( $view );
        
        $this->view->layout->setLayout($layout);
        
        $this->setBodyHtml($this->view->layout->render());
    }
    
}

class Sparx_MailerException extends Exception { }