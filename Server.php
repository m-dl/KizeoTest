<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Server
 *
 * @author Maxime
 */
class Server {
    // un serveur a une localisation
    private $location;
    
    function __construct($location) {
        $this->location = $location;
    }

    function getLocation() {
        return $this->location;
    }

    function setLocation($location) {
        $this->location = $location;
    }
}
