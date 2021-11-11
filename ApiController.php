<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function main(){
        return $this->render("main/index.html.twig");
    }

    /**
     * @Route("/api/post", name="api_post", methods={"POST"})
     */
    public function post_api(Request $request): Response
    {   
        $posts = new Posts(); 
        $parameter = json_decode($request->getContent(), true);
        $title = $parameter['title'];
        $content = $parameter['content'];

        $posts->setTitle($title);
        $posts->setContent($content);
        $em = $this->getDoctrine()->getManager();
        $em->persist($posts);
        $em->flush();
        return $this->json([
                'Inserted Successfully!!'
        ]);
    }

    /**
     * @Route("/api/update/{id}", name="api_update", methods={"PUT"})
     */
    public function update_api(Request $request, $id): Response
    {   

        $post = $this->getDoctrine()->getRepository(Posts::class)->find($id);
        $parameter = json_decode($request->getContent(), true);
        $title = $parameter['title'];
        $content = $parameter['content'];

        $post->setTitle($title);
        $post->setContent($content);
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        return $this->json([
                'Updated Successfully!!'
        ]);
    }
    
    /**
     * @Route("/api/delete/{id}", name="api_delete", methods={"DELETE"})
     */
    public function delete_api($id){
        $post = $this->getDoctrine()->getRepository(Posts::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->json([
            'Deleted Successfully!!'
        ]);
    }

    /**
     * @Route("/api/fetchall", name="api_fetchall", methods={"GET"})
     */
    public function fetchall_api(){
        $posts = $this->getDoctrine()->getRepository(Posts::class)->findAll();

        return $this->json($posts);
    }
}
