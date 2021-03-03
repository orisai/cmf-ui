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
use function substr;

final class CoreRouterProvider implements RouterProvider
{

	public function getRouter(): Router
	{
		$router = new RouteList();

		$router[] = new Route('/admin/sign/in', substr(AdminSignPresenter::ACTION_IN, 1));
		$router[] = new Route('/admin/sign/out', substr(AdminSignPresenter::ACTION_OUT, 1));
		$router[] = new Route('/admin/error', substr(AdminErrorPresenter::ACTION_DEFAULT, 1));
		$router[] = new Route('/admin', substr(DashboardPresenter::ACTION_DEFAULT, 1));

		$router[] = new Route('/sign/in', substr(FrontSignPresenter::ACTION_IN, 1));
		$router[] = new Route('/sign/out', substr(FrontSignPresenter::ACTION_OUT, 1));
		$router[] = new Route('/error', substr(FrontErrorPresenter::ACTION_DEFAULT, 1));
		$router[] = new Route('/', substr(HomepagePresenter::ACTION_DEFAULT, 1));

		return $router;
	}

}
