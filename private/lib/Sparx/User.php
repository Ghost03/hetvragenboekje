<?php

class Sparx_User {
    
    private $data;
    
    private $language;
    
    private static $message = '';
    
    public function __construct($id = false) {
        $this->language = Zend_Registry::get('language');
    }
    
    /**
     * Handle a login
     * @return type 
     */
    public function login($email,$password) 
    {
        $db = Zend_Registry::get('db');        
        $language = Zend_Registry::get('Zend_Translate');

        $q = $db->prepare("SELECT * FROM customer WHERE email = :email");
        $q->bindValue(':email', $email, PDO::PARAM_STR);
        $q->execute();

        $customer = $q->fetch(PDO::FETCH_ASSOC);

        if (!$customer || $customer['password_hash'] != self::hashPassword($password,$customer['password_salt'])) {
            self::$message = $language->translate('Your login information is incorrect.');
            return false;
        }

        if ($customer['status'] < 1) {
            //self::$message = $language->translate('Your email address has not yet been confirmed.');
            //return false;
        }

        unset($customer['password_hash']);
        unset($customer['password_salt']);

        // last login
        $q = $db->prepare('UPDATE customer SET date_login = NOW() WHERE id = :id');
        $q->bindValue(':id', $customer['id']);
        $q->execute();

        // login history
        $q = $db->prepare('INSERT INTO customer_login (customer_id,date_created,ip) VALUES (:id,:date,:ip)');
        $q->bindValue(':id', $customer['id']);
        $q->bindValue(':date',date('Y-m-d H:i:s'));
        $q->bindValue(':ip',$_SERVER['REMOTE_ADDR']);
        $q->execute();

        $_SESSION['customer'] = $customer;
        return true;
    }
    
    public function register($data)
    {
        $db = Zend_Registry::get('db');        
        $language = Zend_Registry::get('Zend_Translate');

        // check users exists
        $q = $db->prepare("SELECT id FROM customer WHERE email = :email");
        $q->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $q->execute();
        $exists = $q->fetch(PDO::FETCH_COLUMN);

        if ($exists) {
            self::$message = $language->translate('This email address already exists in our database.');
            return false;
        }

        // generate password / insert user
        $salt = self::_generateSalt();
        $hash = self::hashPassword($data['password'],$salt);
        $fields = array('firstname', 'lastname', 'email', 'password_hash', 'password_salt', 'language_id','date_created');

        $q = $db->prepare('INSERT INTO customer (' . implode(',', $fields) . ') VALUES (:' . implode(',:', $fields) . ')');
        foreach (array('firstname', 'lastname', 'email') as $field)
            $q->bindValue(":$field", $data[$field]);
        $q->bindValue(":password_salt", $salt);
        $q->bindValue(":password_hash", $hash);
        $q->bindValue(":language_id", $this->language);
        $q->bindValue(":date_created", date('Y-m-d H:i:s'));
        $q->execute();

        $id = $db->lastInsertId();

        // send confirmation email
        $code = md5($hash . $id);

        $mail = new Sparx_Mailer();
        $mail->setSubject($language->translate('Your registration'));
        $mail->addTo($data['email'], $data['firstname'] . ' ' . $data['lastname']);
        $mail->view->firstname = $data['firstname'];
        $mail->view->lastname = $data['lastname'];
        $mail->view->email = $data['email'];
        $mail->view->link = 'http://' . $_SERVER['HTTP_HOST'] . $mail->view->url(array('id' => $id, 'code' => $code), 'user-activation');
        $mail->render('user/register.phtml');
        $mail->send();        

        self::$message = $language->translate('Your registration is almost complete, check your email!');
        return true;
    }


    /**
     * Get the result message from the login
     * @return string 
     */
    public function getMessage() 
    {
        return self::$message;
    }
    
    /**
     * Check wether the current visitor is logged in
     * @return Zend_Session_Namespace 
     */
    public static function isAuthenticated() {
        $customer = new Zend_Session_Namespace('customer');
        if (!isset($customer->id)) {
            $language = Zend_Registry::get('Zend_Translate');
            self::$message = $language->translate('You need to login to view this page.');
            return false;
        }
        return $customer;
    }

    public static function hashPassword($password,$salt) {
        return md5($password.$salt);
    }

    public static function _generateSalt() {
        $salt = '';
        for ($i = 0; $i < 8; $i++)
            $salt .= chr(rand(33, 127));

        return $salt;
    }
}