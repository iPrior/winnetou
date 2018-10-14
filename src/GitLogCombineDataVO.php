<?php


namespace Winnetou;


class GitLogCombineDataVO extends GitLogVO
{
    /**
     * @var \DateTime
     */
    protected $issueStarted;

    /**
     * @var int
     */
    protected $timeSpentSeconds = 0;

    /**
     * GitLogCombineDataVO constructor.
     * @param \DateTime $issueStarted
     * @param int $timeSpentSeconds
     * @param GitLogVO $gitLogVO
     */
    public function __construct(\DateTime $issueStarted, int $timeSpentSeconds, GitLogVO $gitLogVO)
    {
        parent::__construct($gitLogVO->getHash(), $gitLogVO->getDateTime(), $gitLogVO->getIssueKey(), $gitLogVO->getComment());

        $this->setIssueStarted($issueStarted)
            ->setTimeSpentSeconds($timeSpentSeconds);
        $this->checkInvariant();
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function checkInvariant()
    {
        if ($this->getTimeSpentSeconds() < 0) {
            throw new \InvalidArgumentException('Time spent seconds less zero');
        }
    }

    /**
     * @return \DateTime
     */
    public function getIssueStarted(): \DateTime
    {
        return $this->issueStarted;
    }

    /**
     * @param \DateTime $issueStarted
     * @return GitLogCombineDataVO
     */
    protected function setIssueStarted(\DateTime $issueStarted): GitLogCombineDataVO
    {
        $this->issueStarted = $issueStarted;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeSpentSeconds(): int
    {
        return $this->timeSpentSeconds;
    }

    /**
     * @param int $timeSpentSeconds
     * @return GitLogCombineDataVO
     */
    protected function setTimeSpentSeconds(int $timeSpentSeconds): GitLogCombineDataVO
    {
        $this->timeSpentSeconds = $timeSpentSeconds;
        return $this;
    }
}
