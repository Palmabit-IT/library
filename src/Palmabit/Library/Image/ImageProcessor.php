<?php

  namespace Palmabit\Library\Images;

  use Illuminate\Support\Facades\File;
  use Illuminate\Support\MessageBag;
  use Palmabit\Library\Exceptions\ImageEvidenceException;

  class ImageProcessor {
    protected $height = 50;
    protected $width = 50;
    protected $path = '/';

    protected $helper;
    protected $image;

    function __construct($image) {
      $this->helper = new ImageHelper();
      $this->image  = $image;
    }

    public function crop() {
      return $this->helper->croptImage($this->image, $this->height, $this->width);
    }

    public function resize() {

      return $this->helper->resizeImage($this->image, $this->height, $this->width);
    }

    public function resizeByRatio() {
      $ratio = $this->getRatio();
      if (intval($this->image->width() / $ratio > $this->image->height())) {
        return $this->image->fit(intval($this->image->height() * $ratio), $this->image->height());
      } else {
        return $this->image->fit($this->image->width(), intval($this->image->width() / $ratio));
      }
    }

    public function getRatio() {
      return $this->height / $this->width;
    }

    public function cropAndResize() {
      return $this->crop($this->resize());
    }

    public function save($filename) {

      if (!File::exists(public_path() . $this->path)) {
        File::makeDirectory(public_path() . $this->path, $mode = 0777, true, true);
      }
      $relativePath = $this->path . $filename;
      $this->image->save(public_path() . $relativePath);

      return $relativePath;
    }

    public static function delete($filePath) {
      if (!File::delete(public_path() . $filePath)) {
        throw new ImageEvidenceException(new MessageBag(['Errore nell\'eliminazione dell\'immagine']));
      }
      return true;
    }

  }