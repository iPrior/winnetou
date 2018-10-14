<?php


namespace Winnetou;


class WinnetouConfigVO
{
    /**
     * @var \DateTime
     */
    protected $startWorkDayDt;

    /**
     * @var string
     */
    protected $pattern = '';

    /**
     * @var string
     */
    protected $authorMask = '';

    /**
     * @var array
     */
    protected $rootDirs = [];

    /**
     * @var string
     */
    protected $jiraHost = '';

    /**
     * @var string
     */
    protected $jiraLogin = '';

    /**
     * @var string
     */
    protected $jiraPassword = '';

    /**
     * @var bool
     */
    protected $debug = true;

    protected function __construct()
    {

    }

    /**
     * @param array $config
     * @return WinnetouConfigVO
     * @throws \InvalidArgumentException
     * @throws \Error
     */
    public static function createFromArray(array $config): WinnetouConfigVO
    {
        $config = self::prepareDateTime(
            self::convertArrayKeys($config)
        );

        $self = new self();
        $self->setStartWorkDayDt($config['start-work-day-dt'])
            ->setPattern($config['pattern'] ?? '')
            ->setAuthorMask($config['author-mask'] ?? '')
            ->setRootDirs($config['root-dirs'] ?? [])
            ->setJiraHost($config['jira-host'] ?? '')
            ->setJiraLogin($config['jira-login'] ?? '')
            ->setJiraPassword($config['jira-password'] ?? '')
            ->setDebug($config['debug'] ?? $self->debug);

        $self->checkInvariant();

        return $self;
    }

    /**
     * @param array $data
     * @return array
     */
    protected static function prepareDateTime(array $data): array
    {
        $keys = [
            'start-work-day-dt',
            'end-work-day-dt',
        ];

        foreach ($keys as $key) {
            $dt = $data[$key] ?? null;
            if ($dt instanceof \DateTime) {
                continue;
            } elseif (is_scalar($dt)) {
                $data[$key] = new \DateTime($dt);
            } else {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    protected static function convertArrayKeys(array $data): array
    {
        $ret = [];
        foreach ($data as $k => $v) {
            $key = strtolower(
                implode(
                    '-',
                    preg_split('/(?=[A-Z])/', $k, -1, PREG_SPLIT_NO_EMPTY)
                )
            );
            $ret[$key] = $v;
        }

        return $ret;
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function checkInvariant()
    {
        if (!$this->getPattern()) {
            throw new \InvalidArgumentException('Pattern is empty');
        }
        if (!$this->getAuthorMask()) {
            throw new \InvalidArgumentException('Author mask is empty');
        }
        if (!$this->getRootDirs()) {
            throw new \InvalidArgumentException('Root directories is empty');
        }
        if (!$this->getJiraHost()) {
            throw new \InvalidArgumentException('JIRA host is empty');
        }
        if (!$this->getJiraLogin()) {
            throw new \InvalidArgumentException('JIRA login is empty');
        }
        if (!$this->getJiraPassword()) {
            throw new \InvalidArgumentException('JIRA password is empty');
        }

        foreach ($this->getRootDirs() as $rootDir) {
            if (!file_exists($rootDir)) {
                throw new \InvalidArgumentException('Repository directory not found by path: ' . $rootDir);
            }
            if (!is_dir($rootDir)) {
                throw new \InvalidArgumentException('This is not directory: ' . $rootDir);
            }
            if (!is_readable($rootDir)) {
                throw new \InvalidArgumentException('Repository directory is not readable: ' . $rootDir);
            }
        }
    }

    /**
     * @return \DateTime
     */
    public function getStartWorkDayDt(): \DateTime
    {
        return $this->startWorkDayDt;
    }

    /**
     * @param \DateTime $startWorkDayDt
     * @return WinnetouConfigVO
     */
    protected function setStartWorkDayDt(\DateTime $startWorkDayDt): WinnetouConfigVO
    {
        $this->startWorkDayDt = $startWorkDayDt;
        return $this;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     * @return WinnetouConfigVO
     */
    protected function setPattern(string $pattern): WinnetouConfigVO
    {
        $this->pattern = trim($pattern);
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorMask(): string
    {
        return $this->authorMask;
    }

    /**
     * @param string $authorMask
     * @return WinnetouConfigVO
     */
    protected function setAuthorMask(string $authorMask): WinnetouConfigVO
    {
        $this->authorMask = trim($authorMask);
        return $this;
    }

    /**
     * @return array
     */
    public function getRootDirs(): array
    {
        return $this->rootDirs;
    }

    /**
     * @param array $rootDirs
     * @return WinnetouConfigVO
     */
    protected function setRootDirs(array $rootDirs): WinnetouConfigVO
    {
        $this->rootDirs = array_map('trim', $rootDirs);
        return $this;
    }

    /**
     * @return string
     */
    public function getJiraHost(): string
    {
        return $this->jiraHost;
    }

    /**
     * @param string $jiraHost
     * @return WinnetouConfigVO
     */
    protected function setJiraHost(string $jiraHost): WinnetouConfigVO
    {
        $this->jiraHost = trim($jiraHost);
        return $this;
    }

    /**
     * @return string
     */
    public function getJiraLogin(): string
    {
        return $this->jiraLogin;
    }

    /**
     * @param string $jiraLogin
     * @return WinnetouConfigVO
     */
    protected function setJiraLogin(string $jiraLogin): WinnetouConfigVO
    {
        $this->jiraLogin = trim($jiraLogin);
        return $this;
    }

    /**
     * @return string
     */
    public function getJiraPassword(): string
    {
        return $this->jiraPassword;
    }

    /**
     * @param string $jiraPassword
     * @return WinnetouConfigVO
     */
    protected function setJiraPassword(string $jiraPassword): WinnetouConfigVO
    {
        $this->jiraPassword = $jiraPassword;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     * @return WinnetouConfigVO
     */
    protected function setDebug(bool $debug): WinnetouConfigVO
    {
        $this->debug = $debug;
        return $this;
    }
}
