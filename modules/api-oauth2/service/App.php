<?php
/**
 * app service
 * @package api-oauth2
 * @version 0.0.1
 * @upgrade true
 */

namespace ApiOauth2\Service;

use ApiOauth2\Library\Storage;

class App {
    
    public $server;
    private $authorized;
    private $atoken;
    private $scopes = [];
    
    public function __construct(){
        $dis = &\Phun::$dispatcher;
        
        $config = $dis->config->apiOauth2;
        
        $storage = new Storage();
        $server  = new \OAuth2\Server($storage, [
            'use_jwt_access_tokens'         => true,
            'store_encrypted_token_string'  => false,
            'access_lifetime'               => $config['token_lifetime'],
            'id_lifetime'                   => $config['token_lifetime']
        ]);
        
        $server->addGrantType(new \OAuth2\GrantType\AuthorizationCode($storage));
        
        $server->addGrantType(new \OAuth2\GrantType\ClientCredentials($storage, [
            'allow_public_clients' => false
        ]));
        
        $server->addGrantType(new \OAuth2\GrantType\UserCredentials($storage));
        
        $server->addGrantType(new \OAuth2\GrantType\RefreshToken($storage, [
            'always_issue_new_refresh_token' => true
        ]));
        
        if($server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())){
            $this->atoken = $server->getAccessTokenData(\OAuth2\Request::createFromGlobals());
            if($this->atoken){
                $this->atoken = (object)$this->atoken;
                $this->authorized = true;
                $this->scopes = explode(' ', $this->atoken->scope);
                if($this->atoken->user_id)
                    $dis->user->loginById($this->atoken->user_id, false);
            }
        }
        
        $this->server = $server;
    }
    
    public function isAuthorized(){
        return $this->authorized;
    }
    
    public function hasScope($scope){
        return in_array($scope, $this->scopes);
    }
    
    public function getScopes(){
        return $this->scopes;
    }
}