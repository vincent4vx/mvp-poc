<?php

namespace Quatrevieux\Mvp\Core\Util;

use ArrayIterator;
use CallbackFilterIterator;
use Closure;
use Composer\Autoload\ClassLoader;
use Exception;
use IteratorAggregate;
use IteratorIterator;
use PhpToken;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Traversable;

use function class_exists;
use function file_get_contents;
use function interface_exists;
use function is_array;
use function is_file;
use function is_readable;
use function is_subclass_of;
use function realpath;
use function str_replace;
use function str_starts_with;
use function strlen;
use function substr;

/**
 * @template T as object
 *
 * @extends IteratorAggregate<class-string<T>>
 */
class ClassNameIterator extends IteratorIterator
{
    public function __construct(?iterable $inner = null)
    {
        $inner ??= self::allClasses();

        if (is_array($inner)) {
            $inner = new ArrayIterator($inner);
        }

        parent::__construct($inner);
    }

    public function filter(Closure $predicate): self
    {
        return new self(new CallbackFilterIterator($this, $predicate));
    }

    public function namespace(string $namespace): self
    {
        return $this->filter(static fn (string $class): bool => str_starts_with($class, $namespace));
    }

    /**
     * @param class-string<I> $interface
     * @return self<I>
     *
     * @template I as object
     */
    public function implements(string $interface): self
    {
        return $this->filter(static fn (string $class): bool => is_subclass_of($class, $interface));
    }

    /**
     * @return iterable<class-string>
     */
    private static function allClasses(): iterable
    {
        foreach (ClassLoader::getRegisteredLoaders() as $classLoader) {
            foreach ($classLoader->getClassMap() as $class => $path) {
                if (class_exists($class) || interface_exists($class)) {
                    yield $class;
                }
            }

            foreach ($classLoader->getPrefixesPsr4() as $prefix => $paths) {
                foreach ($paths as $path) {
                    $iterator = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
                        RecursiveIteratorIterator::LEAVES_ONLY
                    );

                    $path = realpath($path);

                    foreach ($iterator as $file) {
                        $class = $prefix . str_replace(
                            ['/', '.php'],
                            ['\\', ''],
                            substr($file->getRealPath(), strlen($path) + 1)
                        );

                        if (class_exists($class, false) || interface_exists($class, false) || self::isClassFile($class, $file->getRealPath())) {
                            yield $class;
                        }
                    }
                }
            }
        }
    }

    private static function isClassFile(string $expectedClass, string $file): bool
    {
        if (!is_file($file) || !is_readable($file)) {
            return false;
        }

        $classBaseName = str_contains($expectedClass, '\\') ? substr($expectedClass, strrpos($expectedClass, '\\') + 1) : $expectedClass;
        $tokens = PhpToken::tokenize(file_get_contents($file));

        $isClass = false;
        $foundClass = false;

        foreach ($tokens as $token) {
            if ($token->is(T_WHITESPACE)) {
                continue;
            }

            if ($token->is(T_CLASS) || $token->is(T_INTERFACE)) {
                $isClass = true;
            } elseif ($isClass && $token->is(T_STRING) && $token->text === $classBaseName) {
                $foundClass = true;
                break;
            } else {
                $isClass = false;
            }
        }

        return $foundClass;
    }
}
