<?php

defined('C5_EXECUTE') or die('Access denied');

use Concrete\Core\Application\Service\FileManager;
use Concrete\Core\Form\Service\Form;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Validation\CSRF\Token;
use Concrete\Core\View\View;

/** @var string $title */
/** @var string $author */
/** @var string $price */
/** @var string $priceSuffixApple */
/** @var string $priceSuffixGoogle */
/** @var string $iconApple */
/** @var string $iconGoogle */
/** @var string $button */
/** @var string $buttonUrlApple */
/** @var string $buttonUrlGoogle */
/** @var string $enabledPlatforms */
/** @var string $closeLabel */

$app = Application::getFacadeApplication();
/** @var Form $form */
/** @noinspection PhpUnhandledExceptionInspection */
$form = $app->make(Form::class);
/** @var Token $token */
/** @noinspection PhpUnhandledExceptionInspection */
$token = $app->make(Token::class);
/** @var FileManager $fileManager */
/** @noinspection PhpUnhandledExceptionInspection */
$fileManager = $app->make(FileManager::class);

?>

<div class="ccm-dashboard-header-buttons">
    <div class="btn-group" role="group">
        <?php /** @noinspection PhpUnhandledExceptionInspection */
        View::element("dashboard/help", [], "smartbanner"); ?>
    </div>
</div>

<form action="#" method="post">´
    <?php echo $token->output("update_settings"); ?>

    <fieldset>
        <legend>
            <?php echo t("General"); ?>
        </legend>

        <div class="form-group">
            <?php echo $form->label("title", "Title"); ?>
            <?php echo $form->text("title", $title); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("author", "Author"); ?>
            <?php echo $form->text("author", $author); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("price", "Price"); ?>
            <?php echo $form->text("price", $price); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("priceSuffixApple", "Price Suffix Apple"); ?>
            <?php echo $form->text("priceSuffixApple", $priceSuffixApple); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("priceSuffixGoogle", "Price Suffix Google"); ?>
            <?php echo $form->text("priceSuffixGoogle", $priceSuffixGoogle); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("iconApple", "Icon Apple"); ?>
            <?php echo $fileManager->image("iconApple", "iconApple", t("Please select file...") ,$iconApple); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("iconGoogle", "Icon Google"); ?>
            <?php echo $fileManager->image("iconGoogle", "iconGoogle", t("Please select file...") ,$iconGoogle); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("button", "Button"); ?>
            <?php echo $form->text("button", $button); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("buttonUrlApple", "Button URL Apple"); ?>
            <?php echo $form->text("buttonUrlApple", $buttonUrlApple); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("buttonUrlGoogle", "Button URL Google"); ?>
            <?php echo $form->text("buttonUrlGoogle", $buttonUrlGoogle); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("enabledPlatforms", "Enabled Platforms"); ?>
            <?php echo $form->text("enabledPlatforms", $enabledPlatforms); ?>
        </div>

        <div class="form-group">
            <?php echo $form->label("closeLabel", "Close Label"); ?>
            <?php echo $form->text("closeLabel", $closeLabel); ?>
        </div>
    </fieldset>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <?php echo $form->submit('save', t('Save'), ['class' => 'btn btn-primary float-end']); ?>
        </div>
    </div>
</form>