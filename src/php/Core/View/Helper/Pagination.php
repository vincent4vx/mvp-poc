<?php

namespace Quatrevieux\Mvp\Core\View\Helper;

use Closure;
use Quatrevieux\Mvp\Core\Router;

final class Pagination implements \Stringable
{
    private int $currentPage = 1;
    private int $totalPages = 1;
    private string $class = 'pagination';
    private int $maxPages = 10;

    public function __construct(
        private readonly Router $router,
        /**
         * @var Closure(int):object
         */
        private readonly Closure $queryGenerator,
    ) {
    }

    public function currentPage(int $currentPage): Pagination
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    public function totalPages(int $totalPages): Pagination
    {
        $this->totalPages = $totalPages;
        return $this;
    }

    public function class(string $class): Pagination
    {
        $this->class = $class;
        return $this;
    }

    public function maxPages(int $maxPages): Pagination
    {
        $this->maxPages = $maxPages;
        return $this;
    }

    public function __toString(): string
    {
        $generator = $this->queryGenerator;

        if ($this->totalPages <= 1) {
            return '';
        }

        $html = sprintf('<ul class="%s">', $this->class);

        if ($this->currentPage > 1) {
            $html .= sprintf(
                '<li class="page-item"><a class="page-link" href="%s">Previous</a></li>',
                $this->router->generate($generator($this->currentPage - 1))
            );
        } else {
            $html .= '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
        }

        $start = max(1, $this->currentPage - $this->maxPages / 2);
        $end = min($this->totalPages, $start + $this->maxPages - 1);
        $start = max(1, $end - $this->maxPages + 1);

        for ($i = $start; $i <= $end; ++$i) {
            $html .= sprintf(
                '<li class="page-item%s"><a class="page-link" href="%s">%d</a></li>',
                $i === $this->currentPage ? ' active' : '',
                $this->router->generate($generator($i)),
                $i
            );
        }

        if ($this->currentPage < $this->totalPages) {
            $html .= sprintf(
                '<li class="page-item"><a class="page-link" href="%s">Next</a></li>',
                $this->router->generate($generator($this->currentPage + 1))
            );
        } else {
            $html .= '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
        }

        return $html . '</ul>';
    }
}
