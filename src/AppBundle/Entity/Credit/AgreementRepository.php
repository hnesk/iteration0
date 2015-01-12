<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 29.11.14
 * Time: 16:30
 */

namespace AppBundle\Entity\Credit;

use Doctrine\ORM\EntityRepository;

class AgreementRepository extends EntityRepository
{
    public function persist(Agreement $agreement)
    {
        $this->_em->persist($agreement);
        $this->_em->flush();
    }

    public function remove(Agreement $agreement)
    {
        $this->_em->remove($agreement);
        $this->_em->flush();
    }
}
