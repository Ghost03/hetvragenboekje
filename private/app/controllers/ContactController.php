<?php

class ContactController extends AppController {

    public function overviewAction()
    {   

    }

    public function contactsendAction()
    {
        $config = Zend_Registry::get('config');

        if(!empty( $_POST['name'] ) && !empty( $_POST['email'] ) && !empty( $_POST['subject'] ) && !empty( $_POST['message'] ) )
        {
            if(!empty( $_POST['username']) )
                $username = trim ( $_POST['username'] );

            $name = trim( $_POST['name'] );
            $email = trim( $_POST['email'] );
            $subject = trim( $_POST['subject'] );
            $message = trim( $_POST['message'] );

             $auth = array('auth' => 'login',
                'username' => $config->contactmailer->username,
                'password' => $config->contactmailer->password);

            $transport = new Zend_Mail_Transport_Smtp($config->contactmailer->smtp, $auth);
            $view = Zend_Layout::getMvcInstance()->getView();
            $text = $view->partial('mail/contact.phtml', array('name' => $name, 'username' => $username, 'email' => $email, 'subject' => $subject, 'message' => $message));

            $mail = new Zend_Mail();
            $mail->setBodyText($text, 'utf-8');
            $mail->setBodyHtml($text, 'utf-8');
            $mail->setFrom($config->contactmailer->email, 'Het Vragenboekje Info');
            $mail->addTo($config->contactmailer->email, 'Het Vragenboekje Info');
            $mail->setSubject('Contactformulier - Het Vragenboekje');
            $mail->send($transport);

            $this->_redirect('contact');
        }
    }
    
}

?>
