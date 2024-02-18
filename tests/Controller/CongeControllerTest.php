<?php

namespace App\Test\Controller;

use App\Entity\Conge;
use App\Repository\CongeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CongeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CongeRepository $repository;
    private string $path = '/conge/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Conge::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Conge index');

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
            'conge[Description]' => 'Testing',
            'conge[Date_Debut]' => 'Testing',
            'conge[Date_Fin]' => 'Testing',
            'conge[Justification]' => 'Testing',
            'conge[User]' => 'Testing',
        ]);

        self::assertResponseRedirects('/conge/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Conge();
        $fixture->setDescription('My Title');
        $fixture->setDate_Debut('My Title');
        $fixture->setDate_Fin('My Title');
        $fixture->setJustification('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Conge');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Conge();
        $fixture->setDescription('My Title');
        $fixture->setDate_Debut('My Title');
        $fixture->setDate_Fin('My Title');
        $fixture->setJustification('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'conge[Description]' => 'Something New',
            'conge[Date_Debut]' => 'Something New',
            'conge[Date_Fin]' => 'Something New',
            'conge[Justification]' => 'Something New',
            'conge[User]' => 'Something New',
        ]);

        self::assertResponseRedirects('/conge/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getDate_Debut());
        self::assertSame('Something New', $fixture[0]->getDate_Fin());
        self::assertSame('Something New', $fixture[0]->getJustification());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Conge();
        $fixture->setDescription('My Title');
        $fixture->setDate_Debut('My Title');
        $fixture->setDate_Fin('My Title');
        $fixture->setJustification('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/conge/');
    }
}
