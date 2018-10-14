<?php


namespace Winnetou;


class GitLogParser
{
    /**
     * @var GitLogVO[]
     */
    protected $data = [];

    /**
     * @var GitLogParserConfigVO
     */
    protected $config;

    /**
     * GitLogParser constructor.
     * @param GitLogParserConfigVO $config
     * @throws \Exception
     */
    public function __construct(GitLogParserConfigVO $config)
    {
        if ('Linux' !== PHP_OS) {
            throw new \Exception('Sorry, i am work  only on linux =(');
        }

        $this->config = $config;
    }

    /**
     * @return GitLogVO[]
     */
    public function getData(): array
    {
        if (!$this->data) {
            $this->parse();
        }

        return $this->data;
    }

    protected function parse()
    {
        $repoDir = $this->config->getRepoDir();
        $author = $this->config->getAuthorMask();
        $after = $this->config->getAfterDt()->format('Y-m-d');

        $commits = [];
        $cmd = 'cd ' . $repoDir . ' && git log --author=' . $author . ' --after=' . $after . 'T00:00:00';
        exec($cmd . ' 2>&1', $commits);

        if ($commits) {
            $commits[] = '';
            $pattern = $this->config->getPattern();
            $matches = [];
            preg_match_all($pattern, implode(PHP_EOL, $commits), $matches);

            if ($matches && isset($matches['hash'])) {
                foreach ($matches['hash'] as $i => $hash) {
                    $dt = $matches['dt'][$i] ?? '';
                    $issue = $matches['issue'][$i] ?? '';
                    $comment = $matches['comment'][$i] ?? '';

                    if (!$hash || !$dt || !$issue) {
                        continue;
                    }

                    $this->data[$hash] = new GitLogVO(
                        $hash,
                        new \DateTime($dt),
                        $issue,
                        $comment
                    );
                }
            }
        }
    }
}
