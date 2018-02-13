<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServerList
 *
 * @author Maxime
 */

include_once 'Server.php';

class ServerList {
    
    // une liste (tableau) de serveurs
    private $serverList;
    
    function __construct() {
        $this->serverList = array();
        // ajouter les serveurs ici ...
        array_push($this->$serverList, new Server("/France"));
        array_push($this->$serverList, new Server("/Allemagne"));
        //array_push($serverList, new Server("/Italie"));
    }

    function getServerList() {
        return $this->serverList;
    }

    function setServerList($serverList) {
        $this->serverList = $serverList;
    }
}
