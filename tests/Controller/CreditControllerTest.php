<?php

namespace App\Test\Controller;

use App\Entity\Credit;
use App\Repository\CreditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreditControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CreditRepository $repository;
    private string $path = '/credit/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Credit::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Credit index');

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
            'credit[solde_demande]' => 'Testing',
            'credit[date_debut_paiement]' => 'Testing',
            'credit[nbr_mois_paiement]' => 'Testing',
            'credit[description]' => 'Testing',
            'credit[User]' => 'Testing',
        ]);

        self::assertResponseRedirects('/credit/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Credit();
        $fixture->setSolde_demande('My Title');
        $fixture->setDate_debut_paiement('My Title');
        $fixture->setNbr_mois_paiement('My Title');
        $fixture->setDescription('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Credit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Credit();
        $fixture->setSolde_demande('My Title');
        $fixture->setDate_debut_paiement('My Title');
        $fixture->setNbr_mois_paiement('My Title');
        $fixture->setDescription('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'credit[solde_demande]' => 'Something New',
            'credit[date_debut_paiement]' => 'Something New',
            'credit[nbr_mois_paiement]' => 'Something New',
            'credit[description]' => 'Something New',
            'credit[User]' => 'Something New',
        ]);

        self::assertResponseRedirects('/credit/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSolde_demande());
        self::assertSame('Something New', $fixture[0]->getDate_debut_paiement());
        self::assertSame('Something New', $fixture[0]->getNbr_mois_paiement());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Credit();
        $fixture->setSolde_demande('My Title');
        $fixture->setDate_debut_paiement('My Title');
        $fixture->setNbr_mois_paiement('My Title');
        $fixture->setDescription('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/credit/');
    }
}
