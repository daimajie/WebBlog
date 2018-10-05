<?php
namespace app\components\widgets\imageInput\models;
use app\components\services\UploadService;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class ImageModel extends Model
{
    public $image;
    public $field;

    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'image', 'extensions' => 'png, jpg, jpeg, gif',
                'minWidth' => 100, 'maxWidth' => 1000,
                'minHeight' => 100, 'maxHeight' => 1000,
            ]
        ];
    }

    public function upImage($subDir = 'cover'){
        $this->image = UploadedFile::getInstanceByName($this->field);

        //验证
        if ( !$this->validate() ) {
            return false;
        }

        //获取后缀
        $ext = $this->image->extension;

        //生成文件
        $ret = UploadService::generateImage($subDir, $ext);

        //上传
        if( !$this->image->saveAs($ret['fullPath']) ){
            $this->addError('image', '保存文件失败，请重试。');
            return false;
        }

        //上传成功
        return $ret;

    }
}