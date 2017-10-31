<?php

namespace Shinka\ThreadLog\XF\Pub\Controller;

class Member extends XFCP_Member
{
    public function actionThreadLog() {
        return $this->message('Hello world!');
    }
}