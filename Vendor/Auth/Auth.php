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

interface authFunctions {
    public function logOut($login);
}

class Auth{
    const salt=159753;
    private $login;
    private $password;
    private $ip;
    
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


class FinalyAuth extends Auth implements authFunctions{
    public function logOut($login){
        if($_SESSION['login']==$login){
            unset($_SESSION['login']);
            unset($_SESSION['password']);
            unset($_SESSION['ip']);
            session_destroy();
            return true;
        }
        else {
            return false;
        }
    }
}

$a=new FinalyAuth('admin','0000','192.168.1.11');
$a->createAuth();

if($a->checkAuth('admin','0000','192.168.1.11','159753')===true){
    echo 'logined'."\r\n";
}
else {
    echo 'NOT logined'."\r\n";
}

if($a->logOut('admin1')===true){
    echo 'logout DONE'."\r\n";
}
else {
    echo 'logout FAIL. Check login'."\r\n";
}
