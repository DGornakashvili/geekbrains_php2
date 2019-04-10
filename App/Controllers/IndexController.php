<?php

namespace App\Controllers;

use App\Models\Image;

class IndexController extends Controller
{
	protected $template = 'index.twig';

	/**
	 * Главная страница
	 * @return string главная страница, если передан id, соответствеющее изображение
	 * @throws - ошибки шаблонизатора
	 */
	public function index(): string
	{
		if (isset($_GET['id'])) {
			$id = (int)$_GET['id'];

			$this->template = 'singleImg.twig';

			/**
			 * @var Image $image
			 */
			$image = Image::getByKey($id);
			$image->views++;
			$image->save();

			$renderData = [
				'title' => "Image $id",
				'img' => $image
			];
		} else {
			/**
			 * @var Image $images
			 */
			$images = Image::get([], [['col' => 'views', 'direction' => 'desc']]);

			$renderData = [
				'title' => 'Gallery',
				'images' => $images
			];
		}
		return $this->render($renderData);
	}
}