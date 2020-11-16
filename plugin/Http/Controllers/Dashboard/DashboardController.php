<?php

namespace Visually\Http\Controllers\Dashboard;

use Visually\Http\Controllers\Controller;

class DashboardController extends Controller
{

	/**
	 * @return \Visually\WPBones\View\View
	 */
  public function index()
  {
    return Visually()->view( 'dashboard.index' );
  }
}
