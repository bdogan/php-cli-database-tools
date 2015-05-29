<?php

namespace PhpDatabaseToolsCli\Command;

use CLIFramework\Command;
use PhpDatabaseTools;

use Exception;

class CompareCommand extends Command {

  public function brief() {
    return 'Compare 2 Mysql Databases and Outputs revision sql';
  }

  public function options($opts)
  {
    $opts->add('server1:', 'Referance database server \'user:pass@host\'');
    $opts->add('server2:', 'Target database server \'user:pass@host\'');
    $opts->add('referance:', 'Referance database')->isa('string');
    $opts->add('target:', 'Target database')->isa('string');
    $opts->add('only-check', 'Only Check');
  }

  public function execute()
  {

    $serverPattern = '/([a-z|A-Z|0-9]*)?:([a-z|A-Z|0-9]*)?@(.*)/';
    $server1 = $this->options->server1;
    if (!preg_match($serverPattern, $server1, $server1)) throw new Exception("Invalid option 'server1'");

    $server2 = $this->options->server2;
    if (!preg_match($serverPattern, $server2, $server2)) throw new Exception("Invalid option 'server2'");

    $referanceDb = $this->options->referance;
    $targetDb = $this->options->target;
    $dbPattern = '/.*?/';
    if (!is_string($referanceDb) || empty($referanceDb)) throw new Exception("Invalid option 'referance'");
    if (!is_string($targetDb) || empty($targetDb)) throw new Exception("Invalid option 'target'");

    $server1 = array("server" => $server1[3], "username" => $server1[1], "password" => $server1[2], "database" => $referanceDb);
    $server2 = array("server" => $server2[3], "username" => $server2[1], "password" => $server2[2], "database" => $targetDb);

    $Generator = new PhpDatabaseTools\Generator();

    $refDbSchema = $Generator->Generate($server1);
    $targetDbSchema = $Generator->Generate($server2);

    if (!PhpDatabaseTools\Compare::isSame($refDbSchema, $targetDbSchema))
    {
      echo PhpDatabaseTools\Compare::revisionSql($refDbSchema, $targetDbSchema);
    }
    
  }

}
