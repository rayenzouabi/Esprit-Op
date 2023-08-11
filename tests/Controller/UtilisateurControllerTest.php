<?php

namespace App\Test\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilisateurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private UtilisateurRepository $repository;
    private string $path = '/user/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Utilisateur::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'utilisateur[nom]' => 'Testing',
            'utilisateur[prenom]' => 'Testing',
            'utilisateur[cin]' => 'Testing',
            'utilisateur[dateNaiss]' => 'Testing',
            'utilisateur[age]' => 'Testing',
            'utilisateur[numPermis]' => 'Testing',
            'utilisateur[ville]' => 'Testing',
            'utilisateur[numTel]' => 'Testing',
            'utilisateur[login]' => 'Testing',
            'utilisateur[mdp]' => 'Testing',
            'utilisateur[photoPersonel]' => 'Testing',
            'utilisateur[photoPermis]' => 'Testing',
            'utilisateur[idrole]' => 2,
        ]);

        self::assertResponseRedirects('/user/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setCin('My Title');
        $fixture->setDateNaiss('My Title');
        $fixture->setAge('My Title');
        $fixture->setNumPermis('My Title');
        $fixture->setVille('My Title');
        $fixture->setNumTel('My Title');
        $fixture->setLogin('My Title');
        $fixture->setMdp('My Title');
        $fixture->setPhotoPersonel('My Title');
        $fixture->setPhotoPermis('My Title');
        $fixture->setIdrole('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setCin('My Title');
        $fixture->setDateNaiss('My Title');
        $fixture->setAge('My Title');
        $fixture->setNumPermis('My Title');
        $fixture->setVille('My Title');
        $fixture->setNumTel('My Title');
        $fixture->setLogin('My Title');
        $fixture->setMdp('My Title');
        $fixture->setPhotoPersonel('My Title');
        $fixture->setPhotoPermis('My Title');
        $fixture->setIdrole('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'utilisateur[nom]' => 'Something New',
            'utilisateur[prenom]' => 'Something New',
            'utilisateur[cin]' => 'Something New',
            'utilisateur[dateNaiss]' => 'Something New',
            'utilisateur[age]' => 'Something New',
            'utilisateur[numPermis]' => 'Something New',
            'utilisateur[ville]' => 'Something New',
            'utilisateur[numTel]' => 'Something New',
            'utilisateur[login]' => 'Something New',
            'utilisateur[mdp]' => 'Something New',
            'utilisateur[photoPersonel]' => 'Something New',
            'utilisateur[photoPermis]' => 'Something New',
            'utilisateur[idrole]' => 'Something New',
        ]);

        self::assertResponseRedirects('/user/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getCin());
        self::assertSame('Something New', $fixture[0]->getDateNaiss());
        self::assertSame('Something New', $fixture[0]->getAge());
        self::assertSame('Something New', $fixture[0]->getNumPermis());
        self::assertSame('Something New', $fixture[0]->getVille());
        self::assertSame('Something New', $fixture[0]->getNumTel());
        self::assertSame('Something New', $fixture[0]->getLogin());
        self::assertSame('Something New', $fixture[0]->getMdp());
        self::assertSame('Something New', $fixture[0]->getPhotoPersonel());
        self::assertSame('Something New', $fixture[0]->getPhotoPermis());
        self::assertSame('Something New', $fixture[0]->getIdrole());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Utilisateur();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setCin('My Title');
        $fixture->setDateNaiss('My Title');
        $fixture->setAge('My Title');
        $fixture->setNumPermis('My Title');
        $fixture->setVille('My Title');
        $fixture->setNumTel('My Title');
        $fixture->setLogin('My Title');
        $fixture->setMdp('My Title');
        $fixture->setPhotoPersonel('My Title');
        $fixture->setPhotoPermis('My Title');
        $fixture->setIdrole('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/user/');
    }
}
