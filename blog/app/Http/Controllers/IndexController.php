<?php

namespace App\Http\Controllers;

use App\Article;
use App\Layout;
use Illuminate\Support\Facades\URL;


class IndexController extends Controller
{
    /**
     * Show the main page.
     *
     * @param int $id
     * @return View
     */
    public function show()
    {
        $last_articles = Article::orderBy('created_at', 'desc')->where('confirmed',
            '=', '1')->where('type_article', '=',
            "article")->limit(2)->get();
        $active_menu_item = Layout::get_active_menu_item(URL::current());
        return view('index', compact('last_articles', 'active_menu_item'));
    }

    public function sitemap()
    {
        $articles = Article::orderBy('created_at', 'desc')->where('confirmed',
            '=', '1')->where('type_article', '=', 'article')->get();

        // инициализируем новый dom объект
        $xml = new domDocument();

        //создаём тег urlset
        $urlset = $xml->createElement('urlset');

        //добавляем атрибут xmlns, как указан на яндексе
        //и указываем его значение
        $xmlns = $xml->createAttribute('xmlns');
        $xmlns->value = "http://www.sitemaps.org/schemas/sitemap/0.9";

        //добавляем атрибут в тег urlset
        $urlset->appendChild($xmlns);

        //цикл, в котором обходим, полученный массив с продуктами
        foreach ($issues as $issue) {

            //внутри urlset создаём теги url для каждого товара
            $url = $urlset->appendChild($xml->createElement('url'));
            //тег loc внутри url, тут будет URL товара
            $loc = $url->appendChild($xml->createElement('loc'));

            //с помощью класса Url и метода to получаем url товара
            //и добавляем внутри тега loc
            $loc->appendChild($xml->createTextNode(Url::to(['/' . $issue->id], 'https')));
//            $loc->appendChild($xml->createTextNode(Url::toRoute('/'.$issue->id, 'https'));

            //тег даты последнего изменения проблемы и сама дата
            $lastmod = $url->appendChild($xml->createElement('lastmod'));


//            if (is_null($issue->updatedDate)) {
//
//                $lastmod->appendChild($xml->createTextNode($issue->createdDate));
//
//            } else {
//
//                $lastmod->appendChild($xml->createTextNode($issue->updatedDate));
//
//            }


            if (is_null($issue->updatedDate)) {

                $lastmod->appendChild($xml->createTextNode(date('Y-m-d\TH:i:sP', strtotime($issue->createdDate))));

            } else {

                $lastmod->appendChild($xml->createTextNode(date('Y-m-d\TH:i:sP', strtotime($issue->updatedDate))));

            }


            //добавляем тег приоритета для поисковиков
            $priority = $url->appendChild($xml->createElement('priority'));
            //указываем для каждого товара приоритет — 1
            $priority->appendChild($xml->createTextNode('1'));
        }

        $xml->appendChild($urlset);

        //и записываем в переменную это всё
        $sm = $xml->saveXML();

        //передача в шаблон
        return $this->renderPartial('sitemap', ['sm' => $sm]);
    }
}