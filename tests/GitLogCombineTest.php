<?php

namespace Winnetou\Test;

use PHPUnit\Framework\TestCase;
use Winnetou\GitLogCombine;
use Winnetou\GitLogVO;

/**
 * @covers \Winnetou\GitLogCombine
 */
class GitLogCombineTest extends TestCase
{
    /**
     * @var \DateTime
     */
    protected static $startWorkDayDt;

    /**
     * @var GitLogVO[]
     */
    protected static $gitLogList = [];

    /**
     * @var \DateInterval
     */
    protected static $interval = 'PT1H';

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        static::$startWorkDayDt = new \DateTime('now');
        static::$interval = new \DateInterval('PT1H');

        $dateTime = clone static::$startWorkDayDt;
        for ($a = 0; $a < 2; $a++) {
            $dateTime->add(static::$interval);
            static::$gitLogList[] = new GitLogVO(
                bin2hex(random_bytes(4)),
                clone $dateTime,
                'Issue ' . $a,
                'Comment ' . $a
            );
        }
    }

    public function test__construct()
    {
        $obj = new GitLogCombine(static::$startWorkDayDt);
        $this->assertInstanceOf(GitLogCombine::class, $obj);

        return $obj;
    }

    /**
     * @depends test__construct
     * @param GitLogCombine $obj
     * @return GitLogCombine
     */
    public function testAppendGitLog(GitLogCombine $obj)
    {
        $result = $obj->appendGitLog(current(static::$gitLogList));
        $this->assertInstanceOf(GitLogCombine::class, $result);

        return $result;
    }

    /**
     * @depends testAppendGitLog
     * @param GitLogCombine $obj
     * @return GitLogCombine
     */
    public function testAppendGitLogList(GitLogCombine $obj)
    {
        $result = $obj->appendGitLogList([end(static::$gitLogList)]);
        $this->assertInstanceOf(GitLogCombine::class, $result);

        return $result;
    }

    /**
     * @depends testAppendGitLogList
     * @param GitLogCombine $obj
     * @throws \Exception
     */
    public function testGetResultData(GitLogCombine $obj)
    {
        $data = $obj->getResultData();
        $this->assertCount(count(static::$gitLogList), $data);
        $dateTime = clone static::$startWorkDayDt;
        $tmpDateTime = (clone static::$startWorkDayDt)->add(static::$interval);
        $timeSpent = $tmpDateTime->getTimestamp() - $dateTime->getTimestamp();

        foreach (array_reverse(static::$gitLogList) as $a => $item) {
            $vo = $data[$a];

            $this->assertEquals($vo->getTimeSpentSeconds(), $timeSpent);
            $this->assertEquals($vo->getIssueStarted(), $dateTime);
            $dateTime->add(static::$interval);
        }
    }

}
