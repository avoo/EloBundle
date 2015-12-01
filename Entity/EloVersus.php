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

namespace Avoo\EloBundle\Entity;

use Avoo\Elo\Model\EloPlayerInterface;
use Avoo\Elo\Model\EloVersusInterface;


/**
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class EloVersus implements EloVersusInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var EloPlayerInterface $playerA
     */
    protected $playerA;

    /**
     * @var EloPlayerInterface $playerB
     */
    protected $playerB;

    /**
     * @var \DateTime $createdAt
     */
    protected $createdAt;

    /**
     * @var \DateTime $endedAt
     */
    protected $endedAt;

    /**
     * @var float $winner
     */
    protected $winner;

    /**
     * Set player A
     *
     * @param EloPlayerInterface $playerA
     *
     * @return $this
     */
    public function setPlayerA(EloPlayerInterface $playerA)
    {
        $this->playerA = $playerA;

        return $this;
    }

    /**
     * Get player A
     *
     * @return integer
     */
    public function getPlayerA()
    {
        return $this->playerA;
    }

    /**
     * Set player B
     *
     * @param null|EloPlayerInterface $playerB
     *
     * @return $this
     */
    public function setPlayerB(EloPlayerInterface $playerB = null)
    {
        $this->playerB = $playerB;

        return $this;
    }

    /**
     * Get player B
     *
     * @return integer
     */
    public function getPlayerB()
    {
        return $this->playerB;
    }

    /**
     * Set created at
     *
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get created at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set ended at
     *
     * @param \DateTime $endedAt
     *
     * @return $this
     */
    public function setEndedAt(\DateTime $endedAt)
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    /**
     * Get ended at
     *
     * @return \DateTime
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }

    /**
     * Set winner
     *
     * @param float $winner
     *
     * @return $this
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner
     *
     * @return float
     */
    public function getWinner()
    {
        return $this->winner;
    }
} 
