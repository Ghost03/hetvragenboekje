<?php

class LoginController extends CrudController {

    private static function _generateSalt() {
	   $salt = '';
	   for ($i = 0; $i < 8; $i++)
		  $salt .= chr(rand(33, 127));

	   return $salt;
    }

    private static function _hashPassword($pass, $salt) {
	   $hash = strrev($pass);
	   $hash = sha1($hash . substr($salt, 0, 3));
	   $hash = sha1(substr($salt, 3, 3) . $hash);
	   $hash = sha1($hash . substr($salt, 6));
	   return $hash;
    }

    private static function _createRandomPassword() {

	   $chars = "abcdefghijkmnopqrstuvwxyz023456789";
	   srand((double) microtime() * 1000000);
	   $i = 0;
	   $pass = '';

	   while ($i <= 7) {
		  $num = rand() % 33;
		  $tmp = substr($chars, $num, 1);
		  $pass = $pass . $tmp;
		  $i++;
	   }

	   return $pass;
    }

    public function checkemailAction() {
	   $ajaxEmail = $_POST['email'];
	   $ajaxPassword = $_POST['password'];

	   $array = array("email" => $ajaxEmail, "password" => $ajaxPassword);

	   if (!isset($ajaxEmail))
		  exit;
	   $db = Zend_Registry::get('db');

	   $emailDB = $db->fetchRow('SELECT * FROM `users` WHERE email = ?', $ajaxEmail);

	   if (!$emailDB) {
		  $data = array("login-error" => "Onjuiste gegevens");
		  $this->_forward("home", "page", 'default', $data);
	   } else {
		  $this->_forward("login", "login", 'default', $array);
	   }
    }

    public function loginAction() {

	   $db = Zend_Registry::get('db');

	   $email = trim($this->_getParam('email'));
	   $password = trim($this->_getParam('password'));

	   $q = "SELECT * FROM `users` WHERE email = ?";
	   $user = $db->fetchRow($q, $email);

	   if (!$user || $user['hash'] != self::_hashPassword($password, $user['salt'])) {
		  $data = array("login-error" => "Onjuiste gegevens");
		  $this->_forward("home", "page", 'default', $data);
	   } else {
		  unset($user['hash']);
		  $rememberMe = $_POST['remember'];
		  if ($rememberMe == 1) {
			 $seconds = 60 * 60 * 24 * 7; // 7 days
			 Zend_Session::rememberMe($seconds);
		  } else {
			 Zend_Session::ForgetMe();
		  }
		  $_SESSION['user'] = $user['email'];
		  $this->_redirect('/questions');
	   }
    }

    public function forgotpasswordAction() {

	   $config = Zend_Registry::get('config');
	   $db = Zend_Registry::get('db');

	   if (isset($_POST['submit'])) {

		  if (!empty($_POST['email'])) {

			 $email = $_POST['email'];

			 $auth = array('auth' => 'login',
				'username' => $config->mailer->username,
				'password' => $config->mailer->password);

			 $user = $db->fetchRow('SELECT * FROM users WHERE email = ?', $email);

			 if (!$user)
				$this->_redirect('wachtwoord-vergeten');

			 $randomPass = self::_createRandomPassword();
			 $salt = self::_generateSalt();
			 $hash = self::_hashPassword($randomPass, $salt);

			 $q = $db->prepare('UPDATE users SET hash = :hash, salt = :salt WHERE email = :email');
			 $q->bindValue(':hash', $hash);
			 $q->bindValue(':salt', $salt);
			 $q->bindValue(':email', $email);
			 $q->execute();

			 $transport = new Zend_Mail_Transport_Smtp($config->mailer->smtp, $auth);

			 $mail = new Zend_Mail();
			 $mail->setBodyText('Je bent je wachtwoord vergeten. Je nieuwe wachtwoord is: <b>' . $randomPass . '</b>');
			 $mail->setBodyHtml('Je bent je wachtwoord vergeten. Je nieuwe wachtwoord is: <b>' . $randomPass . '</b>');
			 $mail->setFrom($config->mailer->email, 'Het Vragenboekje');
			 $mail->addTo($user['email'], $user['name'] . ' ' . $user['lastname']);
			 $mail->setSubject('Wachtwoord vergeten - Het Vragenboekje');
			 $mail->send($transport);
		  }
		  else {
			 $this->_redirect('wachtwoord-vergeten');
		  }
	   }
    }

}
?>
