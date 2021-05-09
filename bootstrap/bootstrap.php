<?php
use Managers\DatabaseManager;

require_once "../vendor/autoload.php";
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

function load_classphp($directory) {
    if(is_dir($directory)) {
        $scan = scandir($directory);
        unset($scan[0], $scan[1]); //unset . and ..
        foreach($scan as $file) {
            if(is_dir($directory."/".$file)) {
                load_classphp($directory."/".$file);
            } else {
                if(strpos($file, '.class.php') !== false) {
                    require_once $directory."/".$file;
                }
            }
        }
    }
}

load_classphp('./../src');

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/../src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../database/db.sqlite',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
DatabaseManager::init($entityManager);