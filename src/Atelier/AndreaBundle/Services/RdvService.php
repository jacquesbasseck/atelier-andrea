<?php

namespace Atelier\AndreaBundle\Services;

use Atelier\AndreaBundle\Entity\RendezVous;
use Atelier\AndreaBundle\Entity\Soin;
use Atelier\AndreaBundle\Repository\RendezVousRepository;
use User\UserBundle\Entity\User;

class RdvService
{
    private $rendezVousRepository;


    public function  __construct(RendezVousRepository $rendezVousRepository)
    {
        $this->rendezVousRepository = $rendezVousRepository;

    }

    /**
     * @param RendezVous $rendezVous
     * @return array
     */
    public function checkCollision(RendezVous $rendezVous)
    {
        return $this->rendezVousRepository->checkCollision (
            $rendezVous->getId (),
            $rendezVous->getDebut (),
            $rendezVous->getFin ());
    }


    /**
     * @param RendezVous $rendezVous
     * @param $soinId
     * @return bool
     */
    public function checkExistEntryOnJoinedTable(RendezVous $rendezVous, $soinId){
        $soins = $rendezVous->getSoins();
        foreach ($soins as $soin) {
            /**
             * @var $soin Soin
             */
            if ($soin->getId() === $soinId) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param RendezVous $rendezVous
     * @return bool
     */
    public function deleteEntryOnJoinedTable(RendezVous $rendezVous){
        $soins = $rendezVous->getSoins();
        foreach ($soins as $soin) {
            /**
             * @var $soin Soin
             */
            $rendezVous->getSoins()->removeElement($soin);
            $soin->getRendezVous()->removeElement($rendezVous);
        }

        return true;
    }

    /**
     * @param RendezVous $rendezVous
     * @param User $currentUser
     * @return bool
     */
    public function checkRdvOwner(RendezVous $rendezVous, User $currentUser){
        if ($rendezVous->getUser() == $currentUser) {
            return true;
        }
        return false;
    }
}

