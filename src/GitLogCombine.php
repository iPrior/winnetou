<?php


namespace Winnetou;


class GitLogCombine
{
    /**
     * @var GitLogVO[]
     */
    protected $rawCommits = [];

    /**
     * @var GitLogCombineDataVO[]
     */
    protected $sortedCommits = [];

    /**
     * @var \DateTime
     */
    protected $startWorkDayDt;

    /**
     * GitLogCombine constructor.
     * @param \DateTime $startWorkDayDt
     */
    public function __construct(\DateTime $startWorkDayDt)
    {
        $this->startWorkDayDt = $startWorkDayDt;
    }

    /**
     * @param array $gitLogList
     * @return GitLogCombine
     */
    public function appendGitLogList(array $gitLogList): GitLogCombine
    {
        foreach ($gitLogList as $item) {
            $this->appendGitLog($item);
        }

        return $this;
    }

    /**
     * @param GitLogVO $gitLogVO
     * @return GitLogCombine
     */
    public function appendGitLog(GitLogVO $gitLogVO): GitLogCombine
    {
        $this->rawCommits[$gitLogVO->getHash()] = $gitLogVO;

        return $this;
    }

    /**
     * @return GitLogCombineDataVO[]
     * @throws \Exception
     */
    public function getResultData(): array
    {
        $this->combine();

        return $this->sortedCommits;
    }

    /**
     * @throws \Exception
     */
    protected function combine()
    {
        $startDt = $this->startWorkDayDt;
        $sorted = $this->rawCommits;
        if ($sorted) {

            usort($sorted, function (GitLogVO $a, GitLogVO $b) {
                $aTS = $a->getDateTime()->getTimestamp();
                $bTS = $b->getDateTime()->getTimestamp();

                if ($aTS === $bTS) {
                    return 0;
                }

                return $aTS < $bTS ? -1 : 1;
            });


            if (current($sorted)->getDateTime()->getTimestamp() < $startDt->getTimestamp()) {
                $startDt = clone current($sorted)->getDateTime();
                $startDt->sub(new \DateInterval('PT1H'));
            }

            foreach ($sorted as $item) {
                $timeSpent = $item->getDateTime()->getTimestamp() - $startDt->getTimestamp();
                $started = clone $startDt;
                $this->sortedCommits[] = new GitLogCombineDataVO($started, $timeSpent, $item);
                $startDt = clone $item->getDateTime();
            }
        }
    }
}
