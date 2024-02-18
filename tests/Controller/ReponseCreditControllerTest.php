<?php

namespace App\Test\Controller;

use App\Entity\ReponseCredit;
use App\Repository\ReponseCreditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReponseCreditControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ReponseCreditRepository $repository;
    private string $path = '/reponse/credit/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(ReponseCredit::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ReponseCredit index');

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
            'reponse_credit[solde_a_payer]' => 'Testing',
            'reponse_credit[date_debutPaiement]' => 'Testing',
            'reponse_credit[nbr_moisPaiement]' => 'Testing',
            'reponse_credit[description]' => 'Testing',
            'reponse_credit[credit]' => 'Testing',
            'reponse_credit[User]' => 'Testing',
        ]);

        self::assertResponseRedirects('/reponse/credit/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ReponseCredit();
        $fixture->setSolde_a_payer('My Title');
        $fixture->setDate_debutPaiement('My Title');
        $fixture->setNbr_moisPaiement('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCredit('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ReponseCredit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ReponseCredit();
        $fixture->setSolde_a_payer('My Title');
        $fixture->setDate_debutPaiement('My Title');
        $fixture->setNbr_moisPaiement('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCredit('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'reponse_credit[solde_a_payer]' => 'Something New',
            'reponse_credit[date_debutPaiement]' => 'Something New',
            'reponse_credit[nbr_moisPaiement]' => 'Something New',
            'reponse_credit[description]' => 'Something New',
            'reponse_credit[credit]' => 'Something New',
            'reponse_credit[User]' => 'Something New',
        ]);

        self::assertResponseRedirects('/reponse/credit/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSolde_a_payer());
        self::assertSame('Something New', $fixture[0]->getDate_debutPaiement());
        self::assertSame('Something New', $fixture[0]->getNbr_moisPaiement());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getCredit());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new ReponseCredit();
        $fixture->setSolde_a_payer('My Title');
        $fixture->setDate_debutPaiement('My Title');
        $fixture->setNbr_moisPaiement('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCredit('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/reponse/credit/');
    }
}
