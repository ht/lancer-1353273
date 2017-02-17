<?php

namespace Plugin\ProductSortColumn\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PluginCommand extends \Knp\Command\Command
{
    protected function configure()
    {
        $this->setName('product_sort_column:command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
    }
}