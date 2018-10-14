<?php
return [
    'start-work-day-dt' => (new \DateTime('2018-10-14', new \DateTimeZone('Europe/Moscow')))->setTime(10, 0, 0),
    'pattern' => '/commit (?<hash>.*)\n.*\nDate:(?<dt>.*)\n\n.*(?<issue>WINNETOU-\d{1,}) (?<comment>.*)\n/mu',
    'author-mask' => 'darkmonk9@',
    'root-dirs' => [
        __DIR__ . '/../',
    ],
    'jira-host' => 'http://jira.host.com',
    'jira-login' => 'jiraLogin',
    'jira-password' => 'jiraPassword',
    'debug' => true,
];
