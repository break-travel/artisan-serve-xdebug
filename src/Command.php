<?php

namespace BreakTravel\ArtisanServeXdebug;

use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Support\Env;
use ReflectionClass;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Process\PhpExecutableFinder;

#[AsCommand(name: 'serve:xdebug')]
class Command extends ServeCommand
{
    protected $signature = 'serve:xdebug';

    protected $description = 'Serve the application on the PHP development server with XDebug activated';

    protected function serverCommand()
    {
        $reflector = new ReflectionClass(get_parent_class($this));
        $server = dirname($reflector->getFileName()) . '/../resources/server.php';

        return [
            (new PhpExecutableFinder)->find(false),
            '-dxdebug.mode=debug',
            '-dxdebug.start_with_request=yes',
            '-S',
            $this->host() . ':' . $this->port(),
            $server
        ];
    }

    public function option($key = null)
    {
        switch ($key) {
            case 'no-reload':
                return null;
            default:
                parent::option($key);
        }
    }

    protected function host()
    {
        return Env::get('SERVER_HOST', '127.0.0.1');
    }

    protected function port()
    {
        return Env::get('SERVER_PORT', 8000);
    }
}
