<?php
use yii\helpers\Url;

$userData = Yii::$app->userData->getKey(true);
?>
<?php $this->beginContent('@app/modules/user/views/layouts/user.php'); ?>
<div class="social-wrapper row">
    <div id="social-container">
        <div class="row hidden-xs">
            <a class="col-lg-3 col-sm-6 col-xs-12" href="<?= Url::toRoute(['/home/feed']) ?>">
                <div class="main-box infographic-box">
                    <i class="glyphicon glyphicon-pencil text-primary"></i>
                    <span class="headline"><?= Yii::t('app', 'Feed') ?></span>
                    <span class="value"><?= $userData['feed_count'] ?></span>
                </div>
            </a>
            <a class="col-lg-3 col-sm-6 col-xs-12" href="<?= Url::toRoute(['/home/post']) ?>">
                <div class="main-box infographic-box">
                    <i class="glyphicon glyphicon-list-alt text-warning"></i>
                    <span class="headline"><?= Yii::t('app', 'Blog') ?></span>
                    <span class="value"><?= $userData['post_count'] ?></span>
                </div>
            </a>
            <a class="col-lg-3 col-sm-6 col-xs-12" href="<?= Url::toRoute(['/user/dashboard/following']) ?>">
                <div class="main-box infographic-box">
                    <i class="glyphicon glyphicon-eye-open text-success"></i>
                    <span class="headline"><?= Yii::t('app', 'Following') ?></span>
                    <span class="value"><?= $userData['following_count'] ?></span>
                </div>
            </a>
            <a class="col-lg-3 col-sm-6 col-xs-12" href="<?= Url::toRoute(['/user/dashboard/follower']) ?>">
                <div class="main-box infographic-box">
                    <i class="glyphicon glyphicon-user text-info"></i>
                    <span class="headline"><?= Yii::t('app', 'Follower') ?></span>
                    <span class="value"><?= $userData['follower_count'] ?></span>
                </div>
            </a>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-8">
            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
