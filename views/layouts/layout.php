<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use app\models\Group;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>  
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <link rel="apple-touch-icon" sizes="76x76" href="../img/apple-icon.png">
    <link rel="icon" type="image/png" href="../img/favicon.png">

</head>

<body class="d-flex flex-column h-100 white-content">
<?php $this->beginBody() ?>
  <div class="wrapper ">
    <div class="sidebar" style="data-color=blue;" data-color="blue">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="sidebar-wrapper">
        <ul class="nav">
          
          <!-- Меню гостя -->
          <?php if (Yii::$app->user->isGuest) { ?>
          <li class="<?= (Yii::$app->request->pathInfo == 'site/register') ? 'active' : '' ?>">
            <a href="/site/register">
              <i class="tim-icons icon-single-02"></i>
              <p>Регистрация</p>
            </a>
          </li>
          <li class="<?= (Yii::$app->request->pathInfo == 'site/login') ? 'active' : '' ?>">
            <a href="/site/login">
              <i class="tim-icons"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="mb-2 bi bi-door-open" viewBox="0 0 16 16">
                <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
                <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
              </svg></i>
              <p>Вход</p>
            </a>
          </li>
          <?php } ?>

          <!-- Меню админа -->
          <?php if(Yii::$app->user->can('can_admin')) { ?>
          <li class="<?= (Yii::$app->request->pathInfo == 'admin') ? 'active' : '' ?>">
            <a href="/admin">
              <i class="tim-icons icon-single-02"></i>
              <p>Пользователи</p>
            </a>
          </li>
          <?php } ?>

          <!-- Меню студента, куратора и завуча -->
          <?php if(Yii::$app->user->can('per_user')) { ?>
          <li class="<?= (Yii::$app->request->pathInfo == 'account/task') ? 'active' : '' ?>">
            <a href="/account/task">
              <i class="tim-icons icon-pin"></i>
              <p>Мои задачи</p>
            </a>
          </li>
          <li class="<?= (Yii::$app->request->pathInfo == 'account/reflection') ? 'active' : '' ?>">
            <a href="/account/reflection">
              <i class="tim-icons icon-chart-bar-32"></i>
              <p>Статистика</p>
            </a>
          </li>
          <?php } ?>

          <!-- Меню куратора -->
          <?php if(Yii::$app->user->can('per_manager')) { ?>
              <li class="<?= (Yii::$app->request->pathInfo == 'account/group') ? 'active' : '' ?>">
                <a href="/account/group">
                  <i class="tim-icons"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="mb-2 bi bi-people-fill" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                  </svg></i>
                  <p>Мои группы</p>
                </a>
              </li>
          <?php } ?>

          <!-- Меню завуча и админа -->
          <?php if(Yii::$app->user->can('per_head_teacher') || Yii::$app->user->can('can_admin')) { ?>
            <li class="<?= (Yii::$app->request->pathInfo == 'account/group') ? 'active' : '' ?>">
            <a href="/account/group">
              <i class="tim-icons"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="mb-2 bi bi-people-fill" viewBox="0 0 16 16">
                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
              </svg></i>
              <p>Группы</p>
            </a>
          </li>
          <li class="<?= (Yii::$app->request->pathInfo == 'account/subject') ? 'active' : '' ?>">
            <a href="/account/subject">
              <i class="tim-icons"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="mb-2 bi bi-book" viewBox="0 0 16 16">
                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
              </svg></i>
              <p>Предметы</p>
            </a>
          </li>
          <?php } ?>

        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent"  data-color="blue">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand mx-0" href="/site/main">Управление временем</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse" id="navigation" style="flex-grow: 0;">
            <ul class="navbar-nav ml-auto ">
              <?php if (!Yii::$app->user->isGuest) { ?>
              <li class="nav-item pe-0">
                  <p class="mt-2"><?= Yii::$app->user->identity->name ?></p>
              </li>
              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <i class="tim-icons icon-single-02"></i>
                  <b class="caret d-none d-lg-block d-xl-block"></b>
                </a>
                <ul class="dropdown-menu dropdown-navbar">
                  <?php if(Yii::$app->user->can('per_user')) { ?>
                  <li class="nav-link">
                    <a href="/account/profile/update" class="nav-item dropdown-item">Личный кабинет</a>
                  </li>
                  <div class="dropdown-divider"></div>
                  <?php } ?>
                  <li class="nav-link">
                    <?= Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Выйти',
                        ['class' => 'nav-item dropdown-item logout']
                    )
                    . Html::endForm()
                    ?>
                  </li>
                </ul>
              </li>
              <li class="separator d-lg-none"></li>
              
              <?php } ?>
            </ul>
          </div>
        </div>
      </nav>
      <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>
      
      <main id="main" class="flex-shrink-0" role="main">
        <div class="content">
          <div class="row">
              <div class="col-12">
                <?= $content; ?>
              </div>
          </div>
        </div>
      </main>



      <footer class="footer mt-auto py-3">
        <div class="container-fluid">
          <div class="copyright float-none text-center">
            ©
            <script>
              document.write(new Date().getFullYear())
            </script>
          </div>
      </footer>
      </div>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>