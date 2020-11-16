<?php

namespace Visually\WPBones\Contracts\Foundation;

use Visually\WPBones\Contracts\Container\Container;

interface Plugin extends Container {

  /**
   * Get the base path of the Plugin installation.
   *
   * @return string
   */
  public function getBasePath();
}