<?php

namespace Quatrevieux\Mvp\Core;

use Composer\Autoload\ClassLoader;

use function str_starts_with;

class AttributeRouterLoader
{
    public function __construct(
        private readonly string $namespace,
    ) {
    }

    public function load(): Router
    {
        $paths = [];

        foreach ($this->classNames() as $class) {
            $reflection = new \ReflectionClass($class);

            if ($reflection->isAbstract()) {
                continue;
            }

            $route = $reflection->getAttributes(Route::class);

            if (!$route) {
                continue;
            }

            $path = $route[0]->newInstance()->path;

            if (isset($paths[$path])) {
                throw new \RuntimeException("Duplicate route path '$path'");
            }

            $paths[$path] = $class;
        }

        return new Router($paths);
    }

    /**
     * @return list<class-string>
     */
    private function classNames(): array
    {
        $classes = [];

        foreach (ClassLoader::getRegisteredLoaders() as $classLoader) {
            foreach ($classLoader->getClassMap() as $class => $path) {
                if (str_starts_with($class, $this->namespace) && class_exists($class)) {
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

                            if (str_starts_with($class, $this->namespace) && class_exists($class)) {
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

#[\Attribute(\Attribute::TARGET_CLASS)]
final class Route
{
    public function __construct(
        public readonly string $path
    ) {

    }
}
