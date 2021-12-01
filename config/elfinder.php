<?php

return [
  'dir' => ['Files'],
  'disks' => ['Files'],
  'route' => [
    [
      'prefix' => 'dashboard/file-manager',
      'middleware' => ['auth'],
    ],
  ],

  'access' => 'Barryvdh\Elfinder\Elfinder::checkAccess',
  'roots' => null,
  'options' => [],
  'root_options' => [],
];
