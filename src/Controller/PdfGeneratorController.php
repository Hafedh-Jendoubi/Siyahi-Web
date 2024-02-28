<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;

class PdfGeneratorController extends AbstractController
{
    #[Route(path: '/generate/{id}', name: 'pdf_generator')]
    public function index($id, UserRepository $repository): Response
    {
        $user = $repository->find($id);
        $data = [
            'LogoSrc'=> $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/front/assets/img/s-logo.png'),
            'ImageSrc'  => $this->imageToBase64($user->getImage()),
            'FirstName'         => $user->getFirstName(),
            'LastName'         => $user->getLastName(),
            'Address'      => $user->getAddress(),
            'PhoneNumber' => "(+216) " . $user->getPhoneNumber(),
            'CIN' => "(+216) " . $user->getCIN(),
            'Email'        => $user->getEmail()
        ];
        $html =  $this->renderView('pdf_generator/index.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    private function imageToBase64($path): string
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}
