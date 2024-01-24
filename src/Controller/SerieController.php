<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/serie', name: 'app_serie_')]
class SerieController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(SerieRepository $serieRepository): Response
    {
        // $series = $serieRepository->findBy([], ['popularity' => 'DESC', 'vote' => 'DESC'], 30);
        // soit avec une requête DQL personnalisée
        $series = $serieRepository->findBestSeries();
        return $this->render('serie/list.html.twig', [
            "series" => $series
        ]);
    }

    #[Route('/details/{id}', name: 'details')]
    public function details(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        return $this->render('serie/details.html.twig', [
            "serie" => $serie
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        // todo : aller chercher la série en BDD

        // dump('Hello dump');
        // dd('Hello dump');
        // dd($request);
        dump($request);
        return $this->render('serie/create.html.twig', [

        ]);
    }
    #[Route('/demo', name: 'em-demo')]
    public function demo(EntityManagerInterface $entityManager): Response{
        // création de l'instance de l'entité
        $serie = new Serie();

        //hydrate toutes les propriétés
        $serie->setName('Pif');
        $serie->setBackdrop('Pif');
        $serie->setGenres('Pif');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstAirDate(new \DateTime("-1 year"));
        $serie->setLastAirDate(new \DateTime("-6 month"));
        $serie->setOverview('Pif');
        $serie->setPopularity(123.00);
        $serie->setVote(8.2);
        $serie->setStatus('Cancelled');
        $serie->setTmdbId(32547);
        $serie->setPoster('Pif');



        // sauvegarde
        dump($serie);
        $entityManager->persist($serie);
        $entityManager->flush();

        // suprrime
        dump($serie);
        //$entityManager->remove($serie);
        // $entityManager->flush();

        // Update
        $serie->setGenres('Comédie');
        $entityManager->flush();

        return $this->render('serie/create.html.twig');
    }

}
