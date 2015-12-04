EloBundle
=====================
[![Build Status]
(https://scrutinizer-ci.com/g/avoo/EloBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/avoo/EloBundle/build-status/master)
[![Scrutinizer Code Quality]
(https://scrutinizer-ci.com/g/avoo/EloBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/avoo/EloBundle/?branch=master)
[![Latest Stable Version]
(https://poser.pugx.org/avoo/elo-bundle/v/stable.svg)](https://packagist.org/packages/avoo/elo-bundle)
[![License]
(https://poser.pugx.org/avoo/elo-bundle/license.svg)](https://packagist.org/packages/avoo/elo-bundle)

Elo bundle for Symfony 2 

* [Installation](#installation)
* [Configuration](#default-configuration)
* [Class implementation](#class-implementation)
  - [Elo player class](#elo-player-class)
  - [Elo versus class](#elo-versus-class)
  - [User class](#user-class)
* [Default Usage](#default-usage)

Installation
------------

Require [`avoo/elo-bundle`](https://packagist.org/packages/avoo/elo-bundle) into your `composer.json` file:

``` json
{
    "require": {
        "avoo/elo-bundle": "~0.1"
    }
}
```

The elo bundle use [`StofDoctrineExtensionsBundle`](https://github.com/stof/StofDoctrineExtensionsBundle)

Register the bundle in `app/AppKernel.php`:

``` php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Avoo\EloBundle\AvooEloBundle(),
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
    );
}
```

Default Configuration
-----------------------

``` yaml
# app/config/config.yml

# Doctrine Configuration
doctrine:
    orm:
        auto_generate_proxy_classes: "%kernel.debug%"
        entity_managers:
            default:
                auto_mapping: true
                mappings:
                    gedmo_loggable:
                        type: annotation
                        prefix: Gedmo\Loggable\Entity
                        dir: "%kernel.root_dir%/../vendor/gedmo/doctrine-extensions/lib/Gedmo/Loggable/Entity"
                        alias: GedmoLoggable # (optional) it will default to the name set for the mappingmapping
                        is_bundle: false

stof_doctrine_extensions:
    orm:
        default:
            loggable: true
            timestampable: true
```

Class implementation
--------------------

#### Elo player class

**YAML**

``` yml
# src/AppBundle/Resources/config/doctrine/EloPlayer.orm.yml
AppBundle\Entity\EloPlayer:
    type:  entity
    table: elo_player
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
    oneToOne:
        user:
            targetEntity: AppBundle\Entity\User
            inversedBy: eloPlayer
            joinColumn:
                name: user_id
                referencedColumnName: id
```

**XML**

``` xml
<?xml version="1.0" encoding="utf-8"?>
<!-- src/AppBundle/Resources/config/doctrine/EloPlayer.orm.xml -->
<doctrine-mapping
        xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
        http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="AppBundle\Entity\EloPlayer" table="elo_player">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO"/>
        </id>
        <one-to-one field="user" target-entity="AppBundle\Entity\User" inversed-by="eloPlayer">
            <join-column name="user_id" referenced-column-name="id" />
        </one-to-one>
    </entity>
</doctrine-mapping>
```

**Annotation**

``` php
namespace Avoo\EloBundle\Entity;

use Avoo\EloBundle\Entity\EloPlayer as BaseEloPlayer;
use Doctrine\ORM\Mapping as ORM;

class EloPlayer extends BaseEloPlayer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="eloPlayer")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
}
```

#### Elo versus class

**YAML**

``` yml
# src/AppBundle/Resources/config/doctrine/EloVersus.orm.yml
AppBundle\Entity\Eloversus:
    type:  entity
    table: elo_versus
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
    manyToOne:
        playerA:
            targetEntity: AppBundle\Entity\EloPlayer
            joinColumn:
                name: player_a
                referencedColumnName: id
        playerB:
            targetEntity: AppBundle\Entity\EloPlayer
            joinColumn:
                name: player_b
                referencedColumnName: id
```

**XML**

``` xml
<?xml version="1.0" encoding="utf-8"?>
<!-- src/AppBundle/Resources/config/doctrine/EloVersus.orm.xml -->
<doctrine-mapping
        xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
        http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

  <entity name="AppBundle\Entity\EloVersus" table="elo_versus">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO"/>
        </id>

        <many-to-one field="playerA" target-entity="AppBundle\Entity\EloPlayer">
            <join-column name="player_a" referenced-column-name="id" />
        </many-to-one>

        <many-to-one field="playerB" target-entity="AppBundle\Entity\EloPlayer">
            <join-column name="player_b" referenced-column-name="id" />
        </many-to-one>
    </entity>
</doctrine-mapping>
```

**Annotation**

``` php
namespace Avoo\EloBundle\Entity;

use Avoo\EloBundle\Entity\EloVersus as BaseEloVersus;
use Doctrine\ORM\Mapping as ORM;

class EloVersus extends BaseEloVersus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     * @ORM\JoinColumn(name="player_a", referencedColumnName="id")
     */
    protected $playerA;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     * @ORM\JoinColumn(name="player_b", referencedColumnName="id")
     */
    protected $playerB;
}
```

#### User class

**Warning** You need to implement `Avoo/Elo/Model/EloUserInterface`

``` php
use Avoo\Elo\Model\EloUserInterface;

class User implements EloUserInterface
{
    /**
     * @var EloPlayerInterface $eloPlayer
     */
    protected $eloPlayer;

    /**
     * Get elo player
     *
     * @return EloPlayerInterface
     */
    public function getEloPlayer()
    {
        return $this->eloPlayer;
    }
}
```

**YAML**

``` yml
# src/AppBundle/Resources/config/doctrine/User.orm.yml
AppBundle\Entity\User:
    type:  entity
    table: elo_user
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
    oneToOne:
        eloPlayer:
            targetEntity: AppBundle\Entity\EloPlayer
            mappedBy: user
```

**XML**

``` xml
<entity name="AppBundle\Entity\User" table="elo_user">
    <one-to-one field="eloPlayer" mapped-by="user" target-entity="AppBundle\Entity\EloPlayer" />
</entity>
```

**Annotation**

``` php
<?php
use Avoo\Elo\Model\EloUserInterface;
use Doctrine\ORM\Mapping as ORM;

class User implements EloUserInterface
{
    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\EloPlayer", mappedBy="user")
     */
    protected $eloPlayer;
}
```

Default Usage
-------------

``` php
use Avoo\Elo\EloPoint;
use Avoo\Elo\Model\EloVersusInterface;
use Avoo\Elo\Model\EloAggregationInterface;

/** @var EloPoint $calculator */
$calculator = $this->get('avoo_elo.calculator');

/** @var EloVersusInterface $match */
$calculator->calculate($match);

/** @var EloAggregationInterface $aggregation */
$aggregation = $calculator->getAggregation();
```

License
-------

This bundle is released under the MIT license. See the complete license in the bundle:

[License](https://github.com/avoo/EloBundle/blob/master/LICENSE)
