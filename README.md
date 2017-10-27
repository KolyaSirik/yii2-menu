Yii2 menu module
================
Yii2 module for menu creation.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist kolyasiryk/yii2-menu-mongo "*"
```

or add

```
"kolyasiryk/yii2-menu-mongo": "*"
```

to the require section of your `composer.json` file.

Create controllers and include menu and menu-item traits. For example:

```php

class MenuController extends Controller
{
    use MenuTrait;
}
```
```php
class MenuItemController extends Controller
{
    use MenuItemTrait;
}

```

Usage
-----

Minimal configuration:

```php
<?= MenuWidget::widget([
    'menuName' => 'main_footer',
    'menuWrapper' => '<ul class="bottom-nav">{items}</ul>',
]) ?>
```

Also you can define other settings:

```php
<?= MenuWidget::widget([
    'menuName' => 'main_header',
    'template' => function (MenuItem $current) {
        return Html::tag('li', Html::a($current->title, $current->url) . '{children}', [
            'class' => ($current->url == Url::to([''])) ? 'active' : '',
        ]);
    },
    'menuWrapper' => '<nav class="nav-holder"><ul id="nav">{items}</ul></nav>',
    'subMenuWrapper' => '<div class="drop"><ul>{items}</ul></div>',
]) ?>
```