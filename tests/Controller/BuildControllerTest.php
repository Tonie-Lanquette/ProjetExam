<?php

namespace App\Tests\Controller;


use App\Controller\Front\CreateController;
use App\Entity\Build;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;

class BuildControllerTest extends WebTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
    }

    public function testBuildFormSubmissionSuccessWithVisibility()
    {
        $client = static::createClient();
        $form = $this->createMock(FormInterface::class);
        $build = new Build();

        // Mock the user and the form submission
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(1); // Simuler un ID d'utilisateur

        $this->entityManager
            ->method('persist')
            ->with($this->isInstanceOf(Build::class));

        $this->entityManager
            ->method('flush')
            ->willReturn(null);

        // Simuler le comportement du contrôleur
        $controller = new CreateController();
        $controller->setEntityManager($this->entityManager); // Vous devez créer une méthode pour injecter l'EntityManager

        // Configure le build et le form pour le test
        $build->setVisibility(true); // Simuler que la visibilité est activée

        // Simuler le formulaire
        $form->method('isSubmitted')->willReturn(true);
        $form->method('isValid')->willReturn(true);

        // Test de la soumission réussie avec visibilité
        $request = new Request();
        $request->setMethod('POST');

        // Envoi de la requête
        $client->request('POST', '/build', [], [], [], ['_form' => $form]);

        // Vérifier que le message flash a été ajouté
        $this->assertResponseStatusCodeSame(Response::HTTP_SEE_OTHER);
        $this->assertRedirects($client, 'app_profil_index');
    }
}
