<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     *
     * @Route("/new", name="article_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $article = new Article();
//        $article->getAuthor($this->getUser());
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->imageUpload();

            $article->setAuthor($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('blog');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="article", methods="GET")
     * @ParamConverter("article", options={"mapping": {"article" : "slug"}})
     */
    public function showArticle($slug, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->findOneBy(['slug' => $slug]);
//         if (!$article){
//             throw $this->createNotFoundException(sprintf('No article for slug %s', $slug));
//         }

        return $this->render('show_article.html.twig', compact('article'));
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{slug}/edit", name="article_edit", methods="GET|POST")
     * @ParamConverter("edit", options={"mapping": {"article_edit" : "slug"}})
     */
    public function edit(Request $request, Article $article): Response
    {
//        if ($article->getImage()){
//            $article->setImage(
//                new File(realpath('uploads').'/'.$article->getImage())
//            );
//        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->imageUpload();

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('article_deleted', 'Your article has edited!');

            return $this->redirectToRoute('article_edit', ['slug' => $article->getSlug()]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * //     * @IsGranted("ROLE_USER")
     * @Route("/{slug}", name="article_delete", methods="DELETE")
     * @ParamConverter("delete", options={"mapping": {"article_delete" : "slug"}})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('blog');
    }
}