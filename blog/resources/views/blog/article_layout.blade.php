@extends('layouts.app')

@section('title', "Чему учит нас осьминог относительно дизайна организации по Agile?")
@section('description', '')
@section('page_url', route('blog.show_article', 'chemu_uchit_nas_osminog_otnositelno_dizaina_organizacii_po_agile'))
@section('main_image_path', env('APP_URL').'/assets/img/octopus_main.jpg')

@section('custom_css')
    @parent
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="assets/css/custiom_article.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- here we are-->
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
    @include('layouts.navbar_white')

    <div class="article-progress" data-sticky="below-nav">
        <progress class="reading-position" value="0"></progress>
        <div class="article-progress-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <div class="text-small text-muted mr-1">Читаете:</div>
                                <div class="text-small">Чему учит нас осьминог относительно дизайна организации по
                                    Agile?
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="text-small text-muted">Поделиться:</span>
                                <div class="d-flex ml-1">
                                    <a href="{{$article->tweetHrefGenerate()}}"
                                       class="mx-1 btn btn-sm btn-round btn-primary">
                                        <img class="icon" src="assets/img/icons/social/twitter.svg"
                                             alt="twitter social icon" data-inject-svg/>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{route('blog.show_article', $article->text_url)}}&display=popup"
                                       class="mx-1 btn btn-sm btn-round btn-primary">
                                        <img class="icon" src="assets/img/icons/social/facebook.svg"
                                             alt="facebook social icon" data-inject-svg/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="pb-0 pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('blog.home')}}">Блог</a>
                                </li>
                                <li class="breadcrumb-item">
                                    Agile
                                </li>
                            </ol>
                        </nav>
                        <span class="badge bg-primary-alt text-primary">
                <img class="icon bg-primary" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"
                     alt="heart interface icon"
                     data-inject-svg/>{{$article->views_count}}</span>
                    </div>
                    <h1>Чему учит нас осьминог относительно дизайна организации по Agile?</h1>
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <img src="{{env('APP_URL').$article->user->avatar_path}}" alt="Avatar" class="avatar mr-2">
                        </a>
                        <div>
                            <div>Автор статьи: <a href="#">{{$article->user->name}}</a>
                            </div>
                            <div class="text-small text-muted">{{$article->get_nice_time_created()}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="p-0" data-reading-position>
        <div class="container">
            <div class="row justify-content-center position-relative">
                <div class="col-lg-10 col-xl-8">
                    <div class="popover-image">
                        <figure>
                            <img src="/assets/img/octopus_main_1.jpg" alt="Image" class="rounded border shadow-lg">
                            <figcaption>
                                <noindex>
                                    Photo by <a rel="nofollow"
                                                href="https://unsplash.com/@serenarepice?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Serena
                                        Repice Lentini</a> on <a rel="nofollow"
                                                                 href="https://unsplash.com/">Unsplash</a>
                                </noindex>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <article class="article"><p class="lead"> В этой статье я планирую рассказать как на своей практике
                            мы применяем Персональный рейтинг каждого члена команды в Scrum в процессе работы по
                            фреймворку <a href="https://www.scaledagileframework.com">SAFe</a></p>
                        <p>Наверное, многие согласятся с тем, что (особенно в России) у нас люди достаточно часто
                            стараются работать (доставлять конечный продукт в рамках своих компетенций или посредством
                            получения новых) поменьше и получать денег побольше. С размером компании возможности для
                            этого, кажется, что растут прямо пропорционально. С этим, как правило, работают различные
                            околоHR'ы, которые всячески пытаются строить правильную систему мотивации. Сюда же OKR'ы и
                            т.д. В целом, кажется, все это нацелено на сбалансированность нагрузки каждого внутри
                            корпорации и комфорт всех заинтересованных групп лиц/команд корпорации. В данной статье я
                            поделюсь метрикой, которую сам придумал и применяю в команде. Она позволяет, как мне
                            кажется, дополнить усилия HR'ов и OKR'ов в сбалансированности нагрузки внутри одной
                            конкретной команды или увидеть дисбаланс, соответственно. Также, она вполне может и
                            масштабироваться на команду команд, не вижу в этом особой проблемы.</p>
                        <p>Таким образом, мне как Скрам Мастеру достаточно очевидно порой, что нагрузка в команде не
                            сбалансирована, кто-то работает за двоих, кто-то не делает ничего (это крайние формы и,
                            конечно же, серьезная проблема, но данная метрика показывает и не только крайние формы). Со
                            мной случилась такая ситуация и я задумался о том какая метрика могла бы ярко высветить
                            данную проблему. В итоге, это вылилось в персональный рейтинг каждого члена команды. </p>
                        <p>Прежде, чем описать саму метрику, хотелось бы также отметить одну очень важную, на мой
                            взгляд, идею. На данный момент я в ней абсолютно уверен.</p>
                        <p class="lead">Метрики должны строиться на основании тех данных, которые вы и так получаете.
                            Получение какой-либо метрики не должно заставлять команду систематически тратить больше
                            времени и подстраивать свой процесс доставки ценности под саму метрику. Подробнее об этом я
                            постараюсь рассказать в одной из следующих статей.</p>
                        <p>Итак, пример конкретного случая. Конечно, мы используем доску для передвижения User Stories
                            по статусам от DOR (Definition Of Ready) до DOD (Definition Of Done). Она у нас виртуальная
                            (т.е. расположена в интернете по ссылке. Команда у нас тоже распределенная и стендапы
                            проходят через корпоративный скайп как раз с трансляцией доски.</p>
                        <p>Члену команды удобно ставить себя в участники User Story, чтобы при использовании фильтра по
                            себе можно было быстро оставить только те истории, в которых он участвует в данный
                            момент(чаще всего этим фильтром мы пользуемся на стендапах).</p>
                        <div class="popover-image">
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: -2%; left: -1%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Примерно так доска может выглядеть в середине спринта."></div>
                            <img src="assets/img/article-member_rating_1.jpg" alt="Image"
                                 class="rounded border shadow-lg"></div>
                        <br/> <br/>
                        <p> Здесь также, хотелось бы дать пояснение: это не значит что данный член команды не может
                            участвовать в других историях (если, например, на стендапе кто-то из членов команды попросит
                            о помощи, он вполне может стать участником новой истории или наоборот, если почувствует, что
                            его участие не требуется, может перестать быть участником какой-либо истории.</p>
                        <p>Таким образом, чтобы посчитать рейтинг каждого члена команды, нам нужно посмотреть на сколько
                            SP влияет каждый член команды. В нашем случае Аркадий влияет на 29 SP (истории 1, 2, 5, 6),
                            Татьяна влияет на 33 SP (Участвует во всех историях), Василий на 23 SP (истории 1, 3, 5,
                            6).</p>
                        <p> Закрыто(выполнен DOD) у Аркадия 5 из 29 SP, у Татьяны 6 из 32 SP, у Василия 5 из 23. С
                            сортировкой я достаточно долго мучился и пришел вот к такой формуле сравнения двух членов
                            команды (<code>member[i]</code> и <code>member[j]</code>): <br/> <br/>
                        <div class="popover-image">
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 9%; left: 90%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Если количество выполненных SP первого члена команды больше количества выполненных SP второго члена команды и  разность между общим количеством SP на которые влияет первый член команды и выполненных SP первым членом команды меньше или равна той же разности для второго члена команды"></div>
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 25%; left: 90%;"
                                 data-toggle="tooltip" data-placement="bottom" title="" data-original-title="ИЛИ"></div>
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 49%; left: 90%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Первый член команды выполнил все SP на которые влияет и второй член команды не выполнил все SP на которые влияет."></div>
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 62%; left: 90%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Значит первый член команды имеет место в рейтинге выше."></div>
                            <div id="first_point" class="popover-hotspot bg-primary-2" style="top: 76%; left: 90%;"
                                 data-toggle="tooltip" data-placement="bottom" title=""
                                 data-original-title="Иначе, соответственно, второй член команды имеет место в рейтинге выше."></div>
                            <img src="assets/img/article-member_rating_3.jpg" alt="Image"
                                 class="rounded border shadow-lg"></div>
                        </p>                      <p>Согласно этой сортировке мы получим текущий рейтинг членов команды
                            в следующем виде.
                        <ul>
                            <li>1 место. Василий (Выполнено 5 из 23)</li>
                            <li>2 место. Аркадий (Выполнено 5 из 29)</li>
                            <li>3 место. Татьяна (Выполнено 6 из 32)</li>
                        </ul>
                        </p>                      <p>Теперь давайте сгенерируем все данные по спринту. Представим, что
                            спринт длится 5 рабочих дней.
                        <ul>
                            <li>1 день
                                <div class="popover-image">
                                    <div id="first_point" class="popover-hotspot bg-primary-2"
                                         style="top: 76%; left: 90%;" data-toggle="tooltip" data-placement="bottom"
                                         title=""
                                         data-original-title="В первый день спринта все истории еще не начаты."></div>
                                    <img src="assets/img/article-member_rating_day_1.jpg" alt="Image"
                                         class="rounded border shadow-lg"></div>
                                <div class="popover-image"><img src="assets/img/member_rating_1day_graph.jpg"
                                                                alt="Image" class="rounded border shadow-lg"></div>
                                <br/> 1 место: Василий (сожжено 0 из 23)<br/> 2 место: Аркадий (сожжено 0 из 29)<br/> 3
                                место: Татьяна (сожжено 0 из 32)<br/></li>
                            <li>2 день
                                <div class="popover-image">
                                    <div id="first_point" class="popover-hotspot bg-primary-2"
                                         style="top: 76%; left: 90%;" data-toggle="tooltip" data-placement="bottom"
                                         title="" data-original-title="Во второй день частично ушли в работу."></div>
                                    <img src="assets/img/article-member_rating_day_2.jpg" alt="Image"
                                         class="rounded border shadow-lg"></div>
                                <div class="popover-image"><img src="assets/img/member_rating_2day_graph.jpg"
                                                                alt="Image" class="rounded border shadow-lg"></div>
                                <br/> 1 место: Василий (сожжено 0 из 23) динамика(1->1)<br/> 2 место: Аркадий (сожжено 0
                                из 29) динамика(2->2)<br/> 3 место: Татьяна (сожжено 0 из 32) динамика(3->3)<br/></li>
                            <li>3 день
                                <div class="popover-image">
                                    <div id="first_point" class="popover-hotspot bg-primary-2"
                                         style="top: 76%; left: 90%;" data-toggle="tooltip" data-placement="bottom"
                                         title="" data-original-title="В третий день продолжается процесс."></div>
                                    <img src="assets/img/article-member_rating_day_3.jpg" alt="Image"
                                         class="rounded border shadow-lg"></div>
                                <div class="popover-image"><img src="assets/img/member_rating_3day_graph.jpg"
                                                                alt="Image" class="rounded border shadow-lg"></div>
                                <br/> 1 место: Василий (сожжено 5 из 23) динамика(1->1->1)<br/> 2 место: Аркадий
                                (сожжено 5 из 29) динамика(2->2->2)<br/> 3 место: Татьяна (сожжено 5 из 32)
                                динамика(3->3->3)<br/></li>
                            <li>4 день
                                <div class="popover-image">
                                    <div id="first_point" class="popover-hotspot bg-primary-2"
                                         style="top: 76%; left: 90%;" data-toggle="tooltip" data-placement="bottom"
                                         title=""
                                         data-original-title="В четвертый день мы уже закрыли некоторые истории."></div>
                                    <img src="assets/img/article-member_rating_day_4.jpg" alt="Image"
                                         class="rounded border shadow-lg"></div>
                                <div class="popover-image"><img src="assets/img/member_rating_4day_graph.jpg"
                                                                alt="Image" class="rounded border shadow-lg"></div>
                                <br/> 1 место: Василий (сожжено 8 из 23) динамика(1->1->1->1)<br/> 2 место: Аркадий
                                (сожжено 8 из 29) динамика(2->2->2->2)<br/> 3 место: Татьяна (сожжено 9 из 32)
                                динамика(3->3->3->3)<br/></li>
                            <li>5 день
                                <div class="popover-image">
                                    <div id="first_point" class="popover-hotspot bg-primary-2"
                                         style="top: 76%; left: 90%;" data-toggle="tooltip" data-placement="bottom"
                                         title=""
                                         data-original-title="Здесь мы видим финальное состояние спринта."></div>
                                    <img src="assets/img/article-member_rating_day_5.jpg" alt="Image"
                                         class="rounded border shadow-lg"></div>
                                <div class="popover-image"><img src="assets/img/member_rating_5day_graph.jpg"
                                                                alt="Image" class="rounded border shadow-lg"></div>
                                <br/> 1 место: Василий (сожжено 23 из 23) динамика(1->1->1->1->1)<br/> 2 место: Татьяна
                                (сожжено 24 из 32) динамика(3->3->3->3->2)<br/> 3 место: Аркадий (сожжено 21 из 29)
                                динамика(2->2->2->2->3)<br/></li>
                        </ul>
                        </p>                      <p>Таким образом, используя данную метрику можно накапливать
                            персональную статистику каждого члена команды и помогать ему делать правильные выводы.
                            Например, здесь мы видим, что Василий очень грамотно спланировал свое время с самого
                            начала(т.е. на планировании спринта он договорился с командой о том объеме работ, который он
                            и выполнил по факту.) Но, в то же время, может он мог как-то помочь другим членам команды?
                            Возможно и нет, но стоит подумать над этим вопросом перед ретроспективой.</p>
                        <p>У Татьяны и Аркадия проблема посерьезнее. Очевидно, что с самого начала на планировании
                            спринта они договорилась с командой об участии во всех историях и по факту не смогли
                            выполнить обязательства. О причинах также стоит подумать перед ретроспективой. Возможно
                            стоит меньше планировать на себя, возможно расширять компетенции чтобы успевать все
                            запланированное, возможны и другие решения. </p>
                        <p>Таким образом, мы можем накапливать статистику не только по всей команде и не только по
                            одному спринту, но и по конкретным участникам DEV TEAM за все время и использовать эту
                            информацию для постоянного совершенствования команды.</p>
                        <p>В заключении, хотелось бы обратить особое внимание на тот факт, что перед использованием этой
                            метрики в команде должен быть уже достаточно высокий уровень доверия у большей части
                            команды. Также, я рекомендовал бы делать большой акцент на том, что первично - отсутствие
                            переработок и комфортная деятельность.</p>
                        <p class="lead">Мы акцентируемся на правильном прогнозировании результата, а не на мотивации
                            перерабатывать чтобы занимать 1 место. В конечном итоге, эта метрика нацелена на улучшение
                            способности планирования каждого члена команды в отдельности.</p></article>
                </div>
            </div>
        </div>
    </section>

    <section class="has-divider">
        <div class="container pt-3">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">

                    <hr>
                    @include('blog.article.social_sharing')
                    @include('blog.article.answer_form')
                    <hr id="add_comment">
                    @include('blog.article.add_comment')

                </div>
            </div>
        </div>
        <div class="divider">
            <img class="bg-primary-alt" src="assets/img/dividers/divider-1.svg" alt="divider graphic" data-inject-svg/>
        </div>
    </section>

    @include('blog.article.related_stories')
    @include('blog.articles.emailing_list_footer')

@endsection

@section('pageScript')
    @parent
@endsection