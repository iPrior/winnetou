<?php


namespace Winnetou;


class GitLogParserConfigVO
{
    /**
     * @var string
     */
    protected $repoDir = '';

    /**
     * @var string
     */
    protected $pattern = '';

    /**
     * @var string
     */
    protected $authorMask = '';

    /**
     * @var \DateTime
     */
    protected $afterDt;

    /**
     * GitLogParserConfigVO constructor.
     * @param string $repoDir
     * @param string $pattern
     * @param string $authorMask
     * @param \DateTime $afterDateTime
     * @throws \InvalidArgumentException
     */
    public function __construct(
        string $repoDir,
        string $pattern,
        string $authorMask,
        \DateTime $afterDateTime
    )
    {
        $this->setRepoDir($repoDir)
            ->setPattern($pattern)
            ->setAuthorMask($authorMask)
            ->setAfterDt($afterDateTime);

        $this->checkInvariant();
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function checkInvariant()
    {
        if (!$this->getRepoDir()) {
            throw new \InvalidArgumentException('Repository directory path is empty');
        }
        if (!$this->getPattern()) {
            throw new \InvalidArgumentException('Pattern is empty');
        }
        if (!$this->getAuthorMask()) {
            throw new \InvalidArgumentException('Author mask is empty');
        }

        if (!file_exists($this->getRepoDir())) {
            throw new \InvalidArgumentException('Repository directory not found by path: ' . $this->getRepoDir());
        }
        if (!is_dir($this->getRepoDir())) {
            throw new \InvalidArgumentException('This is not directory: ' . $this->getRepoDir());
        }
        if (!is_readable($this->getRepoDir())) {
            throw new \InvalidArgumentException('Repository directory is not readable: ' . $this->getRepoDir());
        }
    }

    /**
     * @return string
     */
    public function getRepoDir(): string
    {
        return $this->repoDir;
    }

    /**
     * @param string $repoDir
     * @return GitLogParserConfigVO
     */
    protected function setRepoDir(string $repoDir): GitLogParserConfigVO
    {
        $this->repoDir = trim($repoDir);
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
     * @return GitLogParserConfigVO
     */
    protected function setPattern(string $pattern): GitLogParserConfigVO
    {
        $this->pattern = $pattern;
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
     * @return GitLogParserConfigVO
     */
    protected function setAuthorMask(string $authorMask): GitLogParserConfigVO
    {
        $this->authorMask = trim($authorMask);
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAfterDt(): \DateTime
    {
        return $this->afterDt;
    }

    /**
     * @param \DateTime $afterDt
     * @return GitLogParserConfigVO
     */
    protected function setAfterDt(\DateTime $afterDt): GitLogParserConfigVO
    {
        $this->afterDt = $afterDt;
        return $this;
    }
}
