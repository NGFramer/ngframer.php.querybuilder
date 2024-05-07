<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

// Non-functional class. Only set's and gets the view name.
Class View {
    private ?string $viewName = null;

    public function getViewName(): string
    {
        return $this->viewName;
    }

    public function setViewName($viewName): void
    {
        $this->viewName = $viewName;
    }
}
