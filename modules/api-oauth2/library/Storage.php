<?php
/**
 * Oauth2 Custom Storage
 * @package ApiOauth2
 * @version 0.0.1
 * @upgrade true
 */

namespace ApiOauth2\Library;

use ApiOauth2\Model\Oauth2Client as OClient;
use ApiOauth2\Model\Oauth2AccessToken as OAToken;
use ApiOauth2\Model\Oauth2AuthorizationCode as OACode;
use ApiOauth2\Model\Oauth2RefreshToken as ORToken;
use ApiOauth2\Model\Oauth2Scope as OScope;
use ApiOauth2\Model\Oauth2User as OUser;

use OAuth2\Encryption\Jwt;

use User\Model\User as User;

class Storage implements
    \OAuth2\Storage\AuthorizationCodeInterface,
    \OAuth2\Storage\ClientCredentialsInterface,
    \OAuth2\Storage\JwtAccessTokenInterface,
    \OAuth2\Storage\JwtBearerInterface,
    \OAuth2\Storage\PublicKeyInterface,
    \OAuth2\Storage\RefreshTokenInterface,
    \OAuth2\Storage\ScopeInterface,
    \OAuth2\Storage\UserCredentialsInterface
{

    private $last_access_token;
    private $last_authorization_code;
    private $last_client;
    private $last_refresh_token;
    private $last_user;
    private $last_user_scope;
    
    private $scopes = [];
    private $scope_default;
    
    protected $encryptionUtil;
    
    /* OAuth2\Storage\AccessTokenInterface ---------------------------------- */
    
    public function __construct(){
        $this->encryptionUtil = new Jwt;
    }
    
    public function getAccessToken($oauth_token, $complete=false){
        $tokenData = $this->encryptionUtil->decode($oauth_token, null, false);
        if($tokenData){
            $client_id  = $tokenData['aud'] ?? null;
            $public_key = $this->getPublicKey($client_id);
            $algorithm  = $this->getEncryptionAlgorithm($client_id);
            
            if(false === $this->encryptionUtil->decode($oauth_token, $public_key, [$algorithm]))
                return false;
            $oauth_token = $tokenData['jti'];
        }
        
        $access_token = $this->last_access_token;
        if(!$access_token || $access_token->access_token != $oauth_token)
            $access_token = null;
        
        if(!$access_token){
            $access_token = OAToken::get(['access_token'=>$oauth_token], false);
            if(!$access_token)
                return false;
            
            $access_token->expires = strtotime($access_token->expires);
            $this->last_access_token = $access_token;
        }
        
        if($complete)
            return $access_token;
        
        return [
            'expires'   => $access_token->expires,
            'client_id' => $access_token->client,
            'user_id'   => $access_token->user,
            'scope'     => $access_token->scope,
            'id_token'  => null
        ];
    }
    
    public function setAccessToken($oauth_token, $client_id, $user_id, $expires, $scope=null){
        $data = [
            'access_token'  => $oauth_token,
            'client'        => $client_id,
            'user'          => $user_id,
            'scope'         => $scope,
            'expires'       => date('Y-m-d H:i:s', $expires)
        ];
        
        $access_token = $this->getAccessToken($oauth_token, true);
        if($access_token)
            return OAToken::set($data, ['id'=>$access_token->id]);
        return OAToken::create($data);
    }
    
    
    /* OAuth2\Storage\AuthorizationCodeInterface ---------------------------- */
    
    public function getAuthorizationCode($code, $complete=false){
        $acode = $this->last_authorization_code;
        if(!$acode || $acode->authorization_code != $code){
            $acode = OACode::get(['authorization_code'=>$code], false);
            if(!$acode)
                return;
            $acode->authorization_code = $code;
        }
        
        if($complete)
            return $acode;
            
        return [
            'client_id'     => $acode->client,
            'user_id'       => $acode->user,
            'expires'       => strtotime($acode->expires),
            'redirect_uri'  => $acode->redirect,
            'scope'         => $acode->scope
        ];
    }
    
    public function setAuthorizationCode($code, $client_id, $user_id, $redirect_uri, $expires, $scope=null, $id_token=null){
        $data = [
            'authorization_code'    => $code,
            'client'                => $client_id,
            'user'                  => $user_id,
            'redirect'              => $redirect_uri,
            'scope'                 => $scope,
            'id_token'              => $id_token,
            'expires'               => date('Y-m-d H:i:s', $expires)
        ];
        
        $acode = $this->getAuthorizationCode($code, true);
        
        if($acode){
            OACode::set($data, ['id'=>$acode->id]);
            foreach($data as $key => $val)
                $this->last_authorization_code->$key = $val;
        }else{
            OACode::create($data);
        }
    }
    
    public function expireAuthorizationCode($code){
        OACode::remove(['authorization_code'=>$code]);
        $acode = $this->last_authorization_code;
        if($acode && $acode->authorization_code == $code)
            $acode->authorization_code = null;
    }
    
    
    /* OAuth2\Storage\ClientCredentialsInterface ---------------------------- */
    
    public function checkClientCredentials($client_id, $client_secret=null){
        $client = $this->getClientDetails($client_id, true);
        if(!$client)
            return false;
        if($client_secret && $client->secret != $client_secret)
            return false;
        return true;
    }
    
    public function isPublicClient($client_id){
        $client = $this->getClientDetails($client_id, true);
        if(!$client)
            return false;
        return empty($client->secret);
    }
    
    
    /* OAuth2\Storage\ClientInterface --------------------------------------- */
    
    public function checkRestrictedGrantType($client_id, $grant_type){
        $client = $this->getClientDetails($client_id, true);
        if(!$client)
            return false;
        return in_array($grant_type, $client->grant_type);
    }
    
    public function getClientDetails($client_id, $complete=false){
        $client = $this->last_client;
        
        if(!$client || $client->id != $client_id){
            $client = OClient::get(['id'=>$client_id], false);
            if(!$client)
                return false;
            $client->grant_type = explode(' ', $client->grant_type);
            $this->last_client = $client;
        }
        
        if($complete)
            return $client;
        
        return [
            'redirect_uri'  => $client->redirect,
            'client_id'     => $client->id,
            'grant_types'   => $client->grant_type,
            'user_id'       => $client->user,
            'scope'         => $client->scope
        ];
    }
    
    public function getClientScope($client_id){
        $client = $this->getClientDetails($client_id, true);
        if(!$client)
            return false;
        return $client->scope;
    }
    
    
    /* OAuth2\Storage\JwtAccessTokenInterface -------------------------------- */
    
    // implement AccessTokenInterface
    
    
    /* OAuth2\Storage\JwtBearerInterface ------------------------------------- */
    
    public function getClientKey($client_id, $subject){
        deb('getClientKey', $client_id, $subject);
    }
    
    public function getJti($client_id, $subject, $audience, $expiration, $jti){
        deb('getJti', $client_id, $subject, $audience, $expiration, $jti);
    }
    
    public function setJti($client_id, $subject, $audience, $expiration, $jti){
        deb('setJti', $client_id, $subject, $audience, $expiration, $jti);
    }
    
    
    /* OAuth2\Storage\PublicKeyInterface ------------------------------------- */
    
    public function getPublicKey($client_id=null){
        return file_get_contents(BASEPATH . '/etc/oauth2/pubkey.pem');
    }
    
    public function getPrivateKey($client_id=null){
        return file_get_contents(BASEPATH . '/etc/oauth2/privkey.pem');
    }
    
    public function getEncryptionAlgorithm($client_id=null){
        return 'RS256';
    }
    
    
    /* OAuth2\Storage\RefreshTokenInterface ---------------------------------- */
    
    public function getRefreshToken($refresh_token, $complete=false){
        $rtoken = $this->last_refresh_token;
        
        if(!$rtoken || $rtoken->refresh_token != $refresh_token){
            $rtoken = ORToken::get(['refresh_token'=>$refresh_token], false);
            if(!$rtoken)
                return;
            $this->last_refresh_token = $rtoken;
        }
        
        if($complete)
            return $rtoken;
        
        return [
            'refresh_token' => $rtoken->refresh_token,
            'client_id'     => $rtoken->client,
            'user_id'       => $rtoken->user,
            'scope'         => $rtoken->scope,
            'expires'       => strtotime($rtoken->expires)
        ];
    }
    
    public function setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope=null){
        ORToken::create([
            'refresh_token' => $refresh_token,
            'client'        => $client_id,
            'user'          => $user_id,
            'scope'         => $scope,
            'expires'       => date('Y-m-d H:i:s', $expires)
        ]);
    }
    
    public function unsetRefreshToken($refresh_token){
        ORToken::remove(['refresh_token'=>$refresh_token]);
        if($this->last_refresh_token && $refresh_token == $this->last_refresh_token->refresh_token)
            $this->last_refresh_token = null;
    }
    
    
    /* OAuth2\Storage\ScopeInterface ----------------------------------------- */
    
    public function scopeExists($scope){
        $this->getDefaultScope();
        return isset($this->scopes[$scope]);
    }
    
    public function getDefaultScope($client_id=null){
        if($this->scope_default)
            return $this->scope_default;
        
        $scopes = OScope::get([]);
        if(!$scopes)
            return null;
        
        $scope_default = [];
        foreach($scopes as $scope){
            if($scope->default)
                $scope_default[] = $scope->name;
            $this->scopes[$scope->name] = $scope;
        }
        
        if(!$scope_default)
            return null;
        $this->scope_default = implode(' ', $scope_default);
        
        return $this->scope_default;
    }
    
    
    /* OAuth2\Storage\UserCredentialsInterface ------------------------------- */
    
    public function checkUserCredentials($username, $password){
        $dis = \Phun::$dispatcher;
        $user = $dis->user->getByCred($username, $password);
        if(!$user)
            return false;
        
        return (bool)($this->last_user = $user);
    }
    
    public function getUserDetails($username){
        $user = $this->last_user;
        if(!$user || $user->name != $username){
            $this->last_user_scope = null;
            $user = User::get(['name'=>$username], false);
            if(!$user)
                return false;
            $this->last_user = $user;
        }
        
        if(!$this->last_user_scope){
            $user_scope = OUser::get(['user'=>$user->id], false);
            if($user_scope)
                $this->last_user_scope = $user_scope->scope;
        }
        
        return [
            'user_id' => $user->id,
            'scope'   => $this->last_user_scope
        ];
    }
}