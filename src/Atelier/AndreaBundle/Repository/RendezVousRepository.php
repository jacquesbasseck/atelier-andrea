<?php

namespace Atelier\AndreaBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * RendezVousRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RendezVousRepository extends EntityRepository
{
    /**
     * @param $id
     * @param $debut
     * @param $fin
     * @return array
     */
    public function checkCollision($id, $debut, $fin)
    {
        $qb = $this->createQueryBuilder ('r')
            ->where ('r.debut BETWEEN :debut AND :fin AND r.id != :id')
            ->orWhere ('r.fin BETWEEN :debut AND :fin AND r.id != :id')
            ->setParameters ([':debut' => $debut, ':fin' => $fin, ':id' => $id]);

        return $qb->getQuery ()->getResult ();
    }
}

