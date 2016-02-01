<?php

// Router::get('stateName', 'URI', 'Controller@method')

Router::get('home', '/', 'Index@index');
Router::get("defaultPage", "/page", "Index@page");
Router::get('page', '/page/(:any)', 'Index@page');