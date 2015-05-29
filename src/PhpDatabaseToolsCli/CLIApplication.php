<?php

namespace PhpDatabaseToolsCli;
use CLIFramework\Application;

class CLIApplication extends Application
{

    const NAME = 'PhpDatabaseToolsCli';
    const VERSION = '0.1';

    /* init your application options here */
    public function options($opts)
    {
        $opts->add('v|verbose', 'verbose message');
        $opts->add('path:', 'required option with a value.');
        $opts->add('path?', 'optional option with a value');
        $opts->add('path+', 'multiple value option.');
    }

    /* register your command here */
    public function init()
    {
        $this->command('help');
        $this->command('compare');
    }

}
