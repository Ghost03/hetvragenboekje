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
		  $this->_forward("home", "Index", 'default', $data);
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
		  $this->_forward("home", "Index", 'default', $data);
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

		  	 $view = Zend_Layout::getMvcInstance()->getView();


			 $email = $_POST['email'];

			 $auth = array('auth' => 'login',
				'username' => $config->mailer->username,
				'password' => $config->mailer->password);

			 $user = $db->fetchRow('SELECT * FROM users WHERE email = ?', $email);

			 if (!$user)
				$this->_redirect('wachtwoord-vergeten');

			 // Date
			 $date = date("Y-m-d H:i");
			 $time = new DateTime($date);
			 $time->add(new DateInterval('PT30M'));
			 
			 // Data
			 $uniqid = uniqid();
			 $user_id = $user['id'];
			 $expiration = $time->format('Y-m-d H:i');
			 $ip = $_SERVER['REMOTE_ADDR'];

		 	 $q = $db->prepare('INSERT INTO user_reset (reset_id, user_id, expiration, ip) VALUES (:reset_id, :user_id, :expiration, :ip)');
	         $q->bindValue(':reset_id', $uniqid);
	         $q->bindValue(':user_id', $user_id);
	         $q->bindValue(':expiration', $expiration);
	         $q->bindValue(':ip', $ip);
	 		 $q->execute();

		 	 $temporarylink = $config->baseurl . 'reset?id=' . $uniqid;

		 	 $this->view->temporarylink = $temporarylink;
			 $text = $view->partial('mail/password-forgot.phtml', array('link' => $temporarylink, 'config' => $config));

			 $transport = new Zend_Mail_Transport_Smtp($config->mailer->smtp, $auth);

			 $mail = new Zend_Mail();
			 $mail->setBodyText($text, 'utf-8');
			 $mail->setBodyHtml($text, 'utf-8');
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

    public function resetAction() {

	   $config = Zend_Registry::get('config');
	   $db = Zend_Registry::get('db');

	   $reset_id = $_GET['id'];
	   $reset = $db->fetchRow('SELECT * FROM user_reset WHERE reset_id = ?', $reset_id);

	   $date = date("Y-m-d H:i:s");
	   $exp_date = $reset['expiration'];

	   if( $reset && $date < $exp_date ) {

		   	echo '<form action="resetpassword" method="POST">
		   		<label for="password">Nieuw wachtwoord:</label>
		   		<input type="password" id="password" name="password" /><br />
		   		<input type="hidden" name="reset_id" value="' . $reset_id . '" />
		   		<input type="submit" name="submit" />
		   	</form>';
	   }
	   else {
	   	 $this->_redirect('reset?id=' . $reset_id);
	   }

    }

    public function resetpasswordAction() {

       $config = Zend_Registry::get('config');
	   $db = Zend_Registry::get('db');

	    if(isset($_POST['submit']))  {

			if(!empty($_POST['password']) && !empty($_POST['reset_id'])) {

				$reset_id = $_POST['reset_id'];
				$password = $_POST['password'];
			    $salt = self::_generateSalt();
			    $hash = self::_hashPassword($password, $salt);

			    $reset = $db->fetchRow('SELECT * FROM user_reset WHERE reset_id = ?', $reset_id);

			   	$q = $db->prepare('UPDATE users SET hash = :hash, salt = :salt WHERE id = :id');
		        $q->bindValue(':hash', $hash);
		        $q->bindValue(':salt', $salt);
		        $q->bindValue(':id', $reset['user_id']);
		 		$q->execute();

		 		$d = $db->prepare('DELETE FROM user_reset WHERE reset_id = :reset_id');
	   			$d->bindValue(':reset_id', $_POST['reset_id']);
	   			$d->execute();

	   			$this->_redirect('categorieen');
	   		}

	   	}	
	   	else {
	   		$this->_redirect('wachtwoord-vergeten');
	   	}
    }

}
?>
