<?php
    function emailAliasDelete($email){
        $domain = substr($email,strpos($email,'@'));
        $name = str_replace($domain,'',$email);
        if(strpos($name,'+')){
            $name = substr($name,0,(strpos($name,'+'))-(strlen($name)));
        }
        $sanitizedEmail = str_replace(['.','_'],'',$name).$domain;
        return $sanitizedEmail;
    }
?>