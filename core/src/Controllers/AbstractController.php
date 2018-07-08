<?php namespace EvolutionCMS\Controllers;

use EvolutionCMS\Interfaces\ManagerTheme\ControllerInterface;
use EvolutionCMS\Interfaces\ManagerThemeInterface;

abstract class AbstractController implements ControllerInterface
{
    /**
     * @var string
     */
    protected $view;

    /**
     * @var ManagerThemeInterface
     */
    protected $managerTheme;

    /** @var int */
    protected $index;

    /**
     * @inheritdoc
     */
    public function __construct(ManagerThemeInterface $managerTheme)
    {
        $this->managerTheme = $managerTheme;
    }

    /**
     * @inheritdoc
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @inheritdoc
     */
    abstract public function canView(): bool;

    /**
     * @inheritdoc
     */
    abstract public function checkLocked() : ?string;

    /**
     * @inheritdoc
     */
    public function getParameters(array $params = []) : array
    {
        return $params;
    }

    /**
     * @inheritdoc
     */
    public function render(array $params = []) : string
    {
        return $this->managerTheme->view(
            $this->getView(),
            $this->getParameters($params)
        )->render();
    }

    /**
     * @inheritdoc
     */
    public function setIndex($index) : void
    {
        $this->index = $index;
    }

    /**
     * @inheritdoc
     */
    public function getIndex()
    {
        return $this->index;
    }
}
