<?php

namespace Winnetou\Test;

use PHPUnit\Framework\TestCase;
use Winnetou\GitLogCombineDataVO;
use Winnetou\GitLogVO;

/**
 * @covers \Winnetou\GitLogCombineDataVO
 */
class GitLogCombineDataVOTest extends TestCase
{
    /**
     * @var GitLogVO
     */
    protected static $gitLogVO;

    /**
     * @var \DateTime
     */
    protected static $issueStarted;

    /**
     * @var int
     */
    protected static $timeSpend = 0;

    public static function setUpBeforeClass()
    {
        static::$issueStarted = new \DateTime('now');
        static::$timeSpend = 3600;
        static::$gitLogVO = new GitLogVO(
            'abirvalg',
            static::$issueStarted,
            'abirvalg',
            'abirvalg'
        );
    }


    public function test__construct()
    {
        $obj = new GitLogCombineDataVO(
            static::$issueStarted,
            static::$timeSpend,
            static::$gitLogVO
        );
        $this->assertInstanceOf(GitLogCombineDataVO::class, $obj);

        return $obj;
    }

    /**
     * @depends test__construct
     * @param GitLogCombineDataVO $obj
     */
    public function testGetIssueStarted(GitLogCombineDataVO $obj)
    {
        $this->assertEquals(static::$issueStarted, $obj->getIssueStarted());
    }

    /**
     * @depends test__construct
     * @param GitLogCombineDataVO $obj
     */
    public function testGetTimeSpentSeconds(GitLogCombineDataVO $obj)
    {
        $this->assertEquals(static::$timeSpend, $obj->getTimeSpentSeconds());
    }
}
