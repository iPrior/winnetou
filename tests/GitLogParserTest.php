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
        '50d34c1d2159a6f2e856b79c1efe766fb84240b0' => [
            'hash' => '50d34c1d2159a6f2e856b79c1efe766fb84240b0',
            'dateTime' => 'Sun Oct 14 12:23:26 2018 +0300',
            'issueKey' => 'WATCH-2',
            'comment' => 'unit tests'
        ],
        '2deecd044e5de5494cdbc7a84e99e1a9c835d441' => [
            'hash' => '2deecd044e5de5494cdbc7a84e99e1a9c835d441',
            'dateTime' => 'Sun Oct 14 11:58:20 2018 +0300',
            'issueKey' => 'WATCH-1',
            'comment' => 'First test commit'
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
