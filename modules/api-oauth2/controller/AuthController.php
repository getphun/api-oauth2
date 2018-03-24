<?php
/**
 * Oauth2 Auth
 * @package ApiOauth2
 * @version 0.0.1
 * @upgrade true
 */

namespace ApiOauth2\Controller;

class AuthController extends \ApiController
{

    public function authorizeAction(){
        $request = \OAuth2\Request::createFromGlobals();
        $response = new \OAuth2\Response();
        
        if(!$this->app->server->validateAuthorizeRequest($request, $response))
            return $response->send();
        
        // redirect user to login page
        $config = $this->config->apiOauth2;
        $this->redirectUrl($config['loginRouter'], [], [
            'state'         => $this->req->getQuery('state'),
            'response_type' => $this->req->getQuery('response_type'),
            'client_id'     => $this->req->getQuery('client_id'),
            'redirect_uri'  => $this->req->getQuery('redirect_uri')
        ]);
    }
    
    public function accessTokenAction(){
        $this->app
            ->server
            ->handleTokenRequest(\OAuth2\Request::createFromGlobals())
            ->send();
    }
}