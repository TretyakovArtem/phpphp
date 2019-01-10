<?php

interface QuackBehavior
{
    public function quack();
}

interface FlyBehavior
{
    public function fly();
}


abstract class Duck
{
    protected $quackBehavior;

    protected $flyBehavior;

    public abstract function display();

    public function performQuack()
    {
        $this->quackBehavior->quack();
    }

    public function performFly()
    {
        $this->flyBehavior->fly();
    }

    public function swim()
    {
        echo "Я плыву\n";
    }

    public function setFlyBehavior(FlyBehavior $fb)
    {
        $this->flyBehavior = $fb;
    }

    public function setQuackBehavior(QuackBehavior $qb)
    {
        $this->quackBehavior = $qb;
    }
}

class FlyWithWings implements FlyBehavior
{
    public function fly()
    {
        echo "Я лечу\n";
    }
}


class FlyNoWay implements FlyBehavior
{
    public function fly()
    {
        echo "Я не умею летать\n";
    }
}

class SimpleQuack implements QuackBehavior
{
    public function quack()
    {
        echo "Кря-кря\n";
    }
}

class MuteQuack implements QuackBehavior
{
    public function quack()
    {
        echo "Тишина\n";
    }
}


class Squeak implements QuackBehavior
{
    public function quack()
    {
        echo "Гря-гря\n";
    }
}


class MallardDuck extends Duck
{
    public function __construct()
    {
        $this->quackBehavior = new SimpleQuack();
        $this->flyBehavior   = new FlyNoWay();
    }

    public function display()
    {
        echo "Утка с красным хохолком\n";
    }
}

class MiniDuckSimulator
{
    public static function main() : void
    {
        /*$mallard = new MallardDuck();
        $mallard->performQuack();
        $mallard->performFly();
        $mallard->display();*/

        $model = new ModelDuck();
        $model->performFly();
        $model->setFlyBehavior(new FlyRocketPowered());
        $model->performFly();
    }
}


class ModelDuck extends Duck
{
    public function __construct()
    {
        $this->flyBehavior = new FlyNoWay();
        $this->quackBehavior = new SimpleQuack();
    }

    public function display()
    {
        echo "Это модель утки";
    }
}

class FlyRocketPowered implements FlyBehavior
{
    public function fly()
    {
        echo "Утка, летающая с помощью ракеты\n";
    }
}


MiniDuckSimulator::main();