<?php
/*
 * This file is part of the Ecentria software.
 *
 * (c) 2014, OpticsPlanet, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ecentria\Libraries\CoreRestBundle\Services\Transaction\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Ecentria\Libraries\CoreRestBundle\Entity\Transaction,
    Ecentria\Libraries\CoreRestBundle\Model\CRUD\CrudEntityInterface,
    Ecentria\Libraries\CoreRestBundle\Services\ErrorBuilder;

use Gedmo\Exception\FeatureNotImplementedException;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Transaction DELETE handler
 *
 * @author Alex Niedre <alex.niedre@intexsys.lv>
 */
class TransactionDeleteHandler implements TransactionHandlerInterface
{
    /**
     * Constructor
     *
     * @param ErrorBuilder $errorBuilder Error builder
     */
    public function __construct(ErrorBuilder $errorBuilder)
    {
        $this->errorBuilder = $errorBuilder;
    }

    /**
     * Supports method
     *
     * @return string
     */
    public function supports()
    {
        return 'DELETE';
    }

    /**
     * Handle
     *
     * @param Transaction                         $transaction  Transaction
     * @param CrudEntityInterface|ArrayCollection $data         Data
     * @param ConstraintViolationList|null        $violations   Violations
     * @param ArrayCollection|null                $infoMessages Info messages
     *
     * @throws FeatureNotImplementedException
     *
     * @return CrudEntityInterface
     */
    public function handle(
        Transaction $transaction,
        $data,
        ConstraintViolationList $violations = null,
        ArrayCollection $infoMessages = null
    ) {
        if (!$data instanceof CrudEntityInterface) {
            throw new FeatureNotImplementedException(
                get_class($data) . ' class is not supported by transactions (DELETE). Instance of CrudEntity needed.'
            );
        }

        $this->errorBuilder->processViolations($violations);
        $this->errorBuilder->setTransactionErrors($transaction);

        $success = !$this->errorBuilder->hasErrors();
        $status = $success ? Transaction::STATUS_OK : Transaction::STATUS_CONFLICT;

        $transaction->setStatus($status);
        $transaction->setSuccess($success);

        return $data;
    }
}
