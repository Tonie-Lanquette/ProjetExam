<?php

namespace App\Tests\Entity;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ArticleEntityTest extends KernelTestCase
{
    public function testValidEntity (){
        $testEntity = (new Article())
            ->setTitle('Test title')
            ->setIntroduction('Test introduction')
            ->setStarterExplication('Test starter')
            ->setCoreExplication('Test core')
            ->setOptionalExplication('Test optional')
            ->setConclusion('Test conclusion')
            ->setCreated(new \DateTime());
        
        self::bootKernel();

        $validator = self::getContainer()->get(ValidatorInterface::class);
        $errors = $validator->validate($testEntity);
        $this->assertCount(0, $errors);
    }

    public function testInvalidEntity()
    {
        $testEntity = (new Article())
            ->setTitle('')
            ->setIntroduction('Test introduction')
            ->setStarterExplication('Test starter')
            ->setCoreExplication('Test core')
            ->setOptionalExplication('Test optional')
            ->setConclusion('Test conclusion')
            ->setCreated(new \DateTime());

        self::bootKernel();

        $validator = self::getContainer()->get(ValidatorInterface::class);
        $errors = $validator->validate($testEntity);
        $this->assertCount(1, $errors);
    }
}
