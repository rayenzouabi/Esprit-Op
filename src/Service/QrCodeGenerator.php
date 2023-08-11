<?php
 
 namespace App\Service;

use App\Entity\Utilisateur;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;
use Endroid\QrCode\Writer\SvgWriter;

class QrCodeGenerator 
{
    public function createQrCode(Utilisateur $user): ResultInterface
    {
        $userInfo= 'nom: '.$user->getNom() . '|' .'prenom: '.$user->getPrenom() 
        . '|' .'email: '.$user->getLogin() .'|'.'cin: '.$user->getCin()
        . '|' .'numéro de téléphone: '.$user->getNumTel() . '|' .'Identifiant: '.$user->getIdentifiant() 
        .'|'.'date de naissance: '.$user->getDateNaiss()->format('Y-M-d') . '|' .'age: '.$user->getAge()  ;
        // Generate the QR code with user information
       
        $result = Builder::create()
        ->writer(new SvgWriter())
        ->writerOptions([])
        ->data($userInfo)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(200)
        ->margin(10)
        ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->labelText('Vous trouvez vos informations ici')
        ->labelFont(new NotoSans(20))
        ->labelAlignment(new LabelAlignmentCenter())
        ->validateResult(false)
        ->build();
        return $result;
    }
}
  