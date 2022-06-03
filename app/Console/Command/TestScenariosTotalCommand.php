<?php

namespace App\Console\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Electronics\Console;
use App\Electronics\Controller;
use App\Electronics\Microwave;
use App\Electronics\Television;

use App\Services\ElectronicItems;

#[AsCommand(
    name: 'app:scenarios_total',
    description: 'This command will make a purchase and display in order the purchased items and the total sum',
    hidden: false
)]
class TestScenariosTotalCommand extends Command
{

    /**
     * Initiating the purchases and display the purchased items
     * 
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Instanciating the eletronics
        $console = new Console();
        $console->setType('console');
        $console->setPrice(350.00);

        $firstTelevision = new Television();
        $firstTelevision->setType('television');
        $firstTelevision->setPrice(1099.00);
        
        $secondTelevision = new Television();
        $secondTelevision->setType('television');
        $secondTelevision->setPrice(2099.99);
        
        $microwave = new Microwave();
        $microwave->setType('microwave');
        $microwave->setPrice(75.50);
        
        // Let's add extras to the eletronics
        $consoleExtras = array(
            ['price' => 20.15, 'isWired' => true],
            ['price' => 40.00, 'isWired' => false],
            ['price' => 90.00, 'isWired' => true],
            ['price' => 16.75, 'isWired' => false]
        );
        
        $firstTelevisionExtras = array(
            ['price' => 12.80, 'isWired' => false],
            ['price' => 12.80, 'isWired' => false]
        );
        
        $secondTelevisionExtras = array(
            ['price' => 12.80, 'isWired' => false]
        );
        
        $this->addExtrasToEletronic($console, $consoleExtras);
        $this->addExtrasToEletronic($firstTelevision, $firstTelevisionExtras);
        $this->addExtrasToEletronic($secondTelevision, $secondTelevisionExtras);

        // grouping our eletronics under a service instance 
        //so we can call 'shopping' methods such as suming up the total
        $electronicItems = new ElectronicItems([
            $console,
            $firstTelevision,
            $secondTelevision,
            $microwave
        ]);
        
        // getting the sorted list of items by price
        $sortedItems = $electronicItems->sortItems();

        $output->writeln("QUESTION 1:");
        $output->writeln("***************Items ordered***************");
        foreach ($sortedItems as $key => $value) {
            $output->writeln("Item : " . $value->getType() . " - " . $value->getPrice());
            if($value->countExtras() > 0){
                $extras = $value->getSortedExtras();
                foreach ($extras as $extraKey => $extraValue) {
                    $output->writeln("Extra : " . $extraValue->getType() . " - " . $extraValue->getPrice());
                }
            }
        }
        
        // showing the total price
        $output->writeln("***************Total Pricing***************");
        $output->writeln("The shopping cart total is: $" . $electronicItems->getTotalPrice());
        
        // showing the total priceof the console and its controllers
        $output->writeln("QUESTION 2:");
        $output->writeln("The total sum of the console and its controllers is: $" . $console->getTotalPriceOfItemAndExtras('console'));

        return Command::SUCCESS;
    }
    
    private function addExtrasToEletronic($item, array $extras)
    {
        foreach ($extras as $extra) {
            if ($item->canAddExtras()) {

                $controller = new Controller();
                $controller->setType('controller');
                $controller->setPrice($extra['price']);
                $controller->setWired($extra['isWired']);

                $item->setExtras($controller);
            }
        }
    }
}