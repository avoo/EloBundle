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
use Avoo\Elo\Model\EloUserInterface;

/**
 * @author Jérémy Jégou <jejeavo@gmail.com>
 */
class EloPlayer implements EloPlayerInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer $elo
     */
    protected $elo;

    /**
     * @var EloUserInterface $user
     */
    protected $user;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set elo
     *
     * @param integer $elo
     *
     * @return $this
     */
    public function setElo($elo)
    {
        $this->elo = $elo;

        return $this;
    }

    /**
     * Get current elo
     *
     * @return integer
     */
    public function getElo()
    {
        return $this->elo;
    }

    /**
     * Set user
     *
     * @param EloUserInterface $user
     *
     * @return $this
     */
    public function setUser(EloUserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return EloUserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
} 
