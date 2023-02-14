<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VinylController
{
  #[Route('/')]
  public function homepage(){
    return new Response('Title: PB and Jams');
  }

  #[Route('/browse/{categories}')]
  public function browse($categories = null) : Response {
    return new Response('Genre: '. $categories);
  }
}