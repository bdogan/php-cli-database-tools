<?php
  require_once __DIR__ . '/vendor/autoload.php';

  try
  {
    $app = new \PhpDatabaseToolsCli\CLIApplication();
    $app->run($argv);
    exit(0);
  }
  catch (Exception $e)
  {
    echo $e->getMessage() . "\r\n";
    exit(1);
  }

?>
