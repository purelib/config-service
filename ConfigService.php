<?php
namespace PureLib\Service;

use Zend\Config\Factory;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConfigService implements \PureLib\Base\ServiceFactoryInterface {

    public function createService (ServiceLocatorInterface $serviceLocator) {

        if (!$serviceLocator->has('configType')) {
            return false;
        }

        $type = $serviceLocator->get('configType');

        if ($type === 'file') {

            if (!$serviceLocator->has('configFiles')) {
                return false;
            }

            $configFiles = $serviceLocator->get('configFiles');

            if (!function_exists('yaml_parse')) {
                \Zend\Config\Factory::registerReader( 'yaml',
                    new \Zend\Config\Reader\Yaml('\Symfony\Component\Yaml\Yaml::parse')
                );
            }

            $config = Factory::fromFiles($configFiles);
            return $config;
        }

        // @todo config type : string

        return false;
    }
}