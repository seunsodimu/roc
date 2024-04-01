<?php

namespace App\Controllers;

use Kinde\KindeSDK\KindeClientSDK;
use Kinde\KindeSDK\Configuration;
use Kinde\KindeSDK\Sdk\Enums\GrantType;

class Auth extends BaseController
{
    private $kindeClient;
    private $kindeConfig;
    

    public function __construct()
    {

        $this->kindeClient = new KindeClientSDK(getenv("KINDE_HOST"), getenv("KINDE_REDIRECT_URL"), getenv("KINDE_CLIENT_ID"), getenv("KINDE_CLIENT_SECRET"), getenv("KINDE_GRANT_TYPE"), getenv("KINDE_LOGOUT_REDIRECT_URL"));
		$this->kindeConfig = new Configuration();
		$this->kindeConfig->setHost("KINDE_HOST");

    }

    public function login()
    {
        if (!$this->kindeClient->isAuthenticated) {
        $this->kindeClient->login(['org_code'=>getenv('KINDE_ORG_ID')]);
        // $authy = $this->kindeClient->getUserDetails();
        // var_dump($authy); exit;
    }
    }

    public function logout()
    {
        $this->kindeClient->logout();
    }

    public function register()
    {
        $this->kindeClient->register();
    }

    public function callback()
    {
        $token = $this->kindeClient->getToken();
		$this->kindeConfig->setAccessToken($token->access_token);
		var_dump($token); 
        //echo "<br>is auth: "; print($this->kinde->isAuthenticated());
    }
}