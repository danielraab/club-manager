<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@gitlab.com:mvkematen/club-scheduler.git'); //todo change to github

add('shared_files', [
    'public/favicon.ico',
    "public/logo.svg",
    'public/manifest.json'
]);
add('shared_dirs', []);
add('writable_dirs', []);
set('writable_recursive', true);

// Hosts
import('deployer-hosts.yaml');


//necessary for some hosting systems
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


after('deploy:failed', 'deploy:unlock');
