<?php

namespace Bitter\Smartbanner\Provider;

use Concrete\Core\Application\Application;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Entity\File\File as FileEntity;
use Concrete\Core\Entity\File\Version;
use Concrete\Core\Entity\Site\Site;
use Concrete\Core\File\File;
use Concrete\Core\Foundation\Service\Provider;
use Concrete\Core\Page\Page;
use Concrete\Core\Routing\RouterInterface;
use Bitter\Smartbanner\Routing\RouteList;
use Concrete\Core\Site\Config\Liaison;
use Concrete\Core\Site\Service;
use Concrete\Core\View\View;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ServiceProvider extends Provider
{
    protected RouterInterface $router;
    protected EventDispatcherInterface $eventDispatcher;
    protected Service $siteService;
    protected Site $site;
    protected Liaison $siteConfig;

    public function __construct(
        Application              $app,
        RouterInterface          $router,
        EventDispatcherInterface $eventDispatcher,
        Service                  $siteService
    )
    {
        parent::__construct($app);

        $this->router = $router;
        $this->eventDispatcher = $eventDispatcher;
        $this->siteService = $siteService;
        $this->site = $this->siteService->getActiveSiteForEditing();
        $this->siteConfig = $this->site->getConfigRepository();
    }

    public function register()
    {
        $this->registerRoutes();
        $this->registerAssets();
        $this->registerEventHandlers();
    }

    private function registerEventHandlers()
    {
        $this->eventDispatcher->addListener("on_before_render", function () {
            $c = Page::getCurrentPage();

            if ($c instanceof Page && !$c->isError() && !$c->isAdminArea()) {
                $v = View::getInstance();

                $v->requireAsset("smartbanner");

                $iconApple = "";
                $iconGoogle = "";

                $f = File::getByID($this->siteConfig->get("smartbanner.icon_apple"));

                if ($f instanceof FileEntity) {
                    $fv = $f->getApprovedVersion();

                    if ($fv instanceof Version) {
                        $iconApple = $fv->getURL();
                    }
                }

                $f = File::getByID($this->siteConfig->get("smartbanner.icon_google"));

                if ($f instanceof FileEntity) {
                    $fv = $f->getApprovedVersion();

                    if ($fv instanceof Version) {
                        $iconGoogle = $fv->getURL();
                    }
                }

                $v->addHeaderItem(sprintf('<meta name="smartbanner:title" content="%s">', t($this->siteConfig->get("smartbanner.title", "Smart Application"))));
                $v->addHeaderItem(sprintf('<meta name="smartbanner:author" content="%s">', t($this->siteConfig->get("smartbanner.author", "SmartBanner Contributors"))));
                $v->addHeaderItem(sprintf('<meta name="smartbanner:price" content="%s">', t($this->siteConfig->get("smartbanner.price", "FREE"))));
                $v->addHeaderItem(sprintf('<meta name="smartbanner:price-suffix-apple" content="%s">', t($this->siteConfig->get("smartbanner.price_suffix_apple", " - On the App Store"))));
                $v->addHeaderItem(sprintf('<meta name="smartbanner:price-suffix-google" content="%s">', t($this->siteConfig->get("smartbanner.price_suffix_google", " - In Google Play"))));
                $v->addHeaderItem(sprintf('<meta name="smartbanner:icon-apple" content="%s">', $iconApple));
                $v->addHeaderItem(sprintf('<meta name="smartbanner:icon-google" content="%s">', $iconGoogle));
                $v->addHeaderItem(sprintf('<meta name="smartbanner:button" content="%s">', t($this->siteConfig->get("smartbanner.button", "VIEW"))));
                $v->addHeaderItem(sprintf('<meta name="smartbanner:button-url-apple" content="%s">', $this->siteConfig->get("smartbanner.button_url_apple", "https://ios/application-url")));
                $v->addHeaderItem(sprintf('<meta name="smartbanner:button-url-google" content="%s">', $this->siteConfig->get("smartbanner.button_url_google", "https://android/application-url")));
                $v->addHeaderItem(sprintf('<meta name="smartbanner:enabled-platforms" content="%s">', $this->siteConfig->get("smartbanner.enabled_platforms", "android,ios")));
                $v->addHeaderItem(sprintf('<meta name="smartbanner:close-label" content="%s">', t($this->siteConfig->get("smartbanner.close_label", "Close"))));
            }
        });
    }

    private function registerAssets()
    {
        $al = AssetList::getInstance();

        $al->register("javascript", "smartbanner", "js/smartbanner.js", ["version" => "1.25.0"], "smartbanner");
        $al->register("css", "smartbanner", "css/smartbanner.css", ["version" => "1.25.0"], "smartbanner");

        $al->registerGroup("smartbanner", [
            ["javascript", "smartbanner"],
            ["css", "smartbanner"]
        ]);
    }

    private function registerRoutes()
    {
        $this->router->loadRouteList(new RouteList());
    }
}