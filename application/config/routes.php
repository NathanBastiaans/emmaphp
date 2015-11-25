<?php

// Router::get('stateName', 'URI', 'Controller@method')

Router::get('home', '/', 'Index@index');
Router::get('page2', '/page/(:any)', 'Index@page2');

?>