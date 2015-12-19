<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php $this->head() ?>
    </head>
    <body class="sidebar-mini skin-blue-light">
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <!-- header logo: style can be found in header.less -->
        <header class="main-header">
            <a href="#" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                iiSNS AdminLTE
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?= Yii::$app->user->identity->username ?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?= Yii::getAlias('@web/adminlte/img/user2-160x160.jpg') ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        Jane Doe - Web Developer
                                        <small>Member since Nov. 2012</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= URL::toRoute(['/site/logout']) ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar" style="height: auto;">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?= Yii::getAlias('@web/adminlte/img/user2-160x160.jpg') ?>" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>Hello, <?= Yii::$app->user->identity->username ?></p>

                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- search form -->
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                    </div>
                </form>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li>
                        <a href="<?= Url::toRoute('/site/index') ?>">
                            <i class="glyphicon glyphicon-dashboard"></i> <span><?= Yii::t('app', 'Dashboard') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute('/explore/index') ?>">
                            <i class="glyphicon glyphicon-globe"></i> <span><?= Yii::t('app', 'Explore') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute('/setting/default') ?>">
                            <i class="glyphicon glyphicon-cog"></i> <span><?= Yii::t('app', 'Setting') ?></span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="glyphicon glyphicon-hdd"></i>
                            <span><?= Yii::t('app', 'Content') ?></span>
                            <i class="glyphicon glyphicon-menu-down pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= Url::toRoute('/user') ?>"><i class="glyphicon glyphicon-menu-right"></i> <?= Yii::t('app', 'User') ?></a></li>
                            <li><a href="<?= Url::toRoute('/forum/forum/index') ?>"><i class="glyphicon glyphicon-menu-right"></i> <?= Yii::t('app', 'Forum') ?></a></li>
                            <li><a href="<?= Url::toRoute('/post') ?>"><i class="glyphicon glyphicon-menu-right"></i> <?= Yii::t('app', 'Blog') ?></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/rbac']) ?>">
                            <i class="glyphicon glyphicon-wrench"></i> <span><?= Yii::t('app', 'RBAC') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/site/cache']) ?>">
                            <i class="glyphicon glyphicon-road"></i> <span><?= Yii::t('app', 'Cache') ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::toRoute(['/site/phpinfo']) ?>">
                            <i class="glyphicon glyphicon-info-sign"></i> <span>PHPinfo</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= \Yii::$app->controller->module->id ?>
                    <small>Preview page</small>
                </h1>
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?= Alert::widget() ?>
                <?= $content ?>
            </section><!-- /.content -->
        </div><!-- /.right-side -->
    </div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>