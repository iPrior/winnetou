<?php

namespace Winnetou\Test;

use PHPUnit\Framework\TestCase;
use Winnetou\GitLogParserConfigVO;

/**
 * @covers \Winnetou\GitLogParserConfigVO
 */
class GitLogParserConfigVOTest extends TestCase
{
    /**
     * @var array
     */
    protected static $config = [];

    public static function setUpBeforeClass()
    {
        static::$config = require __DIR__ . '/config.test.php';
    }

    public function test__construct()
    {
        $obj = new GitLogParserConfigVO(
            current(static::$config['root-dirs']),
            static::$config['pattern'],
            static::$config['author-mask'],
            static::$config['start-work-day-dt']
        );

        $this->assertInstanceOf(GitLogParserConfigVO::class, $obj);

        return $obj;
    }

    /**
     * @depends test__construct
     */
    public function testCheckInvariantRepoDir()
    {
        $this->expectException(\InvalidArgumentException::class);

        new GitLogParserConfigVO(
            'abirvalg',
            static::$config['pattern'],
            static::$config['author-mask'],
            static::$config['start-work-day-dt']
        );
    }

    /**
     * @depends test__construct
     */
    public function testCheckInvariantPattern()
    {
        $this->expectException(\InvalidArgumentException::class);

        new GitLogParserConfigVO(
            current(static::$config['root-dirs']),
            '',
            static::$config['author-mask'],
            static::$config['start-work-day-dt']
        );
    }

    /**
     * @depends test__construct
     */
    public function testCheckInvariantAuthorMask()
    {
        $this->expectException(\InvalidArgumentException::class);

        new GitLogParserConfigVO(
            current(static::$config['root-dirs']),
            static::$config['pattern'],
            '',
            static::$config['start-work-day-dt']
        );
    }

    /**
     * @depends test__construct
     * @param GitLogParserConfigVO $obj
     */
    public function testGetRepoDir(GitLogParserConfigVO $obj)
    {
        $this->assertEquals(current(static::$config['root-dirs']), $obj->getRepoDir());
    }

    /**
     * @depends test__construct
     * @param GitLogParserConfigVO $obj
     */
    public function testGetAuthorMask(GitLogParserConfigVO $obj)
    {
        $this->assertEquals(static::$config['author-mask'], $obj->getAuthorMask());
    }

    /**
     * @depends test__construct
     * @param GitLogParserConfigVO $obj
     */
    public function testGetAfterDt(GitLogParserConfigVO $obj)
    {
        $this->assertEquals(static::$config['start-work-day-dt'], $obj->getAfterDt());
    }

    /**
     * @depends test__construct
     * @param GitLogParserConfigVO $obj
     */
    public function testGetPattern(GitLogParserConfigVO $obj)
    {
        $this->assertEquals(static::$config['pattern'], $obj->getPattern());
    }
}
