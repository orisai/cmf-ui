<?php declare(strict_types = 1);

namespace OriCMF\UI\Routing;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\Routing\Router;
use OriCMF\UI\Admin\Dashboard\Presenter\DashboardPresenter;
use OriCMF\UI\Admin\Error\Presenter\ErrorPresenter as AdminErrorPresenter;
use OriCMF\UI\Admin\Sign\Presenter\SignPresenter as AdminSignPresenter;
use OriCMF\UI\Front\Error\Presenter\ErrorPresenter as FrontErrorPresenter;
use OriCMF\UI\Front\Homepage\Presenter\HomepagePresenter;
use OriCMF\UI\Front\Sign\Presenter\SignPresenter as FrontSignPresenter;
use function ltrim;

final class CoreRouterProvider implements RouterProvider
{

	public function getRouter(): Router
	{
		$router = new RouteList();

		$router[] = new Route('/admin/sign/in', ltrim(AdminSignPresenter::ACTION_IN, ':'));
		$router[] = new Route('/admin/sign/out', ltrim(AdminSignPresenter::ACTION_OUT, ':'));
		$router[] = new Route('/admin/error', ltrim(AdminErrorPresenter::ACTION_DEFAULT, ':'));
		$router[] = new Route('/admin', ltrim(DashboardPresenter::ACTION_DEFAULT, ':'));

		$router[] = new Route('/sign/in', ltrim(FrontSignPresenter::ACTION_IN, ':'));
		$router[] = new Route('/sign/out', ltrim(FrontSignPresenter::ACTION_OUT, ':'));
		$router[] = new Route('/error', ltrim(FrontErrorPresenter::ACTION_DEFAULT, ':'));
		$router[] = new Route('/', ltrim(HomepagePresenter::ACTION_DEFAULT, ':'));

		return $router;
	}

}
