<?php

namespace App\Test\Controller;
use App\Entity\Offres;
use App\Repository\OffresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OffresControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private OffresRepository $repository;
    private string $path = '/offres/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get(OffresRepository::class);
        $this->manager = static::getContainer()->get(EntityManagerInterface::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        // Customize the following line based on your actual page title
        self::assertSelectorTextContains('h1', 'Offre index');
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'offres[Titre]' => 'New Title',
            'offres[Description]' => 'New Description',
            'offres[Société]' => 'New Company',
            'offres[Adresse]' => 'New Address',
            'offres[email]' => 'new@example.com',
            'offres[type]' => 'Emploi', // or 'Stage'
            'offres []'
            // Add other form fields here
        ]);

        self::assertResponseRedirects('/offres/');
        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $fixture = new Offres();

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        // Customize the following line based on your actual page title
        self::assertSelectorTextContains('h1', 'Offre');
        // Add assertions for displaying property values
    }

    public function testEdit(): void
    {
        $fixture = new Offres();

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'offres[Titre]' => 'Updated Title',
            // Add other form fields here
        ]);

        self::assertResponseRedirects('/offres/');

        $updatedOffre = $this->repository->find($fixture->getId());
        self::assertSame('Updated Title', $updatedOffre->getTitre());
        // Add other assertions for updated properties
    }

    public function testRemove(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Offres();

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/offres/');
    }
}
