<?php
/*
 * Simple alghoritme for create and destroy auth 
 * status of users in php sessions
 * session have next data 
 * [user] => login
 * [password] => md5($password.$salt)
 * [ip]=> ip
 */
namespace Vendor\Auth;

class Auth{
    const salt=159753;
    private $login;
    private $password;
    private $ip='127.0.0.1';
    
    function __construct($login,$password,$ip){
        $this->login=$login;
        $this->password=$password;
        $this->ip=$ip;
    }
    
    public function createAuth(){
        session_start();
        $_SESSION['login']=$this->login;
        $_SESSION['password']=md5($this->password.self::salt);
        $_SESSION['ip']=$this->ip;
    }
    
    public function checkAuth($login,$password,$ip,$salt){
        $passwordHash=md5($password.$salt);
        if($_SESSION['login']==$login && $_SESSION['password']==$passwordHash && $_SESSION['ip']==$ip){
            return true;
        }
        else{
            return false;
        }
    }
    
}

$a=new Auth('admin','0000','192.168.1.11');
$a->createAuth();
$loginStatus = $a->checkAuth('admin','0000','192.168.1.11','159753');
if($loginStatus===true){
    echo 'logined'."\r\n";
}
else {
    echo 'NOT logined'."\r\n";
}