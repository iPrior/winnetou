<?php

namespace Winnetou\Test;

use PHPUnit\Framework\TestCase;
use Winnetou\GitLogParser;
use Winnetou\GitLogParserConfigVO;
use Winnetou\GitLogVO;

/**
 * @covers \Winnetou\GitLogParser
 */
class GitLogParserTest extends TestCase
{
    /**
     * @var GitLogParserConfigVO
     */
    protected static $config;

    /**
     * @var array
     */
    protected static $actualData = [
        '93721fcc46715f70a7d9e0c8cd43cf963866403d' => [
            'hash' => '93721fcc46715f70a7d9e0c8cd43cf963866403d',
            'dateTime' => 'Sun Oct 14 15:13:40 2018 +0300',
            'issueKey' => 'WINNETOU-2',
            'comment' => 'Test commit'
        ],
        'e08da065a9433610edf26a260a45a4a7bdb1ccd3' => [
            'hash' => 'e08da065a9433610edf26a260a45a4a7bdb1ccd3',
            'dateTime' => 'Sun Oct 14 15:10:44 2018 +0300',
            'issueKey' => 'WINNETOU-1',
            'comment' => 'First commit'
        ],
    ];

    public static function setUpBeforeClass()
    {
        $config = require __DIR__ . '/config.test.php';
        static::$config = new GitLogParserConfigVO(
            current($config['root-dirs']),
            $config['pattern'],
            $config['author-mask'],
            $config['start-work-day-dt']
        );
    }

    /**
     * @return GitLogParser
     * @throws \Exception
     */
    public function test__construct()
    {
        $obj = new GitLogParser(static::$config);
        $this->assertInstanceOf(GitLogParser::class, $obj);

        return $obj;
    }

    /**
     * @depends test__construct
     * @param GitLogParser $obj
     */
    public function testGetData(GitLogParser $obj)
    {
        $data = $obj->getData();
        foreach (static::$actualData as $key => $item) {
            $this->assertArrayHasKey($key, $data);
            $vo = $data[$key];
            $this->assertInstanceOf(GitLogVO::class, $vo);
            $this->assertEquals($vo->getHash(), $item['hash']);
            $this->assertEquals($vo->getIssueKey(), $item['issueKey']);
            $this->assertEquals($vo->getComment(), $item['comment']);
            $this->assertEquals($vo->getDateTime(), new \DateTime($item['dateTime']));
        }
    }
}
