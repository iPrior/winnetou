<?php


namespace Winnetou;


class GitLogVO
{
    /**
     * @var string
     */
    protected $hash = '';

    /**
     * @var \DateTime
     */
    protected $dateTime;

    /**
     * @var string
     */
    protected $issueKey = '';

    /**
     * @var string
     */
    protected $comment = '';

    /**
     * GitLogVO constructor.
     * @param string $hash
     * @param \DateTime $dateTime
     * @param string $issueKey
     * @param string $comment
     * @throws \InvalidArgumentException
     */
    public function __construct(
        string $hash,
        \DateTime $dateTime,
        string $issueKey,
        string $comment
    )
    {
        $this->setHash($hash)
            ->setDateTime($dateTime)
            ->setIssueKey($issueKey)
            ->setComment($comment);
        $this->checkInvariant();
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function checkInvariant()
    {
        if (!$this->getHash()) {
            throw new \InvalidArgumentException('Git commit hash is empty');
        }
        if (!$this->getIssueKey()) {
            throw new \InvalidArgumentException('Issue key is empty');
        }
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return GitLogVO
     */
    protected function setHash(string $hash): GitLogVO
    {
        $this->hash = trim($hash);
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param \DateTime $dateTime
     * @return GitLogVO
     */
    protected function setDateTime(\DateTime $dateTime): GitLogVO
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getIssueKey(): string
    {
        return $this->issueKey;
    }

    /**
     * @param string $issueKey
     * @return GitLogVO
     */
    protected function setIssueKey(string $issueKey): GitLogVO
    {
        $this->issueKey = trim($issueKey);
        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return GitLogVO
     */
    protected function setComment(string $comment): GitLogVO
    {
        $this->comment = trim($comment);
        return $this;
    }
}
