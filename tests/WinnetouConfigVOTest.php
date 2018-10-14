<?php

namespace Winnetou\Test;

use PHPUnit\Framework\TestCase;
use Winnetou\WinnetouConfigVO;

/**
 * @covers \Winnetou\WinnetouConfigVO
 */
class WinnetouConfigVOTest extends TestCase
{
    /**
     * @var array
     */
    protected static $config = [];

    public static function setUpBeforeClass()
    {
        static::$config = require __DIR__ . '/config.test.php';
    }

    public function testCreateFromArray()
    {
        $obj = WinnetouConfigVO::createFromArray(static::$config);
        $this->assertInstanceOf(WinnetouConfigVO::class, $obj);

        return $obj;
    }

    /**
     * @depends testCreateFromArray
     */
    public function testCheckInvariantPattern()
    {
        $config = static::$config;
        $config['pattern'] = '';
        $this->expectException(\InvalidArgumentException::class);
        WinnetouConfigVO::createFromArray($config);
    }

    /**
     * @depends testCreateFromArray
     */
    public function testCheckInvariantAuthorMask()
    {
        $config = static::$config;
        $config['author-mask'] = '';
        $this->expectException(\InvalidArgumentException::class);
        WinnetouConfigVO::createFromArray($config);
    }

    /**
     * @depends testCreateFromArray
     */
    public function testCheckInvariantRootDirs()
    {
        $config = static::$config;
        $config['root-dirs'][0] = 'abirvalg';
        $this->expectException(\InvalidArgumentException::class);
        WinnetouConfigVO::createFromArray($config);
    }

    /**
     * @depends testCreateFromArray
     */
    public function testCheckInvariantJiraHost()
    {
        $config = static::$config;
        $config['jira-host'] = '';
        $this->expectException(\InvalidArgumentException::class);
        WinnetouConfigVO::createFromArray($config);
    }

    /**
     * @depends testCreateFromArray
     */
    public function testCheckInvariantJiraLogin()
    {
        $config = static::$config;
        $config['jira-login'] = '';
        $this->expectException(\InvalidArgumentException::class);
        WinnetouConfigVO::createFromArray($config);
    }

    /**
     * @depends testCreateFromArray
     */
    public function testCheckInvariantJiraPassword()
    {
        $config = static::$config;
        $config['jira-password'] = '';
        $this->expectException(\InvalidArgumentException::class);
        WinnetouConfigVO::createFromArray($config);
    }

    /**
     * @depends testCreateFromArray
     * @param WinnetouConfigVO $obj
     */
    public function testGetStartWorkDayDt(WinnetouConfigVO $obj)
    {
        $this->assertEquals(static::$config['start-work-day-dt'], $obj->getStartWorkDayDt());
    }

    /**
     * @depends testCreateFromArray
     * @param WinnetouConfigVO $obj
     */
    public function testGetAuthorMask(WinnetouConfigVO $obj)
    {
        $this->assertEquals(static::$config['author-mask'], $obj->getAuthorMask());
    }

    /**
     * @depends testCreateFromArray
     * @param WinnetouConfigVO $obj
     */
    public function testGetRootDirs(WinnetouConfigVO $obj)
    {
        $this->assertEquals(static::$config['root-dirs'], $obj->getRootDirs());
    }

    /**
     * @depends testCreateFromArray
     * @param WinnetouConfigVO $obj
     */
    public function testGetJiraHost(WinnetouConfigVO $obj)
    {
        $this->assertEquals(static::$config['jira-host'], $obj->getJiraHost());
    }

    /**
     * @depends testCreateFromArray
     * @param WinnetouConfigVO $obj
     */
    public function testIsDebug(WinnetouConfigVO $obj)
    {
        $this->assertEquals(static::$config['debug'], $obj->isDebug());
    }

    /**
     * @depends testCreateFromArray
     * @param WinnetouConfigVO $obj
     */
    public function testGetPattern(WinnetouConfigVO $obj)
    {
        $this->assertEquals(static::$config['pattern'], $obj->getPattern());
    }

    /**
     * @depends testCreateFromArray
     * @param WinnetouConfigVO $obj
     */
    public function testGetJiraLogin(WinnetouConfigVO $obj)
    {
        $this->assertEquals(static::$config['jira-login'], $obj->getJiraLogin());
    }

    /**
     * @depends testCreateFromArray
     * @param WinnetouConfigVO $obj
     */
    public function testGetJiraPassword(WinnetouConfigVO $obj)
    {
        $this->assertEquals(static::$config['jira-password'], $obj->getJiraPassword());
    }
}
