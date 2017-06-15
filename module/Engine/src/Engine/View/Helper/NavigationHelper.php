<?php

namespace Engine\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Mvc\Exception as Exception;
use CurrentRoute\View\Helper\CurrentRoute;

class NavigationHelper extends AbstractHelper
{
    public function __invoke(CurrentRoute $route, $navigationType)
    {
        if (empty($route->getRoute()))
            return;

        switch ($navigationType)
        {
            case 'breadcrumbs':
                return $this->getBreadcrumbs($route);
                break;
            case 'navigationMenu':
                return $this->getNavigationMenu($route);
                break;
            case 'pageTitle':
                return $this->getPageTitle($route);
                break;
            case 'headTitle':
                return $this->getPageTitle($route, true);
                break;
            default:
                return 'Invalid navigationType';
                break;
        }
    }

    public function getBreadcrumbs($route)
    {
        $parts = explode("/", $route->getRoute());

        try {
            $activePage = $this->getPage($parts[0]);
            $rootPage = $this->getPage($parts[0], true);
        }
        catch (\Exception $e)
        {
            return;
        }


        if (empty($activePage) || empty($rootPage))
            return;

        if ($activePage->__get('disableNavigation'))
            return;

        $isRoot = $activePage->__get('isRoot') == $rootPage->__get('isRoot');
        switch ($parts[0])
        {
            default:
                switch ($route->getAction())
                {
                    default:
                        return $this->buildBreadcrumbs($parts[0], 'default', $activePage, $isRoot);
                        break;

                }
                break;
        }
    }

    public function getNavigationMenu($route)
    {
        $parts = explode("/", $route->getRoute());

        try {
            $activePage = $this->getPage($parts[0]);
        }
        catch (\Exception $e)
        {
            return;
        }

        if (empty($activePage))
            return;

        switch ($parts[0])
        {
            default:
                switch ($route->getAction())
                {
                    default:
                        require __DIR__ . '/../../../../view/layout/navigation/navigation_menu/default.phtml';
                        break;
                }
                break;
        }
    }

    public function getPageTitle($route, $clear = false)
    {
        $parts = explode("/", $route->getRoute());
        try {
            $activePage = $this->getPage($parts[0]);}
        catch (\Exception $e)
        {
            return;
        }

        if (empty($activePage)) {
            //echo 'NAVIGATION ERROR;';
            return;
        }

        if ($activePage->__get('disableNavigation') && !$clear)
            return;

        switch ($parts[0])
        {
            default:
                switch ($route->getAction())
                {
                    default:
                        return $this->buildPageTitile($activePage, $clear, 'default');
                        break;
                }
                break;
        }
    }

    private function getPage($name, $isRoot = false)
    {
        $view = $this->view;
        $navigation = empty($name) ? $view->navigation() : $view->navigation($name . '_navigation');
        $page = $navigation->findOneBy($isRoot ? 'isRoot' : 'active', true);
        return $page;
    }

    private function buildBreadcrumbs($navigationName, $name, $page, $isRoot)
    {
        if ($isRoot)
            return str_replace('{$page}', $page,
                    $this->view
                    ->navigation($navigationName . '_navigation')
                    ->breadcrumbs()->setRenderInvisible(true)
                    ->setPartial('layout/navigation/breadcrumb/'.$name.'/root.phtml')->__toString()
                );
        else
            return $this->view
                ->navigation($navigationName . '_navigation')
                ->breadcrumbs()->setRenderInvisible(true)
                ->setPartial('layout/navigation/breadcrumb/'.$name.'/children.phtml');

    }

    private function buildPageTitile($activePage, $clear, $context = 'default')
    {
        $title_before = $clear ? '' :
            $this->view
                ->navigation()
                ->breadcrumbs()->setRenderInvisible(true)
                ->setPartial('layout/navigation/title/context/'. $context .'/before.phtml')->__toString();
        $title_after = $clear ? '' :
            $this->view
                ->navigation()
                ->breadcrumbs()->setRenderInvisible(true)
                ->setPartial('layout/navigation/title/context/'. $context .'/after.phtml')->__toString();
        return $title_before . $activePage . $title_after;

    }
}