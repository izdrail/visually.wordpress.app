<?php

namespace Visually\Console;

use Visually\WPBones\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  protected $commands = [
    'Visually\Console\Commands\Import',
  ];
}