<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of File
 *
 * @author Maxime
 */
class File {
    
    // un fichier a une nom et un contenu
    private $name, $content;
    
    function __construct($name, $content) {
        $this->name = $name;
        $this->content = $content;
    }
    
    function getName() {
        return $this->name;
    }

    function getContent() {
        return $this->content;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setContent($content) {
        $this->content = $content;
    }

}
