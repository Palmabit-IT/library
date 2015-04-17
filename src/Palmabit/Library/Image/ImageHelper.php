<?php namespace  Palmabit\Library\Images;


class ImageHelper
{
	/**
	 * @param $image
	 * @param $height
	 * @param $width
	 * @return object Intervention Image
	 */
	public function croptImage($image, $height, $width)
	{
		if ($this->ifPortrait($image)) {
			return $image->crop($height, $width);
		} else {
			return $image->crop($width, $height);
		}

	}

	/**
	 * @param $image
	 * @param $height
	 * @param $width
	 * @return object Intervention Image
	 */
	public function resizeImage($image, $height,$width)
	{
		if ($this->ifPortrait($image)) {
			return $image->resize(null, $height, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
		} else {
			return $image->resize($width, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
		}

	}

	public function ifPortrait($image)
	{
		if ($image->width() < $image->height()) {
			return true;
		}

		return false;

	}

} 