<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 01.01.2018
 * Time: 12:14
 *
 * @var $this View
 * @var $model File
 * @var $ratio float
 *
 */

use floor12\files\assets\IconHelper;
use floor12\files\models\File;
use floor12\files\models\FileType;
use yii\helpers\Html;
use yii\web\View;

$doc_contents = [
    'application/msword',
    'application/vnd.ms-excel',
    'application/vnd.ms-powerpoint',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation'
];


?>
<div class="btn-group files-btn-group">

    <div data-title="<?= $model->title ?>" id="yii2-file-object-<?= $model->id ?>"
         class="dropdown-toggle btn-group floor12-file-object <?= ($model->type == FileType::IMAGE) ? "floor12-file-object-image" : NULL ?>"
         style="<?= ($model->type == FileType::IMAGE) ? "background-image: url(" . $model->getPreviewWebPath(160) . ")" : NULL ?>"
         data-toggle="dropdown"
         aria-haspopup="true"
         aria-expanded="false" title="<?= $model->title ?>">

        <?= Html::hiddenInput((new ReflectionClass($model->class))->getShortName() . "[{$model->field}_ids][]", $model->id, ['class' => 'f12-file-input']) ?>
        <?= Html::hiddenInput((new ReflectionClass($model->class))->getShortName() . "[{$model->field}]", 1) ?>

        <?php if ($model->type != FileType::IMAGE) { ?>
            <div class="file-icon"><?= $model->icon ?></div>
            <span class="file__title">
                <?= $model->title ?>
            </span>
        <?php } ?>
    </div>

    <ul class="dropdown-menu dropdown-menu-file-object dropdown-menu-file-object-single">
        <a class="dropdown-item" href="<?= $model->href ?>" target="_blank" data-pjax="0">
            <?= IconHelper::DOWNLOAD ?>
            <?= Yii::t('files', 'Download') ?>
        </a>
        <a class="dropdown-item" href="javascript:;" onclick="clipboard('<?= \yii\helpers\Url::to($model->href, true) ?>'); return false;">
            <?= IconHelper::LINK ?>
            <?= Yii::t('files', 'Copy link to clipboard') ?>
        </a>
        <?php if (in_array($model->content_type, $doc_contents)) { ?>
            <a class="dropdown-item" href="https://view.officeapps.live.com/op/view.aspx?src=<?= \yii\helpers\Url::to($model->href, true) ?>"
               target="_blank" data-pjax="0">
                <?= IconHelper::VIEW ?>
                <?= Yii::t('files', 'View') ?>
            </a>
        <?php } ?>
        <a class="dropdown-item" href="javascript:;" onclick="showRenameFileForm(<?= $model->id ?>, event); return false;">
            <?= IconHelper::RENAME ?>
            <?= Yii::t('files', 'Rename') ?>
        </a>
        <?php if ($model->type == FileType::IMAGE && !$model->isSvg()) { ?>
            <a class="dropdown-item" href="javascript:;" onclick="initCropper(<?= $model->id ?>,'<?= $model->href ?>',<?= $ratio ?>)">
                <?= IconHelper::CROP ?>
                <?= Yii::t('files', 'Edit') ?>
            </a>
        <?php } ?>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="javascript:;" onclick="removeFile(<?= $model->id ?>); showUploadButton(event); return false;">
            <?= IconHelper::TRASH ?>
            <?= Yii::t('files', 'Delete') ?>
        </a>
        <a class="dropdown-item" href="javascript:;" onclick="removeAllFiles(event); return false;">
            <?= IconHelper::EXCLAMATION ?>
            <?= Yii::t('files', 'Delete all') ?>
        </a>
    </ul>

</div>


