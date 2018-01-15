<?php
namespace App\Utils;
class Lottery
{
    public function getRand()
    {

        $index = 0;
        $upPriceIndex = $this->getRandIndex($index);

        for ($j = 0; $j < $index + 1; $j++) {

            $i = 0;

            while ($i < 20 || (!$index++)) {

                if ($upPriceIndex > $index) {

                    $upPriceIndex = $this->getRandIndex($index);


                } else {

                    break;
                }

                $i++;
            }

            if ($i != 20) {
                break;
            }

        }
        return $upPriceIndex;


    }

    public function getRandIndex($index)
    {

        $upPriceIndex = mt_rand($index, 4);

        return $upPriceIndex;
    }

    public function getPrice() {
        $prizeArr = array(20, 50, 100, 150, 200);

        $upPriceIndex = $this->getRand();

        $price = 0;

        while (!$price) {
            $price = rand(0, $prizeArr[$upPriceIndex]) / 10;
        }
        return $price;
    }

}



?>