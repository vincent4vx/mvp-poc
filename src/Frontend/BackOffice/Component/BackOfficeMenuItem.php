<?php

namespace Quatrevieux\Mvp\Frontend\BackOffice\Component;

class BackOfficeMenuItem
{
    /**
     * @var array<class-string, class-string>
     */
    private array $requests = [];

    /**
     * @var array<class-string, string>
     */
    private array $sub = [];

    public function __construct(
        public readonly string $label,
        public readonly object $request,
    ) {
    }

    public function with(string $request): self
    {
        $this->requests[$request] = $request;

        return $this;
    }

    /**
     * @param string $label
     * @param class-string $request
     * @return $this
     */
    public function sub(string $label, string $request): self
    {
        $this->requests[$request] = $request;
        $this->sub[$request] = $label;

        return $this;
    }

    public function hasSubItems(): bool
    {
        return !empty($this->sub);
    }

    public function subItems(): array
    {
        return $this->sub;
    }

    public function active(object $request): bool
    {
        return $this->request instanceof ($request::class) || isset($this->requests[$request::class]);
    }
}
