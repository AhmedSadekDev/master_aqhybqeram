<?php

if (request()->is('*dashboard*')  && !request()->is('*api*')) {
    include "web/dashboard/web.php";
}

if (!request()->is('*dashboard*') && !request()->is('*api*')) {
    include "web/front/web.php";
}