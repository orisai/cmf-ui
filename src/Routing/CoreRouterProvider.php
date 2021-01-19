<?php declare(strict_types = 1);

namespace OriCMF\UI\Routing;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\Routing\Router;

final class CoreRouterProvider implements RouterProvider
{

	public function getRouter(): Router
	{
		$router = new RouteList();

		$router[] = new Route('/admin/sign/in', 'OriCMF:UI:Admin:Sign:In:default');
		$router[] = new Route('/admin/error', 'OriCMF:UI:Admin:Error:default');

		$router[] = new Route('/sign/in', 'OriCMF:UI:Front:Sign:In:default');
		$router[] = new Route('/error', 'OriCMF:UI:Front:Error:default');

		return $router;
	}

}
