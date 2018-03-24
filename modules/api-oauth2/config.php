<?php
/**
 * api-oauth2 config file
 * @package api-oauth2
 * @version 0.0.1
 * @upgrade true
 */

return [
    '__name' => 'api-oauth2',
    '__version' => '0.0.1',
    '__git' => 'https://github.com/getphun/api-oauth2',
    '__files' => [
        'modules/api-oauth2'    => ['install','remove','update'],
        'etc/oauth2'            => ['install','remove']
    ],
    '__dependencies' => [
        'user',
        'api',
        'db-mysql'
    ],
    '_services' => [
        'app' => 'ApiOauth2\\Service\\App'
    ],
    '_autoload' => [
        'classes' => [
            'ApiOauth2\\Service\\App' => 'modules/api-oauth2/service/App.php',
            'ApiOauth2\\Model\\Oauth2Client' => 'modules/api-oauth2/model/Oauth2Client.php',
            'ApiOauth2\\Model\\Oauth2AccessToken' => 'modules/api-oauth2/model/Oauth2AccessToken.php',
            'ApiOauth2\\Model\\Oauth2AuthorizationCode' => 'modules/api-oauth2/model/Oauth2AuthorizationCode.php',
            'ApiOauth2\\Model\\Oauth2RefreshToken' => 'modules/api-oauth2/model/Oauth2RefreshToken.php',
            'ApiOauth2\\Model\\Oauth2Scope' => 'modules/api-oauth2/model/Oauth2Scope.php',
            'ApiOauth2\\Model\\Oauth2User' => 'modules/api-oauth2/model/Oauth2User.php',
            'ApiOauth2\\Controller\\AuthController' => 'modules/api-oauth2/controller/AuthController.php',
            'ApiOauth2\\Library\\Storage' => 'modules/api-oauth2/library/Storage.php',
            
            'OAuth2\\Autoloader' => 'modules/api-oauth2/third-party/OAuth2/Autoloader.php',
            'OAuth2\\ClientAssertionType\\ClientAssertionTypeInterface' => 'modules/api-oauth2/third-party/OAuth2/ClientAssertionType/ClientAssertionTypeInterface.php',
            'OAuth2\\ClientAssertionType\\HttpBasic' => 'modules/api-oauth2/third-party/OAuth2/ClientAssertionType/HttpBasic.php',
            'OAuth2\\Controller\\AuthorizeController' => 'modules/api-oauth2/third-party/OAuth2/Controller/AuthorizeController.php',
            'OAuth2\\Controller\\AuthorizeControllerInterface' => 'modules/api-oauth2/third-party/OAuth2/Controller/AuthorizeControllerInterface.php',
            'OAuth2\\Controller\\ResourceController' => 'modules/api-oauth2/third-party/OAuth2/Controller/ResourceController.php',
            'OAuth2\\Controller\\ResourceControllerInterface' => 'modules/api-oauth2/third-party/OAuth2/Controller/ResourceControllerInterface.php',
            'OAuth2\\Controller\\TokenController' => 'modules/api-oauth2/third-party/OAuth2/Controller/TokenController.php',
            'OAuth2\\Controller\\TokenControllerInterface' => 'modules/api-oauth2/third-party/OAuth2/Controller/TokenControllerInterface.php',
            'OAuth2\\Encryption\\EncryptionInterface' => 'modules/api-oauth2/third-party/OAuth2/Encryption/EncryptionInterface.php',
            'OAuth2\\Encryption\\FirebaseJwt' => 'modules/api-oauth2/third-party/OAuth2/Encryption/FirebaseJwt.php',
            'OAuth2\\Encryption\\Jwt' => 'modules/api-oauth2/third-party/OAuth2/Encryption/Jwt.php',
            'OAuth2\\GrantType\\AuthorizationCode' => 'modules/api-oauth2/third-party/OAuth2/GrantType/AuthorizationCode.php',
            'OAuth2\\GrantType\\ClientCredentials' => 'modules/api-oauth2/third-party/OAuth2/GrantType/ClientCredentials.php',
            'OAuth2\\GrantType\\GrantTypeInterface' => 'modules/api-oauth2/third-party/OAuth2/GrantType/GrantTypeInterface.php',
            'OAuth2\\GrantType\\JwtBearer' => 'modules/api-oauth2/third-party/OAuth2/GrantType/JwtBearer.php',
            'OAuth2\\GrantType\\RefreshToken' => 'modules/api-oauth2/third-party/OAuth2/GrantType/RefreshToken.php',
            'OAuth2\\GrantType\\UserCredentials' => 'modules/api-oauth2/third-party/OAuth2/GrantType/UserCredentials.php',
            'OAuth2\\OpenID\\Controller\\AuthorizeController' => 'modules/api-oauth2/third-party/OAuth2/OpenID/Controller/AuthorizeController.php',
            'OAuth2\\OpenID\\Controller\\AuthorizeControllerInterface' => 'modules/api-oauth2/third-party/OAuth2/OpenID/Controller/AuthorizeControllerInterface.php',
            'OAuth2\\OpenID\\Controller\\UserInfoController' => 'modules/api-oauth2/third-party/OAuth2/OpenID/Controller/UserInfoController.php',
            'OAuth2\\OpenID\\Controller\\UserInfoControllerInterface' => 'modules/api-oauth2/third-party/OAuth2/OpenID/Controller/UserInfoControllerInterface.php',
            'OAuth2\\OpenID\\GrantType\\AuthorizationCode' => 'modules/api-oauth2/third-party/OAuth2/OpenID/GrantType/AuthorizationCode.php',
            'OAuth2\\OpenID\\ResponseType\\AuthorizationCode' => 'modules/api-oauth2/third-party/OAuth2/OpenID/ResponseType/AuthorizationCode.php',
            'OAuth2\\OpenID\\ResponseType\\AuthorizationCodeInterface' => 'modules/api-oauth2/third-party/OAuth2/OpenID/ResponseType/AuthorizationCodeInterface.php',
            'OAuth2\\OpenID\\ResponseType\\CodeIdToken' => 'modules/api-oauth2/third-party/OAuth2/OpenID/ResponseType/CodeIdToken.php',
            'OAuth2\\OpenID\\ResponseType\\CodeIdTokenInterface' => 'modules/api-oauth2/third-party/OAuth2/OpenID/ResponseType/CodeIdTokenInterface.php',
            'OAuth2\\OpenID\\ResponseType\\IdToken' => 'modules/api-oauth2/third-party/OAuth2/OpenID/ResponseType/IdToken.php',
            'OAuth2\\OpenID\\ResponseType\\IdTokenInterface' => 'modules/api-oauth2/third-party/OAuth2/OpenID/ResponseType/IdTokenInterface.php',
            'OAuth2\\OpenID\\ResponseType\\IdTokenToken' => 'modules/api-oauth2/third-party/OAuth2/OpenID/ResponseType/IdTokenToken.php',
            'OAuth2\\OpenID\\ResponseType\\IdTokenTokenInterface' => 'modules/api-oauth2/third-party/OAuth2/OpenID/ResponseType/IdTokenTokenInterface.php',
            'OAuth2\\OpenID\\Storage\\AuthorizationCodeInterface' => 'modules/api-oauth2/third-party/OAuth2/OpenID/Storage/AuthorizationCodeInterface.php',
            'OAuth2\\OpenID\\Storage\\UserClaimsInterface' => 'modules/api-oauth2/third-party/OAuth2/OpenID/Storage/UserClaimsInterface.php',
            'OAuth2\\Request' => 'modules/api-oauth2/third-party/OAuth2/Request.php',
            'OAuth2\\RequestInterface' => 'modules/api-oauth2/third-party/OAuth2/RequestInterface.php',
            'OAuth2\\Response' => 'modules/api-oauth2/third-party/OAuth2/Response.php',
            'OAuth2\\ResponseInterface' => 'modules/api-oauth2/third-party/OAuth2/ResponseInterface.php',
            'OAuth2\\ResponseType\\AccessToken' => 'modules/api-oauth2/third-party/OAuth2/ResponseType/AccessToken.php',
            'OAuth2\\ResponseType\\AccessTokenInterface' => 'modules/api-oauth2/third-party/OAuth2/ResponseType/AccessTokenInterface.php',
            'OAuth2\\ResponseType\\AuthorizationCode' => 'modules/api-oauth2/third-party/OAuth2/ResponseType/AuthorizationCode.php',
            'OAuth2\\ResponseType\\AuthorizationCodeInterface' => 'modules/api-oauth2/third-party/OAuth2/ResponseType/AuthorizationCodeInterface.php',
            'OAuth2\\ResponseType\\JwtAccessToken' => 'modules/api-oauth2/third-party/OAuth2/ResponseType/JwtAccessToken.php',
            'OAuth2\\ResponseType\\ResponseTypeInterface' => 'modules/api-oauth2/third-party/OAuth2/ResponseType/ResponseTypeInterface.php',
            'OAuth2\\Scope' => 'modules/api-oauth2/third-party/OAuth2/Scope.php',
            'OAuth2\\ScopeInterface' => 'modules/api-oauth2/third-party/OAuth2/ScopeInterface.php',
            'OAuth2\\Server' => 'modules/api-oauth2/third-party/OAuth2/Server.php',
            'OAuth2\\Storage\\AccessTokenInterface' => 'modules/api-oauth2/third-party/OAuth2/Storage/AccessTokenInterface.php',
            'OAuth2\\Storage\\AuthorizationCodeInterface' => 'modules/api-oauth2/third-party/OAuth2/Storage/AuthorizationCodeInterface.php',
            'OAuth2\\Storage\\Cassandra' => 'modules/api-oauth2/third-party/OAuth2/Storage/Cassandra.php',
            'OAuth2\\Storage\\ClientCredentialsInterface' => 'modules/api-oauth2/third-party/OAuth2/Storage/ClientCredentialsInterface.php',
            'OAuth2\\Storage\\ClientInterface' => 'modules/api-oauth2/third-party/OAuth2/Storage/ClientInterface.php',
            'OAuth2\\Storage\\CouchbaseDB' => 'modules/api-oauth2/third-party/OAuth2/Storage/CouchbaseDB.php',
            'OAuth2\\Storage\\DynamoDB' => 'modules/api-oauth2/third-party/OAuth2/Storage/DynamoDB.php',
            'OAuth2\\Storage\\JwtAccessToken' => 'modules/api-oauth2/third-party/OAuth2/Storage/JwtAccessToken.php',
            'OAuth2\\Storage\\JwtAccessTokenInterface' => 'modules/api-oauth2/third-party/OAuth2/Storage/JwtAccessTokenInterface.php',
            'OAuth2\\Storage\\JwtBearerInterface' => 'modules/api-oauth2/third-party/OAuth2/Storage/JwtBearerInterface.php',
            'OAuth2\\Storage\\Memory' => 'modules/api-oauth2/third-party/OAuth2/Storage/Memory.php',
            'OAuth2\\Storage\\Mongo' => 'modules/api-oauth2/third-party/OAuth2/Storage/Mongo.php',
            'OAuth2\\Storage\\MongoDB' => 'modules/api-oauth2/third-party/OAuth2/Storage/MongoDB.php',
            'OAuth2\\Storage\\Pdo' => 'modules/api-oauth2/third-party/OAuth2/Storage/Pdo.php',
            'OAuth2\\Storage\\PublicKeyInterface' => 'modules/api-oauth2/third-party/OAuth2/Storage/PublicKeyInterface.php',
            'OAuth2\\Storage\\Redis' => 'modules/api-oauth2/third-party/OAuth2/Storage/Redis.php',
            'OAuth2\\Storage\\RefreshTokenInterface' => 'modules/api-oauth2/third-party/OAuth2/Storage/RefreshTokenInterface.php',
            'OAuth2\\Storage\\ScopeInterface' => 'modules/api-oauth2/third-party/OAuth2/Storage/ScopeInterface.php',
            'OAuth2\\Storage\\UserCredentialsInterface' => 'modules/api-oauth2/third-party/OAuth2/Storage/UserCredentialsInterface.php',
            'OAuth2\\TokenType\\Bearer' => 'modules/api-oauth2/third-party/OAuth2/TokenType/Bearer.php',
            'OAuth2\\TokenType\\Mac' => 'modules/api-oauth2/third-party/OAuth2/TokenType/Mac.php',
            'OAuth2\\TokenType\\TokenTypeInterface' => 'modules/api-oauth2/third-party/OAuth2/TokenType/TokenTypeInterface.php'
        ],
        'files' => []
    ],
    
    '_routes' => [
        'api' => [
            'apiOauth2AccessToken' => [
                'rule' => '/access_token',
                'handler' => 'ApiOauth2\\Controller\\Auth::accessToken',
                'method' => 'POST'
            ],
            'apiOauth2Authorize' => [
                'rule' => '/authorize',
                'handler' => 'ApiOauth2\\Controller\\Auth::authorize',
                'method' => 'GET'
            ]
        ]
    ],
    
    'apiOauth2' => [
        'token_lifetime' => 3600,
        'loginRouter'    => 'siteUserLogin'
    ]
];