<?php

namespace AppBundle\Composer;

use Symfony\Component\ClassLoader\ClassCollectionLoader;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;
use Composer\Script\Event;

class ScriptHandler
{
    public static function build(Event $event)
    {
        $event->getIO()->write('----------------UPDATE FINISHED----------------');
    }
}