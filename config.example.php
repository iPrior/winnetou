<?php
return [
    'start-work-day-dt' => (new \DateTime('now', new \DateTimeZone('Europe/Moscow')))->setTime(10, 0, 0),
    'pattern' => '/commit (?<hash>.*)\n.*\nDate:(?<dt>.*)\n\n.*(?<issue>PROJECT_PREFIX-\d{1,}) (?<comment>.*)\n/mu',
    'author-mask' => 'author@',
    'root-dirs' => [
        '/path/to/folder/with/repositories1',
        '/path/to/folder/with/repositories2',
    ],
    'jira-host' => 'http://jira.host.com',
    'jira-login' => 'jiraLogin',
    'jira-password' => 'jiraPassword',
    'debug' => true,
];
