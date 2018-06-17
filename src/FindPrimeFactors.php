<?php

namespace Robert;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class FindPrimeFactors extends Command {

    public function configure() {
        $this->setName("FindFactors")
                ->setDescription("Outputs all prime factors of the input integer.")
                ->addArgument("Number", InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output) {
        $inputNumber = $input->getArgument('Number');
        if (filter_var($inputNumber, FILTER_VALIDATE_INT) === false) {
            $output->writeln("<error>Input is not an integer. Please enter an integer</error>");
            exit(1);
        }
        $factorArray = $this->findFactors([$inputNumber], $output);
        $output->writeln("<info>{$this->arrayToString($factorArray)}</info>");
        //$output->writeln("<info>$factorArray</info>");
    }

    private function findFactors($inputNumbers, $output) {
        $outputNumbers = $inputNumbers;
        for ($a = 0; $a < count($outputNumbers); $a++) {
            for ($i = 2; $i < $outputNumbers[$a]; $i++) {
                if (($outputNumbers[$a] % $i) === 0 && $outputNumbers[$a] !== $i) {
                    // cut $a value from array, push $input[$a] and $input[$a]/$i
                    $factorA = $outputNumbers[$a] / $i;
                    $factorB = $i;
                    //useful lines for debugging
                    //$output->writeln("<info>Current array is: {$this->arrayToString($inputNumbers)}</info>");
                    //$output->writeln("<info>Removing {$outputNumbers[$a]}"
                    //. " and replacing it with {$factorA} and {$factorB}</info>");
                    array_splice($outputNumbers, $a, 1);
                    $a++;
                    array_push($outputNumbers, $factorA, $factorB);
                }
            }
        }
        if($inputNumbers !== $outputNumbers){
            return $this->findFactors($outputNumbers, $output);
        }
        return $outputNumbers;
    }
    
    private function arrayToString($inputArray){
        $outputString = "";
        if(count($inputArray) === 0){
            return $outputString;
        }
        for($i = 0; $i < count($inputArray); $i++){
            $outputString = $outputString . ", " . $inputArray[$i];
        }
        $outputString = trim($outputString, ", ");
        return $outputString;
    }

}
