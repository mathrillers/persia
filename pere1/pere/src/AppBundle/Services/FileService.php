<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 17/02/2016
 * Time: 11:38
 */

namespace AppBundle\Services;


use AppBundle\Entity\Image;
use Doctrine\ORM\Mapping as ORM;
use SplFileInfo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileService
{
    /**
     * @var \AppBundle\Entity\Compte
     */
    private $user;
    /**
     * @var \AppBundle\Entity\Personne
     */
    private $pers;

    /**
     * @var \AppBundle\Entity\Image
     */
    private $image;
    /**
     * @var  string
     */
    private $url;

    /**
     * @var  UploadedFile[]
     */
    private $files;
    /**
     * @var \AppBundle\Entity\Image[]
     *
     */

      private $images;

    /**
     * @var  array()
     */
    private $paths;

    /**
     * FileService constructor.
     */
    public function __construct()
    {
        $this->image = new Image();
        $this->images=array();
    }

    /**
     * @return \AppBundle\Entity\Compte
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \AppBundle\Entity\Compte $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return \AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param \AppBundle\Entity\Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @param string $fileName
     *
     * @return string
     */
    public function getExtension($fileName)
    {
        $info = new SplFileInfo($fileName);

        return $info->getExtension();

    }


    public function uploadAvatar()
    {
        $moveTo= __DIR__.'/../../../web/images/profils/'.$this->pers->getPersonneId().'/'.$this->pers->getCompte()->getUsername();
        // the file property can be empty if the field is not required
        if (null === $this->image->getFile()) {
            return false;
        }
        $originalName=$this->image->getFile()->getClientOriginalName();
        $extension=$this->getExtension($this->image->getFile()->getClientOriginalName());

        $this->image->getFile()->move(
           $moveTo, $originalName   );

        $newName=$this->pers->getCompte()->getUsername().'.'.$extension;

        rename($moveTo.'/'.$originalName,$moveTo.'/'.$newName);

        // set the path property to the filename where you've saved the file
        $this->url = 'images/profils/'.$this->pers->getPersonneId().'/'.$this->pers->getCompte()->getUsername().'/'.$newName;

        $this->image->setFile(null);
        return true;
    }

    /**
     * @param \AppBundle\Entity\Immobilier $immobilier
     *
     * @return bool
     */
    public function upload($immobilier)
    {
        if (null === $this->getFiles()) {
            return false;
        }
       // $i=0;
        foreach($this->files as $file)
        {
            $img=new Image();
            $img ->setImmobilier($immobilier);
           /* $path = sha1(uniqid(mt_rand(), true)).'.'.$file->guessExtension();
            array_push ($this->paths, $path);*/
            $originalName=$file->getClientOriginalName();
            $file->move($this->getUploadRootDir($immobilier ), $originalName);

            $newUrl="images/profils/".$immobilier->getProprietaire()->getPersonneId()."/biens/".$immobilier->getImmobilierId()."/".$originalName;
            $img->setUrl($newUrl);
            $img->setNom($originalName);

            array_push ( $this->images,$img);

            unset($file);
        }
    }
    /**
     * @param \AppBundle\Entity\Immobilier $immo
     *
     * @return string
     */
    protected function getUploadRootDir($immo)
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/images/profils/'.$immo->getProprietaire()->getPersonneId()."/biens/".$immo->getImmobilierId()."/";
    }
    /**
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile[] $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * @param array $paths
     */
    public function setPaths($paths)
    {
        $this->paths = $paths;
    }

    /**
     * @return \AppBundle\Entity\Image[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param \AppBundle\Entity\Image[] $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return \AppBundle\Entity\Personne
     */
    public function getPers()
    {
        return $this->pers;
    }

    /**
     * @param \AppBundle\Entity\Personne $pers
     */
    public function setPers($pers)
    {
        $this->pers = $pers;
    }


    /**
     * @param \AppBundle\Entity\Agence $agence
     *
     * @return bool
     */
    public function upload1($agence)
    {
        if (null === $this->getFiles()) {
            return false;
        }
        // $i=0;
        foreach($this->files as $file)
        {
            $img=new Image(0,0,0);
            $img ->setAgence($agence);
            /* $path = sha1(uniqid(mt_rand(), true)).'.'.$file->guessExtension();
             array_push ($this->paths, $path);*/
            $originalName=$file->getClientOriginalName();
            $file->move($this->getUploadRootDir1($agence ), $originalName);

            $newUrl="images/Agences/".$img->getAgence()->getNom()."/".$originalName;
            $img->setUrl($newUrl);
            $img->setNom($originalName);

            array_push ( $this->images,$img);

            unset($file);
        }
    }
    /**
     * @param \AppBundle\Entity\Agence $agen
     *
     * @return string
     */
    protected function getUploadRootDir1($agen)
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/images/Agences/'.$agen->getNom()."/";
    }
    //*********************************************************************************************


}