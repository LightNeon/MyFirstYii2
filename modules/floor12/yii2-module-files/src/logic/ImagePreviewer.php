<?php


namespace floor12\files\logic;

use floor12\files\components\SimpleImage;
use floor12\files\models\File;
use Yii;
use yii\base\ErrorException;

class ImagePreviewer
{

    protected $model;
    protected $width;
    protected $webp;
    protected $fileName;
    protected $fileNameWebp;

    /**
     * ImagePreviewer constructor.
     * @param File $model
     * @param int $width
     * @param bool $webp
     * @throws ErrorException
     */
    public function __construct(File $model, int $width, $webp = false)
    {
        $this->model = $model;
        $this->width = $width;
        $this->webp = $webp;

        if (!$this->model->isImage() && !$this->model->isVideo())
            throw new ErrorException('File is not an image or video.');
    }

    /**
     * @return string
     * @throws \ErrorException
     * @throws \yii\base\InvalidConfigException
     */
    public function getUrl()
    {
        if ($this->model->isSvg())
            return $this->model->getRootPath();

        $cachePath = Yii::$app->getModule('files')->cacheFullPath;
        $jpegName = str_replace(["\\", "\/", '//'], '/', $this->model->makeNameWithSize($this->model->filename, $this->width));
        $webpName = str_replace(["\\", "\/", '//'], '/', $this->model->makeNameWithSize($this->model->filename, $this->width, true));

        $this->fileName = $cachePath . $jpegName;
        $this->fileNameWebp = $cachePath . $webpName;

        $this->prepareFolder();

        $sourceImagePath = $this->model->rootPath;
        if ($this->model->isVideo()) {
            $sourceImagePath = $this->fileName . '.jpeg';
            if (!is_file($sourceImagePath))
                Yii::createObject(VideoFrameExtractor::class, [
                    $this->model->rootPath,
                    $sourceImagePath
                ])->extract();
        }

        if (!is_file($this->fileName) || filesize($this->fileName) == 0)
            $this->createPreview($sourceImagePath);

        if ($this->webp && !file_exists($this->fileNameWebp))
            $this->createPreviewWebp();

        if ($this->webp)
            return $this->fileNameWebp;

        return $this->fileName;
    }

    /**
     * Generate all folders for storing image thumbnails cache.
     */
    protected function prepareFolder()
    {
        if (!file_exists(Yii::$app->getModule('files')->cacheFullPath))
            if (!mkdir($concurrentDirectory = Yii::$app->getModule('files')->cacheFullPath) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

        preg_match('/(.+\/\d{2})\/\d{2}\//', $this->fileName, $matches);
        if (!file_exists($matches[1]))
            if (!mkdir($concurrentDirectory = $matches[1]) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        if (!file_exists($matches[0]))
            if (!mkdir($concurrentDirectory = $matches[0]) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        if (!file_exists($matches[0]))
            throw new ErrorException("Unable to create cache folder: {$matches[0]}");
    }

    /**
     * Creat JPG preview
     * @param $sourceImagePath
     * @throws ErrorException
     */
    protected function createPreview($sourceImagePath)
    {
        $img = new SimpleImage();
        $img->load($sourceImagePath);

        $imgWidth = $img->getWidth();
        $imgHeight = $img->getHeight();

        if ($this->width && $this->width < $imgWidth) {
            $ratio = $this->width / $imgWidth;
            $img->resizeToWidth($this->width);
        }

        $saveType = $img->image_type;
        if ($saveType == IMG_WEBP || $saveType == IMG_QUADRATIC)
            $saveType = IMG_JPEG;

        $img->save($this->fileName, $saveType);
    }

    /**
     *  Create webp from default preview
     */
    protected function createPreviewWebp()
    {
        $img = new SimpleImage();
        $img->load($this->fileName);
        $img->save($this->fileNameWebp, IMAGETYPE_WEBP, 70);
    }
}