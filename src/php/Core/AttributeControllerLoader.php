<?php

namespace Quatrevieux\Mvp\Core;

use Composer\Autoload\ClassLoader;

use function str_starts_with;

class AttributeControllerLoader
{
    public function __construct(
        private readonly string $namespace,
    ) {
    }

    public function load(): array
    {
        $controllers = [];

        foreach ($this->classNames() as $class) {
            $reflection = new \ReflectionClass($class);

            if ($reflection->isAbstract()) {
                continue;
            }

            $attribute = $reflection->getAttributes(Handles::class);

            if (!$attribute) {
                continue;
            }

            $requestClass = $attribute[0]->newInstance()->requestClass;

            if (isset($controllers[$requestClass])) {
                throw new \RuntimeException("Duplicate controller for request '$requestClass'");
            }

            $controllers[$requestClass] = $class;
        }

        return $controllers;
    }

    /**
     * @return list<class-string>
     */
    private function classNames(): array
    {
        $classes = [];

        foreach (ClassLoader::getRegisteredLoaders() as $classLoader) {
            foreach ($classLoader->getClassMap() as $class => $path) {
                if (str_starts_with($class, $this->namespace) && class_exists($class) && is_subclass_of($class, ControllerInterface::class)) {
                    $classes[] = $class;
                }
            }

            foreach ($classLoader->getPrefixesPsr4() as $prefix => $paths) {
                if (str_starts_with($prefix, $this->namespace) || str_starts_with($this->namespace, $prefix)) {
                    foreach ($paths as $path) {
                        $iterator = new \RecursiveIteratorIterator(
                            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
                            \RecursiveIteratorIterator::LEAVES_ONLY
                        );

                        $path = realpath($path);

                        foreach ($iterator as $file) {
                            $class = $prefix . str_replace(
                                ['/', '.php'],
                                ['\\', ''],
                                substr($file->getRealPath(), strlen($path) + 1)
                            );

                            if (str_starts_with($class, $this->namespace) && class_exists($class) && is_subclass_of($class, ControllerInterface::class)) {
                                $classes[] = $class;
                            }
                        }
                    }
                }
            }
        }

        return $classes;
    }
}
