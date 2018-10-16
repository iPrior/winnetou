<?php


namespace Winnetou;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @codeCoverageIgnore
 */
class WinnetouConsoleCommand extends Command
{
    protected const ARG_CONFIG_PATH = 'config-path';
    protected const ARG_DEBUG = 'debug';
    protected const ARG_DATE = 'date';
    protected const ARG_START_WORK_DAY_DT = 'start-work-dt';

    protected function configure()
    {
        $this->setName('winnetou')
            ->addArgument(self::ARG_CONFIG_PATH, InputArgument::REQUIRED, 'path to config file')
            ->addArgument(self::ARG_DEBUG, InputArgument::OPTIONAL, 'Debug (1 or 0)', null)
            ->addArgument(self::ARG_START_WORK_DAY_DT, InputArgument::OPTIONAL, 'working day start time', null)
            ->setDescription('Create Jira WorkLog by git commits');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument(self::ARG_CONFIG_PATH);
        $debug = $input->getArgument(self::ARG_DEBUG);
        $startWorkDay = $input->getArgument(self::ARG_START_WORK_DAY_DT);

        try {
            $config = require $filePath;
            if (null !== $startWorkDay) {
                $config['start-work-day-dt'] = new \DateTime($startWorkDay);
            }
            if (null !== $debug) {
                $config['debug'] = (bool)$debug;
            }

            $winnetouConfig = WinnetouConfigVO::createFromArray($config);
            $winnetou = new Winnetou($winnetouConfig);

            $data = $winnetou->createWorkLog();

            $table = new Table($output);
            $table->setHeaders([
                'Status', 'WorkLog ID', 'Issue', 'Start DateTime', 'End DateTime', 'Work time (sec.)', 'Description'
            ]);

            foreach ($data as $row) {
                $table->addRow($row);
            }

            $table->render();

        } catch (\Exception $e) {
            $output->writeln('ERROR: ' . $e->getMessage());
        } catch (\Error $e) {
            $output->writeln('ERROR: ' . $e->getMessage());
        }
    }
}
