<?php

namespace Gounsch;

class Controller
{
    public static function home(): never
    {
        header('Location: /');

        exit();
    }

    /**
     * @throws \InvalidArgumentException
     */
    public static function uploadFile(Files $files, array $uploadedFile): void
    {
        if ($uploadedFile['size'] > 10000000) {
            throw new \InvalidArgumentException('File size is greater than 10 MB. Please upload a smaller file.');
        }

        $files->add($uploadedFile['name'], file_get_contents($uploadedFile['tmp_name']));
    }

    public static function deleteFile(Files $files, string $filename): void
    {
        $files->delete($filename);
    }

    public static function login(array $post): string
    {
        if (!in_array($post['_username'], ['eena', 'meena', 'deeka'], true)) {
            http_response_code(401);

            echo "Expected one of eena, meena or deeka. {$post['_username']} given.";

            echo '<meta http-equiv="refresh" content="3;url=/">';
            exit;
        }

        return $post['_username'];
    }

    public static function preview(\finfo $finfo, Files $files, string $filename): never
    {
        $data = $files->get($filename);

        $mimeType = $finfo->buffer($data);

        header('Content-Disposition: inline');
        header("Content-Type: {$mimeType}");

        echo $data;
        exit();
    }
}