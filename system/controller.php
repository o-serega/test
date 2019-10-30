<?php
class controller{

    public $resultBD;


    public function __construct() {

        $this->resultBD = new mysqli(DB_LOCAL,DB_USERNAME,DB_PASSWORD,DB_BASE);
        //если произошла ошибка то выводим сообщение
        $this->resultBD->ping();
            
        if (!$this->resultBD)
              throw new Exception('Не удалось подключиться к базе данных.');
       

       
        if(getFilter::filter('modul', 'str') == 'statusy'){  
        
            require_once('modul/statusy.php');
            statusy::fnStatusy();
 
        }elseif(getFilter::filter('modul', 'str') == 'anekdoty'){  
        
            require_once('modul/anekdoty.php');
            anekdoty::fnAnekdoty();
            
        }elseif(getFilter::filter('modul', 'str') == 'lenta'){  
        
            require_once('modul/lenta.php');
            lenta::fnLenta();
            
        }elseif(getFilter::filter('modul', 'str') == 'congratulations'){  
        
            require_once('modul/congratulations.php');
            congratulations::fnCongratulations();
            
        }
        elseif(getFilter::filter('modul', 'str') == 'aphorisms'){  
        
            require_once('modul/aphorisms.php');
            aphorisms::fnAphorisms();
            
        }elseif(getFilter::filter('modul', 'str') == 'fotoprikoly'){  
        
            require_once('modul/fotoprikoly.php');
            fotoprikoly::fnFotoprikoly();
            
        }elseif(getFilter::filter('modul', 'str') == 'user'){  
        
            require_once('modul/user.php');
            user::fnUser();
            
        }elseif(getFilter::filter('modul', 'str') == 'support'){  
        
            require_once('modul/support.php');
            support::fnSupport();
            
        }elseif(getFilter::filter('modul', 'str') == 'cookiepolicy'){  
        
            require_once('modul/cookiepolicy.php');
            cookiepolicy::fnCookiepolicy();
            
        }elseif(getFilter::filter('modul', 'str') == 'about'){  
        
            require_once('modul/about.php');
            about::fnAbout();
            
        }elseif(getFilter::filter('modul', 'str') == 'autorizaciya' and getFilter::filter('cats', 'str') == ''){  
        
            require_once('modul/support.php');
            support::fnSupport();
            
        }elseif(getFilter::filter('modul', 'str') == 'js'){
                
                require_once('system/js.php');
                js::fnJs();
               
        }elseif(getFilter::filter('modul', 'str') == 'ajax'){
                
                require_once('system/ajax.php');
                ajax::fnAjax();
               
        }elseif(getFilter::filter('modul', 'str') == ''){
    
                require_once('modul/anekdoty.php');
                anekdoty::fnAnekdoty();
               
        }elseif(getFilter::filter('modul', 'str') == 'interesting'){
                
                require_once('modul/interesting.php');
                interesting::fnInteresting();
               
        }else{
            header('Location: /404.php');
        }
        
    }
    
}

?>