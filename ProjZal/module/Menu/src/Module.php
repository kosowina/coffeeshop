<?php
namespace Menu;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
	public function getServiceConfig()
		{
			return [
				'factories' => [
					Model\MenuTable::class => function($container) {
						$tableGateway = $container->get(Model\MenuTableGateway::class);
						return new Model\MenuTable($tableGateway);
					},
					Model\MenuTableGateway::class => function ($container) {
						$dbAdapter = $container->get(AdapterInterface::class);
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new Model\Menu());
						return new TableGateway('menu', $dbAdapter, null, $resultSetPrototype);
					},
				],
			];
		}
	public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\MenuController::class => function($container) {
                    return new Controller\MenuController(
                        $container->get(Model\MenuTable::class)
                    );
                },
            ],
        ];
    }
}