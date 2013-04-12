<?php

/**
 * 
 * This is tiny library for social shite I wrapped one day ;-)
 * @author Pawel Piotr Przedaowski
 *
 */

// credits for this class go to some guy who posted this on Hyves forum
class HyvesAccessToken extends Zend_Oauth_Http_AccessToken
{
    /**
     * Don't filter out custom parameters for accesstoken operation.
     * Hyves requires certain parameters to function correctly.
     *
     * @param  array $params
     * @return array
     */
    protected function _cleanParamsOfIllegalCustomParameters(array $params)
    {
        return $params;
    }
}

class Sparx_SocialConnect
{
    private $_config;
    
    public function __construct(Zend_Config $config)
    {
        $this->_config = $config;
    }
    
    public function login($service, $callbackUrl, $request)
    {
        switch($service) {
            case 'twitter':
                $session = new Zend_Session_Namespace('social.twitter');
                
                $config = array(
                    'callbackUrl'    => $callbackUrl,
                    'siteUrl'        => 'https://api.twitter.com/oauth',
                    'consumerKey'    => $this->_config->twitter->consumer_key,
                    'consumerSecret' => $this->_config->twitter->consumer_secret
                );
                
                $consumer = new Zend_Oauth_Consumer($config);
                
                if(!isset($session->request_token)) {
                    $session->request_token = $consumer->getRequestToken();
                
                    $consumer->redirect();
                } else {
                    // if it blows here we dont have authorized request token, so clear it and retry
                    try {
                        $session->access_token =
                            $consumer->getAccessToken($request->getQuery(), $session->request_token);
                    } catch(Zend_Oauth_Exception $e) {
                        $this->clearSession('twitter');
                        
                        return false;
                    }
                    
                    $session->user_id = $session->access_token->getParam('user_id');
                    
                    unset($session->request_token);
                }
                
                break;
            case 'facebook':
                $session = new Zend_Session_Namespace('social.facebook');
                $config = $this->_config->facebook;
                
                $query = $request->getQuery();
                if(!isset($query['code'])) {
                    $session->redirect_uri = $callbackUrl;
                    
                    $url = 'https://www.facebook.com/dialog/oauth?client_id=' .
                    $config->id . '&redirect_uri=' . $callbackUrl .
                    '&scope=email,publish_stream,offline_access,user_birthday';
                    Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')
                        ->gotoUrlAndExit($url);
                } else {
                    $client = new Zend_Http_Client();
                    $client->setUri('https://graph.facebook.com/oauth/access_token')
                        ->setParameterGet('client_id', $config->id)
                        ->setParameterGet('redirect_uri', $session->redirect_uri)
                        ->setParameterGet('client_secret', $config->secret)
                        ->setParameterGet('code', $query['code']);
                    
                    
                    unset($session->redirect_uri);
                    
                    parse_str($client->request()->getBody(), $response);
                    
                    $access_token = $session->access_token = $response['access_token'];
                }
                
                break;
            case 'hyves':
                $session = new Zend_Session_Namespace('social.hyves');
                
                $config = array(
                    'callbackUrl' => $callbackUrl,
                    'siteUrl' => 'http://data.hyves-api.nl/',
                    'authorizeUrl' => 'http://www.hyves.nl/api/authorize',
                    'consumerKey' => $this->_config->hyves->key,
                    'consumerSecret' => $this->_config->hyves->secret
                );
                
                $consumer = new Zend_Oauth_Consumer($config);
                
                if(!isset($session->request_token)) {
                    $parameters = array(
                       'ha_method' => 'auth.requesttoken',
                       'strict_oauth_spec_response' => 'true',
                       'methods' => 'users.getLoggedin,users.get,countries.get,cities.get,wwws.create'
                    );
                    
                    $session->request_token = $consumer->getRequestToken($parameters);
                    
                    $consumer->redirect();
                } else {
                    $parameters = array(
                        'ha_method' => 'auth.accesstoken',
                        'strict_oauth_spec_response' => 'true'
                    );
                    $hyvesToken = new HyvesAccessToken($consumer, $parameters);
                    
                    
                    // when it blows the token is worng (not authorized or user pressed back)
                    try {
                        $session->access_token = $consumer->getAccessToken(
                            $request->getQuery(), $session->request_token, null, $hyvesToken);
                    } catch(Zend_Oauth_Exception $e) {
                        $this->clearSession('hyves');
                        
                        return false;
                    }
                    
                    $session->user_id = $session->access_token->getParam('userid');
                    
                    unset($session->request_token);
                }
                
                break;
        }
        
        return $this->getClient($service);
    }
    
    public function hasSession($service)
    {
        switch($service) {
            case 'twitter':
                $session = new Zend_Session_Namespace('social.twitter');
                
                return isset($session->access_token);
            case 'facebook':
                $session = new Zend_Session_Namespace('social.facebook');
                
                return isset($session->access_token);
            case 'hyves':
                $session = new Zend_Session_Namespace('social.hyves');
                
                return isset($session->access_token);
        }
        
        return false;
    }
    
