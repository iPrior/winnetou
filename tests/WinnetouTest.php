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
                'WATCH-1',
                '2018-10-14 10:00:00',
                '2018-10-14 11:58:20',
                7100,
                'First test commit',
            ],
            [
                'OK',
                'DEBUG',
                'WATCH-2',
                '2018-10-14 11:58:20',
                '2018-10-14 12:23:26',
                1506,
                'unit tests',
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
