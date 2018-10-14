<?php

namespace Winnetou\Test;

use PHPUnit\Framework\TestCase;
use Winnetou\GitLogVO;

/**
 * @covers \Winnetou\GitLogVO
 */
class GitLogVOTest extends TestCase
{
    /**
     * @var \DateTime
     */
    protected static $dateTime;

    /**
     * @var string
     */
    protected $hash = '0108cfc2c190cca3c8b5fc73e5d11cf72e4e0a00';

    /**
     * @var string
     */
    protected $issueKey = 'abirvalg';

    /**
     * @var string
     */
    protected $comment = 'unit tests and travis-ci';

    public static function setUpBeforeClass()
    {
        static::$dateTime = new \DateTime('now');
    }

    public function test__construct()
    {
        $obj = new GitLogVO(
            $this->hash,
            static::$dateTime,
            $this->issueKey,
            $this->comment
        );
        $this->assertInstanceOf(GitLogVO::class, $obj);

        return $obj;
    }

    /**
     * @depends test__construct
     * @param GitLogVO $obj
     */
    public function testGetIssueKey(GitLogVO $obj)
    {
        $this->assertEquals($this->issueKey, $obj->getIssueKey());
    }

    /**
     * @depends test__construct
     * @param GitLogVO $obj
     */
    public function testGetComment(GitLogVO $obj)
    {
        $this->assertEquals($this->comment, $obj->getComment());
    }

    /**
     * @depends test__construct
     * @param GitLogVO $obj
     */
    public function testGetDateTime(GitLogVO $obj)
    {
        $this->assertEquals(static::$dateTime, $obj->getDateTime());
    }

    /**
     * @depends test__construct
     * @param GitLogVO $obj
     */
    public function testGetHash(GitLogVO $obj)
    {
        $this->assertEquals($this->hash, $obj->getHash());
    }
}
