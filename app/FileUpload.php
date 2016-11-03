<?php

namespace App;

use Aws\S3\Exception\S3Exception;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    protected $s3;

    public function initalizeAws()
    {
        try {
            $this->s3 = AWS::createClient('s3');
        } catch (S3Exception $e) {
            echo $e->getMessage();
        }
    }

    public function link($id)
    {
        //
    }

    public function upload($bucket, $key, $file)
    {
        $this->initalizeAws();

        try {
            $this->s3->putObject([
                'Bucket'     => $bucket,
                'Key'        => $key,
                'SourceFile' => $file
            ]);
        } catch (S3Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteBucket($bucket)
    {
        $this->initalizeAws();

        try {
            $this->s3->bucket($bucket)->delete();
        } catch (S3Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteObject($object)
    {
        $this->initalizeAws();

        try {
            $this->s3->object($object)->delete();
        } catch (S3Exception $e) {
            echo $e->getMessage();
        }
    }
}
