<?php

namespace Concrete\Package\Smartbanner\Controller\SinglePage\Dashboard;

use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Error\ErrorList\ErrorList;
use Concrete\Core\Form\Service\Validation;
use Concrete\Core\Page\Controller\DashboardSitePageController;

class Smartbanner extends DashboardSitePageController
{
    /** @var Repository */
    protected $siteConfig;
    /** @var Validation */
    protected $formValidator;

    public function on_start()
    {
        parent::on_start();
        $this->siteConfig = $this->getSite()->getConfigRepository();
        $this->formValidator = $this->app->make(Validation::class);
    }

    public function view()
    {
        if ($this->request->getMethod() === "POST") {
            $this->formValidator->setData($this->request->request->all());
            $this->formValidator->addRequiredToken("update_settings");

            if ($this->formValidator->test()) {
                $this->siteConfig->save("smartbanner.title", $this->request->request->get("title"));
                $this->siteConfig->save("smartbanner.author", $this->request->request->get("author"));
                $this->siteConfig->save("smartbanner.price", $this->request->request->get("price"));
                $this->siteConfig->save("smartbanner.price_suffix_apple", $this->request->request->get("priceSuffixApple"));
                $this->siteConfig->save("smartbanner.price_suffix_google", $this->request->request->get("priceSuffixGoogle"));
                $this->siteConfig->save("smartbanner.icon_apple", $this->request->request->get("iconApple"));
                $this->siteConfig->save("smartbanner.icon_google", $this->request->request->get("iconGoogle"));
                $this->siteConfig->save("smartbanner.button", $this->request->request->get("button"));
                $this->siteConfig->save("smartbanner.button_url_apple", $this->request->request->get("buttonUrlApple"));
                $this->siteConfig->save("smartbanner.button_url_google", $this->request->request->get("buttonUrlGoogle"));
                $this->siteConfig->save("smartbanner.enabled_platforms", $this->request->request->get("enabledPlatforms"));
                $this->siteConfig->save("smartbanner.close_label", $this->request->request->get("closeLabel"));

                if (!$this->error->has()) {
                    $this->set("success", t("The settings has been successfully updated."));
                }
            } else {
                /** @var ErrorList $errorList */
                $errorList = $this->formValidator->getError();

                foreach ($errorList->getList() as $error) {
                    $this->error->add($error);
                }
            }
        }

        $this->set("title", $this->siteConfig->get("smartbanner.title", "Smart Application"));
        $this->set("author", $this->siteConfig->get("smartbanner.author", "SmartBanner Contributors"));
        $this->set("price", $this->siteConfig->get("smartbanner.price", "FREE"));
        $this->set("priceSuffixApple", $this->siteConfig->get("smartbanner.price_suffix_apple", " - On the App Store"));
        $this->set("priceSuffixGoogle", $this->siteConfig->get("smartbanner.price_suffix_google", " - In Google Play"));
        $this->set("iconApple", $this->siteConfig->get("smartbanner.icon_apple"));
        $this->set("iconGoogle", $this->siteConfig->get("smartbanner.icon_google"));
        $this->set("button", $this->siteConfig->get("smartbanner.button", "VIEW"));
        $this->set("buttonUrlApple", $this->siteConfig->get("smartbanner.button_url_apple", "https://ios/application-url"));
        $this->set("buttonUrlGoogle", $this->siteConfig->get("smartbanner.button_url_google", "https://android/application-url"));
        $this->set("enabledPlatforms", $this->siteConfig->get("smartbanner.enabled_platforms", "android,ios"));
        $this->set("closeLabel", $this->siteConfig->get("smartbanner.close_label", "Close"));
    }
}