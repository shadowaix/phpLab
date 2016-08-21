# phpLab
php学习

# php代码

```php
<?php
/**
 * The control file of RESCUE module.
 */
class rescue extends control
{
    public function __construct()
    {
        parent::__construct();
        $user = Ucenter::init()->getUserInfo();
        $this->orgcode = $this->app->user->organ->orgcode;
        $this->orgroot = $this->app->user->organ->orgroot;
        $this->userid = $this->app->user->id;
    }

}



```
