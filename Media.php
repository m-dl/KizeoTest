<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Media
 *
 * @author Maxime
 */

include_once 'File.php';
include_once 'ServerList.php';
include_once 'Server.php';

class Media {
    
    // lire un fichier
    static public function getFile($filename) {
        // si le fichier existe sur le serveur où l'on se situe, on le lit, sinon on le lit
        // et il faut aussi l'écrire
        if (file_exists($_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR.$filename))
            // lire seulement un fichier
            getOnlyFile($filename);
        else
            // lire puis écrire un fichier
            getAndWriteFile($filename);
    }
    
    // écrire un fichier vers plusieurs endroits
    static public function setFiles($filename, $content) {
        // on récupère la liste des serveurs
        $serverList = new ServerList();
        // parcourt la liste des serveurs 
        foreach ($serverList->getServerList() as $server) {
            // on va aller écrire le fichier sur le serveur
            setSingleFile($server->getLocation().DIRECTORY_SEPARATOR.$filename, $content);
        }
    }
    
    // écrire le fichier à l'endroit donné
    static public function setSingleFile($filename, $content) {
        try {
            // écriture du fichier, accès concurrent bloqué
            $flag = file_put_contents($filename, $content | LOCK_EX);
            // si aucune erreur alors succès
            if($flag) 
                echo "Ecriture du fichier réalisée avec succès.";
            else
                echo "Erreur : lors de l'écriture du fichier (accès concurrent possible).";
        } catch (Exception $e) {
            // gestion message d'erreur  
            echo $e->getMessage();
        }
    }
    
    // trouver un fichier parmi les serveurs
    static public function findFile($filename) {
        // on récupère la liste des serveurs
        $serverList = new ServerList();
        // on enlève le serveur sur lequel on se situe car on sait déjà que le fichier ne s'y trouve pas
        array_diff($serverList->getServerList(), [$_SERVER['SERVER_NAME']]);
        // parcourt la liste des serveurs
        foreach ($serverList->getServerList() as $server) {
            try {
                // si le fichier est trouvé sur le serveur 
                if (file_exists($server->getLocation().DIRECTORY_SEPARATOR.$filename))
                    // on return son adresse et on quitte la recherche (la boucle)
                    return $server->getLocation().DIRECTORY_SEPARATOR.$filename; 
            } catch (Exception $e) {
                // gestion message d'erreur
                echo $e->getMessage();
            }
        }
        return NULL;
    }
    
    // lire seulement un fichier
    static public function getOnlyFile($filename) {
        try {
            // on lit le contenu
            $content = file_get_contents($_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR.$filename);
            // si le contenu est bien récupéré sans erreur
            if($content)
                // on l'affiche
                echo $content;
            else
                echo "Erreur : lors de la lecture du fichier.";
        } catch (Exception $e) {
            // gestion message d'erreur
            echo $e->getMessage();
        }
    }
    
    // lire puis écrire un fichier
    static public function getAndWriteFile($filename) {
        // on doit aller chercher où se trouve ce fichier sinon
        $path = findFile($filename);
        // si on a trouvé une adrese
        if($path) {
            try {
                // on lit le contenu
                $content = file_get_contents($path);
                // si le contenu est bien récupéré sans erreur
                if($content) {
                    // on l'affiche
                    echo $content;
                    // et on oublie pas d'écrire de fichier sur le serveur actuel comme ça, on l'aura en accès 
                    // lecture direct pour les prochaines fois
                    setSingleFile($_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR.$filename, $content);
                }
                else
                    echo "Erreur : lors de la lecture du fichier.";
            } catch (Exception $e) {
                // gestion message d'erreur
                echo $e->getMessage();
            }
        }
        else
            echo "Erreur : le fichier est introuvable sur les serveurs.";
    }
}