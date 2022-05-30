<?php

namespace App\Controller;

use App\Entity\Link;
use App\Entity\LinkStatistic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Url;

class LinkController extends AbstractController
{
    /**
     * @Route("/{slug}", name="app_to_url")
     */
    public function toUrl(ManagerRegistry $doctrine, string $slug): Response
    {
        $link = $doctrine->getRepository(Link::class)->findOneBy(['slug' => $slug]);

        $statistic = new LinkStatistic();
        $statistic->setLink($link);
        $statistic->setTime(time());
        $statistic->setCountry('Ukraine');

        $entityManager = $doctrine->getManager();
        $entityManager->persist($statistic);
        $entityManager->flush();

        return $this->redirect($link->getUrl());
    }

    /**
     * @Route("/", name="app_link_create")
     */
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $link = new Link();

        $link->setFinishTime(time());

        $form = $this->createFormBuilder($link)
            ->add('url', TextType::class, [
                'label' => 'Посилання',
                'required' => true,
                'constraints' => [new Url()]
            ])
            ->add('finish_time', DateTimeType::class, [
                'label' => 'Активне до',
                'input' => 'timestamp',
                'constraints' => [new GreaterThan(time())]
            ])
            ->add('save', SubmitType::class, ['label' => 'Мініфікувати'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $link = $form->getData();

            $entityManager = $doctrine->getManager();

            $highest_id = $entityManager->createQueryBuilder()
                ->select('MAX(e.id)')
                ->from(Link::class, 'e')
                ->getQuery()
                ->getSingleScalarResult();

            $link->setSlug($highest_id + 1);

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($link);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->redirectToRoute('link_show', ['slug' => $link->getSlug()]);
        }

        return $this->renderForm('link/create.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/link/statistics/{slug}", name="link_statistics")
     */
    public function statistics(ManagerRegistry $doctrine, string $slug, Request $request): Response
    {
        $link = $doctrine->getRepository(Link::class)->findOneBy(['slug' => $slug]);

        return $this->render('link/statistics.html.twig', [
            'link' => $link,
            'minifiedLink' => $request->getSchemeAndHttpHost() . '/' . $link->getSlug()
        ]);
    }

    /**
     * @Route("/link/{slug}", name="link_show")
     */
    public function show(ManagerRegistry $doctrine, string $slug, Request $request): Response
    {
        $link = $doctrine->getRepository(Link::class)->findOneBy(['slug' => $slug]);

        return $this->render('link/view.html.twig', [
            'link' => $link,
            'minifiedLink' => $request->getSchemeAndHttpHost() . '/' . $link->getSlug()
        ]);
    }


}
