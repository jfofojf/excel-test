<?php

namespace App\Service;

use App\Clients\PostsClientFactory;
use App\Exports\DataExport;
use App\Imports\DataImport;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ExcelService
{
    protected const FILES_DIR = 'data';
    protected const FILE_NAME_TEMPLATE = '%s-%s.xlsx';

    protected const POSTS_CHUNK_SIZE = 70;

    public function prepareFromFile(UploadedFile $file): DataExport
    {
        $filename = sprintf(self::FILE_NAME_TEMPLATE, $file->getFilename(), time());

        Storage::putFileAs(self::FILES_DIR, $file, $filename);

        $array = (new DataImport)->toArray(self::FILES_DIR . '/' . $filename);

        Storage::delete(self::FILES_DIR . '/' . $filename);

        $arr = reset($array);
        $count = count($arr);
        for ($i = 1; $i < $count; $i++) {
            for ($j = $i; $j >= 1 && $arr[$j][2] > $arr[$j - 1][2]; $j--) {
                [$arr[$j], $arr[$j - 1]] = [$arr[$j - 1], $arr[$j]];
            }
        }

        $titles = $bodies = [];
        foreach ($arr as $post) {
            $titles[] = $post[0];
            $bodies[] = $post[1];
        }

        return new DataExport([$titles, $bodies]);
    }

    /**
     * @throws GuzzleException
     */
    public function getFromResource(): DataExport
    {
        $client = PostsClientFactory::create();

        $titles = $bodies = [];
        for ($i = 1; $i < 3; $i++) {
            $data = $client->getPosts($i, self::POSTS_CHUNK_SIZE);

            foreach ($data as $post) {
                $titles[] = $post['title']['rendered'];
                $bodies[] = $post['content']['rendered'];
            }
        }

        return new DataExport([$titles, $bodies]);
    }

}
