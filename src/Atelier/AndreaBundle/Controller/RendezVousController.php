<?php

namespace Atelier\AndreaBundle\Controller;

use Atelier\AndreaBundle\Entity\RendezVous;
use Atelier\AndreaBundle\Entity\Soin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use User\UserBundle\Entity\User;

class RendezVousController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emploiDuTempsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rendezVous = $em->getRepository('AtelierAndreaBundle:RendezVous')->findAll();
        $rendezVousJson = $this->formatRendezVousData($rendezVous);

        $soins = $em->getRepository('AtelierAndreaBundle:Soin')->findAll();
        $soinsJson = $this->formatSoinData($soins);

        $userJson = $this->formatUserData($this->getUser());

        return $this->render('@AtelierAndrea/RendezVous/emploi_du_temps.html.twig', [
            'rendezvousJson' => $rendezVousJson,
            'soinsJson' => $soinsJson,
            'userJson' => $userJson
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAction(Request $request)
    {
        try {
            $rdvId = $request->request->get('id');
            if (!$rdvId) {
                throw new \Exception('Le rendez-vous n\'existe pas.');
            }

            $em = $this->getDoctrine()->getManager();
            $rendezVous = $em->getRepository('AtelierAndreaBundle:RendezVous')->find($rdvId);
            if ($rendezVous) {
                $rdvService = $this->get('rendez_vous.service');
                if (!$rdvService->checkRdvOwner($rendezVous, $this->getUser())){
                    throw new \Exception("Vous n'avez le droit de modifier ce rendez-vous.");
                }

                $em->remove($rendezVous);
                $em->flush();
            }

            return new JsonResponse([
                'status' => 'success',
                'message' => 'Ce rendez-vous a été bien supprimé.'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Une erreur est survenue.',
                'error_message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $dateDebut = new \DateTime($request->request->get('debut'));
            // SOIN
            $soinId = $request->request->get('soin');
            $soinId = intval(explode(',', $soinId)[0]);
            /**
             * @var $soin Soin
             */
            $soin = $em->getRepository('AtelierAndreaBundle:Soin')->find($soinId);
            if (!$soin) {
                throw new Exception('Le soin que vous avez choisi n\'existe pas.');
            }

            $rendezVous = new RendezVous();
            $rendezVous->setTitre($request->request->get('titre'));
            $rendezVous->setInfos($request->request->get('infos'));
            $rendezVous->setUser($this->getUser());
            $rendezVous->addSoin($soin);
            $rendezVous->setDebut(new \DateTime($request->request->get('debut')));
            $rendezVous->setFin($dateDebut->modify("+{$soin->getDuree ()} minutes"));

            $collisionRendezVous = $this->get('rendez_vous.service')->checkCollision($rendezVous);
            if (!empty($collisionRendezVous)) {
                $listIds = '';
                foreach ($collisionRendezVous as $rdv) {
                    /**
                     * @var $rdv RendezVous
                     */
                    $listIds .= $rdv->getId() . '-';
                }
                throw new Exception('Il y a déjà un rendez-vous prévu à cet horaire: ' . $listIds);
            }

            $em->persist($rendezVous);
            $soin->addRendezVous($rendezVous);
            $em->flush();

            return new JsonResponse([
                'id' => $rendezVous->getId(),
                'status' => 'Le rendez-vous a été bien créé.'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Une erreur est survenue',
                'error_message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateAction(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $dateDebut = new \DateTime($request->request->get('debut'));
            // SOIN
            $soinId = $request->request->get('soin');
            $soinId = intval(explode(',', $soinId)[0]);
            /**
             * @var $soin Soin
             */
            $soin = $em->getRepository('AtelierAndreaBundle:Soin')->find($soinId);
            if (!$soin) {
                throw new Exception('Le soin que vous avez choisi n\'existe pas.');
            }

            $rendezVous = $em->getRepository('AtelierAndreaBundle:RendezVous')->find($request->request->get('id'));
            /**
             * @var $rendezVous RendezVous
             */
            if (!$rendezVous) {
                throw new \Exception('Ce rendez-vous n\'existe pas.');
            }

            $rdvService = $this->get('rendez_vous.service');
            if (!$rdvService->checkRdvOwner($rendezVous, $this->getUser())){
                throw new \Exception("Vous n'avez le droit de modifier ce rendez-vous.");
            }
            $rdvService->deleteEntryOnJoinedTable($rendezVous);
            $rendezVous->addSoin($soin);
            $rendezVous->setTitre($request->request->get('titre'));
            $rendezVous->setInfos($request->request->get('infos'));
            $rendezVous->setDebut(new \DateTime($request->request->get('debut')));
            $rendezVous->setFin($dateDebut->modify("+{$soin->getDuree ()} minutes"));

            $collisionRendezVous = $rdvService->checkCollision($rendezVous);
            if (!empty($collisionRendezVous)) {
                $listIds = '';
                foreach ($collisionRendezVous as $rdv) {
                    /**
                     * @var $rdv RendezVous
                     */
                    $listIds .= $rdv->getId() . '-';
                }
                throw new Exception('Il y a déjà un rendez-vous prévu à cet horaire: ' . $listIds);
            }

            $soin->addRendezVous($rendezVous);
            $em->flush();

            return new JsonResponse([
                'id' => $rendezVous->getId(),
                'status' => 'Le rendez-vous a été bien créé.'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => 'Une erreur est survenue',
                'error_message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function userAction(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $rdv = $em->getRepository('AtelierAndreaBundle:RendezVous')->find($request->request->get('rdvId'));
            if (!$rdv) {
                throw new \Exception("Ce rendez-vous n'existe pas.");
            }
            /** @var User $user */
            $user = $rdv->getUser();
            if (!$user) {
                throw new \Exception('Ce rendez-vous n\'est pas attribué');
            }
            $userJson = $this->formatUserData($user);

            return new JsonResponse([
                'userJson' => $userJson,
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => "l'utilisateur n'existe pas."
            ], 400);
        }
    }


    /**
     * @param array $rdvs
     * @return array|string
     */
    private function formatRendezVousData(array $rdvs)
    {
        if (!$rdvs || empty($rdvs)) {
            return [];
        }

        $formatedRendezVousData = [];
        foreach ($rdvs as $rdv) {
            /**
             * @var $soin Soin
             */
            $soin = $rdv->getSoins()->current();
            $labelSoin = '0,0';
            if ($soin) {
                $labelSoin = $soin->getId() . ',' . $soin->getDuree() . ',' . $soin->getCouleur();
            }
            /**
             * @var $rdv RendezVous
             */
            array_push($formatedRendezVousData, [
                'id' => $rdv->getId(),
                'infos' => $rdv->getInfos(),
                'soin' => $labelSoin,
                'titre' => $rdv->getTitre(),
                "start_date" => $rdv->getDebut()->format("d-m-Y H:i"),
                "end_date" => $rdv->getFin()->format("d-m-Y H:i"),
            ]);
        }
        return json_encode($formatedRendezVousData);
    }

    /**
     * @param array $soins
     * @return array|string
     */
    private function formatSoinData(array $soins)
    {
        if (!$soins || empty($soins)) {
            return [];
        }

        $formatedSoinData = [];
        array_push($formatedSoinData, [
            'key' => '0,0,blue',
            'label' => 'Sélectionnez un soin'
        ]);

        foreach ($soins as $soin) {
            /**
             * @var $soin Soin
             */
            array_push(
                $formatedSoinData, [
                'key' => $soin->getId() . ',' . $soin->getDuree() . ',' . $soin->getCouleur(),
                'label' => $soin->getNom(),
                'duree' => $soin->getDuree()
            ]);
        }

        return json_encode($formatedSoinData);
    }

    /**
     * @param User $user
     * @return array
     */
    private function formatUserData(User $user)
    {
        /**
         * @var $user User
         */
        return json_encode([
            'id' => $user->getId(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'tel' => $user->getTelephone(),
            'email' => $user->getEmail(),
            'dateNaissance' => $user->getDateNaissance()->format('d/m/Y'),
            'sexe' => $user->getSexe()
        ]);
    }

}
