<?php

namespace Concrete\Package\Smartbanner;

use Bitter\Smartbanner\Provider\ServiceProvider;
use Concrete\Core\Entity\Package as PackageEntity;
use Concrete\Core\Package\Package;

class Controller extends Package
{
    protected string $pkgHandle = 'smartbanner';
    protected string $pkgVersion = '0.0.1';
    protected $appVersionRequired = '9.0.0';
    protected $pkgAutoloaderRegistries = [
        'src/Bitter/Smartbanner' => 'Bitter\Smartbanner',
    ];

    public function getPackageDescription(): string
    {
        return t('Smartbanner is a Concrete CMS add-on that displays a sleek banner on your website promoting your mobile app from the App Store or Google Play.');
    }

    public function getPackageName(): string
    {
        return t('Smartbanner');
    }

    public function on_start()
    {
        /** @var ServiceProvider $serviceProvider */
        /** @noinspection PhpUnhandledExceptionInspection */
        $serviceProvider = $this->app->make(ServiceProvider::class);
        $serviceProvider->register();
    }

    public function install(): PackageEntity
    {
        $pkg = parent::install();
        $this->installContentFile("data.xml");
        return $pkg;
    }

    public function upgrade()
    {
        parent::upgrade();
        $this->installContentFile("data.xml");
    }
}