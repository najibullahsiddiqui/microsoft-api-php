<?php


namespace cb\Microsoft\Models;

use GuzzleHttp\Exception\ClientException;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\User;
use cb\Microsoft\Auth;
use cb\Microsoft\Handlers\Session;


/**
 * Base Model
 */
class BaseModel
{
    protected $graph;
    public function graph()
    {
        $this->graph = new Graph();
        $this->graph->setAccessToken(Session::get("accessToken")); 
        return $this->graph;
    }
    public function checkAuthentication() :bool
    {
        $url =  "/me";
        try {
            $user = $this->graph()->createRequest("get",$url)
                ->setReturnType(User::class)
                ->execute();   
        } catch (ClientException $e) {
            return false;
            
        }
        return (null !== $user->getGivenName()) ? true : false ;
    }    
}