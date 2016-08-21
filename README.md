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

    public function searchRescueCarnum()
    {
        $params = fixer::input('request')->getArray();
        $pager = $this->rescueService->searchRescueCarnum($params);
        $this->view->pager = $pager;
        $this->display();
    }

    public function searchRescueCarnum()
    {
        $params = fixer::input('request')->getArray();
        $pager = $this->rescueService->searchRescueCarnum($params);
        $this->view->pager = $pager;
        $this->display();
    }

    public function searchCustomerName()
    {
        $params = fixer::input('request')->getArray();
        $pager = $this->rescueService->searchCustomerName($params);
        $this->view->pager = $pager;
        $this->display();
    }

    public function searchRescueId()
    {
        $params = fixer::input('request')->getArray();
        $pager = $this->rescueService->searchRescueId($params);
        $this->view->pager = $pager;
        $this->display();
    }

    public function searchRescueInfo()
    {
        $params = fixer::input('request')->getArray();
        $pager = $this->rescueService->searchRescueInfo($params);
        $this->view->pager = $pager;
        $this->display();
    }

    public function searchOrgList(){
      $res = $this->batteryService->searchOrgList();
      $this->view->data = $res;
      $this->display();
    }
}



```
