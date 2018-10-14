# Winnetou 

Create Jira WorkLog by git commits

Branch | Travis-CI                                                             | Coveralls
------ | ----------------------------------------------------------------------|----------
master | ![Travis-Ci](https://travis-ci.org/iPrior/winnetou.svg?branch=master) | [![Coverage Status](https://coveralls.io/repos/github/iPrior/winnetou/badge.svg?branch=master)](https://coveralls.io/github/iPrior/winnetou?master)
v1     | ![Travis-Ci](https://travis-ci.org/iPrior/winnetou.svg?branch=v1)     | [![Coverage Status](https://coveralls.io/repos/github/iPrior/winnetou/badge.svg?branch=v1)](https://coveralls.io/github/iPrior/winnetou?branch=v1)

**Works only on Linux OS!** Because `find` utility used

[Russian doc](./ru-readme.md)

```text
+--------+------------+------------+---------------------+---------------------+------------------+----------------------------------------------------------------------------------------+
| Status | WorkLog ID | Issue      | Start DateTime      | End DateTime        | Work time (sec.) | Description                                                                            |
+--------+------------+------------+---------------------+---------------------+------------------+----------------------------------------------------------------------------------------+
| OK     | DEBUG      | POJEC-1234 | 2018-10-11 10:00:00 | 2018-10-11 11:57:20 | 7040             | Comment text. Comment text. Comment text. Comment.text.                                |
| OK     | DEBUG      | POJEC-1235 | 2018-10-11 11:57:20 | 2018-10-11 12:03:27 | 367              | Comment text. Comment text. Comment text. Comment.text.                                |
| OK     | DEBUG      | POJEC-1236 | 2018-10-11 12:03:27 | 2018-10-11 13:51:44 | 6497             | Comment text. Comment text. Comment text. Comment.text. Comment text.                  |
| OK     | DEBUG      | POJEC-1237 | 2018-10-11 13:51:44 | 2018-10-11 14:42:13 | 3029             | Comment text. Comment text. Comment text. Comment.text. Comment text. Comment text.    |
| OK     | DEBUG      | POJEC-1238 | 2018-10-11 14:42:13 | 2018-10-11 17:55:27 | 11594            | Comment text. Comment text. Comment text. Comment.text.                                |
+--------+------------+------------+---------------------+---------------------+------------------+----------------------------------------------------------------------------------------+

```

### Configure

```php
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
```

* **start-work-day-dt** - working day start time. *Search of commits will on this day. See [git documentation](https://git-scm.com/docs/git-log#git-log---afterltdategt)*
* **pattern** - regexp for parsing commits. Need change  `PROJECT_PREFIX` on required project prefix..
* **author-mask** - mask for filtering commits by author. See [git documentation](https://git-scm.com/docs/git-log#git-log---authorltpatterngt)
* **root-dirs** - list of directories for searches git repositories. *Directories named `vendor` are excluded*
* **jira-host** - URL Jira host
* **jira-login** - Jira user login
* **jira-password** - Jira user password
* **debug** - if set `TRUE`, information don't send to Jira.

### Used

Run command:

`php cli.php winnetou <config-path> [<start-work-dt> [<debug>]]`


### License

**MIT License**
