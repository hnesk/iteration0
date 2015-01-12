<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 29.11.14
 * Time: 16:30
 */

namespace AppBundle\Entity\Credit;

use Doctrine\ORM\EntityRepository;

class LenderRepository extends EntityRepository
{
    public function persist(Lender $lender)
    {
        $this->_em->persist($lender);
        $this->_em->flush();
    }

    public function remove(Lender $lender)
    {
        $this->_em->remove($lender);
        $this->_em->flush();
    }
}
