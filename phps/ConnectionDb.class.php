<?php
class DbCommands{
    private $dbDatas = array("localhost","root","1234");
    private $connectionLink;
    function __construct($dbName){
        $this->connectionLink = new mysqli($this->dbDatas[0],$this->dbDatas[1],$this->dbDatas[2],$dbName);
    }
    //even more methodssss
};
?>