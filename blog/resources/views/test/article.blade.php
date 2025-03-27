<!-- Stored in resources/views/child.blade.php -->


<!doctype html>
<html lang="ru">

<head>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#007bff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Favicon -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-12999557-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-12999557-2');
    </script>

    <meta charset="utf-8">

    <!-- Title ----------------------------------------------------------->
    <title>Принятие пользовательских типов в Go</title>
    <!-- Title ----------------------------------------------------------->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Description ----------------------------------------------------------->
    <meta name="description"
          content="В статье рассказывается о концепции пользовательских типов в Go и о корректном ее применении">
    <!-- Description ----------------------------------------------------------->
    <meta property="og:url"
          content="http://newampleev.com/article-1"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title"
          content="Когда мы сможем увидеть продолжение 5 сезона сериала &#171;Миллиарды&#187;? | Амплеев Евгений - Scrum Master / Full stack web developer"/>
    <meta property="og:description"
          content="В данной статье я постараюсь описать основные и, наиболее яркие отличия фреймворка SAFe относительно SCRUM, которые я заметил за год работы в SAFe."/>
    <meta property="og:image" content="http://newampleev.comassets/img/article-5_my.jpg"/>

    <link href="assets/css/loaders/loader-typing.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="assets/css/prism.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="assets/css/theme.css" rel="stylesheet" type="text/css" media="all"/>


    <link rel="preload" as="font" href="assets/fonts/Inter-UI-upright.var.woff2" type="font/woff2"
          crossorigin="anonymous">
    <link rel="preload" as="font" href="assets/fonts/Inter-UI.var.woff2" type="font/woff2" crossorigin="anonymous">
</head>


<body>
<div class="loader">
    <div class="loading-animation"></div>
</div>

<link href="assets/css/custom.css" rel="stylesheet" type="text/css" media="all"/>

<div class="navbar-container ">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">

            <a class="navbar-brand fade-page" href="http://newampleev.com/blog">
                <span>Ampleev.com</span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse"
                    aria-expanded="false" aria-label="Toggle navigation">
                <img class="icon navbar-toggler-open" src="assets/img/icons/interface/menu.svg"
                     alt="menu interface icon" data-inject-svg/>
                <img class="icon navbar-toggler-close" src="assets/img/icons/interface/cross.svg"
                     alt="cross interface icon" data-inject-svg/>
            </button>

            <div class="dropdown ml-2">
                <img src="/storage/user_avatars/female-3_my.jpg" alt="User"
                     class="avatar avatar-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">
                <div class="dropdown-menu dropdown-menu-right dropdown-content">
                    <h6 id="menu_active_item">Мой профиль</h6>
                    <a class="dropdown-item" href="http://newampleev.com/logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Выйти</a>
                    <form id="logout-form" action="http://newampleev.com/logout" method="POST"
                          style="display: none;">
                        <input type="hidden" name="_token" value="BUH5xFouPlIQzeROqXClWpmRm5bkwwrKfS78ORks">
                    </form>
                </div>
            </div>


        </div>
    </nav>
</div>
<div class="article-progress" data-sticky="below-nav">
    <progress class="reading-position" value="0"></progress>
    <div class="article-progress-wrapper">
        <div class="container">
            <div class="row">
                <div class="col py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <div class="text-small text-muted mr-1">Читаете:</div>
                            <!-- Заголовок в прогресс-баре -------------------------------------------------------->
                            <div class="text-small">Разбираемся с аллокациями в <code>Golang</code>
                            </div>
                            <!-- Заголовок в прогресс-баре -------------------------------------------------------->
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="text-small text-muted">Поделиться:</span>
                            <div class="d-flex ml-1">
                                <a href="https://twitter.com/intent/tweet?text=Диаграммы сгорания в контексте SAFe http://newampleev.com/article-1"
                                   class="mx-1 btn btn-sm btn-round btn-primary">
                                    <img class="icon" src="assets/img/icons/social/twitter.svg"
                                         alt="twitter social icon" data-inject-svg/>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=http://newampleev.com/article-1&display=popup"
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
                                <a href="http://newampleev.com/blog">Блог</a>
                            </li>
                            <li class="breadcrumb-item">
                                Agile
                            </li>
                        </ol>
                    </nav>
                    <span class="badge bg-primary-alt text-primary">
                <img class="icon bg-primary" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"
                     alt="heart interface icon"
                     data-inject-svg/>1</span>
                </div>

                <!-- Заголовок статьи H1-->
                <h1>Разбираемся с аллокациями в <code>Golang</code></h1>
                <!-- Заголовок статьи H1-->
                <!-- ----------------------------------------------------------------------------------------------------------->
                <div class="d-flex align-items-center">
                    <a href="#">
                        <img src="/assets/img/avatars/yevgeniy_ampleev.png" alt="Avatar"
                             class="avatar mr-2">
                    </a>
                    <div>
                        <div>Автор статьи: <a href="#">Евгений Амплеев</a>
                        </div>
                        <div class="text-small text-muted">17 января 2025 в 13:51</div>
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
                <!-- ----------------------------------------------------------------------------------------------------------->
                <!-- First paragraph-->
                <!-- ----------------------------------------------------------------------------------------------------------->
                <figure><img src="/assets/img/allocations_main.png"
                             alt="Принятие пользовательских типов в Go"
                             class="rounded border">
                </figure>
                <h2>Введение</h2>
                <p class="lead">Благодаря эффективному встроенному управлению памятью в среде выполнения
                    <strong>Go</strong> мы чаще всего
                    можем не обращать особого внимания на детали того, как происходят выделения памяти. Однако время от
                    времени <strong>мы можем обнаружить в
                        нашем коде проблемы с производительностью</strong> и тогда все же приходится разбираться.</p>

                <p class="lead">Любой, кто запускал бенчмарк с флагом <code>-benchmem</code>, наверняка видел статистику
                    <code>allocs/op</code> в
                    выводах, подобных приведенным ниже. В этом посте мы рассмотрим, что понимается под <strong>аллокациями
                        памяти</strong> и что мы
                    можем сделать, чтобы повлиять на это число.</p>
                <br/>
                <pre class="language-bash"><code>BenchmarkFunc-8  67836464  16.0 ns/op  8 B/op  1 allocs/op</code></pre>
                <br/>
                <!-- ----------------------------------------------------------------------------------------------------------->
                <!-- End first paragraph-->
                <!-- ----------------------------------------------------------------------------------------------------------->
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-10">
                <!-- ----------------------------------------------------------------------------------------------------------->
                <!-- Основной контент -->
                <!-- ----------------------------------------------------------------------------------------------------------->
                <article class="article"><br/>
                    <h2><strong>Стек (от англ. Stack)</strong> и <strong>Куча (от англ. Heap)</strong>, которые мы знаем
                        и любим</h2>
                    <p class="lead">Для того чтобы разобраться в значении параметра <code>allocs/op</code> в
                        <strong>Go</strong>, мы сфокусируемся на двух
                        областях памяти, которые используются в <strong>Go</strong>-программах: <strong><i>Стэк</i> (от
                            англ.
                            Stack)</strong> и
                        <strong>Куча (от англ. Heap)</strong>.</p>
                    <p class="lead">Во многих популярных средах программирования под <strong>Стэком</strong> обычно
                        подразумевается стэк
                        вызовов <strong>Потока (от англ. Thread)</strong>. <strong>Стэк вызовов</strong> - это стэковая
                        структура данных
                        <strong><code>LIFO</code></strong>, в которой
                        хранятся аргументы,
                        локальные переменные и другие данные, отслеживаемые в процессе выполнения функций <strong>Потоком</strong>.
                        Каждый вызов функции добавляет (pushes) новый фрэйм в <strong>Стэк</strong>, а каждый возврат
                        функции удаляет
                        (pops) из <strong>Стэка</strong>.</p>
                    <p class="lead">Мы должны иметь возможность безопасно освободить память последнего
                        <strong>Фрэйма</strong> <strong>Стэка</strong>,
                        когда он будет выгружен. Поэтому мы не можем хранить в стеке ничего, на что впоследствии
                        придется ссылаться в другом месте.</p>

                    <figure class="sign">
                        <p><img src="/assets/img/allocations_1.png"
                                alt="Вид стека вызовов через некоторое время после вызова println"></p>
                        <figcaption>Вид <strong>Стэка</strong> вызовов через некоторое время после вызова
                            <code>println</code>
                        </figcaption>
                    </figure>

                    <p class="lead">Поскольку <strong>Потоки</strong> управляются <strong>ОС</strong>, объем памяти,
                        доступный для <strong>Стэка Потоков</strong>, обычно
                        фиксирован, например, по умолчанию составляет <strong><code>8 МБ</code></strong> во многих
                        средах <strong>Linux</strong>. Это означает, что нам
                        также <strong>необходимо следить за тем, сколько данных оказывается в Стэке</strong>, особенно в
                        случае глубоко
                        вложенных рекурсивных функций. Если указатель <strong>Стэка</strong> на приведенной выше
                        диаграмме пройдет через
                        <strong>Лимит Стэка</strong>, программа завершится с ошибкой переполнения <strong>Стека</strong>.
                    </p>
                    <p class="lead"><strong>Куча</strong> - это более сложная область памяти. Мы по своей инициативе
                        можем использовать Кучу
                        для хранения данных, необходимых в
                        нашей программе. <strong>Память, выделенная здесь, не может быть просто освобождена при
                            возвращении
                            функции, и ею нужно тщательно управлять, чтобы избежать утечек и фрагментации</strong>.
                        Куча, как
                        правило, вырастает во много раз больше, чем любой Стэк потоков, и основная часть усилий по
                        оптимизации будет направлена на изучение использования Кучи.</p>

                    <h2>Стек и куча в Go</h2>
                    <p class="">Потоки, управляемые ОС, полностью абстрагированы от нас средой выполнения Go, и вместо
                        них мы работаем с новой абстракцией: Goroutines. Гороутины концептуально очень похожи на потоки,
                        но они существуют в пользовательском пространстве. Это означает, что время выполнения, а не ОС,
                        устанавливает правила поведения стеков.</p>

                    <figure class="sign">
                        <p><img src="/assets/img/allocations_2.png"
                                alt="Нити, абстрагированные от существования"></p>
                        <figcaption><strong>Потоки</strong>, абстрагированные от существования
                        </figcaption>
                    </figure>

                    <p class="lead">Вместо того чтобы иметь жесткие ограничения, установленные ОС, стеки
                        <strong>горутин</strong>
                        начинаются с небольшого объема памяти (в настоящее время <strong><code>2 КБ</code></strong>).
                        Перед выполнением каждого вызова
                        функции выполняется проверка в прологе функции, чтобы убедиться, что переполнение стека не
                        произойдет. На приведенной ниже диаграмме функция <code>convert()</code> может быть выполнена в
                        пределах
                        текущего размера стека (без превышения SP над <code>stackguard0</code>).</p>

                    <figure class="sign">
                        <p><img src="/assets/img/allocations_3.png"
                                alt="Крупный план Cтека вызовов goroutine"></p>
                        <figcaption>Крупный план <strong>Cтека вызовов goroutine</strong>
                        </figcaption>
                    </figure>

                    <p class="lead">
                        Если бы это было не так, то перед выполнением <code>convert()</code> среда выполнения
                        скопировала бы текущий
                        стек в новую большую область непрерывной памяти. <strong>Это означает, что стеки в Go имеют
                            динамический
                            размер и, как правило, могут продолжать расти до тех пор, пока для них достаточно
                            памяти.</strong>
                    </p>

                    <p class="lead">Куча Go снова концептуально похожа на потоковую модель, описанную выше. Все горутины
                        используют общую кучу, и все, что не может быть сохранено в стеке, попадает туда. Когда в
                        проверяемой функции происходит распределение кучи, мы увидим, что значение
                        <code>allocs/ops</code> stat
                        увеличивается на единицу. Работа сборщика мусора заключается в том, чтобы впоследствии
                        освободить переменные кучи, на которые больше нет ссылок.</p>

                    <p class="lead">Подробное объяснение того, как происходит управление памятью в Go, можно найти в
                        статье Наглядное руководство по работе с аллокатором памяти Go с нуля.</p>

                    <h2>Как узнать, что переменная выделена в куче?</h2>
                    <p class="lead">Ответ на этот вопрос содержится в официальном FAQ.</p>
                    <p class="blockquote-footer">Компиляторы Go выделяют переменные, локальные для функции, в стековом
                        фрейме
                        этой функции. Однако если компилятор не может доказать, что на переменную не будут ссылаться
                        после возврата функции, то он должен выделить переменную в куче мусора, чтобы избежать ошибок с
                        висячими указателями. Кроме того, если локальная переменная очень большая, возможно, имеет смысл
                        хранить ее в куче, а не в стеке.
                        Если у переменной занят адрес, она является кандидатом на размещение в куче. Тем не менее,
                        базовый анализ побега признает некоторые случаи, когда такие переменные не будут жить после
                        возврата из функции и могут располагаться в стеке.</p>
                    <p class="lead">Поскольку реализации компиляторов меняются со временем, <strong>невозможно узнать,
                            какие
                            переменные будут выделены в кучу, просто прочитав код Go</strong>. Однако можно просмотреть
                        результаты
                        вышеупомянутого <strong>escape-analysis</strong> в выводе компилятора. Этого можно добиться с
                        помощью аргумента
                        <code>gcflags</code>, передаваемого в <code>go build</code>. Полный список опций можно
                        посмотреть через <code>go tool compile
                            -help</code>.</p>
                    <p class="lead">Для вывода результатов анализа можно использовать опцию <code>-m</code> (<code>print
                            optimization decisions</code>). Проверим это на простой программе, которая создает два
                        стековых фрейма для функций
                        <code>main1</code> и <code>stackIt</code>.</p>

                    <pre class="language-go"><code>
func main1() {
   _ = stackIt()
}
//go:noinline
func stackIt() int {
   y := 2
   return y * 2
}
                        </code></pre>

                    <p class="lead">Поскольку мы не можем обсуждать поведение стека, если компилятор удалит наши вызовы
                        функций, <a href="#">pragma</a> <code>noinline</code> используется для предотвращения инлайнинга
                        при компиляции кода. Давайте
                        посмотрим, что компилятор может сказать о своих решениях по оптимизации. Опция <code>-l</code>
                        используется
                        для исключения решений по инлайнингу.</p>
                    <pre class="language-bash"><code>
