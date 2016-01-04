<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {

        if( !$this->getUser() )
           return $this->redirect( $this->generateUrl( 'fos_user_security_login' ) );

        return $this->render( 'AppBundle:IndexController:index.html.twig', [
            // ...
        ] );
    }

}
