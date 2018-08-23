<?php

    namespace Modules\Core\Libs;

    use Exception;

    class ImageCompress {

        private $file;
        private $quality;
        private $pngQuality;
        /**
         * @var null
         */
        private $name;
        /**
         * @var null
         */
        private $destination;

        /**
         * @param      $file
         * @param      $quality
         * @param      $pngQuality
         * @param null $name
         * @param null $destination
         *
         * @return $this
         */
        public function set ($file, $quality = 60, $pngQuality = 9, $name = NULL, $destination = NULL)
        {
            $this->file        = $file;
            $this->quality     = $quality;
            $this->pngQuality  = $pngQuality;
            $this->name        = $name;
            $this->destination = $destination;

            return $this;
        }

        public function compress ()
        {
            $arrayTpes   = ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png'];
            $maxSize     = 5245330;
            $destination = NULL;

            try {

                //If not found the file
                if (empty($this->file) && !file_exists($this->file)) {
                    throw new Exception('Please inform the image!');

                    return FALSE;
                }

                //Get image infos..
                $imageInfos = pathinfo($this->file);
                //Get image width, height, mimetype, etc..
                $imageData = getimagesize($this->file);
                //Set MimeType on variable
                $imageMime = $imageData['mime'];

                //Verifiy if the file is a image
                if (!in_array($imageMime, $arrayTpes)) {
                    throw new Exception('Please send a image!');

                    return FALSE;
                }

                //Verify if folder destination isn´t empty
                if (!empty($this->destination)) {

                    //And verify the last one element of value
                    $last_char = substr($this->destination, -1);

                    if ($last_char !== '/') {
                        $this->destination = $this->destination . '/';
                    }

                    if (!file_exists($this->destination)) {
                        mkdir($this->destination, 0777, TRUE);
                    }
                }

                //Set destination
                $destination = ($this->destination != NULL ? $this->destination : $imageInfos['dirname']);
                $destination = $destination . DIRECTORY_SEPARATOR . $imageInfos['basename'];

                switch ($imageMime) {
                    //if is JPG and siblings
                    case 'image/jpeg':
                    case 'image/pjpeg':
                        //Create a new jpg image
                        $new_image = imagecreatefromjpeg($this->file);
                        imagejpeg($new_image, $destination, $this->quality);
                        break;
                    //if is PNG and siblings
                    case 'image/png':
                    case 'image/x-png':
                        //Create a new png image
                        $new_image = imagecreatefrompng($this->file);
                        imagealphablending($new_image, FALSE);
                        imagesavealpha($new_image, TRUE);
                        imagepng($new_image, $destination, $this->pngQuality);
                        break;
                    // if is GIF
                    case 'image/gif':
                        //Create a new gif image
                        $new_image = imagecreatefromgif($this->file);
                        imagealphablending($new_image, FALSE);
                        imagesavealpha($new_image, TRUE);
                        imagegif($new_image, $destination);
                }


            } catch (Exception $ex) {
                return $ex->getMessage();
            }

            return $destination;

        }


    }