<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use justinvoelker\tagging\TaggingWidget;

/* @var $this yii\web\View */

$this->params['title'] = Yii::t('app', 'Explore') . ' - ' . Yii::t('app', 'Posts');
?>
<div class="row">
    <div class="col-md-9" id="home-post">
        <?php foreach ($posts['result'] as $post): ?>
            <section class="post-item">
                <div class="row">
                    <div class="post-content col-md-9">
                        <article>
                            <a class="mecctitle" href="<?= Url::toRoute(['/user/view/view-post', 'id' => $post['id']]) ?>" target="_blank">
                                <h2><?= Html::encode($post['title']) ?></h2>
                            </a>
                            <address class="meccaddress">
                                <time><span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($post['created_at']) ?></time>
                                -
                                <?= Html::a('<span class="glyphicon glyphicon-user"></span> ' . Html::encode($post['username']), ['/user/view', 'id' => $post['username']]) ?>
                            </address>
                        </article>
                    </div>
                    <div class="post-image col-md-3 hidden-xs">
                        <?php
                            $pattern = "/<[img|IMG].*?src=\"([^^]*?)\".*?>/";
                            preg_match_all($pattern, $post['content'], $match);
                            if (!empty($match[1][0])) {
                                echo Html::a(Html::img($match[1][0], ['class' => 'pull-right']), ['/explore/view-post', 'id' => $post['id']], ['target' => '_blank']);
                            }
                        ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </section>
        <?php endforeach ?>
        <?= LinkPager::widget([
            'pagination' => $posts['pages']
        ]); ?>
    </div>
    <div class="col-md-3">
        <?= TaggingWidget::widget([
            'items' => $tags,
            'url' => ['/explore/posts'],
            'format' => 'ul',
            'urlParam' => 'tag',
            'listOptions' => ['class' => 'list-group'],
            'liOptions' => ['class' => 'list-group-item']
        ]) ?>
    </div>
</div>
