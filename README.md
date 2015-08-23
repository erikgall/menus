# Menu/Item Manager for Laravel 5.1

```
$menu = $menus->build('siteMenu', function ($m) {

      $m->add('MAIN NAVIGATION', ['class' => 'header']);

      $dashboard = $m->add('Dashboard', ['url' => '#', 'class' => 'treeview']);

      $dashboard->link->wrap('span')
                      ->fa('dashboard')
                      ->iconLeft();

      $dashboard->add('Settings', ['url' => route('admin.dashboard')])->link->wrap('span')
                                                                            ->fa('circle-o');

      $page = $m->add('Pages', ['url' => route('admin.page.index')]);

      $page->link->wrap('span')
                 ->fa('newspaper-o');

      return $m;
    });
  ```
