<?php

namespace App;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $s3;

    public function __construct()
    {
        //
    }

    /**
     * @param  integer $id
     */
    public function link($id)
    {
        //
    }

    /**
     * @param  string $bucket
     * @param  string $key
     * @param  string $file
     */
    public function upload($bucket, $key, $file)
    {
        //
    }
}
