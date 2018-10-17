<?php

class Authentication
{
    protected $api_token = "thisismycustomapikeystringtovalidatearequest";
    protected $JWT_token = "secret_server_key";

    private $origin = array("graafschapcollege.nl", "localhost", "www.google.com");

    function validate($headers){
        $jwt = new JWT();

        //Validate JWTToken
        if(isset($headers['JWTtoken'])){
            try{
                if($jwt::decode($headers['JWTtoken'], $this->JWT_token)){
                    return true;
                }
            }catch (Exception $e){
                echo '{';
                echo '"Message": "Huehuehue, you tried to fake the JWTtoken, and you failed! Better luck next time!"';
                echo '}';
                exit;
            }
        }
//Validate API_KEY
        else if(isset($headers['x-api-key'])){
            if($this->validateKey($headers['x-api-key'])){
                $token = array();
                $token['id'] = "username_here";
                echo '{';
                echo '"JWTtoken": "' . $jwt::encode($token, $this->JWT_token) . '"';
                echo '}';
                exit;
            }
            else{
                echo '{';
                echo '"Message": "Wrong api-key!!! Try again!"';
                echo '}';
                exit;
            }
        }
        else if(isset($headers['Origin'])) {
            $request_origin = $headers['Origin'];
            if($this->validateOrigin($request_origin)){
                echo '{';
                echo '"x-api-key": "' . $this->getToken() .'"';
                echo '}';
                exit;
            } else {
                echo '{';
                echo '"Error": "Access denied for this domain!"';
                echo '}';
                exit;
            }
        }
        else{
            echo '{';
            echo '"Error": "No headers sent! Cant verify origin of request or validate auth token!"';
            echo '}';
            exit;
        }
        return true;
    }

    private function validateKey($key){
        if($key === $this->api_token){
            return true;
        }
        return false;
    }

    private function validateOrigin($origin){
        if(in_array($origin, $this->origin)){
            return true;
        }
        return false;
    }

    private function getToken(){
        return $this->api_token;
    }
}
?>