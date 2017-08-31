<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $baseDir = realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR."web";
        $finder = new Finder;
        $iterator = $finder
            ->directories()
            ->name('~*')
            ->depth(0)
            ->in($baseDir);
        //print_r($iterator);
        $i=0;
        foreach(iterator_to_array($iterator) as $path)
            $iterator1[$i++] = $this->generateUrl('homepage').str_replace($baseDir.DIRECTORY_SEPARATOR,'',$path);
        //print_r($iterator);
        // replace this example code with whatever you need
        return $this->render('default/default.html.twig', [
            'base_dir' => $baseDir,'iterator' => $iterator1, //$this->generateUrl('homepage')
        ]);
    }
    /**
     * @Route("/{user}", name="UserContent")
     */
    public function showUserDir(Request $request, $user){

        $baseDir = realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR."web".DIRECTORY_SEPARATOR
                   .$user;
        $finder = new Finder;
        $iterator = $finder
            ->files()
            ->name('*.ahk')
            ->in($baseDir);
        $i=0;$paths=[];$pathsNames=[];
        foreach(iterator_to_array($iterator) as $path){
            $pathsNames[$i] = str_replace($baseDir.DIRECTORY_SEPARATOR,'',$path);
            $paths[$i] = file_get_contents($path);$i++;
        }

        return $this->render('default/user.html.twig', [
            'user' => $user, 'paths'=>$paths, 'pathNamess' => $pathsNames, //$this->generateUrl('homepage')
        ]);
    }
}
