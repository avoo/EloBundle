<?php

/*
* The MIT License (MIT)
*
* Copyright (c) 2014 J. Jégou <jejeavo@gmail.com>
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

namespace Avoo\EloBundle\Listener;

use Avoo\Elo\EloPoint;
use Avoo\Elo\Model\EloPlayerInterface;
use Avoo\Elo\Model\EloVersusInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

/**
 * Class EloVersusSubscriber
 *
 * @author Jérémy Jégou <jjegou@shivacom.fr>
 */
class EloVersusSubscriber implements EventSubscriber
{
    /**
     * @var EloPoint $eloPoint
     */
    protected $eloPoint;

    /**
     * Construct
     *
     * @param EloPoint $eloPoint
     */
    public function __construct(EloPoint $eloPoint)
    {
        $this->eloPoint = $eloPoint;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,
            Events::postUpdate
        );
    }

    /**
     * Calculate the new elo
     *
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        /** @var EloVersusInterface $resource */
        $resource = $event->getEntity();

        if (!$this->isValid($resource)) {
            return;
        }

        $resource->setEndedAt(new \DateTime());
        $this->updateElo($resource, $event->getEntityManager());
    }

    /**
     * Close the match
     *
     * @param PreUpdateEventArgs $event
     */
    public function preUpdate(PreUpdateEventArgs $event)
    {
        /** @var EloVersusInterface $resource */
        $resource = $event->getEntity();

        if (!$this->isValid($resource)) {
            return;
        }

        $resource->setEndedAt(new \DateTime());
    }

    /**
     * Calculate the new elo
     *
     * @param LifecycleEventArgs $event
     */
    public function postUpdate(LifecycleEventArgs $event)
    {
        /** @var EloVersusInterface $resource */
        $resource = $event->getEntity();

        if (!$this->isValid($resource)) {
            return;
        }

        $this->updateElo($resource, $event->getEntityManager());
    }

    /**
     * Is valid resource
     *
     * @param mixed $resource
     *
     * @return boolean
     */
    private function isValid($resource)
    {
        if (!$resource instanceof EloVersusInterface ||
            is_null($resource->getWinner()) ||
            !is_null($resource->getEndedAt())
        ) {
            return false;
        }

        return true;
    }

    /**
     * Update elo player
     *
     * @param EloVersusInterface $resource
     * @param EntityManager      $manager
     */
    private function updateElo(EloVersusInterface $resource, EntityManager $manager)
    {
        $this->eloPoint->calculate($resource);
        $resource->getPlayerA()->setElo($this->eloPoint->getAggregation()->getNewEloA());
        $resource->getPlayerB()->setElo($this->eloPoint->getAggregation()->getNewEloB());

        $this->persist($resource->getPlayerA(), $manager);
        $this->persist($resource->getPlayerB(), $manager);
    }

    /**
     * Perist entity
     *
     * @param mixed         $entity
     * @param EntityManager $manager
     */
    private function persist($entity, EntityManager $manager)
    {
        $manager->persist($entity);
        $manager->flush();
    }
}
