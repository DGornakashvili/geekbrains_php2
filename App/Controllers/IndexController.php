<?php

namespace App\Controllers;

use App\Models\Image;

class IndexController extends Controller
{
    protected $template = 'index.twig';

    /**
     * @param array $data
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index($data = [])
    {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];

            $this->template = 'singleImg.twig';
            $image = Image::getByKey($id);
            $image->views++;
            $image->save();
            $renderData = [
                'title' => "Image $id",
                'img' => $image
            ];
        } else {
            $images = Image::get(null,[['col' => 'views', 'direction' => 'desc']]);
            $renderData = [
                'title' => 'Gallery',
                'images' => $images
            ];
        }
        return $this->render($renderData);
    }
}