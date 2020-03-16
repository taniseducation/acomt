<?php

    function runScript($script) {
        $path = dirname(__FILE__)."/../../bin/".$script . " 2>&1";
        exec($path, $output);
    }
    
    function protect() {
        runScript("protect_folder.sh");
    }
    
    function validateEnvironment() {

    }


