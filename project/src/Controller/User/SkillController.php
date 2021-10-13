<?php

namespace App\Controller\User;

use App\Entity\Skill;
use App\Form\Skill1Type;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    #[Route('/skill/', name: 'user_skill', methods: ['GET'])]
    public function index(SkillRepository $skillRepository): Response
    {
        return $this->render('user/skill/index.html.twig', [
            'skills' => $skillRepository->findAll(),
        ]);
    }

    #[Route('/skill/edit/{id}', name: 'user_skill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SkillRepository $skillRepository, $id=''): Response
    {
        $skill = $id?$skillRepository->find($id):null;
        $skill = $skill??new Skill();
        $form = $this->createForm(Skill1Type::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skillRepository->save($skill);
            return $this->redirectToRoute('skill_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('user/skill/edit.html.twig', [
            'skill' => $skill,
            'form' => $form,
        ]);
    }

    #[Route('/skill/delete/{skill}', name: 'user_skill_delete', methods: ['GET'])]
    public function delete(Request $request, SkillRepository $skillRepository, Skill $skill): Response
    {
        if ($skill->getPerson()->getUser()->getId()==$this->getUser()->getId() &&
            $this->isCsrfTokenValid('delete'.$skill->getId(), $request->request->get('_token'))) {
            $skillRepository->delete($skill);
        }
        return $this->redirectToRoute('skill_index', [], Response::HTTP_SEE_OTHER);
    }
}
