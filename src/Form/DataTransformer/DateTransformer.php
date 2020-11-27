<?php

namespace App\Form\DataTransformer;

use DateTime;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateTransformer implements DataTransformerInterface
{
    /**
     * transform
     *
     * @param DateTime $date
     * 
     * @return string
     */
    public function transform($date){
        if($date === null) {
            return '';
        }

        return $date->format('Y-m-d');
    }
    
    /**
     * reverseTransform
     *
     * @param string $dateString
     * 
     * @return DateTime
     */
    public function reverseTransform($dateString){

        if($dateString === null) {
            throw new TransformationFailedException();
        }

        $date = DateTime::createFromFormat('d/m/Y', $dateString);

        if($date === false) {
            throw new TransformationFailedException();
        }

        return $date;
    }
}
