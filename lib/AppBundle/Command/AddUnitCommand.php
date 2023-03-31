<?php

namespace Imported\AppBundle\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Pimcore\Model\DataObject\QuantityValue\Unit;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:add-unit')]
class AddUnitCommand extends Command
{
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct();
        $this->logger = $logger;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $unitItems=[["id" => "1","abbreviation" => "kw", "longname" => "kilowatt"],["id" => "2","abbreviation" => "w","longname" => "watt","baseunit" => "1","factor" => 0.001]];
        $output->writeln(['Prepared Default Units ','============']);
        foreach($unitItems as $unitItem) {
            $unit = new Unit();
            $unit->setValues($unitItem);
            try {
                $unit->save();
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                return Command::FAILURE;
            }
        }
        $output->writeln(['Processed Default Units ','============']);
        return Command::SUCCESS;
    }
}
