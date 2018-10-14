<?php

namespace Winnetou\Test;

use PHPUnit\Framework\TestCase;
use Winnetou\Winnetou;
use Winnetou\WinnetouConfigVO;

/**
 * @covers \Winnetou\Winnetou
 */
class WinnetouTest extends TestCase
{
    /**
     * @var WinnetouConfigVO
     */
    protected static $config;

    /**
     * @var array
     */
    protected static $actualData = [];

    public static function setUpBeforeClass()
    {
        $config = require __DIR__ . '/config.test.php';
        static::$config = WinnetouConfigVO::createFromArray($config);

        static::$actualData = [
            [
                'OK',
                'DEBUG',
                'WINNETOU-1',
                '2018-10-14 10:00:00',
                '2018-10-14 15:10:44',
                18644,
                'First commit',
            ],
            [
                'OK',
                'DEBUG',
                'WINNETOU-2',
                '2018-10-14 15:10:44',
                '2018-10-14 15:13:40',
                176,
                'Test commit',
            ],
        ];
    }

    public function test__construct()
    {
        $obj = new Winnetou(static::$config);
        $this->assertInstanceOf(Winnetou::class, $obj);

        return $obj;
    }

    /**
     * @depends test__construct
     * @param Winnetou $obj
     * @throws \Exception
     */
    public function testCreateWorkLog(Winnetou $obj)
    {
        $data = $obj->createWorkLog();
        foreach (static::$actualData as $k => $item) {
            $this->assertArrayHasKey($k, $data);
            foreach ($item as $a => $v) {
                $this->assertEquals($data[$k][$a], $v);
            }
        }
    }
}
