<?php
/*
 * This file is part of the Ecentria software.
 *
 * (c) 2015, OpticsPlanet, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ecentria\Libraries\CoreRestBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Ecentria\Libraries\CoreRestBundle\Entity\Transaction;


/**
 * InfoBuilder
 *
 * @author Arturs Reiljans <artur.reiljans@intexsys.lv>
 */
class InfoBuilder
{
    /**
     * Messages
     *
     * @var ArrayCollection
     */
    private $messages;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    /**
     * Set messages
     *
     * @param ArrayCollection $messages Messages
     * @return $this
     */
    public function setMessages(ArrayCollection $messages)
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * Get messages
     *
     * @return ArrayCollection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set transaction messages
     *
     * @param Transaction $transaction Transaction
     * @return $this
     */
    public function setTransactionMessages(Transaction $transaction)
    {
        $transaction->getMessages()->set('info', $this->messages);
        return $this;
    }
}
