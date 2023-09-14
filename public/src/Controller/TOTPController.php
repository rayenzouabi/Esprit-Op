<?php

namespace App\Controller;

use App\Form\TotpLoginFormType;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Totp\TotpAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Scheb\TwoFactorBundle\Security\Authentication\Exception\InvalidTwoFactorCodeException as ExceptionInvalidTwoFactorCodeException;

class TOTPController extends AbstractController
{
    #[Route("/2fa-login", name:"2fa_login")]
    public function totp_Login(Request $request)
    {
        $error = $request->getSession()->get('totp_login_error');
        return $this->render('totp/login.html.twig', [
            'error' => $error,
        ]);
    }
    #[Route("/2fa_check", name:"2fa_check")]
    public function totp_check(Request $request, TotpAuthenticatorInterface $authenticator)
    {
        $context = $this->get('security.token_storage')->getToken()->getTwoFactorAuthenticationContext();

        try {
            // Validate the TOTP code
            $authenticator->checkCode($context, $request->get('totp_code'));

            // If the code is valid, mark the user as two-factor authenticated
            $context->setAuthenticated(true);
            $this->get('security.token_storage')->getToken()->setTwoFactorAuthenticationContext($context);

            // Redirect to the homepage or the originally requested URL
            if ($targetUrl = $context->getTargetUrl()) {
                return $this->redirect($targetUrl);
            } else {
                return $this->redirectToRoute('profile_page');
            }
        } catch (ExceptionInvalidTwoFactorCodeException $e) {
            // If the code is invalid, display an error message and the TOTP form again
            return $this->render('totp.html.twig', array(
                'error' => $e->getMessage(),
                'code' => $request->get('totp_code')
            ));
        }
    }
}