$ go build -gcflags '-m -l'
# github.com/Jimeux/go-samples/allocations</code></pre>

                    <p class="lead">Здесь мы видим, что никаких решений относительно анализа побега не принималось.
                        Другими словами, переменная <code>y</code> осталась на стеке и не вызвала никаких выделений из
                        кучи. Мы можем
                        проверить это с помощью бенчмарка.</p>

                    <pre class="language-bash"><code>
$ go test -bench . -benchmem
BenchmarkStackIt-8  680439016  1.52 ns/op  0 B/op  0 allocs/op</code></pre>

                    <p class="lead">Как и ожидалось, значение <code>allocs/op</code> stat равно <code>0</code>. Важное
                        наблюдение, которое мы
                        можем сделать из этого результата, заключается в том, что <strong>копирование переменных может
                            позволить
                            нам хранить их в стеке</strong> и избежать выделения в кучу. Давайте проверим это, изменив
                        программу,
                        чтобы избежать копирования с помощью указателя.</p>

                    <pre class="language-go"><code>
func main2() {
   _ = stackIt2()
}
//go:noinline
func stackIt2() *int {
   y := 2
   res := y * 2
   return &res
}</code></pre>
                    <p class="lead">Посмотрим на вывод компилятора:</p>
                    <pre class="language-bash"><code>
go build -gcflags '-m -l'
# github.com/Jimeux/go-samples/allocations
./main.go:10:2: moved to heap: res
                        </code></pre>
                    <p class="lead">
                        Компилятор сообщает нам, что он переместил указатель <code>res</code> в кучу, что вызывает
                        выделение кучи,
                        как показано в приведенном ниже примере
                    </p>
                    <pre class="language-bash"><code>
$ go test -bench . -benchmem
BenchmarkStackIt2-8  70922517  16.0 ns/op  8 B/op  1 allocs/op</code></pre>
                    <p class="lead">Значит ли это, что указатели гарантированно создают выделения? Давайте снова изменим
                        программу, чтобы на этот раз передать указатель вниз по стеку.</p>
                    <pre class="language-go"><code>
func main3() {
   y := 2
   _ = stackIt3(&y) // pass y down the stack as a pointer
}

//go:noinline
func stackIt3(y *int) int {
   res := *y * 2
   return res
}</code></pre>
                    <p class="lead">Однако запуск бенчмарка показывает, что в куче ничего не было выделено.</p>
                    <pre class="language-bash"><code>
$ go test -bench . -benchmem
BenchmarkStackIt3-8  705347884  1.62 ns/op  0 B/op  0 allocs/op</code></pre>
                    <p class="lead">Вывод компилятора говорит нам об этом прямо:</p>
                    <pre class="language-bash"><code>
$ go build -gcflags '-m -l'
# github.com/Jimeux/go-samples/allocations
./main.go:10:14: y does not escape</code></pre>
                    <p class="lead">Почему мы получаем это кажущееся несоответствие? <code>stackIt2</code> передает
                        <code>res</code> <strong>вверх по
                            стеку</strong> в <code>main</code>, где на <code>y</code> будут ссылаться <strong>уже
                            после</strong> того, как стековый кадр <code>stackIt2</code> будет
                        освобожден. Поэтому компилятор может решить, что <code>y</code> нужно переместить в кучу, чтобы
                        он остался
                        жив. Если бы он этого не сделал, <code>y</code> не существовало бы к моменту обращения к нему в
                        <code>main</code>.</p>
                    <p class="lead"><code>stackIt3</code>, с другой стороны, передает <code>y</code> вниз по стеку, и
                        <code>y</code> нигде не упоминается за
                        пределами <code>main3</code>. Поэтому компилятор может судить, что <code>y</code> может
                        существовать только в стеке и не
                        нуждается в выделении в куче. Мы ни при каких обстоятельствах не сможем получить указатель
                        <code>nil</code>,
                        обратившись к <code>y</code>.</p>
                    <p class="lead"><strong>Общее правило, которое мы можем вывести из этого, заключается в том, что
                            совместное
                            использование указателей вверх по стеку приводит к выделению, а совместное использование
                            указателей вниз по стеку - нет</strong>. Однако это не гарантировано, поэтому для полной
                        уверенности вам
                        нужно проверить это с помощью <code>gcflags</code> или бенчмарков. Что мы можем сказать
                        наверняка, так это
                        то, что любая попытка уменьшить количество <code>allocs/op</code> будет связана с поиском
                        неработающих
                        указателей.</p>
                    <h2>Почему мы заботимся о выделении кучи?</h2>
                    <p class="lead">Мы немного узнали о том, что означает <code>alloc</code> в <code>allocs/op</code>, и
                        как проверить, сработало
                        ли выделение в кучу, но почему нас должно волновать, что эта статистика ненулевая? На этот
                        вопрос можно ответить с помощью бенчмарков, которые мы уже провели.</p>
                    <pre class="language-bash"><code>
BenchmarkStackIt-8   680439016  1.52 ns/op  0 B/op  0 allocs/op
BenchmarkStackIt2-8  70922517   16.0 ns/op  8 B/op  1 allocs/op
BenchmarkStackIt3-8  705347884  1.62 ns/op  0 B/op  0 allocs/op</code></pre>
                    <p class="lead">Несмотря на то, что требования к памяти для соответствующих переменных практически
                        одинаковы, относительная нагрузка на процессор в <code>BenchmarkStackIt2</code> ярко выражена.
                        Мы можем
                        получить немного больше информации, построив пламенные графики <strong>CPU-профилей</strong>
                        реализаций <code>stackIt</code> и
                        <code>stackIt2</code>.</p>
                    <figure class="sign">
                        <p><img src="/assets/img/allocations_4.png"
                                alt="stackIt CPU profile"></p>
                        <figcaption>stackIt CPU profile
                        </figcaption>
                    </figure>
                    <figure class="sign">
                        <p><img src="/assets/img/allocations_5.png"
                                alt="stackIt CPU profile"></p>
                        <figcaption>stackIt2 CPU profile
                        </figcaption>
                    </figure>
                    <p class="lead"><code>stackIt</code> имеет ничем не примечательный профиль, который предсказуемо
                        спускается по
                        стеку вызовов до самой функции <code>stackIt</code>. <code>stackIt2</code>, напротив, активно
                        использует большое
                        количество функций времени выполнения, которые потребляют много дополнительных циклов
                        процессора. Это демонстрирует сложность, связанную с выделением в куче, и дает некоторое
                        начальное представление о том, куда уходят эти дополнительные 10 или около того наносекунд на
                        операцию.</p>
                    <h2>А что в реальном мире?</h2>
                    <p class="lead">Многие аспекты производительности не становятся очевидными без производственных
                        условий. Ваша единственная функция может эффективно работать в микробенчмарках, но какое влияние
                        она окажет на ваше приложение, обслуживающее тысячи одновременных пользователей?</p>
                    <p class="lead">В этом посте мы не будем воссоздавать целое приложение, но рассмотрим некоторые
                        более подробные способы диагностики производительности с помощью инструмента трассировки. Начнем
                        с определения (несколько) большой структуры с девятью полями.</p>

                    <pre class="language-go"><code>
type BigStruct struct {
   A, B, C int
   D, E, F string
   G, H, I bool
}</code></pre>
                    <p class="lead">Теперь мы определим две функции: <code>CreateCopy</code>, которая копирует
                        экземпляры <code>BigStruct</code>
                        между фреймами стека, и <code>CreatePointer</code>, которая разделяет указатели
                        <code>BigStruct</code> по стеку, избегая
                        копирования, но приводя к выделению кучи.</p>
                    <pre class="language-go"><code>

//go:noinline
func CreateCopy() BigStruct {
   return BigStruct{
      A: 123, B: 456, C: 789,
      D: "ABC", E: "DEF", F: "HIJ",
      G: true, H: true, I: true,
   }
}
//go:noinline
func CreatePointer() *BigStruct {
   return &BigStruct{
      A: 123, B: 456, C: 789,
      D: "ABC", E: "DEF", F: "HIJ",
      G: true, H: true, I: true,
   }
}</code></pre>
                    <p class="lead">Мы можем проверить объяснение, данное выше, с помощью техник, которые использовались
                        до сих пор.</p>
                    <pre class="language-bash"><code>
$ go build -gcflags '-m -l'
./main.go:67:9: &BigStruct literal escapes to heap
$ go test -bench . -benchmem
BenchmarkCopyIt-8     211907048  5.20 ns/op  0 B/op   0 allocs/op
BenchmarkPointerIt-8  20393278   52.6 ns/op  80 B/op  1 allocs/op</code></pre>
                    <p class="lead">Вот тесты, которые мы будем использовать для инструмента трассировки. Каждый из них
                        создает <code>20_000_000</code> экземпляров <code>BigStruct</code> с помощью соответствующей
                        функции <code>Create</code>.</p>
                    <pre class="language-go"><code>
const creations = 20_000_000

func TestCopyIt(t *testing.T) {
   for i := 0; i < creations; i++ {
      _ = CreateCopy()
   }
}

func TestPointerIt(t *testing.T) {
   for i := 0; i < creations; i++ {
      _ = CreatePointer()
   }
}</code></pre>
                    <p class="lead">Далее мы сохраним вывод трассировки CreateCopy в файл copy_trace.out и откроем его с
                        помощью инструмента трассировки в браузере.</p>
                    <pre class="language-bash"><code>
$ go test -run TestCopyIt -trace=copy_trace.out
PASS
ok   github.com/Jimeux/go-samples/allocations 0.281s
$ go tool trace copy_trace.out
Parsing trace...
Splitting trace...
Opening browser. Trace viewer is listening on http://127.0.0.1:57530</code></pre>
                    <p class="lead">Выбрав в меню пункт <code>View trace</code>, мы видим следующее, почти такое же
                        непримечательное
                        изображение, как и диаграмма пламени для функции <code>stackIt</code>. Используются только два
                        из восьми
                        потенциальных логических ядер (Procs), а горутина <code>G19</code> тратит почти все время на
                        выполнение
                        нашего тестового цикла - что нам и нужно.</p>
                    <figure class="sign">
                        <p><img src="/assets/img/allocations_6.png"
                                alt="Трассировка 20 000 000 вызовов CreateCopy"></p>
                        <figcaption>Трассировка 20_000_000 вызовов CreateCopy
                        </figcaption>
                    </figure>
                    <p class="lead">Давайте сгенерируем данные трассировки для кода CreatePointer:</p>
                    <pre class="language-bash"><code>
$ go test -run TestPointerIt -trace=pointer_trace.out
PASS
ok   github.com/Jimeux/go-samples/allocations 2.224s
go tool trace pointer_trace.out
Parsing trace...
Splitting trace...
Opening browser. Trace viewer is listening on http://127.0.0.1:57784</code></pre>
                    <p class="lead">Вы, наверное, уже заметили, что тест занял <code>2,224 с</code> по сравнению с
                        <code>0,281 с</code> для
                        <code>CreateCopy</code>, а выбор <code>View trace</code> показывает нечто гораздо
                        более красочное и напряженное на
                        этот раз. Были задействованы все логические ядра, и, судя по всему, в куче было гораздо больше
                        действий, потоков и горутин, чем в прошлый раз.</p>

                    <figure class="sign">
                        <p><img src="/assets/img/allocations_7.png"
                                alt="Трассировка для 20_000_000 вызовов CreatePointer"></p>
                        <figcaption>Трассировка для <code>20_000_000</code> вызовов <code>CreatePointer</code>
                        </figcaption>
                    </figure>
                    <p class="lead">Если мы увеличим масштаб трассировки на миллисекунду или около того, то увидим
                        множество горутин, выполняющих операции, связанные со <a
                            href="https://www.ardanlabs.com/blog/2018/12/garbage-collection-in-go-part1-semantics.html">сборкой
                            мусора</a>. В приведенной ранее цитате
                        из FAQ использовалась фраза <strong>garbage-collected heap</strong>, потому что задача сборщика
                        мусора - очищать
                        все, что находится в куче и на что больше не ссылаются.</p>

                    <figure class="sign">
                        <p><img src="/assets/img/allocations_8.png"
                                alt="Крупный план активности GC в трассировке CreatePointer"></p>
                        <figcaption>Крупный план активности <strong>GC</strong> в трассировке <code>CreatePointer</code>
                        </figcaption>
                    </figure>

                    <p class="lead">Хотя сборщик мусора в Go становится все более эффективным, этот процесс не проходит
                        даром. Мы можем визуально убедиться, что тестовый код иногда полностью останавливался в
                        вышеприведенном выводе трассировки. Это не относится к <code>CreateCopy</code>, поскольку все
                        наши экземпляры
                        <code>BigStruct</code> оставались в стеке, и <strong>GC</strong> оставалось сделать совсем
                        немного.
                    </p>
                    <p class="lead">Сравнение результатов анализа работы горутин из двух наборов данных трассировки
                        дает большее представление об этом. <code>CreatePointer</code> (внизу) потратил более <code>15
                            %</code>
                        своего времени
                        выполнения на сметание или приостановку <strong>(GC)</strong> и планирование работы горутин.</p>

                    <figure class="sign">
                        <p><img src="/assets/img/allocations_9.png"
                                alt="Анализ горутины верхнего уровня для CreatePointer"></p>
                        <figcaption>Анализ горутины верхнего уровня для <code>CreatePointer</code>
                        </figcaption>
                    </figure>

                    <p class="lead">Взгляд на некоторые статистические данные, доступные в других местах трассировки,
                        еще больше иллюстрирует затраты на выделение кучи, с разительной разницей в количестве
                        сгенерированных goroutines и почти 400 STW (stop the world) событий для теста <code>CreatePointer</code>.
                    </p>

                    <pre class="language-bash"><code>
