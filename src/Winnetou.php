<?php


namespace Winnetou;


use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\IssueService;

class Winnetou
{
    /**
     * @var WinnetouConfigVO
     */
    protected $config;

    /**
     * @var array
     */
    protected $repoDirs = [];

    /**
     * Winnetou constructor.
     * @param WinnetouConfigVO $config
     */
    public function __construct(WinnetouConfigVO $config)
    {
        $this->config = $config;
        $this->findRepositories();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function createWorkLog()
    {
        $combine = new GitLogCombine($this->config->getStartWorkDayDt());
        foreach ($this->repoDirs as $repoDir) {
            $parserConfig = new GitLogParserConfigVO(
                $repoDir,
                $this->config->getPattern(),
                $this->config->getAuthorMask(),
                $this->config->getStartWorkDayDt()
            );
            $parser = new GitLogParser($parserConfig);

            $combine->appendGitLogList($parser->getData());
        }

        $combineDataList = $combine->getResultData();

        $returnData = [];
        if ($combineDataList) {
            $jiraIssueService = new IssueService(
                new ArrayConfiguration(
                    [
                        'jiraHost' => $this->config->getJiraHost(),
                        'jiraUser' => $this->config->getJiraLogin(),
                        'jiraPassword' => $this->config->getJiraPassword(),
                        'cookieAuthEnabled' => true,
                        'cookieFile' => __DIR__ . '/../jira-cookie.txt',
                    ]
                )
            );

            foreach ($combineDataList as $item) {
                $ret = new \stdClass();
                $ret->id = 'OOPS';
                try {
                    if ($this->config->isDebug()) {
                        $ret->id = 'DEBUG';
                    } else {
                        $ret = $this->sendToJira($item, $jiraIssueService);
                    }
                    $status = $ret->id ? 'OK' : 'FAIL';
                } catch (\Exception $e) {
                    $status = 'ERROR';
                }

                $interval = new \DateInterval('PT' . $item->getTimeSpentSeconds() . 'S');
                $returnData[] = [
                    $status,
                    $ret->id,
                    $item->getIssueKey(),
                    $item->getIssueStarted()->format('Y-m-d H:i:s'),
                    $item->getIssueStarted()->add($interval)->format('Y-m-d H:i:s'),
                    $item->getTimeSpentSeconds(),
                    $item->getComment()
                ];
            }
        }

        return $returnData;
    }

    /**
     * @param GitLogCombineDataVO $item
     * @param IssueService $jiraIssueService
     * @return mixed
     * @throws \JiraRestApi\JiraException
     * @codeCoverageIgnore
     */
    protected function sendToJira(GitLogCombineDataVO $item, IssueService $jiraIssueService)
    {
        $jiraWorkLog = new \JiraRestApi\Issue\Worklog();
        $jiraWorkLog->setComment($item->getComment())
            ->setStarted($item->getIssueStarted())
            ->setTimeSpentSeconds($item->getTimeSpentSeconds());
        $ret = $jiraIssueService->addWorklog(
            $item->getIssueKey(),
            $jiraWorkLog
        );
        return $ret;
    }

    protected function findRepositories()
    {
        $dirs = [];
        foreach ($this->config->getRootDirs() as $rootDir) {
            $cmd = 'find ' . $rootDir . ' -type d -name .git';
            exec($cmd . ' 2>&1', $dirs);

            foreach ($dirs as $item) {
                if (preg_match('/vendor/', $item)) {
                    continue;
                }

                $this->repoDirs[] = realpath($item . DIRECTORY_SEPARATOR . '..');
            }
        }

        $this->repoDirs = array_unique($this->repoDirs);
    }
}
