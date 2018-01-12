<?php

/**
 * @file
 * Contains \WordPressProject\composer\ScriptHandler.
 */

namespace WordPressProject\composer;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ScriptHandler
{

  protected static function getWordPressRoot($project_root)
  {
    return $project_root .  '/web';
  }

  public static function createRequiredFiles(Event $event)
  {
    $fs = new Filesystem();
    $root = static::getWordPressRoot(getcwd());

    $dirs = [
      'wp-content/plugins',
      'wp-content/themes',
      'wp',
      'private/scripts/quicksilver',
    ];

    // Required for unit testing
    foreach ($dirs as $dir) {
      if (!$fs->exists($root . '/'. $dir)) {
        $fs->mkdir($root . '/'. $dir);
        $fs->touch($root . '/'. $dir . '/.gitkeep');
      }
    }

    // Create the files directory with chmod 0777
    if (!$fs->exists($root . '/wp-content/uploads')) {
      $oldmask = umask(0);
      $fs->mkdir($root . '/wp-content/uploads', 0777);
      umask($oldmask);
      $event->getIO()->write("Create a wp-content/uploads directory with chmod 0777");
    }
  }
}
