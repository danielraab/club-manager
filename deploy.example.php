<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@gitlab.com:mvkematen/club-scheduler.git'); //todo change to github

add('shared_files', [
    'public/favicon.ico'
]);
add('shared_dirs', []);
add('writable_dirs', []);
set('writable_recursive', true);

// Hosts

host('your.domain.com')
    ->set('remote_user', 'username')
    ->set('http_user', 'username')
    ->set('bin/php', '/usr/local/php82/bin/php')
    ->set('writable_mode', 'chmod')
    ->set('deploy_path', '~/path_to_the_project');

after('deploy:failed', 'deploy:unlock');