    public function clearSession($service)
    {
        switch($service) {
            case 'twitter':
                $session = new Zend_Session_Namespace('social.twitter');
                
                unset($session->access_token);
                unset($session->request_token);
             
                break;
            case 'facebook':
                $session = new Zend_Session_Namespace('social.facebook');
                
                unset($session->access_token);
                unset($session->redirect_uri);
            case 'hyves':
                $session = new Zend_Session_Namespace('social.hyves');
                
                unset($session->access_token);
                unset($session->request_token);
        }
    }
    
    public function getClient($service)
    {
        switch($service) {
            case 'twitter':
                $session = new Zend_Session_Namespace('social.twitter');
                
                $config = array(
                    'siteUrl'        => 'https://api.twitter.com/oauth',
                    'consumerKey'    => $this->_config->twitter->consumer_key,
                    'consumerSecret' => $this->_config->twitter->consumer_secret
                );
                
                return new TwitterClient($session->access_token->getHttpClient($config), $session->user_id);
            case 'facebook':
                $session = new Zend_Session_Namespace('social.facebook');
                
                return new FacebookClient($session->access_token);
            case 'hyves':
                $session = new Zend_Session_Namespace('social.hyves');
                
                $config = array(
                    'consumerKey' => $this->_config->hyves->key,
                    'consumerSecret' => $this->_config->hyves->secret
                );
                
                return new HyvesClient($session->access_token->getHttpClient($config), $session->user_id);
        }
    }
    
    public function post($message, $networks)
    {
        $clients = array();
        
        if($networks['facebook'])
            $clients['fb'] = $this->getClient('facebook');
        if($networks['hyves'])
            $clients['hyves'] = $this->getClient('hyves');
        if($networks['twitter'])
            $clients['twitter'] = $this->getClient('twitter');
        
        if(isset($clients['fb'])) {
            $return = $clients['fb']->request('me/feed', array('message' => $message), 'POST');
        }
        if(isset($clients['hyves'])) {
            $return = $clients['hyves']->request('wwws.create', array('emotion' => $message, 'visibility' => 'public'));
        }
        if(isset($clients['twitter'])) {
            $return = $clients['twitter']->request('statuses/update.json', array('status' => $message));
        }
    }
}

class SocialClient
{
    private $_baseParams = array();
    
    private $_basePath;
    
    protected $_method = Zend_Http_Client::GET;
    
    public function __construct($basePath)
    {
        $this->_basePath = $basePath;
    }
    
    private $_httpClient;
    
    public function setHttpClient($httpClient)
    {
        $this->_httpClient = $httpClient;
    }
    
    public function getHttpClient()
    {
        return $this->_httpClient;
    }
    
    protected function _request($path, $params = array(), $method = null)
    {
        if(!$method) $method = $this->_method;
        $client = $this->_httpClient;
        
        $uri = $this->_basePath . $path;
        $this->_httpClient->setMethod($method);
        if($method == Zend_Http_Client::GET) $uri .= '?' . http_build_query($params);
        
        if($method == Zend_Http_Client::POST)
            foreach($params as $key => $value)
                $client->setParameterPost($key, $value);
        
        $result = Zend_Json::decode($client->setUri($uri)->request()->getBody());
        
        // clear parameters for Hyves
        if($method == Zend_Http_Client::POST)
            foreach($params as $key => $value)
                $client->setParameterPost($key);
            
        return $result;
    }
}

class FacebookClient extends SocialClient
{
    public function __construct($accessToken)
    {
        parent::__construct('https://graph.facebook.com/');
        
        $client = new Zend_Http_Client();
        $client->setEncType(Zend_Http_Client::ENC_FORMDATA);
        $client->setParameterGet('access_token', $accessToken);
        
        $this->setHttpClient($client);
    }
    
    public function request($path, $params = array(), $method = null)
    {
        return parent::_request($path, $params, $method);
    }
}

class TwitterClient extends SocialClient
{
    public $me;
    
    public function __construct($client, $me = null, $version = 1)
    {
        parent::__construct("http://api.twitter.com/$version/");
        
        $this->me = $me;
        
        $this->_method = Zend_Http_Client::POST;
        
        $this->setHttpClient($client);
    }
    
    public function request($path, $params = array(), $method = null)
    {
        return parent::_request($path, $params, $method);
    }
}

class HyvesClient extends SocialClient
{
    public $me;
    
    public function __construct($client, $me = null)
    {
        parent::__construct('http://data.hyves-api.nl/');
        
        $this->me = $me;
        
        $this->_method = Zend_Http_Client::POST;
        $client->setParameterPost('ha_format', 'json');
        $this->setHttpClient($client);
    }
    
    public function request($method, $params = array())
    {
        $params['ha_method'] = $method;
        return parent::_request('', $params);
    }
}