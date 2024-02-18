<?php

namespace App\Test\Controller;

use App\Entity\ReponseConge;
use App\Repository\ReponseCongeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReponseCongeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ReponseCongeRepository $repository;
    private string $path = '/reponse/conge/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(ReponseConge::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ReponseConge index');

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
            'reponse_conge[DateDebut]' => 'Testing',
            'reponse_conge[DateFin]' => 'Testing',
            'reponse_conge[Conge]' => 'Testing',
            'reponse_conge[User]' => 'Testing',
        ]);

        self::assertResponseRedirects('/reponse/conge/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ReponseConge();
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setConge('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ReponseConge');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ReponseConge();
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setConge('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'reponse_conge[DateDebut]' => 'Something New',
            'reponse_conge[DateFin]' => 'Something New',
            'reponse_conge[Conge]' => 'Something New',
            'reponse_conge[User]' => 'Something New',
        ]);

        self::assertResponseRedirects('/reponse/conge/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateDebut());
        self::assertSame('Something New', $fixture[0]->getDateFin());
        self::assertSame('Something New', $fixture[0]->getConge());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new ReponseConge();
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setConge('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/reponse/conge/');
    }
}