+------------+------+---------+
|            | Copy | Pointer |
+------------+------+---------+
| Goroutines |   41 |  406965 |
| Heap       |   10 |  197549 |
| Threads    |   15 |   12943 |
| bgsweep    |    0 |  193094 |
| STW        |    0 |     397 |
+------------+------+---------+</code></pre>

                    <p class="lead">Однако следует помнить, что условия теста <code>CreateCopy</code> очень
                        нереалистичны для
                        типичной программы, несмотря на название этого раздела. Вполне нормально видеть, что GC
                        использует постоянное количество CPU, а указатели являются особенностью любой реальной
                        программы. Тем не менее, вместе с графиком пламени, приведенным ранее, это дает нам некоторое
                        представление о том, почему мы можем захотеть отслеживать статистику <code>allocs/op</code> и по
                        возможности
                        избегать ненужных выделений из кучи.</p>

                    <h2>Резюме</h2>

                    <p class="lead">Надеюсь, эта статья дала некоторое представление о различиях между стеком и кучей в
                        программе на Go, о значении статистики <code>allocs/op</code>, а также о некоторых способах
                        исследования
                        использования памяти.</p>

                    <p class="lead">Корректность и удобство сопровождения нашего кода обычно превалируют над хитрыми
                        техниками сокращения использования указателей и снижения активности GC. Всем уже известна фраза
                        о преждевременной оптимизации, и кодирование на Go ничем не отличается от этого.</p>

                    <p class="lead">Однако если мы предъявляем жесткие требования к производительности или иным образом
                        выявляем «узкое место» в программе, представленные здесь концепции и инструменты, надеюсь,
                        станут полезной отправной точкой для проведения необходимых оптимизаций.
                    </p>

                    <p class="lead">Если вы хотите поиграть с простыми примерами кода, приведенными в этом посте,
                        ознакомьтесь с исходным кодом и README на GitHub.</p>

                    <p class="lead">Ссылки
                        Часто задаваемые вопросы (FAQ) | golang.org
                        Скрытые #pragmas в Go | dave.cheney.net
                        Трассировка команд | golang.org
                        Серия статей о сборке мусора в Go | Arden Labs
                        Понимание выделений: стек и куча | YouTube</p>
                </article>
                <!------------------------------------------------------------------------------------------------------------->
                <!-- Основной контент завершен-->
                <!------------------------------------------------------------------------------------------------------------->
            </div>
            <section class="has-divider">
                <div class="container pt-3">
                    <div class="row justify-content-center">
                        <div class="col-xl-7 col-lg-8 col-md-10">

                            <hr>
                            <div class="d-flex align-items-center">

                                <div class="d-flex mx-2">


                                    <a href="https://www.facebook.com/sharer/sharer.php?u=http://newampleev.com/article-1&display=popup"
                                       class="btn btn-round btn-primary mx-1">
                                        <img class="icon icon-sm" src="assets/img/icons/social/facebook.svg"
                                             alt="facebook social icon" data-inject-svg/>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text=Диаграммы сгорания в контексте SAFe http://newampleev.com/article-1"
                                       class="btn btn-round btn-primary mx-1">
                                        <img class="icon icon-sm" src="assets/img/icons/social/twitter.svg"
                                             alt="twitter social icon" data-inject-svg/>
                                    </a>

                                </div>
                            </div>
                            <hr>
                            <h5 class="my-4">Всего комментариев: 0</h5>

                            <ol class="comments">
                                <li id="comment_1" class="comment">
                                    <div class="d-flex align-items-center text-small"><img
                                            src="/storage/user_avatars/female-3_my.jpg" alt="Sarah Priestly"
                                            class="avatar avatar-sm mr-2">
                                        <div class="text-dark mr-1">Евгений Амплеев</div>
                                        <div class="text-muted">сегодня в 10:49</div>
                                    </div>
                                    <div class="my-2">Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                        commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                                        dolore eu
                                        fugiat nulla pariatur.
                                    </div>
                                    <div><span to_give_an_answer_to_comment class="text-small answer-to-comment-link"
                                               data-answer_to_comment_id="1">Ответить</span></div>
                                    <ol class="comments">
                                        <li id="comment_2" class="comment">
                                            <div class="d-flex align-items-center text-small"><img
                                                    src="/storage/user_avatars/female-3_my.jpg" alt="Sarah Priestly"
                                                    class="avatar avatar-sm mr-2">
                                                <div class="text-dark mr-1">Евгений Амплеев</div>
                                                <div class="text-muted">сегодня в 10:49</div>
                                            </div>
                                            <div class="my-2">Duis aute irure dolor in reprehenderit in voluptate velit
                                                esse cillum
                                                dolore eu fugiat nulla pariatur.
                                            </div>
                                            <div><span to_give_an_answer_to_comment
                                                       class="text-small answer-to-comment-link"
                                                       data-answer_to_comment_id="2">Ответить</span></div>
                                    </ol>
                                </li>
                                </li>
                                <li id="comment_3" class="comment">
                                    <div class="d-flex align-items-center text-small"><img
                                            src="/storage/user_avatars/female-3_my.jpg" alt="Sarah Priestly"
                                            class="avatar avatar-sm mr-2">
                                        <div class="text-dark mr-1">Евгений Амплеев</div>
                                        <div class="text-muted">сегодня в 10:49</div>
                                    </div>
                                    <div class="my-2">Ut enim ad minima veniam, quis nostrum exercitationem ullam
                                        corporis suscipit
                                        laboriosam, nisi ut aliquid ex ea commodi consequatur?
                                    </div>
                                    <div><span to_give_an_answer_to_comment class="text-small answer-to-comment-link"
                                               data-answer_to_comment_id="3">Ответить</span></div>
                                </li>
                                <li id="comment_4" class="comment">
                                    <div class="d-flex align-items-center text-small"><img
                                            src="/storage/user_avatars/female-3_my.jpg" alt="Sarah Priestly"
                                            class="avatar avatar-sm mr-2">
                                        <div class="text-dark mr-1">Евгений Амплеев</div>
                                        <div class="text-muted">сегодня в 10:49</div>
                                    </div>
                                    <div class="my-2">Sed quia non numquam eius modi tempora incidunt ut labore et
                                        dolore magnam
                                        aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
                                        exercitationem
                                    </div>
                                    <div><span to_give_an_answer_to_comment class="text-small answer-to-comment-link"
                                               data-answer_to_comment_id="4">Ответить</span></div>
                                </li>
                            </ol>

                            <hr>
                            <h5 class="my-4">Добавить комментарий</h5>


                            <form action="http://newampleev.com/add-comment" method="post"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="BUH5xFouPlIQzeROqXClWpmRm5bkwwrKfS78ORks">
                                <input
                                    type="hidden" name="article_id" value=1>
                                <input type="hidden" name="comment_id" value=0>
                                <div class="form-group">
                            <textarea id="add_comment_ta" class="form-control" name="content" rows="7"
                                      placeholder="Вы авторизованы и можете написать комментарий"></textarea>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">


                                    <button class="btn btn-primary" type="submit">Отправить</button>
                                </div>

                            </form>

                            <script language="JavaScript">
                                if (window.location.href === 'https://ampleev.com/article-1#add_comment') {
                                    textaria = document.getElementById('add_comment_ta');
                                    // insertAtCursor(textaria, '')
                                }

                                function insertAtCursor(myField, myValue) {
                                    //IE support
                                    if (document.selection) {
                                        myField.focus();
                                        sel = document.selection.createRange();
                                        sel.text = myValue;
                                    }
                                    //MOZILLA and others
                                    else if (myField.selectionStart || myField.selectionStart == '0') {
                                        var startPos = myField.selectionStart;
                                        var endPos = myField.selectionEnd;
                                        myField.value = myField.value.substring(0, startPos)
                                            + myValue
                                            + myField.value.substring(endPos, myField.value.length);
                                    } else {
                                        myField.value += myValue;
                                    }
                                }
                            </script>


                        </div>
                    </div>
                </div>
                <div class="divider">
                    <img class="bg-primary-alt" src="assets/img/dividers/divider-1.svg" alt="divider graphic"
                         data-inject-svg/>
                </div>
            </section>

            <section class="bg-primary-alt">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col">
                            <h3 class="h2">Возможно, вам будет интересно</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="100">
                            <a href="#" class="card card-body justify-content-between bg-primary text-light">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="text-small d-flex">
                                        <div class="mr-2">
                                            Links
                                        </div>
                                        <span class="opacity-70">19th December</span>
                                    </div>
                                    <span class="badge bg-primary-alt text-primary">
                  <img class="icon icon-sm bg-primary" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"
                       alt="heart interface icon" data-inject-svg/>27
                </span>
                                </div>
                                <div>
                                    <h2>A time-tracking app that isn’t a pain.</h2>
                                    <span class="text-small opacity-70">http://www.website.io/link</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="200">
                            <div class="card">
                                <a href="#">
                                    <img src="assets/img/article-1.jpg" alt="Image" class="card-img-top">
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="text-small d-flex">
                                            <div class="mr-2">
                                                <a href="#">Business</a>
                                            </div>
                                            <span class="text-muted">29th November</span>
                                        </div>
                                        <span class="badge bg-primary-alt text-primary">
                    <img class="icon icon-sm bg-primary" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"
                         alt="heart interface icon" data-inject-svg/>12
                  </span>
                                    </div>
                                    <a href="#">
                                        <h4>How to build collateral</h4>
                                    </a>
                                    <p class="flex-grow-1">
                                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                                        doloremque
                                        laudantium.
                                    </p>
                                    <div class="d-flex align-items-center mt-3">
                                        <img src="assets/img/avatars/female-3.jpg" alt="Image" class="avatar avatar-sm">
                                        <div class="ml-1">
                                            <span class="text-small text-muted">By</span>
                                            <span class="text-small">Abby Sims</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="300">
                            <div class="card">
                                <a href="#">
                                    <img src="assets/img/article-2.jpg" alt="Image" class="card-img-top">
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="text-small d-flex">
                                            <div class="mr-2">
                                                <a href="#">Design</a>
                                            </div>
                                            <span class="text-muted">27th November</span>
                                        </div>
                                        <span class="badge bg-primary-alt text-primary">
                    <img class="icon icon-sm bg-primary" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"
                         alt="heart interface icon" data-inject-svg/>23
                  </span>
                                    </div>
                                    <a href="#">
                                        <h4>Forging your path</h4>
                                    </a>
                                    <p class="flex-grow-1">
                                        Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                        laudantium.
                                    </p>
                                    <div class="d-flex align-items-center mt-3">
                                        <img src="assets/img/avatars/male-4.jpg" alt="Image" class="avatar avatar-sm">
                                        <div class="ml-1">
                                            <span class="text-small text-muted">By</span>
                                            <span class="text-small">Cedric</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <footer class="pb-4 bg-primary-3 text-light">
                <div class="container">
                    <div class="row mb-5">
                        <div class="col">
                            <a href="index.html">
                                <span><h2>Ampleev.com</h2></span>
                            </a>


                        </div>


                        <div class="col-6 col-lg">
                            <h5>Контакты</h5>
                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex">
                                    <img class="icon" src="assets/img/icons/theme/map/marker-1.svg" alt="marker-1 icon"
                                         data-inject-svg/>
                                    <div class="ml-3">
                  <span>50 Можайское шоссе
                    Москва</span>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex">
                                    <img class="icon" src="assets/img/icons/theme/communication/call-1.svg"
                                         alt="call-1 icon"
                                         data-inject-svg/>
                                    <div class="ml-3">
                                        <span>+79 2613 82008</span>
                                        <span class="d-block text-muted text-small">Пн - Пт 9am - 5pm</span>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex">
                                    <img class="icon" src="assets/img/icons/theme/communication/mail.svg"
                                         alt="mail icon"
                                         data-inject-svg/>
                                    <div class="ml-3">
                                        <a href="#">e@mpleev.com</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-6 col-lg-3">


                        </div>
                    </div>
                    <div class="row justify-content-center mb-2">
                        <div class="col-auto">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a href="https://www.instagram.com/mpleeve/" class="nav-link">
                                        <img class="icon undefined" src="assets/img/icons/social/instagram.svg"
                                             alt="instagram social icon" data-inject-svg/>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://twitter.com/ampleevE"
                                       class="nav-link">
                                        <img class="icon undefined" src="assets/img/icons/social/twitter.svg"
                                             alt="twitter social icon" data-inject-svg/>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="https://www.facebook.com/eampleev"
                                       class="nav-link">
                                        <img class="icon undefined" src="assets/img/icons/social/facebook.svg"
                                             alt="facebook social icon" data-inject-svg/>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col col-md-auto text-center">
                            <small class="text-muted">&copy;2019 Все права сохранены. Ampleev.com®
                            </small>
                        </div>
                    </div>
                </div>
            </footer>

            <a href="#" class="btn back-to-top btn-primary btn-round" data-smooth-scroll data-aos="fade-up"
               data-aos-offset="2000"
               data-aos-mirror="true" data-aos-once="false">
                <img class="icon" src="assets/img/icons/theme/navigation/arrow-up.svg" alt="arrow-up icon"
                     data-inject-svg/>
            </a>


            <!-- Required vendor scripts (Do not remove) -->
            <script type="text/javascript" src="assets/js/jquery.min.js"></script>
            <script type="text/javascript" src="assets/js/popper.min.js"></script>
            <script type="text/javascript" src="assets/js/bootstrap.js"></script>

            <!-- Optional Vendor Scripts (Remove the plugin script here and comment initializer script out of index.js if site does not use that feature) -->

            <!-- AOS (Animate On Scroll - animates elements into view while scrolling down) -->
            <script type="text/javascript" src="assets/js/aos.js"></script>
            <!-- Clipboard (copies content from browser into OS clipboard) -->
            <script type="text/javascript" src="assets/js/clipboard.js"></script>
            <!-- Fancybox (handles image and video lightbox and galleries) -->
            <script type="text/javascript" src="assets/js/jquery.fancybox.min.js"></script>
            <!-- Flatpickr (calendar/date/time picker UI) -->
            <script type="text/javascript" src="assets/js/flatpickr.min.js"></script>
            <!-- Flickity (handles touch enabled carousels and sliders) -->
            <script type="text/javascript" src="assets/js/flickity.pkgd.min.js"></script>
            <!-- Ion rangeSlider (flexible and pretty range slider elements) -->
            <script type="text/javascript" src="assets/js/ion.rangeSlider.min.js"></script>
            <!-- Isotope (masonry layouts and filtering) -->
            <script type="text/javascript" src="assets/js/isotope.pkgd.min.js"></script>
            <!-- jarallax (parallax effect and video backgrounds) -->
            <script type="text/javascript" src="assets/js/jarallax.min.js"></script>
            <script type="text/javascript" src="assets/js/jarallax-video.min.js"></script>
            <script type="text/javascript" src="assets/js/jarallax-element.min.js"></script>
            <!-- jQuery Countdown (displays countdown text to a specified date) -->
            <script type="text/javascript" src="assets/js/jquery.countdown.min.js"></script>
            <!-- jQuery smartWizard facilitates steppable wizard content -->
            <script type="text/javascript" src="assets/js/jquery.smartWizard.min.js"></script>
            <!-- Plyr (unified player for Video, Audio, Vimeo and Youtube) -->
            <script type="text/javascript" src="assets/js/plyr.polyfilled.min.js"></script>
            <!-- Prism (displays formatted code boxes) -->
            <script type="text/javascript" src="assets/js/prism.js"></script>
            <!-- ScrollMonitor (manages events for elements scrolling in and out of view) -->
            <script type="text/javascript" src="assets/js/scrollMonitor.js"></script>
            <!-- Smooth scroll (animation to links in-page)-->
            <script type="text/javascript" src="assets/js/smooth-scroll.polyfills.min.js"></script>
            <!-- SVGInjector (replaces img tags with SVG code to allow easy inclusion of SVGs with the benefit of inheriting colors and styles)-->
            <script type="text/javascript" src="assets/js/svg-injector.umd.production.js"></script>
            <!-- TwitterFetcher (displays a feed of tweets from a specified account)-->
            <script type="text/javascript" src="assets/js/twitterFetcher_min.js"></script>
            <!-- Typed text (animated typing effect)-->
            <script type="text/javascript" src="assets/js/typed.min.js"></script>
            <!-- Required theme scripts (Do not remove) -->
            <script type="text/javascript" src="assets/js/theme.js"></script>
            <!-- Removes page load animation when window is finished loading -->
            <script type="text/javascript">
                window.addEventListener("load", function () {
                    document.querySelector('body').classList.add('loaded');
                });
            </script>

            <link rel='stylesheet' type='text/css' property='stylesheet'
                  href='//newampleev.com/_debugbar/assets/stylesheets?v=1569336942'>
            <script type='text/javascript' src='//newampleev.com/_debugbar/assets/javascript?v=1569336942'></script>
            <script type="text/javascript">jQuery.noConflict(true);</script>
            <script> Sfdump = window.Sfdump || (function (doc) {
                    var refStyle = doc.createElement('style'), rxEsc = /([.*+?^${}()|\[\]\/\\])/g,
                        idRx = /\bsf-dump-\d+-ref[012]\w+\b/,
                        keyHint = 0 <= navigator.platform.toUpperCase().indexOf('MAC') ? 'Cmd' : 'Ctrl',
                        addEventListener = function (e, n, cb) {
                            e.addEventListener(n, cb, false);
                        };
                    (doc.documentElement.firstElementChild || doc.documentElement.children[0]).appendChild(refStyle);
                    if (!doc.addEventListener) {
                        addEventListener = function (element, eventName, callback) {
                            element.attachEvent('on' + eventName, function (e) {
                                e.preventDefault = function () {
                                    e.returnValue = false;
                                };
                                e.target = e.srcElement;
                                callback(e);
                            });
                        };
                    }

                    function toggle(a, recursive) {
                        var s = a.nextSibling || {}, oldClass = s.className, arrow, newClass;
                        if (/\bsf-dump-compact\b/.test(oldClass)) {
                            arrow = '▼';
                            newClass = 'sf-dump-expanded';
                        } else if (/\bsf-dump-expanded\b/.test(oldClass)) {
                            arrow = '▶';
                            newClass = 'sf-dump-compact';
                        } else {
                            return false;
                        }
                        if (doc.createEvent && s.dispatchEvent) {
                            var event = doc.createEvent('Event');
                            event.initEvent('sf-dump-expanded' === newClass ? 'sfbeforedumpexpand' : 'sfbeforedumpcollapse', true, false);
                            s.dispatchEvent(event);
                        }
                        a.lastChild.innerHTML = arrow;
                        s.className = s.className.replace(/\bsf-dump-(compact|expanded)\b/, newClass);
                        if (recursive) {
                            try {
                                a = s.querySelectorAll('.' + oldClass);
                                for (s = 0; s < a.length; ++s) {
                                    if (-1 == a[s].className.indexOf(newClass)) {
                                        a[s].className = newClass;
                                        a[s].previousSibling.lastChild.innerHTML = arrow;
                                    }
                                }
                            } catch (e) {
                            }
                        }
                        return true;
                    };

                    function collapse(a, recursive) {
                        var s = a.nextSibling || {}, oldClass = s.className;
                        if (/\bsf-dump-expanded\b/.test(oldClass)) {
                            toggle(a, recursive);
                            return true;
                        }
                        return false;
                    };

                    function expand(a, recursive) {
                        var s = a.nextSibling || {}, oldClass = s.className;
                        if (/\bsf-dump-compact\b/.test(oldClass)) {
                            toggle(a, recursive);
                            return true;
                        }
                        return false;
                    };

                    function collapseAll(root) {
                        var a = root.querySelector('a.sf-dump-toggle');
                        if (a) {
                            collapse(a, true);
                            expand(a);
                            return true;
                        }
                        return false;
                    }

                    function reveal(node) {
                        var previous, parents = [];
                        while ((node = node.parentNode || {}) && (previous = node.previousSibling) && 'A' === previous.tagName) {
                            parents.push(previous);
                        }
                        if (0 !== parents.length) {
                            parents.forEach(function (parent) {
                                expand(parent);
                            });
                            return true;
                        }
                        return false;
                    }

                    function highlight(root, activeNode, nodes) {
                        resetHighlightedNodes(root);
                        Array.from(nodes || []).forEach(function (node) {
                            if (!/\bsf-dump-highlight\b/.test(node.className)) {
                                node.className = node.className + ' sf-dump-highlight';
                            }
                        });
                        if (!/\bsf-dump-highlight-active\b/.test(activeNode.className)) {
                            activeNode.className = activeNode.className + ' sf-dump-highlight-active';
                        }
                    }

                    function resetHighlightedNodes(root) {
                        Array.from(root.querySelectorAll('.sf-dump-str, .sf-dump-key, .sf-dump-public, .sf-dump-protected, .sf-dump-private')).forEach(function (strNode) {
                            strNode.className = strNode.className.replace(/\bsf-dump-highlight\b/, '');
                            strNode.className = strNode.className.replace(/\bsf-dump-highlight-active\b/, '');
                        });
                    }

                    return function (root, x) {
                        root = doc.getElementById(root);
                        var indentRx = new RegExp('^(' + (root.getAttribute('data-indent-pad') || ' ').replace(rxEsc, '\\$1') + ')+', 'm'),
                            options = {"maxDepth": 1, "maxStringLength": 160, "fileLinkFormat": false},
                            elt = root.getElementsByTagName('A'), len = elt.length, i = 0, s, h, t = [];
                        while (i < len) t.push(elt[i++]);
                        for (i in x) {
                            options[i] = x[i];
                        }

                        function a(e, f) {
                            addEventListener(root, e, function (e, n) {
                                if ('A' == e.target.tagName) {
                                    f(e.target, e);
                                } else if ('A' == e.target.parentNode.tagName) {
                                    f(e.target.parentNode, e);
                                } else {
                                    n = /\bsf-dump-ellipsis\b/.test(e.target.className) ? e.target.parentNode : e.target;
                                    if ((n = n.nextElementSibling) && 'A' == n.tagName) {
                                        if (!/\bsf-dump-toggle\b/.test(n.className)) {
                                            n = n.nextElementSibling || n;
                                        }
                                        f(n, e, true);
                                    }
                                }
                            });
                        };

                        function isCtrlKey(e) {
                            return e.ctrlKey || e.metaKey;
                        }

                        function xpathString(str) {
                            var parts = str.match(/[^'"]+|['"]/g).map(function (part) {
                                if ("'" == part) {
                                    return '"\'"';
                                }
                                if ('"' == part) {
                                    return "'\"'";
                                }
                                return "'" + part + "'";
                            });
                            return "concat(" + parts.join(",") + ", '')";
                        }

                        function xpathHasClass(className) {
                            return "contains(concat(' ', normalize-space(@class), ' '), ' " + className + " ')";
                        }

                        addEventListener(root, 'mouseover', function (e) {
                            if ('' != refStyle.innerHTML) {
                                refStyle.innerHTML = '';
                            }
                        });
                        a('mouseover', function (a, e, c) {
                            if (c) {
                                e.target.style.cursor = "pointer";
                            } else if (a = idRx.exec(a.className)) {
                                try {
                                    refStyle.innerHTML = '.phpdebugbar pre.sf-dump .' + a[0] + '{background-color: #B729D9; color: #FFF !important; border-radius: 2px}';
                                } catch (e) {
                                }
                            }
                        });
                        a('click', function (a, e, c) {
                            if (/\bsf-dump-toggle\b/.test(a.className)) {
                                e.preventDefault();
                                if (!toggle(a, isCtrlKey(e))) {
                                    var r = doc.getElementById(a.getAttribute('href').substr(1)), s = r.previousSibling,
                                        f = r.parentNode, t = a.parentNode;
                                    t.replaceChild(r, a);
                                    f.replaceChild(a, s);
                                    t.insertBefore(s, r);
                                    f = f.firstChild.nodeValue.match(indentRx);
                                    t = t.firstChild.nodeValue.match(indentRx);
                                    if (f && t && f[0] !== t[0]) {
                                        r.innerHTML = r.innerHTML.replace(new RegExp('^' + f[0].replace(rxEsc, '\\$1'), 'mg'), t[0]);
                                    }
                                    if (/\bsf-dump-compact\b/.test(r.className)) {
                                        toggle(s, isCtrlKey(e));
                                    }
                                }
                                if (c) {
                                } else if (doc.getSelection) {
                                    try {
                                        doc.getSelection().removeAllRanges();
                                    } catch (e) {
                                        doc.getSelection().empty();
                                    }
                                } else {
                                    doc.selection.empty();
                                }
                            } else if (/\bsf-dump-str-toggle\b/.test(a.className)) {
                                e.preventDefault();
                                e = a.parentNode.parentNode;
                                e.className = e.className.replace(/\bsf-dump-str-(expand|collapse)\b/, a.parentNode.className);
                            }
                        });
                        elt = root.getElementsByTagName('SAMP');
                        len = elt.length;
                        i = 0;
                        while (i < len) t.push(elt[i++]);
                        len = t.length;
                        for (i = 0; i < len; ++i) {
                            elt = t[i];
                            if ('SAMP' == elt.tagName) {
                                a = elt.previousSibling || {};
                                if ('A' != a.tagName) {
                                    a = doc.createElement('A');
                                    a.className = 'sf-dump-ref';
                                    elt.parentNode.insertBefore(a, elt);
                                } else {
                                    a.innerHTML += ' ';
                                }
                                a.title = (a.title ? a.title + '\n[' : '[') + keyHint + '+click] Expand all children';
                                a.innerHTML += '<span>▼</span>';
                                a.className += ' sf-dump-toggle';
                                x = 1;
                                if ('sf-dump' != elt.parentNode.className) {
                                    x += elt.parentNode.getAttribute('data-depth') / 1;
                                }
                                elt.setAttribute('data-depth', x);
                                var className = elt.className;
                                elt.className = 'sf-dump-expanded';
                                if (className ? 'sf-dump-expanded' !== className : (x > options.maxDepth)) {
                                    toggle(a);
                                }
                            } else if (/\bsf-dump-ref\b/.test(elt.className) && (a = elt.getAttribute('href'))) {
                                a = a.substr(1);
                                elt.className += ' ' + a;
                                if (/[\[{]$/.test(elt.previousSibling.nodeValue)) {
                                    a = a != elt.nextSibling.id && doc.getElementById(a);
                                    try {
                                        s = a.nextSibling;
                                        elt.appendChild(a);
                                        s.parentNode.insertBefore(a, s);
                                        if (/^[@#]/.test(elt.innerHTML)) {
                                            elt.innerHTML += ' <span>▶</span>';
                                        } else {
                                            elt.innerHTML = '<span>▶</span>';
                                            elt.className = 'sf-dump-ref';
                                        }
                                        elt.className += ' sf-dump-toggle';
                                    } catch (e) {
                                        if ('&' == elt.innerHTML.charAt(0)) {
                                            elt.innerHTML = '…';
                                            elt.className = 'sf-dump-ref';
                                        }
                                    }
                                }
                            }
                        }
                        if (doc.evaluate && Array.from && root.children.length > 1) {
                            root.setAttribute('tabindex', 0);
                            SearchState = function () {
                                this.nodes = [];
                                this.idx = 0;
                            };
                            SearchState.prototype = {
                                next: function () {
                                    if (this.isEmpty()) {
                                        return this.current();
                                    }
                                    this.idx = this.idx < (this.nodes.length - 1) ? this.idx + 1 : 0;
                                    return this.current();
                                }, previous: function () {
                                    if (this.isEmpty()) {
                                        return this.current();
                                    }
                                    this.idx = this.idx > 0 ? this.idx - 1 : (this.nodes.length - 1);
                                    return this.current();
                                }, isEmpty: function () {
                                    return 0 === this.count();
                                }, current: function () {
                                    if (this.isEmpty()) {
                                        return null;
                                    }
                                    return this.nodes[this.idx];
                                }, reset: function () {
                                    this.nodes = [];
                                    this.idx = 0;
                                }, count: function () {
                                    return this.nodes.length;
                                },
                            };

                            function showCurrent(state) {
                                var currentNode = state.current(), currentRect, searchRect;
                                if (currentNode) {
                                    reveal(currentNode);
                                    highlight(root, currentNode, state.nodes);
                                    if ('scrollIntoView' in currentNode) {
                                        currentNode.scrollIntoView(true);
                                        currentRect = currentNode.getBoundingClientRect();
                                        searchRect = search.getBoundingClientRect();
                                        if (currentRect.top < (searchRect.top + searchRect.height)) {
                                            window.scrollBy(0, -(searchRect.top + searchRect.height + 5));
                                        }
                                    }
                                }
                                counter.textContent = (state.isEmpty() ? 0 : state.idx + 1) + ' of ' + state.count();
                            }

                            var search = doc.createElement('div');
                            search.className = 'sf-dump-search-wrapper sf-dump-search-hidden';
                            search.innerHTML = ' <input type="text" class="sf-dump-search-input"> <span class="sf-dump-search-count">0 of 0<\/span> <button type="button" class="sf-dump-search-input-previous" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 1331l-166 165q-19 19-45 19t-45-19L896 965l-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"\/><\/svg> <\/button> <button type="button" class="sf-dump-search-input-next" tabindex="-1"> <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 808l-742 741q-19 19-45 19t-45-19L109 808q-19-19-19-45.5t19-45.5l166-165q19-19 45-19t45 19l531 531 531-531q19-19 45-19t45 19l166 165q19 19 19 45.5t-19 45.5z"\/><\/svg> <\/button> ';
                            root.insertBefore(search, root.firstChild);
                            var state = new SearchState();
                            var searchInput = search.querySelector('.sf-dump-search-input');
                            var counter = search.querySelector('.sf-dump-search-count');
                            var searchInputTimer = 0;
                            var previousSearchQuery = '';
                            addEventListener(searchInput, 'keyup', function (e) {
                                var searchQuery = e.target.value; /* Don't perform anything if the pressed key didn't change the query */
                                if (searchQuery === previousSearchQuery) {
                                    return;
                                }
                                previousSearchQuery = searchQuery;
                                clearTimeout(searchInputTimer);
                                searchInputTimer = setTimeout(function () {
                                    state.reset();
                                    collapseAll(root);
                                    resetHighlightedNodes(root);
                                    if ('' === searchQuery) {
                                        counter.textContent = '0 of 0';
                                        return;
                                    }
                                    var classMatches = ["sf-dump-str", "sf-dump-key", "sf-dump-public", "sf-dump-protected", "sf-dump-private",].map(xpathHasClass).join(' or ');
                                    var xpathResult = doc.evaluate('.//span[' + classMatches + '][contains(translate(child::text(), ' + xpathString(searchQuery.toUpperCase()) + ', ' + xpathString(searchQuery.toLowerCase()) + '), ' + xpathString(searchQuery.toLowerCase()) + ')]', root, null, XPathResult.ORDERED_NODE_ITERATOR_TYPE, null);
                                    while (node = xpathResult.iterateNext()) state.nodes.push(node);
                                    showCurrent(state);
                                }, 400);
                            });
                            Array.from(search.querySelectorAll('.sf-dump-search-input-next, .sf-dump-search-input-previous')).forEach(function (btn) {
                                addEventListener(btn, 'click', function (e) {
                                    e.preventDefault();
                                    -1 !== e.target.className.indexOf('next') ? state.next() : state.previous();
                                    searchInput.focus();
                                    collapseAll(root);
                                    showCurrent(state);
                                })
                            });
                            addEventListener(root, 'keydown', function (e) {
                                var isSearchActive = !/\bsf-dump-search-hidden\b/.test(search.className);
                                if ((114 === e.keyCode && !isSearchActive) || (isCtrlKey(e) && 70 === e.keyCode)) { /* F3 or CMD/CTRL + F */
                                    if (70 === e.keyCode && document.activeElement === searchInput) { /* * If CMD/CTRL + F is hit while having focus on search input, * the user probably meant to trigger browser search instead. * Let the browser execute its behavior: */
                                        return;
                                    }
                                    e.preventDefault();
                                    search.className = search.className.replace(/\bsf-dump-search-hidden\b/, '');
                                    searchInput.focus();
                                } else if (isSearchActive) {
                                    if (27 === e.keyCode) { /* ESC key */
                                        search.className += ' sf-dump-search-hidden';
                                        e.preventDefault();
                                        resetHighlightedNodes(root);
                                        searchInput.value = '';
                                    } else if ((isCtrlKey(e) && 71 === e.keyCode) /* CMD/CTRL + G */ || 13 === e.keyCode /* Enter */ || 114 === e.keyCode /* F3 */) {
                                        e.preventDefault();
                                        e.shiftKey ? state.previous() : state.next();
                                        collapseAll(root);
                                        showCurrent(state);
                                    }
                                }
                            });
                        }
                        if (0 >= options.maxStringLength) {
                            return;
                        }
                        try {
                            elt = root.querySelectorAll('.sf-dump-str');
                            len = elt.length;
                            i = 0;
                            t = [];
                            while (i < len) t.push(elt[i++]);
                            len = t.length;
                            for (i = 0; i < len; ++i) {
                                elt = t[i];
                                s = elt.innerText || elt.textContent;
                                x = s.length - options.maxStringLength;
                                if (0 < x) {
                                    h = elt.innerHTML;
                                    elt[elt.innerText ? 'innerText' : 'textContent'] = s.substring(0, options.maxStringLength);
                                    elt.className += ' sf-dump-str-collapse';
                                    elt.innerHTML = '<span class=sf-dump-str-collapse>' + h + '<a class="sf-dump-ref sf-dump-str-toggle" title="Collapse"> ◀</a></span>' + '<span class=sf-dump-str-expand>' + elt.innerHTML + '<a class="sf-dump-ref sf-dump-str-toggle" title="' + x + ' remaining characters"> ▶</a></span>';
                                }
                            }
                        } catch (e) {
                        }
                    };
                })(document); </script>
            <style> .phpdebugbar pre.sf-dump {
                    display: block;
                    white-space: pre;
                    padding: 5px;
                    overflow: initial !important;
                }

                .phpdebugbar pre.sf-dump:after {
                    content: "";
                    visibility: hidden;
                    display: block;
                    height: 0;
                    clear: both;
                }

                .phpdebugbar pre.sf-dump span {
                    display: inline;
                }

                .phpdebugbar pre.sf-dump .sf-dump-compact {
                    display: none;
                }

                .phpdebugbar pre.sf-dump a {
                    text-decoration: none;
                    cursor: pointer;
                    border: 0;
                    outline: none;
                    color: inherit;
                }

                .phpdebugbar pre.sf-dump img {
                    max-width: 50em;
                    max-height: 50em;
                    margin: .5em 0 0 0;
                    padding: 0;
                    background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAAAAAA6mKC9AAAAHUlEQVQY02O8zAABilCaiQEN0EeA8QuUcX9g3QEAAjcC5piyhyEAAAAASUVORK5CYII=) #D3D3D3;
                }

                .phpdebugbar pre.sf-dump .sf-dump-ellipsis {
                    display: inline-block;
                    overflow: visible;
                    text-overflow: ellipsis;
                    max-width: 5em;
                    white-space: nowrap;
                    overflow: hidden;
                    vertical-align: top;
                }

                .phpdebugbar pre.sf-dump .sf-dump-ellipsis + .sf-dump-ellipsis {
                    max-width: none;
                }

                .phpdebugbar pre.sf-dump code {
                    display: inline;
                    padding: 0;
                    background: none;
                }

                .sf-dump-str-collapse .sf-dump-str-collapse {
                    display: none;
                }

                .sf-dump-str-expand .sf-dump-str-expand {
                    display: none;
                }

                .sf-dump-public.sf-dump-highlight, .sf-dump-protected.sf-dump-highlight, .sf-dump-private.sf-dump-highlight, .sf-dump-str.sf-dump-highlight, .sf-dump-key.sf-dump-highlight {
                    background: rgba(111, 172, 204, 0.3);
                    border: 1px solid #7DA0B1;
                    border-radius: 3px;
                }

                .sf-dump-public.sf-dump-highlight-active, .sf-dump-protected.sf-dump-highlight-active, .sf-dump-private.sf-dump-highlight-active, .sf-dump-str.sf-dump-highlight-active, .sf-dump-key.sf-dump-highlight-active {
                    background: rgba(253, 175, 0, 0.4);
                    border: 1px solid #ffa500;
                    border-radius: 3px;
                }

                .phpdebugbar pre.sf-dump .sf-dump-search-hidden {
                    display: none !important;
                }

                .phpdebugbar pre.sf-dump .sf-dump-search-wrapper {
                    font-size: 0;
                    white-space: nowrap;
                    margin-bottom: 5px;
                    display: flex;
                    position: -webkit-sticky;
                    position: sticky;
                    top: 5px;
                }

                .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > * {
                    vertical-align: top;
                    box-sizing: border-box;
                    height: 21px;
                    font-weight: normal;
                    border-radius: 0;
                    background: #FFF;
                    color: #757575;
                    border: 1px solid #BBB;
                }

                .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > input.sf-dump-search-input {
                    padding: 3px;
                    height: 21px;
                    font-size: 12px;
                    border-right: none;
                    border-top-left-radius: 3px;
                    border-bottom-left-radius: 3px;
                    color: #000;
                    min-width: 15px;
                    width: 100%;
                }

                .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-next, .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-previous {
                    background: #F2F2F2;
                    outline: none;
                    border-left: none;
                    font-size: 0;
                    line-height: 0;
                }

                .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-next {
                    border-top-right-radius: 3px;
                    border-bottom-right-radius: 3px;
                }

                .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-next > svg, .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-input-previous > svg {
                    pointer-events: none;
                    width: 12px;
                    height: 12px;
                }

                .phpdebugbar pre.sf-dump .sf-dump-search-wrapper > .sf-dump-search-count {
                    display: inline-block;
                    padding: 0 5px;
                    margin: 0;
                    border-left: none;
                    line-height: 21px;
                    font-size: 12px;
                }

                .phpdebugbar pre.sf-dump, .phpdebugbar pre.sf-dump .sf-dump-default {
                    word-wrap: break-word;
                    white-space: pre-wrap;
                    word-break: normal
                }

                .phpdebugbar pre.sf-dump .sf-dump-num {
                    font-weight: bold;
                    color: #1299DA
                }

                .phpdebugbar pre.sf-dump .sf-dump-const {
                    font-weight: bold
                }

                .phpdebugbar pre.sf-dump .sf-dump-str {
                    font-weight: bold;
                    color: #3A9B26
                }

                .phpdebugbar pre.sf-dump .sf-dump-note {
                    color: #1299DA
                }

                .phpdebugbar pre.sf-dump .sf-dump-ref {
                    color: #7B7B7B
                }

                .phpdebugbar pre.sf-dump .sf-dump-public {
                    color: #000000
                }

                .phpdebugbar pre.sf-dump .sf-dump-protected {
                    color: #000000
                }

                .phpdebugbar pre.sf-dump .sf-dump-private {
                    color: #000000
                }

                .phpdebugbar pre.sf-dump .sf-dump-meta {
                    color: #B729D9
                }

                .phpdebugbar pre.sf-dump .sf-dump-key {
                    color: #3A9B26
                }

                .phpdebugbar pre.sf-dump .sf-dump-index {
                    color: #1299DA
                }

                .phpdebugbar pre.sf-dump .sf-dump-ellipsis {
                    color: #A0A000
                }

                .phpdebugbar pre.sf-dump .sf-dump-ns {
                    user-select: none;
                }

                .phpdebugbar pre.sf-dump .sf-dump-ellipsis-note {
                    color: #1299DA
                }</style>
            <script type="text/javascript">
                var phpdebugbar = new PhpDebugBar.DebugBar();
                phpdebugbar.addIndicator("php_version", new PhpDebugBar.DebugBar.Indicator({
                    "icon": "code",
                    "tooltip": "Version"
                }), "right");
                phpdebugbar.addTab("messages", new PhpDebugBar.DebugBar.Tab({
                    "icon": "list-alt",
                    "title": "Messages",
                    "widget": new PhpDebugBar.Widgets.MessagesWidget()
                }));
                phpdebugbar.addIndicator("time", new PhpDebugBar.DebugBar.Indicator({
                    "icon": "clock-o",
                    "tooltip": "Request Duration"
                }), "right");
                phpdebugbar.addTab("timeline", new PhpDebugBar.DebugBar.Tab({
                    "icon": "tasks",
                    "title": "Timeline",
                    "widget": new PhpDebugBar.Widgets.TimelineWidget()
                }));
                phpdebugbar.addIndicator("memory", new PhpDebugBar.DebugBar.Indicator({
                    "icon": "cogs",
                    "tooltip": "Memory Usage"
                }), "right");
                phpdebugbar.addTab("exceptions", new PhpDebugBar.DebugBar.Tab({
                    "icon": "bug",
                    "title": "Exceptions",
                    "widget": new PhpDebugBar.Widgets.ExceptionsWidget()
                }));
                phpdebugbar.addTab("views", new PhpDebugBar.DebugBar.Tab({
                    "icon": "leaf",
                    "title": "Views",
                    "widget": new PhpDebugBar.Widgets.TemplatesWidget()
                }));
                phpdebugbar.addTab("route", new PhpDebugBar.DebugBar.Tab({
                    "icon": "share",
                    "title": "Route",
                    "widget": new PhpDebugBar.Widgets.VariableListWidget()
                }));
                phpdebugbar.addIndicator("currentroute", new PhpDebugBar.DebugBar.Indicator({
                    "icon": "share",
                    "tooltip": "Route"
                }), "right");
                phpdebugbar.addTab("queries", new PhpDebugBar.DebugBar.Tab({
                    "icon": "database",
                    "title": "Queries",
                    "widget": new PhpDebugBar.Widgets.LaravelSQLQueriesWidget()
                }));
                phpdebugbar.addTab("emails", new PhpDebugBar.DebugBar.Tab({
                    "icon": "inbox",
                    "title": "Mails",
                    "widget": new PhpDebugBar.Widgets.MailsWidget()
                }));
                phpdebugbar.addTab("gate", new PhpDebugBar.DebugBar.Tab({
                    "icon": "list-alt",
                    "title": "Gate",
                    "widget": new PhpDebugBar.Widgets.MessagesWidget()
                }));
                phpdebugbar.addTab("session", new PhpDebugBar.DebugBar.Tab({
                    "icon": "archive",
                    "title": "Session",
                    "widget": new PhpDebugBar.Widgets.VariableListWidget()
                }));
                phpdebugbar.addTab("request", new PhpDebugBar.DebugBar.Tab({
                    "icon": "tags",
                    "title": "Request",
                    "widget": new PhpDebugBar.Widgets.HtmlVariableListWidget()
                }));
                phpdebugbar.setDataMap({
                    "php_version": ["php.version",],
                    "messages": ["messages.messages", []],
                    "messages:badge": ["messages.count", null],
                    "time": ["time.duration_str", '0ms'],
                    "timeline": ["time", {}],
                    "memory": ["memory.peak_usage_str", '0B'],
                    "exceptions": ["exceptions.exceptions", []],
                    "exceptions:badge": ["exceptions.count", null],
                    "views": ["views", []],
                    "views:badge": ["views.nb_templates", 0],
                    "route": ["route", {}],
                    "currentroute": ["route.uri",],
                    "queries": ["queries", []],
                    "queries:badge": ["queries.nb_statements", 0],
                    "emails": ["swiftmailer_mails.mails", []],
                    "emails:badge": ["swiftmailer_mails.count", null],
                    "gate": ["gate.messages", []],
                    "gate:badge": ["gate.count", null],
                    "session": ["session", {}],
                    "request": ["request", {}]
                });
                phpdebugbar.restoreState();
                phpdebugbar.ajaxHandler = new PhpDebugBar.AjaxHandler(phpdebugbar, undefined, true);
                phpdebugbar.ajaxHandler.bindToXHR();
                phpdebugbar.setOpenHandler(new PhpDebugBar.OpenHandler({"url": "http:\/\/newampleev.com\/_debugbar\/open"}));
                phpdebugbar.addDataSet({
                    "__meta": {
                        "id": "Xc22b4e9780c38ca7c23cf2f3f879d5cc",
                        "datetime": "2019-12-19 13:59:49",
                        "utime": 1576763989.3625791072845458984375,
                        "method": "GET",
                        "uri": "\/article-1",
                        "ip": "127.0.0.1"
                    },
                    "php": {"version": "7.1.32", "interface": "apache2handler"},
                    "messages": {"count": 0, "messages": []},
                    "time": {
                        "start": 1576763989.2130000591278076171875,
                        "end": 1576763989.36260700225830078125,
                        "duration": 0.1496069431304931640625,
                        "duration_str": "149.61ms",
                        "measures": [{
                            "label": "Booting",
                            "start": 1576763989.2130000591278076171875,
                            "relative_start": 0,
                            "end": 1576763989.30263996124267578125,
                            "relative_end": 1576763989.30263996124267578125,
                            "duration": 0.0896399021148681640625,
                            "duration_str": "89.64ms",
                            "params": [],
                            "collector": null
                        }, {
                            "label": "Application",
                            "start": 1576763989.305183887481689453125,
                            "relative_start": 0.0921838283538818359375,
                            "end": 1576763989.36260890960693359375,
                            "relative_end": 1.9073486328125e-6,
                            "duration": 0.057425022125244140625,
                            "duration_str": "57.43ms",
                            "params": [],
                            "collector": null
                        }]
                    },
                    "memory": {"peak_usage": 16198792, "peak_usage_str": "15.45MB"},
                    "exceptions": {"count": 0, "exceptions": []},
                    "views": {
                        "nb_templates": 9,
                        "templates": [{
                            "name": "blog.article (resources\/views\/blog\/article.blade.php)",
                            "param_count": 2,
                            "params": ["article", "comments"],
                            "type": "blade"
                        }, {
                            "name": "layouts.navbar_white (resources\/views\/layouts\/navbar_white.blade.php)",
                            "param_count": 6,
                            "params": ["obLevel", "__env", "app", "errors", "article", "comments"],
                            "type": "blade"
                        }, {
                            "name": "blog.article.article_progress (resources\/views\/blog\/article\/article_progress.blade.php)",
                            "param_count": 6,
                            "params": ["obLevel", "__env", "app", "errors", "article", "comments"],
                            "type": "blade"
                        }, {
                            "name": "blog.article.breadcrumb_and_views (resources\/views\/blog\/article\/breadcrumb_and_views.blade.php)",
                            "param_count": 6,
                            "params": ["obLevel", "__env", "app", "errors", "article", "comments"],
                            "type": "blade"
                        }, {
                            "name": "blog.article.social_sharing (resources\/views\/blog\/article\/social_sharing.blade.php)",
                            "param_count": 6,
                            "params": ["obLevel", "__env", "app", "errors", "article", "comments"],
                            "type": "blade"
                        }, {
                            "name": "blog.article.comments (resources\/views\/blog\/article\/comments.blade.php)",
                            "param_count": 6,
                            "params": ["obLevel", "__env", "app", "errors", "article", "comments"],
                            "type": "blade"
                        }, {
                            "name": "blog.article.add_comment (resources\/views\/blog\/article\/add_comment.blade.php)",
                            "param_count": 6,
                            "params": ["obLevel", "__env", "app", "errors", "article", "comments"],
                            "type": "blade"
                        }, {
                            "name": "blog.article.related_stories (resources\/views\/blog\/article\/related_stories.blade.php)",
                            "param_count": 6,
                            "params": ["obLevel", "__env", "app", "errors", "article", "comments"],
                            "type": "blade"
                        }, {
                            "name": "layouts.app (resources\/views\/layouts\/app.blade.php)",
                            "param_count": 6,
                            "params": ["obLevel", "__env", "app", "errors", "article", "comments"],
                            "type": "blade"
                        }]
                    },
                    "route": {
                        "uri": "GET article-{article_id}",
                        "middleware": "web",
                        "controller": "App\\Http\\Controllers\\BlogController@show_article",
                        "as": "blog.show_article",
                        "namespace": "App\\Http\\Controllers",
                        "prefix": null,
                        "where": [],
                        "file": "app\/Http\/Controllers\/BlogController.php:23-31"
                    },
                    "queries": {
                        "nb_statements": 7,
                        "nb_failed_statements": 0,
                        "accumulated_duration": 0.006860000000000000645872244575684817391447722911834716796875,
                        "accumulated_duration_str": "6.86ms",
                        "statements": [{
                            "sql": "select * from `articles` where `articles`.`id` = '1' limit 1",
                            "type": "query",
                            "params": [],
                            "bindings": ["1"],
                            "hints": ["Use <code>SELECT *<\/code> only if you need all columns from table", "<code>LIMIT<\/code> without <code>ORDER BY<\/code> causes non-deterministic results, depending on the query execution plan"],
                            "backtrace": [{
                                "index": 17,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Support\/Traits\/ForwardsCalls.php",
                                "line": 23
                            }, {
                                "index": 20,
                                "namespace": null,
                                "name": "\/app\/Http\/Controllers\/BlogController.php",
                                "line": 26
                            }, {
                                "index": 23,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php",
                                "line": 45
                            }, {
                                "index": 24,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php",
                                "line": 219
                            }, {
                                "index": 25,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php",
                                "line": 176
                            }, {
                                "index": 26,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 692
                            }, {
                                "index": 27,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 130
                            }, {"index": 28, "namespace": "middleware", "name": "bindings", "line": 41}, {
                                "index": 29,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 30,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/VerifyCsrfToken.php",
                                "line": 76
                            }, {
                                "index": 31,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 32,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Middleware\/ShareErrorsFromSession.php",
                                "line": 49
                            }, {
                                "index": 33,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 34,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Session\/Middleware\/StartSession.php",
                                "line": 56
                            }, {
                                "index": 35,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 36,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/AddQueuedCookiesToResponse.php",
                                "line": 37
                            }, {
                                "index": 37,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 38,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/EncryptCookies.php",
                                "line": 66
                            }, {
                                "index": 39,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 40,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 105
                            }, {
                                "index": 41,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 694
                            }, {
                                "index": 42,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 669
                            }, {
                                "index": 43,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 635
                            }, {
                                "index": 44,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 624
                            }, {
                                "index": 45,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
                                "line": 176
                            }, {
                                "index": 46,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 130
                            }, {
                                "index": 48,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 49,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
                                "line": 21
                            }],
                            "duration": 0.0042699999999999994904076316970531479455530643463134765625,
                            "duration_str": "4.27ms",
                            "stmt_id": "\/vendor\/laravel\/framework\/src\/Illuminate\/Support\/Traits\/ForwardsCalls.php:23",
                            "connection": "newampleev"
                        }, {
                            "sql": "select * from `users` where `id` = 1 limit 1",
                            "type": "query",
                            "params": [],
                            "bindings": ["1"],
                            "hints": ["Use <code>SELECT *<\/code> only if you need all columns from table", "<code>LIMIT<\/code> without <code>ORDER BY<\/code> causes non-deterministic results, depending on the query execution plan"],
                            "backtrace": [{
                                "index": 15,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php",
                                "line": 52
                            }, {
                                "index": 16,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/SessionGuard.php",
                                "line": 131
                            }, {
                                "index": 17,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/GuardHelpers.php",
                                "line": 60
                            }, {
                                "index": 18,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/AuthManager.php",
                                "line": 307
                            }, {
                                "index": 19,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Support\/Facades\/Facade.php",
                                "line": 245
                            }, {"index": 20, "namespace": null, "name": "\/app\/Article.php", "line": 68}, {
                                "index": 21,
                                "namespace": null,
                                "name": "\/app\/Http\/Controllers\/BlogController.php",
                                "line": 27
                            }, {
                                "index": 24,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php",
                                "line": 45
                            }, {
                                "index": 25,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php",
                                "line": 219
                            }, {
                                "index": 26,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php",
                                "line": 176
                            }, {
                                "index": 27,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 692
                            }, {
                                "index": 28,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 130
                            }, {"index": 29, "namespace": "middleware", "name": "bindings", "line": 41}, {
                                "index": 30,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 31,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/VerifyCsrfToken.php",
                                "line": 76
                            }, {
                                "index": 32,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 33,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Middleware\/ShareErrorsFromSession.php",
                                "line": 49
                            }, {
                                "index": 34,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 35,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Session\/Middleware\/StartSession.php",
                                "line": 56
                            }, {
                                "index": 36,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 37,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/AddQueuedCookiesToResponse.php",
                                "line": 37
                            }, {
                                "index": 38,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 39,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/EncryptCookies.php",
                                "line": 66
                            }, {
                                "index": 40,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 41,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 105
                            }, {
                                "index": 42,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 694
                            }, {
                                "index": 43,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 669
                            }, {
                                "index": 44,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 635
                            }, {
                                "index": 45,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 624
                            }, {
                                "index": 46,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
                                "line": 176
                            }, {
                                "index": 47,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 130
                            }, {
                                "index": 49,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }],
                            "duration": 0.000529999999999999980675180477618368968251161277294158935546875,
                            "duration_str": "530\u03bcs",
                            "stmt_id": "\/vendor\/laravel\/framework\/src\/Illuminate\/Auth\/EloquentUserProvider.php:52",
                            "connection": "newampleev"
                        }, {
                            "sql": "select count(*) as aggregate from `view_articles` where (`article_id` = 1 and `user_id` = 1)",
                            "type": "query",
                            "params": [],
                            "bindings": ["1", "1"],
                            "hints": [],
                            "backtrace": [{"index": 15, "namespace": null, "name": "\/app\/Article.php", "line": 79}, {
                                "index": 16,
                                "namespace": null,
                                "name": "\/app\/Http\/Controllers\/BlogController.php",
                                "line": 27
                            }, {
                                "index": 19,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php",
                                "line": 45
                            }, {
                                "index": 20,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php",
                                "line": 219
                            }, {
                                "index": 21,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php",
                                "line": 176
                            }, {
                                "index": 22,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 692
                            }, {
                                "index": 23,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 130
                            }, {"index": 24, "namespace": "middleware", "name": "bindings", "line": 41}, {
                                "index": 25,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 26,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/VerifyCsrfToken.php",
                                "line": 76
                            }, {
                                "index": 27,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 28,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Middleware\/ShareErrorsFromSession.php",
                                "line": 49
                            }, {
                                "index": 29,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 30,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Session\/Middleware\/StartSession.php",
                                "line": 56
                            }, {
                                "index": 31,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 32,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/AddQueuedCookiesToResponse.php",
                                "line": 37
                            }, {
                                "index": 33,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 34,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/EncryptCookies.php",
                                "line": 66
                            }, {
                                "index": 35,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 36,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 105
                            }, {
                                "index": 37,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 694
                            }, {
                                "index": 38,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 669
                            }, {
                                "index": 39,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 635
                            }, {
                                "index": 40,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 624
                            }, {
                                "index": 41,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
                                "line": 176
                            }, {
                                "index": 42,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 130
                            }, {
                                "index": 44,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 45,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
                                "line": 21
                            }, {
                                "index": 46,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 47,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
                                "line": 21
                            }, {
                                "index": 48,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 49,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php",
                                "line": 27
                            }],
                            "duration": 0.0004000000000000000191686944095437183932517655193805694580078125,
                            "duration_str": "400\u03bcs",
                            "stmt_id": "\/app\/Article.php:79",
                            "connection": "newampleev"
                        }, {
                            "sql": "select * from `comments` where `article_id` = 1",
                            "type": "query",
                            "params": [],
                            "bindings": ["1"],
                            "hints": ["Use <code>SELECT *<\/code> only if you need all columns from table"],
                            "backtrace": [{
                                "index": 14,
                                "namespace": null,
                                "name": "\/app\/Http\/Controllers\/BlogController.php",
                                "line": 28
                            }, {
                                "index": 17,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/ControllerDispatcher.php",
                                "line": 45
                            }, {
                                "index": 18,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php",
                                "line": 219
                            }, {
                                "index": 19,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Route.php",
                                "line": 176
                            }, {
                                "index": 20,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 692
                            }, {
                                "index": 21,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 130
                            }, {"index": 22, "namespace": "middleware", "name": "bindings", "line": 41}, {
                                "index": 23,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 24,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/VerifyCsrfToken.php",
                                "line": 76
                            }, {
                                "index": 25,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 26,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Middleware\/ShareErrorsFromSession.php",
                                "line": 49
                            }, {
                                "index": 27,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 28,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Session\/Middleware\/StartSession.php",
                                "line": 56
                            }, {
                                "index": 29,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 30,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/AddQueuedCookiesToResponse.php",
                                "line": 37
                            }, {
                                "index": 31,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 32,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/EncryptCookies.php",
                                "line": 66
                            }, {
                                "index": 33,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 34,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 105
                            }, {
                                "index": 35,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 694
                            }, {
                                "index": 36,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 669
                            }, {
                                "index": 37,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 635
                            }, {
                                "index": 38,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 624
                            }, {
                                "index": 39,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Kernel.php",
                                "line": 176
                            }, {
                                "index": 40,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 130
                            }, {
                                "index": 42,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 43,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
                                "line": 21
                            }, {
                                "index": 44,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 45,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/TransformsRequest.php",
                                "line": 21
                            }, {
                                "index": 46,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 47,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/ValidatePostSize.php",
                                "line": 27
                            }, {
                                "index": 48,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 49,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/CheckForMaintenanceMode.php",
                                "line": 62
                            }],
                            "duration": 0.0003299999999999999981958875849841206218115985393524169921875,
                            "duration_str": "330\u03bcs",
                            "stmt_id": "\/app\/Http\/Controllers\/BlogController.php:28",
                            "connection": "newampleev"
                        }, {
                            "sql": "select * from `blog_sections` where `blog_sections`.`id` = 1 limit 1",
                            "type": "query",
                            "params": [],
                            "bindings": ["1"],
                            "hints": ["Use <code>SELECT *<\/code> only if you need all columns from table", "<code>LIMIT<\/code> without <code>ORDER BY<\/code> causes non-deterministic results, depending on the query execution plan"],
                            "backtrace": [{
                                "index": 20,
                                "namespace": "view",
                                "name": "blog.article.breadcrumb_and_views",
                                "line": 12
                            }, {
                                "index": 22,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/CompilerEngine.php",
                                "line": 59
                            }, {
                                "index": 23,
                                "namespace": null,
                                "name": "\/vendor\/facade\/ignition\/src\/Views\/Engines\/CompilerEngine.php",
                                "line": 36
                            }, {
                                "index": 24,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 143
                            }, {
                                "index": 25,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 126
                            }, {
                                "index": 26,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 91
                            }, {"index": 27, "namespace": "view", "name": "blog.article", "line": 22}, {
                                "index": 29,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/CompilerEngine.php",
                                "line": 59
                            }, {
                                "index": 30,
                                "namespace": null,
                                "name": "\/vendor\/facade\/ignition\/src\/Views\/Engines\/CompilerEngine.php",
                                "line": 36
                            }, {
                                "index": 31,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 143
                            }, {
                                "index": 32,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 126
                            }, {
                                "index": 33,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 91
                            }, {
                                "index": 34,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Http\/Response.php",
                                "line": 42
                            }, {
                                "index": 35,
                                "namespace": null,
                                "name": "\/vendor\/symfony\/http-foundation\/Response.php",
                                "line": 202
                            }, {
                                "index": 36,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 760
                            }, {
                                "index": 37,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 732
                            }, {
                                "index": 38,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 692
                            }, {
                                "index": 39,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 130
                            }, {"index": 40, "namespace": "middleware", "name": "bindings", "line": 41}, {
                                "index": 41,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 42,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/VerifyCsrfToken.php",
                                "line": 76
                            }, {
                                "index": 43,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 44,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Middleware\/ShareErrorsFromSession.php",
                                "line": 49
                            }, {
                                "index": 45,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 46,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Session\/Middleware\/StartSession.php",
                                "line": 56
                            }, {
                                "index": 47,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 48,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/AddQueuedCookiesToResponse.php",
                                "line": 37
                            }, {
                                "index": 49,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }],
                            "duration": 0.0005000000000000000104083408558608425664715468883514404296875,
                            "duration_str": "500\u03bcs",
                            "stmt_id": "view::blog.article.breadcrumb_and_views:12",
                            "connection": "newampleev"
                        }, {
                            "sql": "select * from `users` where `users`.`id` = 1 limit 1",
                            "type": "query",
                            "params": [],
                            "bindings": ["1"],
                            "hints": ["Use <code>SELECT *<\/code> only if you need all columns from table", "<code>LIMIT<\/code> without <code>ORDER BY<\/code> causes non-deterministic results, depending on the query execution plan"],
                            "backtrace": [{
                                "index": 20,
                                "namespace": "view",
                                "name": "blog.article.breadcrumb_and_views",
                                "line": 25
                            }, {
                                "index": 22,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/CompilerEngine.php",
                                "line": 59
                            }, {
                                "index": 23,
                                "namespace": null,
                                "name": "\/vendor\/facade\/ignition\/src\/Views\/Engines\/CompilerEngine.php",
                                "line": 36
                            }, {
                                "index": 24,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 143
                            }, {
                                "index": 25,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 126
                            }, {
                                "index": 26,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 91
                            }, {"index": 27, "namespace": "view", "name": "blog.article", "line": 22}, {
                                "index": 29,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/CompilerEngine.php",
                                "line": 59
                            }, {
                                "index": 30,
                                "namespace": null,
                                "name": "\/vendor\/facade\/ignition\/src\/Views\/Engines\/CompilerEngine.php",
                                "line": 36
                            }, {
                                "index": 31,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 143
                            }, {
                                "index": 32,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 126
                            }, {
                                "index": 33,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 91
                            }, {
                                "index": 34,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Http\/Response.php",
                                "line": 42
                            }, {
                                "index": 35,
                                "namespace": null,
                                "name": "\/vendor\/symfony\/http-foundation\/Response.php",
                                "line": 202
                            }, {
                                "index": 36,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 760
                            }, {
                                "index": 37,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 732
                            }, {
                                "index": 38,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 692
                            }, {
                                "index": 39,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 130
                            }, {"index": 40, "namespace": "middleware", "name": "bindings", "line": 41}, {
                                "index": 41,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 42,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/VerifyCsrfToken.php",
                                "line": 76
                            }, {
                                "index": 43,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 44,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Middleware\/ShareErrorsFromSession.php",
                                "line": 49
                            }, {
                                "index": 45,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 46,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Session\/Middleware\/StartSession.php",
                                "line": 56
                            }, {
                                "index": 47,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 48,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/AddQueuedCookiesToResponse.php",
                                "line": 37
                            }, {
                                "index": 49,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }],
                            "duration": 0.0004000000000000000191686944095437183932517655193805694580078125,
                            "duration_str": "400\u03bcs",
                            "stmt_id": "view::blog.article.breadcrumb_and_views:25",
                            "connection": "newampleev"
                        }, {
                            "sql": "select count(*) as aggregate from `comments` where (`article_id` = 1)",
                            "type": "query",
                            "params": [],
                            "bindings": ["1"],
                            "hints": [],
                            "backtrace": [{"index": 15, "namespace": null, "name": "\/app\/Article.php", "line": 46}, {
                                "index": 16,
                                "namespace": "view",
                                "name": "blog.article.comments",
                                "line": 1
                            }, {
                                "index": 18,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/CompilerEngine.php",
                                "line": 59
                            }, {
                                "index": 19,
                                "namespace": null,
                                "name": "\/vendor\/facade\/ignition\/src\/Views\/Engines\/CompilerEngine.php",
                                "line": 36
                            }, {
                                "index": 20,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 143
                            }, {
                                "index": 21,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 126
                            }, {
                                "index": 22,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 91
                            }, {"index": 23, "namespace": "view", "name": "blog.article", "line": 48}, {
                                "index": 25,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Engines\/CompilerEngine.php",
                                "line": 59
                            }, {
                                "index": 26,
                                "namespace": null,
                                "name": "\/vendor\/facade\/ignition\/src\/Views\/Engines\/CompilerEngine.php",
                                "line": 36
                            }, {
                                "index": 27,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 143
                            }, {
                                "index": 28,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 126
                            }, {
                                "index": 29,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/View.php",
                                "line": 91
                            }, {
                                "index": 30,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Http\/Response.php",
                                "line": 42
                            }, {
                                "index": 31,
                                "namespace": null,
                                "name": "\/vendor\/symfony\/http-foundation\/Response.php",
                                "line": 202
                            }, {
                                "index": 32,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 760
                            }, {
                                "index": 33,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 732
                            }, {
                                "index": 34,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 692
                            }, {
                                "index": 35,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 130
                            }, {"index": 36, "namespace": "middleware", "name": "bindings", "line": 41}, {
                                "index": 37,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 38,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Foundation\/Http\/Middleware\/VerifyCsrfToken.php",
                                "line": 76
                            }, {
                                "index": 39,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 40,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/View\/Middleware\/ShareErrorsFromSession.php",
                                "line": 49
                            }, {
                                "index": 41,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 42,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Session\/Middleware\/StartSession.php",
                                "line": 56
                            }, {
                                "index": 43,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 44,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/AddQueuedCookiesToResponse.php",
                                "line": 37
                            }, {
                                "index": 45,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 46,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Cookie\/Middleware\/EncryptCookies.php",
                                "line": 66
                            }, {
                                "index": 47,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 171
                            }, {
                                "index": 48,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Pipeline\/Pipeline.php",
                                "line": 105
                            }, {
                                "index": 49,
                                "namespace": null,
                                "name": "\/vendor\/laravel\/framework\/src\/Illuminate\/Routing\/Router.php",
                                "line": 694
                            }],
                            "duration": 0.0004299999999999999894355340313012447950313799083232879638671875,
                            "duration_str": "430\u03bcs",
                            "stmt_id": "\/app\/Article.php:46",
                            "connection": "newampleev"
                        }]
                    },
                    "swiftmailer_mails": {"count": 0, "mails": []},
                    "gate": {"count": 0, "messages": []},
                    "session": {
                        "_token": "BUH5xFouPlIQzeROqXClWpmRm5bkwwrKfS78ORks",
                        "_previous": "array:1 [\n  \"url\" => \"http:\/\/newampleev.com\/article-1\"\n]",
                        "_flash": "array:2 [\n  \"old\" => []\n  \"new\" => []\n]",
                        "login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d": "1",
                        "PHPDEBUGBAR_STACK_DATA": "[]"
                    },
                    "request": {
                        "path_info": "\/article-1",
                        "status_code": "<pre class=sf-dump id=sf-dump-657603 data-indent-pad=\"  \"><span class=sf-dump-num>200<\/span>\n<\/pre><script>Sfdump(\"sf-dump-657603\", {\"maxDepth\":0})<\/script>\n",
                        "status_text": "OK",
                        "format": "html",
                        "content_type": "text\/html; charset=UTF-8",
                        "request_query": "<pre class=sf-dump id=sf-dump-1468097571 data-indent-pad=\"  \">[]\n<\/pre><script>Sfdump(\"sf-dump-1468097571\", {\"maxDepth\":0})<\/script>\n",
                        "request_request": "<pre class=sf-dump id=sf-dump-612183788 data-indent-pad=\"  \">[]\n<\/pre><script>Sfdump(\"sf-dump-612183788\", {\"maxDepth\":0})<\/script>\n",
                        "request_headers": "<pre class=sf-dump id=sf-dump-310267088 data-indent-pad=\"  \"><span class=sf-dump-note>array:10<\/span> [<samp>\n  \"<span class=sf-dump-key>host<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"14 characters\">newampleev.com<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>connection<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"10 characters\">keep-alive<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>cache-control<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"9 characters\">max-age=0<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>upgrade-insecure-requests<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str>1<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>user-agent<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"120 characters\">Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/79.0.3945.88 Safari\/537.36<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>accept<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"124 characters\">text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,image\/apng,*\/*;q=0.8,application\/signed-exchange;v=b3;q=0.9<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>referer<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"26 characters\">http:\/\/newampleev.com\/blog<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>accept-encoding<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"13 characters\">gzip, deflate<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>accept-language<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"35 characters\">ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>cookie<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"1048 characters\">_ga=GA1.2.888310258.1575189780; _gid=GA1.2.2143073912.1576426138; remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d=eyJpdiI6InZQYWlrQ0pRdlVlMHB4cTYzK3djcGc9PSIsInZhbHVlIjoieEwzSlwvNW9nSG5lenJzN211VG5QSWo1Q3JzS3hxb3R4YVVHejJHR2gxR0xiS1ZObjV1QkNvRHp2TkM4ZUtDckFleDMxa0ZXKzcxTGpvOStpTzBkbUsyUUVXZFlvdnluVm4yRzBhbWh3amFPU3dHWFZZQ3dtTEN1R2dCbjZvODM0ZUVwVk50UnhIRm1DSXRrdGxnY1wvTmN0eXJ0MVpxSERjRFZtXC8zS2tkaGJFPSIsIm1hYyI6IjE0NjU3NmZkYjJhMTdhZTFjOGNkNTVkYWI1ZGUwNTcyOWZmNDEyMDljZGEwNzg1ZmM0ZmFkYjllYThiZmIwZjQifQ%3D%3D; XSRF-TOKEN=eyJpdiI6InhkVjFEcFwvNHZVNzhWSnNSdlY4T1d3PT0iLCJ2YWx1ZSI6IkNYNWlUN1pjRVI5Tk12N2NzVjBLbFNFWTNHUmpDaFdmaFJpZTk3MUtQdTNXWDREXC9Ea1lQS3BiUVIwazd5XC9zUiIsIm1hYyI6IjRlYmFjMDBkM2ZlODJiYzY4NGZkNzAxNjdhNTU3M2NkY2JkOGYxNjJmOTgxYmUxYTkzZTFlODVkZjkxNzRhOGEifQ%3D%3D; newampleev_session=eyJpdiI6IlFRSWN1blZXS2hQZklxb0E2dXcxS0E9PSIsInZhbHVlIjoiVW5EbjRQYUtHZ1g1QTBKbWhNZHRBWFFXN2VWZGtibUs2S3c4emFkaDBOTm16T2xsSG9cL1lWcTVZdUtqWXdqYVkiLCJtYWMiOiI4YjFiNTg4NzVmYTk0ZTc3N2E4NWNkYzI1ODE4ZjEwYmE1YTBkNTc1OTc4YzI2MzY0MTRiMDM2MDQ1YzkxZmYwIn0%3D<\/span>\"\n  <\/samp>]\n<\/samp>]\n<\/pre><script>Sfdump(\"sf-dump-310267088\", {\"maxDepth\":0})<\/script>\n",
                        "request_server": "<pre class=sf-dump id=sf-dump-794547245 data-indent-pad=\"  \"><span class=sf-dump-note>array:38<\/span> [<samp>\n  \"<span class=sf-dump-key>REDIRECT_UNIQUE_ID<\/span>\" => \"<span class=sf-dump-str title=\"27 characters\">XfuCVVyofaGX2WWh4PvOtgAAAAQ<\/span>\"\n  \"<span class=sf-dump-key>REDIRECT_STATUS<\/span>\" => \"<span class=sf-dump-str title=\"3 characters\">200<\/span>\"\n  \"<span class=sf-dump-key>UNIQUE_ID<\/span>\" => \"<span class=sf-dump-str title=\"27 characters\">XfuCVVyofaGX2WWh4PvOtgAAAAQ<\/span>\"\n  \"<span class=sf-dump-key>HTTP_HOST<\/span>\" => \"<span class=sf-dump-str title=\"14 characters\">newampleev.com<\/span>\"\n  \"<span class=sf-dump-key>HTTP_CONNECTION<\/span>\" => \"<span class=sf-dump-str title=\"10 characters\">keep-alive<\/span>\"\n  \"<span class=sf-dump-key>HTTP_CACHE_CONTROL<\/span>\" => \"<span class=sf-dump-str title=\"9 characters\">max-age=0<\/span>\"\n  \"<span class=sf-dump-key>HTTP_UPGRADE_INSECURE_REQUESTS<\/span>\" => \"<span class=sf-dump-str>1<\/span>\"\n  \"<span class=sf-dump-key>HTTP_USER_AGENT<\/span>\" => \"<span class=sf-dump-str title=\"120 characters\">Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/79.0.3945.88 Safari\/537.36<\/span>\"\n  \"<span class=sf-dump-key>HTTP_ACCEPT<\/span>\" => \"<span class=sf-dump-str title=\"124 characters\">text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,image\/apng,*\/*;q=0.8,application\/signed-exchange;v=b3;q=0.9<\/span>\"\n  \"<span class=sf-dump-key>HTTP_REFERER<\/span>\" => \"<span class=sf-dump-str title=\"26 characters\">http:\/\/newampleev.com\/blog<\/span>\"\n  \"<span class=sf-dump-key>HTTP_ACCEPT_ENCODING<\/span>\" => \"<span class=sf-dump-str title=\"13 characters\">gzip, deflate<\/span>\"\n  \"<span class=sf-dump-key>HTTP_ACCEPT_LANGUAGE<\/span>\" => \"<span class=sf-dump-str title=\"35 characters\">ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7<\/span>\"\n  \"<span class=sf-dump-key>HTTP_COOKIE<\/span>\" => \"<span class=sf-dump-str title=\"1048 characters\">_ga=GA1.2.888310258.1575189780; _gid=GA1.2.2143073912.1576426138; remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d=eyJpdiI6InZQYWlrQ0pRdlVlMHB4cTYzK3djcGc9PSIsInZhbHVlIjoieEwzSlwvNW9nSG5lenJzN211VG5QSWo1Q3JzS3hxb3R4YVVHejJHR2gxR0xiS1ZObjV1QkNvRHp2TkM4ZUtDckFleDMxa0ZXKzcxTGpvOStpTzBkbUsyUUVXZFlvdnluVm4yRzBhbWh3amFPU3dHWFZZQ3dtTEN1R2dCbjZvODM0ZUVwVk50UnhIRm1DSXRrdGxnY1wvTmN0eXJ0MVpxSERjRFZtXC8zS2tkaGJFPSIsIm1hYyI6IjE0NjU3NmZkYjJhMTdhZTFjOGNkNTVkYWI1ZGUwNTcyOWZmNDEyMDljZGEwNzg1ZmM0ZmFkYjllYThiZmIwZjQifQ%3D%3D; XSRF-TOKEN=eyJpdiI6InhkVjFEcFwvNHZVNzhWSnNSdlY4T1d3PT0iLCJ2YWx1ZSI6IkNYNWlUN1pjRVI5Tk12N2NzVjBLbFNFWTNHUmpDaFdmaFJpZTk3MUtQdTNXWDREXC9Ea1lQS3BiUVIwazd5XC9zUiIsIm1hYyI6IjRlYmFjMDBkM2ZlODJiYzY4NGZkNzAxNjdhNTU3M2NkY2JkOGYxNjJmOTgxYmUxYTkzZTFlODVkZjkxNzRhOGEifQ%3D%3D; newampleev_session=eyJpdiI6IlFRSWN1blZXS2hQZklxb0E2dXcxS0E9PSIsInZhbHVlIjoiVW5EbjRQYUtHZ1g1QTBKbWhNZHRBWFFXN2VWZGtibUs2S3c4emFkaDBOTm16T2xsSG9cL1lWcTVZdUtqWXdqYVkiLCJtYWMiOiI4YjFiNTg4NzVmYTk0ZTc3N2E4NWNkYzI1ODE4ZjEwYmE1YTBkNTc1OTc4YzI2MzY0MTRiMDM2MDQ1YzkxZmYwIn0%3D<\/span>\"\n  \"<span class=sf-dump-key>PATH<\/span>\" => \"<span class=sf-dump-str title=\"29 characters\">\/usr\/bin:\/bin:\/usr\/sbin:\/sbin<\/span>\"\n  \"<span class=sf-dump-key>DYLD_LIBRARY_PATH<\/span>\" => \"<span class=sf-dump-str title=\"34 characters\">\/Applications\/XAMPP\/xamppfiles\/lib<\/span>\"\n  \"<span class=sf-dump-key>SERVER_SIGNATURE<\/span>\" => \"\"\n  \"<span class=sf-dump-key>SERVER_SOFTWARE<\/span>\" => \"<span class=sf-dump-str title=\"78 characters\">Apache\/2.4.41 (Unix) OpenSSL\/1.1.1d PHP\/7.1.32 mod_perl\/2.0.8-dev Perl\/v5.16.3<\/span>\"\n  \"<span class=sf-dump-key>SERVER_NAME<\/span>\" => \"<span class=sf-dump-str title=\"14 characters\">newampleev.com<\/span>\"\n  \"<span class=sf-dump-key>SERVER_ADDR<\/span>\" => \"<span class=sf-dump-str title=\"9 characters\">127.0.0.1<\/span>\"\n  \"<span class=sf-dump-key>SERVER_PORT<\/span>\" => \"<span class=sf-dump-str title=\"2 characters\">80<\/span>\"\n  \"<span class=sf-dump-key>REMOTE_ADDR<\/span>\" => \"<span class=sf-dump-str title=\"9 characters\">127.0.0.1<\/span>\"\n  \"<span class=sf-dump-key>DOCUMENT_ROOT<\/span>\" => \"<span class=sf-dump-str title=\"65 characters\">\/Applications\/XAMPP\/xamppfiles\/htdocs\/new_ampleev.com\/blog\/public<\/span>\"\n  \"<span class=sf-dump-key>REQUEST_SCHEME<\/span>\" => \"<span class=sf-dump-str title=\"4 characters\">http<\/span>\"\n  \"<span class=sf-dump-key>CONTEXT_PREFIX<\/span>\" => \"\"\n  \"<span class=sf-dump-key>CONTEXT_DOCUMENT_ROOT<\/span>\" => \"<span class=sf-dump-str title=\"65 characters\">\/Applications\/XAMPP\/xamppfiles\/htdocs\/new_ampleev.com\/blog\/public<\/span>\"\n  \"<span class=sf-dump-key>SERVER_ADMIN<\/span>\" => \"<span class=sf-dump-str title=\"15 characters\">you@example.com<\/span>\"\n  \"<span class=sf-dump-key>SCRIPT_FILENAME<\/span>\" => \"<span class=sf-dump-str title=\"75 characters\">\/Applications\/XAMPP\/xamppfiles\/htdocs\/new_ampleev.com\/blog\/public\/index.php<\/span>\"\n  \"<span class=sf-dump-key>REMOTE_PORT<\/span>\" => \"<span class=sf-dump-str title=\"5 characters\">58127<\/span>\"\n  \"<span class=sf-dump-key>REDIRECT_URL<\/span>\" => \"<span class=sf-dump-str title=\"10 characters\">\/article-1<\/span>\"\n  \"<span class=sf-dump-key>GATEWAY_INTERFACE<\/span>\" => \"<span class=sf-dump-str title=\"7 characters\">CGI\/1.1<\/span>\"\n  \"<span class=sf-dump-key>SERVER_PROTOCOL<\/span>\" => \"<span class=sf-dump-str title=\"8 characters\">HTTP\/1.1<\/span>\"\n  \"<span class=sf-dump-key>REQUEST_METHOD<\/span>\" => \"<span class=sf-dump-str title=\"3 characters\">GET<\/span>\"\n  \"<span class=sf-dump-key>QUERY_STRING<\/span>\" => \"\"\n  \"<span class=sf-dump-key>REQUEST_URI<\/span>\" => \"<span class=sf-dump-str title=\"10 characters\">\/article-1<\/span>\"\n  \"<span class=sf-dump-key>SCRIPT_NAME<\/span>\" => \"<span class=sf-dump-str title=\"10 characters\">\/index.php<\/span>\"\n  \"<span class=sf-dump-key>PHP_SELF<\/span>\" => \"<span class=sf-dump-str title=\"10 characters\">\/index.php<\/span>\"\n  \"<span class=sf-dump-key>REQUEST_TIME_FLOAT<\/span>\" => <span class=sf-dump-num>1576763989.213<\/span>\n  \"<span class=sf-dump-key>REQUEST_TIME<\/span>\" => <span class=sf-dump-num>1576763989<\/span>\n<\/samp>]\n<\/pre><script>Sfdump(\"sf-dump-794547245\", {\"maxDepth\":0})<\/script>\n",
                        "request_cookies": "<pre class=sf-dump id=sf-dump-577325144 data-indent-pad=\"  \"><span class=sf-dump-note>array:5<\/span> [<samp>\n  \"<span class=sf-dump-key>_ga<\/span>\" => <span class=sf-dump-const>null<\/span>\n  \"<span class=sf-dump-key>_gid<\/span>\" => <span class=sf-dump-const>null<\/span>\n  \"<span class=sf-dump-key>remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d<\/span>\" => \"<span class=sf-dump-str title=\"123 characters\">1|uUvCeCVCBxaio9WBnXfIADyFLfaHbk24efcyq13mkuPT0xfTZbwEwyVBRN3Z|$2y$10$0jWFT7XZ6Y2tHNO5LXk8CufAg4mlq0emEGTQ8gigc5rsp4r97vwVi<\/span>\"\n  \"<span class=sf-dump-key>XSRF-TOKEN<\/span>\" => \"<span class=sf-dump-str title=\"40 characters\">BUH5xFouPlIQzeROqXClWpmRm5bkwwrKfS78ORks<\/span>\"\n  \"<span class=sf-dump-key>newampleev_session<\/span>\" => \"<span class=sf-dump-str title=\"40 characters\">OMRqHiVxcJELbVsWSiIgJ9ZB6asXiglf0CTXthbU<\/span>\"\n<\/samp>]\n<\/pre><script>Sfdump(\"sf-dump-577325144\", {\"maxDepth\":0})<\/script>\n",
                        "response_headers": "<pre class=sf-dump id=sf-dump-844122570 data-indent-pad=\"  \"><span class=sf-dump-note>array:5<\/span> [<samp>\n  \"<span class=sf-dump-key>cache-control<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"17 characters\">no-cache, private<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>date<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"29 characters\">Thu, 19 Dec 2019 13:59:49 GMT<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>content-type<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"24 characters\">text\/html; charset=UTF-8<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>set-cookie<\/span>\" => <span class=sf-dump-note>array:2<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"320 characters\">XSRF-TOKEN=eyJpdiI6IlpycDl0MmhWVmhxOXdyV2dWS3BXU0E9PSIsInZhbHVlIjoiWWRGQ0REWkhCN296NkhoNWU4S0RKY3dveDExaEw5aFhqbytmSmh3MzdETHZQTUlaWUlKeTQwSVpjU3FycUEwaiIsIm1hYyI6IjBjYzc4ZTM0M2Y3MjAyNDExMjExZDMzYjA1YzQ4YjQzOGQyZjU1ZTRlNTYxZGY1ODBhZWMxOWZkZjk2YjE2N2MifQ%3D%3D; expires=Thu, 19-Dec-2019 15:59:49 GMT; Max-Age=7200; path=\/<\/span>\"\n    <span class=sf-dump-index>1<\/span> => \"<span class=sf-dump-str title=\"338 characters\">newampleev_session=eyJpdiI6Imx4ZzZBcW9SZzdGck5wbjdlWk96bkE9PSIsInZhbHVlIjoibzJQTkUrMm1KaHd0Rm9xUjdNcjZBckFXWlVUUVoyZHh5N2FHYkZEbUE1VzNyNkxLM0dJYmlFV0RCMVdxUENLNyIsIm1hYyI6IjVjYzRmNGQxMjA2M2EzY2M5NzNkYmZkNTY0NzE5ZTI5MmM2M2Y1NmNlYjMyNDUyOWY5Mjc1MjM1YzIwOTNiODYifQ%3D%3D; expires=Thu, 19-Dec-2019 15:59:49 GMT; Max-Age=7200; path=\/; httponly<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>Set-Cookie<\/span>\" => <span class=sf-dump-note>array:2<\/span> [<samp>\n    <span class=sf-dump-index>0<\/span> => \"<span class=sf-dump-str title=\"306 characters\">XSRF-TOKEN=eyJpdiI6IlpycDl0MmhWVmhxOXdyV2dWS3BXU0E9PSIsInZhbHVlIjoiWWRGQ0REWkhCN296NkhoNWU4S0RKY3dveDExaEw5aFhqbytmSmh3MzdETHZQTUlaWUlKeTQwSVpjU3FycUEwaiIsIm1hYyI6IjBjYzc4ZTM0M2Y3MjAyNDExMjExZDMzYjA1YzQ4YjQzOGQyZjU1ZTRlNTYxZGY1ODBhZWMxOWZkZjk2YjE2N2MifQ%3D%3D; expires=Thu, 19-Dec-2019 15:59:49 GMT; path=\/<\/span>\"\n    <span class=sf-dump-index>1<\/span> => \"<span class=sf-dump-str title=\"324 characters\">newampleev_session=eyJpdiI6Imx4ZzZBcW9SZzdGck5wbjdlWk96bkE9PSIsInZhbHVlIjoibzJQTkUrMm1KaHd0Rm9xUjdNcjZBckFXWlVUUVoyZHh5N2FHYkZEbUE1VzNyNkxLM0dJYmlFV0RCMVdxUENLNyIsIm1hYyI6IjVjYzRmNGQxMjA2M2EzY2M5NzNkYmZkNTY0NzE5ZTI5MmM2M2Y1NmNlYjMyNDUyOWY5Mjc1MjM1YzIwOTNiODYifQ%3D%3D; expires=Thu, 19-Dec-2019 15:59:49 GMT; path=\/; httponly<\/span>\"\n  <\/samp>]\n<\/samp>]\n<\/pre><script>Sfdump(\"sf-dump-844122570\", {\"maxDepth\":0})<\/script>\n",
                        "session_attributes": "<pre class=sf-dump id=sf-dump-372588224 data-indent-pad=\"  \"><span class=sf-dump-note>array:5<\/span> [<samp>\n  \"<span class=sf-dump-key>_token<\/span>\" => \"<span class=sf-dump-str title=\"40 characters\">BUH5xFouPlIQzeROqXClWpmRm5bkwwrKfS78ORks<\/span>\"\n  \"<span class=sf-dump-key>_previous<\/span>\" => <span class=sf-dump-note>array:1<\/span> [<samp>\n    \"<span class=sf-dump-key>url<\/span>\" => \"<span class=sf-dump-str title=\"31 characters\">http:\/\/newampleev.com\/article-1<\/span>\"\n  <\/samp>]\n  \"<span class=sf-dump-key>_flash<\/span>\" => <span class=sf-dump-note>array:2<\/span> [<samp>\n    \"<span class=sf-dump-key>old<\/span>\" => []\n    \"<span class=sf-dump-key>new<\/span>\" => []\n  <\/samp>]\n  \"<span class=sf-dump-key>login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d<\/span>\" => <span class=sf-dump-num>1<\/span>\n  \"<span class=sf-dump-key>PHPDEBUGBAR_STACK_DATA<\/span>\" => []\n<\/samp>]\n<\/pre><script>Sfdump(\"sf-dump-372588224\", {\"maxDepth\":0})<\/script>\n"
                    }
                }, "Xc22b4e9780c38ca7c23cf2f3f879d5cc");

            </script>
            <script src="assets/js/prism.js" data-manual></script>
</body>
</html>
