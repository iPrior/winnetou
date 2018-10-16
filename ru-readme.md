# Winnetou 

Branch | Travis-CI
------ | -------------
master | ![Travis-Ci](https://travis-ci.org/iPrior/winnetou.svg?branch=master)
v1     | ![Travis-Ci](https://travis-ci.org/iPrior/winnetou.svg?branch=v1)

Списывает время в Jira (issue WorkLog) по коммитам из гита.

**Работает только под Linux!** потому что используется утилита `find`

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

### Настройка

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

* **start-work-day-dt** - время начала рабочего дня. *Поиск комитов будет производиться в этот день. Смотри [документацию git](https://git-scm.com/docs/git-log#git-log---afterltdategt)*
* **pattern** - регулярное выражение для прасинга информации из коммитов. Необходимо заменить `PROJECT_PREFIX` на необходимый префикс проекта.
* **author-mask** - маска для фильтрации коммитов по автору. Смотри [документацию git](https://git-scm.com/docs/git-log#git-log---authorltpatterngt)
* **root-dirs** - список директорий в которых производится поиск репозиториев git. *Директории с именем `vendor` исключаются*
* **jira-host** - URL до Jira
* **jira-login** - логин пользователя в Jira
* **jira-password** - пароль пользователя в Jira
* **debug** - если установлен в `TRUE` то информация не будет отправляться в Jira.

### Использование

Для запуска выполнить команду:

`php cli.php winnetou <config-path> [<debug> [<start-work-dt>]]`


### License

**MIT License**
