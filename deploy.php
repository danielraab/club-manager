<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@gitlab.com:mvkematen/club-scheduler.git');

add('shared_files', [
    'public/favicon.ico'
]);
add('shared_dirs', []);
add('writable_dirs', []);
set('writable_recursive', true);

// Hosts

host('intern.mv-kematen.at')
    ->set('remote_user', 'hosting187061')
    ->set('http_user', 'hosting187061')
    ->set('bin/php', '/usr/local/php82/bin/php')
    ->set('writable_mode', 'chmod')
    ->set('deploy_path', '~/intern.mv-kematen.at/httpdocs');

// tasks
task('config:cache:fix', function () {
    cd('{{release_or_current_path}}');
    run("sed -i -- 's/\/intern.mv-kematen.at\/httpdocs\//\/var\/www\/vhosts\/hosting187061.a2ea9.netcup.net\/intern.mv-kematen.at\/httpdocs\//g' ./bootstrap/cache/*");
});

desc('Build all caches');
task('artisan:caches:all', [
    'artisan:config:cache', // cli realpath is not the same like apache realpath
    'artisan:route:cache',
    'artisan:view:cache',
    'artisan:event:cache',
    'config:cache:fix',
]);

desc('Creates the symbolic links configured for the application');
task('artisan:storage:linkRelative', artisan('storage:link --relative', ['min' => 5.3]));

/**
 * Main deploy task.
 */
desc('Deploys your project');
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:linkRelative',
    'artisan:caches:all',
    'artisan:migrate',
    'deploy:publish',
]);

// Hooks

after('deploy:failed', 'deploy:unlock');
