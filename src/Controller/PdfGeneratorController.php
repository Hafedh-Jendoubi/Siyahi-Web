<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
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
        $writer = new PngWriter();
        $qrCode = QrCode::create('http://192.168.1.18:8000/account/' . $id)
            ->setEncoding(new Encoding('UTF-8'))
            ->setSize(120)
            ->setMargin(0)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        $label = Label::create('')->setFont(new NotoSans(8));
        $qrCode = $writer->write($qrCode, null)->getDataUri();
        $data = [
            'LogoSrc'=> $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/front/assets/img/s-logo.png'),
            'ImageSrc'  => $this->imageToBase64($user->getImage()),
            'FirstName'         => $user->getFirstName(),
            'LastName'         => $user->getLastName(),
            'Gender' => $user->getGender(),
            'Address'      => $user->getAddress(),
            'PhoneNumber' => "(+216) " . $user->getPhoneNumber(),
            'CIN' => $user->getCIN(),
            'Email'        => $user->getEmail(),
            'QR' => $qrCode
        ];
        $html =  $this->renderView('pdf_generator/index.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response($dompdf->stream('resume', ["Attachment" => false]), Response::HTTP_OK, ['Content-Type' => 'application/pdf']);
    }

    private function imageToBase64($path): string
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}
