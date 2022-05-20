<?php

/**
 * Camada - Controller
 * Diretório Pai - library
 * Arquivo - autoload.php
 * 
 * Essa função garante que todas as classes 
 * da pasta lib serão carregadas automaticamente
 */

session_start();

function listDirectories($directory) {
    $glob = glob($directory . '/*');

    if ($glob === false) {
        return array();
    }

    return array_filter($glob, function($dir) {
        return is_dir($dir);
    });
}

function Autoload($class) {
    $extension = spl_autoload_extensions();

    $BaseLibDIR = 'Library';
    $listLibDir = scandir(realpath($BaseLibDIR));
    if (isset($listLibDir) && !empty($listLibDir)) {
        foreach ($listLibDir as $listDirkey => $subDir) {
            $file = $BaseLibDIR . DIRECTORY_SEPARATOR . $subDir . DIRECTORY_SEPARATOR . $class . $extension;
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }

    $listLibSubDir = listDirectories($BaseLibDIR);
    if (isset($listLibSubDir) && !empty($listLibSubDir)) {
        foreach ($listLibSubDir as $subLibList) {
            $insideLibDirs = listDirectories($subLibList);
            if (isset($insideLibDirs) && !empty($insideLibDirs)) {
                foreach ($insideLibDirs as $idLib) {
                    $fileLibApp = $idLib . DIRECTORY_SEPARATOR . $class . $extension;
                    if (file_exists($fileLibApp)) {
                        require_once $fileLibApp;
                    }
                }
            }
        }
    }

    $BaseDIRApp = 'Application';
    $listDirApp = listDirectories($BaseDIRApp);
    if (isset($listDirApp) && !empty($listDirApp)) {
        foreach ($listDirApp as $subList) {
            $insideDirs = listDirectories($subList);
            if (isset($insideDirs) && !empty($insideDirs)) {
                foreach ($insideDirs as $id) {
                    $fileApp = $id . DIRECTORY_SEPARATOR . $class . $extension;
                    if (file_exists($fileApp)) {
                        require_once $fileApp;
                    }
                }
            }
        }
    }
}

spl_autoload_extensions('.php');
spl_autoload_register('Autoload');