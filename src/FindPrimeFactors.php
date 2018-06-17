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
        $factorArray = $this->findFactors([$inputNumber]);
        $output->writeln("<info>The prime factors of {$inputNumber} are {$this->arrayToString($factorArray)}</info>");
    }

    private function findFactors($inputNumbers) {
        $outputNumbers = $inputNumbers;
        for ($a = 0; $a < count($outputNumbers); $a++) {
            for ($i = 2; $i < $outputNumbers[$a]; $i++) {
                if (($outputNumbers[$a] % $i) === 0 && $outputNumbers[$a] !== $i) {
                    // cut $a value from array, push $input[$a] and $input[$a]/$i
                    $factorA = $outputNumbers[$a] / $i;
                    $factorB = $i;array_splice($outputNumbers, $a, 1);
                    $a++;
                    array_push($outputNumbers, $factorA, $factorB);
                }
            }
        }
        if($inputNumbers !== $outputNumbers){
            return $this->findFactors($outputNumbers);
        }
        asort($outputNumbers);
        return $outputNumbers;
    }
    
    private function arrayToString($inputArray){
        $outputString = "";
        if(count($inputArray) === 0){
            return $outputString;
        }
        for($i = 0; $i < count($inputArray); $i++){
            $appendString = ", ";
            if($i === (count($inputArray) - 1)){
                $appendString = ", and ";
            }
            $outputString = $outputString . $appendString . $inputArray[$i];
        }
        $outputString = trim($outputString, ", and");
        return $outputString;
    }

}
