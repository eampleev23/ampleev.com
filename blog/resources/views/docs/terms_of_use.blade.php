@php
    use App\Support\SiteLocale;

    $currentLocale = $site_locale ?? 'ru';
    $termsRoute = SiteLocale::routeNameForLocale('docs.terms_of_use', $currentLocale);
    $termsRuUrl = route('docs.terms_of_use');
    $termsEnUrl = route('en.docs.terms_of_use');
    $locale_switch_urls = [
        'ru' => $termsRuUrl,
        'en' => $termsEnUrl,
    ];

    $copy = $currentLocale === 'en'
        ? [
            'title' => 'Terms of Use and Privacy Policy',
            'description' => 'Terms of use and privacy policy for the personal website and blog of Evgeny Ampleev.',
            'sidebar_title' => 'Terms of Use and Privacy Policy',
            'page_title' => 'Terms of Use',
            'anchors' => [
                'general' => 'General Terms',
                'obligations' => 'User Obligations',
                'privacy' => 'Privacy Policy',
                'other' => 'Other Terms',
            ],
            'section_1' => '1. General Terms',
            'section_2' => '2. User Obligations',
            'section_3' => '3. Privacy Policy',
            'section_4' => '4. Other Terms',
            'preamble' => 'This Agreement constitutes a public offer and sets out the terms governing the use of the materials and services published on the website available at https://ampleev.com by visitors and users of this website (the “Website”).',
            'general' => [
                '1.1. The use of the Website materials and services is governed by the applicable laws of the Russian Federation.',
                '1.2. The User may use the Website materials and services in any manner permitted by the applicable laws of the Russian Federation.',
                '1.3. By obtaining access to the Website materials and using the Website services, the User unconditionally accepts this Agreement and the terms for processing personal information described herein. If the User does not agree with these terms, they must refrain from using the Website services.',
            ],
            'obligations' => [
                '2.1. The User agrees not to take any actions or leave any comments or posts that may be regarded as violating Russian law or the rules of international law, including in the area of intellectual property, copyright and related rights, generally accepted standards of morality and ethics, or any actions that may disrupt or potentially disrupt the normal operation of the Website and its services.',
                '2.2. The use of Website materials without the consent of the rights holders is not permitted.',
                '2.3. When quoting Website materials, including copyrighted works, a reference to the Website is mandatory.',
                '2.4. The Website Administration is not responsible for visiting or using external resources that may be linked from the Website.',
                '2.5. The Website Administration bears no responsibility and assumes no direct or indirect obligations to the User in connection with any possible or actual losses or damages related to any Website content, copyright registration, goods or services available on or obtained through external websites or resources, or any other contacts entered into by the User through information published on the Website or links to external resources.',
                '2.6. The User agrees that the Website Administration bears no responsibility and assumes no obligations in connection with advertising that may be placed on the Website.',
            ],
            'privacy_intro' => '3.1. For the purposes of this Agreement, the User’s personal information includes:',
            'privacy_points' => [
                '3.1.1. Personal information that the User provides about themselves when registering (creating an account) or while using the Services, including personal data. Information required for the provision of the Services is marked accordingly. Other information is provided by the User at their own discretion.',
                '3.1.2. Data that is automatically transmitted to the Website services in the course of their use through software installed on the User’s device, including the IP address, cookie data, information about the User’s browser (or other application used to access the services), technical characteristics of the hardware and software used by the User, the date and time of access to the services, requested page addresses, and other similar information.',
            ],
            'privacy' => [
                '3.2. The Website collects and stores only the personal information that is necessary to provide the Website services or fulfil this Agreement, except where mandatory retention of personal information is required by law for a specific period.',
                '3.3. The Website processes the User’s personal information for the following purposes:',
            ],
            'privacy_purposes' => [
                '3.3.1. Identifying a User registered on the Website for the purpose of subsequently entering into an agreement for the provision of services described on the Website.',
                '3.3.2. Maintaining feedback with the User, including sending notifications, requests related to the use of the Website, provision of services, and processing requests and applications from the User.',
                '3.3.3. Determining the User’s location in order to ensure security and prevent fraud.',
                '3.3.4. Creating the User’s account.',
                '3.3.5. Providing the User with effective customer and technical support when issues arise in connection with the use of the Website.',
                '3.3.6. Carrying out promotional and advertising activities.',
            ],
            'privacy_more' => [
                '3.4. The Website stores Users’ personal information in accordance with the internal regulations of the relevant services.',
                '3.5. The confidentiality of the User’s personal information is preserved, except when the User voluntarily provides information about themselves for public access to an unlimited number of persons. When using certain services, the User agrees that a certain part of their personal information may become publicly available.',
                '3.6. The processing of the User’s personal data is carried out without time limitation by any lawful means, including in personal data information systems using automation tools or without such tools. The processing of Users’ personal data is carried out in accordance with Federal Law No. 152-FZ dated 27 July 2006 “On Personal Data”.',
                '3.7. The Website Administration takes the necessary organizational and technical measures to protect the User’s personal information from unlawful or accidental access, destruction, alteration, blocking, copying, distribution, and from other unlawful actions of third parties.',
                '3.8. The User grants the Website Administration the right to mention cooperation with the User, the services provided to the User, and to use fragments of the results of such services and the User’s name (or company name) in the Website Administration’s portfolio, including for promotional purposes.',
            ],
            'other' => [
                '4.1. Any possible disputes arising out of or in connection with this Agreement shall be resolved in accordance with the applicable laws of the Russian Federation.',
                '4.2. If any provision or condition of this Agreement is recognized by a court of competent jurisdiction as invalid, unenforceable, or void, the remaining provisions shall remain in full force and effect, and the invalid provision shall be replaced by a valid one that is as close as possible in substance and intent to the original.',
                '4.3. Failure by the Website Administration to take action in the event of a violation of this Agreement by any User does not deprive the Website Administration of the right to take appropriate action later in order to protect its interests and the copyright in the Website materials protected under applicable law.',
                '4.4. The Website Administration may amend the terms of this Agreement unilaterally at any time. Such changes become effective on the day the new version of the Agreement is published on the Website. If the User disagrees with the changes, they must stop accessing the Website and stop using the Website materials and services.',
            ],
            'meta_robots' => '',
        ]
        : [
            'title' => 'Пользовательское соглашение и Политика конфиденциальности',
            'description' => 'На данной странице описано пользовательское соглашение и Политика конфиденциальности персонального блога Скрам Мастера и Веб Разработчика Амплеева Е. М.',
            'sidebar_title' => 'Пользовательское соглашение и Политика конфиденциальности',
            'page_title' => 'Пользовательское соглашение',
            'anchors' => [
                'general' => 'Общие условия',
                'obligations' => 'Обязательства Пользователя',
                'privacy' => 'Политика конфиденциальности',
                'other' => 'Прочие условия',
            ],
            'section_1' => '1. Общие условия',
            'section_2' => '2. Обязательства Пользователя',
            'section_3' => '3. Политика конфиденциальности',
            'section_4' => '4. Прочие условия',
            'preamble' => 'Настоящее Соглашение является публичной офертой и определяет условия использования материалов и сервисов, размещенных на сайте в сети Интернет по адресу: https://ampleev.com, посетителями и пользователями данного интернет-сайта (далее — Сайт).',
            'general' => [
                '1.1. Использование материалов и сервисов Сайта регулируется нормами действующего законодательства Российской Федерации.',
                '1.2. Пользователь вправе использовать материалы Сайта и предоставляемые на Сайте сервисы любым способом, допустимым нормами действующего законодательства Российской Федерации.',
                '1.3. Получение доступа к материалам Сайта и использование сервисов Сайта означает безоговорочное согласие Пользователя с настоящим Соглашением и указанными в нем условиями обработки персональной информации; в случае несогласия с этими условиями Пользователь должен воздержаться от использования сервисов Сайта.',
            ],
            'obligations' => [
                '2.1. Пользователь соглашается не предпринимать действий и не оставлять комментарии и записи, которые могут рассматриваться как нарушающие российское законодательство или нормы международного права, в том числе в сфере интеллектуальной собственности, авторских и/или смежных прав, общепринятые нормы морали и нравственности, а также любых действий, которые приводят или могут привести к нарушению нормальной работы Сайта и сервисов Сайта.',
                '2.2. Использование материалов Сайта без согласия правообладателей не допускается.',
                '2.3. При цитировании материалов Сайта, включая охраняемые авторские произведения, ссылка на Сайт обязательна.',
                '2.4. Администрация Сайта не несет ответственности за посещение и использование Пользователем внешних ресурсов, ссылки на которые могут содержаться на Сайте.',
                '2.5. Администрация Сайта не несет ответственности и не имеет прямых или косвенных обязательств перед Пользователем в связи с любыми возможными или возникшими потерями или убытками, связанными с любым содержанием Сайта, регистрацией авторских прав и сведениями о такой регистрации, товарами или услугами, доступными на или полученными через внешние сайты или ресурсы либо иные контакты Пользователя, в которые он вступил, используя размещенную на Сайте информацию или ссылки на внешние ресурсы.',
                '2.6. Пользователь согласен с тем, что Администрация Сайта не несет какой-либо ответственности и не имеет каких-либо обязательств в связи с рекламой, которая может быть размещена на Сайте.',
            ],
            'privacy_intro' => '3.1. В рамках настоящего Соглашения под персональной информацией Пользователя понимаются:',
            'privacy_points' => [
                '3.1.1. Персональная информация, которую Пользователь предоставляет о себе самостоятельно при регистрации (создании учетной записи) или в процессе использования Сервисов, включая персональные данные Пользователя. Обязательная для предоставления Сервисов информация помечена специальным образом. Иная информация предоставляется Пользователем на его усмотрение.',
                '3.1.2. Данные, которые автоматически передаются сервисам Сайта в процессе их использования с помощью установленного на устройстве Пользователя программного обеспечения, в том числе IP-адрес, данные файлов cookie, информация о браузере Пользователя (или иной программе, с помощью которой осуществляется доступ к сервисам), технические характеристики оборудования и программного обеспечения, используемых Пользователем, дата и время доступа к сервисам, адреса запрашиваемых страниц и иная подобная информация.',
            ],
            'privacy' => [
                '3.2. Сайт собирает и хранит только ту персональную информацию, которая необходима для предоставления сервисов Сайта или исполнения настоящего Соглашения, за исключением случаев, когда законодательством предусмотрено обязательное хранение персональной информации в течение определенного законом срока.',
                '3.3. Персональную информацию Пользователя Сайт обрабатывает в следующих целях:',
            ],
            'privacy_purposes' => [
                '3.3.1. Идентификации Пользователя, зарегистрированного на Сайте для дальнейшего заключения договора на предоставление услуг, указанных на Сайте.',
                '3.3.2. Установления с Пользователем обратной связи, включая направление уведомлений, запросов, касающихся использования Сайта, оказания услуг, обработку запросов и заявок от Пользователя.',
                '3.3.3. Определения места нахождения Пользователя для обеспечения безопасности, предотвращения мошенничества.',
                '3.3.4. Создания учетной записи Пользователя.',
                '3.3.5. Предоставления Пользователю эффективной клиентской и технической поддержки при возникновении проблем, связанных с использованием Сайта.',
                '3.3.6. Осуществления рекламной деятельности.',
            ],
            'privacy_more' => [
                '3.4. Сайт хранит персональную информацию Пользователей в соответствии с внутренними регламентами конкретных сервисов.',
                '3.5. В отношении персональной информации Пользователя сохраняется ее конфиденциальность, кроме случаев добровольного предоставления Пользователем информации о себе для общего доступа неограниченному кругу лиц. При использовании отдельных сервисов Пользователь соглашается с тем, что определенная часть его персональной информации становится общедоступной.',
                '3.6. Обработка персональных данных Пользователя осуществляется без ограничения срока любым законным способом, в том числе в информационных системах персональных данных с использованием средств автоматизации или без использования таких средств. Обработка персональных данных Пользователей осуществляется в соответствии с Федеральным законом от 27.07.2006 N 152-ФЗ «О персональных данных».',
                '3.7. Администрация Сайта принимает необходимые организационные и технические меры для защиты персональной информации Пользователя от неправомерного или случайного доступа, уничтожения, изменения, блокирования, копирования, распространения, а также от иных неправомерных действий третьих лиц.',
                '3.8. Пользователь предоставляет Администрации Сайта право упоминания о сотрудничестве с Пользователем, оказанных Пользователю услугах, использования фрагментов результата таких услуг и имени (наименования) Пользователя для указания в портфолио Администрации Сайта (в том числе в рекламных целях).',
            ],
            'other' => [
                '4.1. Все возможные споры, вытекающие из настоящего Соглашения или связанные с ним, подлежат разрешению в соответствии с действующим законодательством Российской Федерации.',
                '4.2. В случае признания какого-либо положения или условия настоящего Соглашения недействительным, лишенным юридической силы или ничтожным судом соответствующей юрисдикции остальные положения настоящего Договора сохраняют свою силу и продолжают действовать без изменений, в то время как положение, признанное ничтожным в силу применимого закона, заменяется действительным, то есть максимально близким относительно предыдущего по своей сути и значению.',
                '4.3. Бездействие со стороны Администрации Сайта в случае нарушения кем-либо из Пользователей положений Соглашения не лишает Администрацию Сайта права предпринять позднее соответствующие действия в защиту своих интересов и защиту авторских прав на охраняемые в соответствии с законодательством материалы Сайта.',
                '4.4. Администрация Сайта вправе в любое время в одностороннем порядке изменять условия настоящего Соглашения. Такие изменения вступают в силу по истечении в день размещения новой версии Соглашения на сайте. При несогласии Пользователя с внесенными изменениями он обязан отказаться от доступа к Сайту, прекратить использование материалов и сервисов Сайта.',
            ],
            'meta_robots' => '',
        ];
@endphp

@extends('layouts.app')

@section('title', $copy['title'])
@section('description', $copy['description'])
@section('page_url', route($termsRoute))
@section('canonical_url', route($termsRoute))
@section('alternate_url_ru', $termsRuUrl)
@section('alternate_url_en', $termsEnUrl)
@section('x_default_url', $termsEnUrl)
@section('meta_robots', $copy['meta_robots'])

@section('sidebar')
    @parent
    <link href="{{ asset('assets/css/custom.css') }}?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')
    @include('layouts.navbar_white')

    <section class="container-fluid py-0">
        <div class="row">
            <div class="col-12 col-md-3 col-lg-2 border-right pt-3 pt-md-5 docs-sidebar">
                <div id="docs-index" class="collapse">
                    <div class="mb-3 mb-md-4">
                        <h6 class="mb-2">{{ $copy['sidebar_title'] }}</h6>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link px-0" href="#general-terms">{{ $copy['anchors']['general'] }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-0" href="#user-obligations">{{ $copy['anchors']['obligations'] }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-0" href="#privacy-policy">{{ $copy['anchors']['privacy'] }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-0" href="#other-terms">{{ $copy['anchors']['other'] }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 col-lg-10">
                <div class="row">
                    <div class="col-xl-10 col-lg-9 px-xl-6 px-lg-4 px-md-3 py-md-5">
                        <div class="card card-body card-lg shadow-3d rounded-sm mb-4 mb-md-5">
                            <h1>{{ $copy['page_title'] }}</h1>
                            <div class="lead">
                                <p>{{ $copy['preamble'] }}</p>
                            </div>
                        </div>

                        <article id="general-terms" class="mb-4 mb-md-6">
                            <h3><p>{{ $copy['section_1'] }}</p></h3>
                            <div>
                                @foreach($copy['general'] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            </div>
                        </article>

                        <article id="user-obligations" class="mb-4 mb-md-6">
                            <h3><p>{{ $copy['section_2'] }}</p></h3>
                            <div>
                                @foreach($copy['obligations'] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            </div>
                        </article>

                        <article id="privacy-policy" class="mb-4 mb-md-6">
                            <h3><p>{{ $copy['section_3'] }}</p></h3>
                            <div>
                                <p>{{ $copy['privacy_intro'] }}</p>
                                @foreach($copy['privacy_points'] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach

                                @foreach($copy['privacy'] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach

                                @foreach($copy['privacy_purposes'] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach

                                @foreach($copy['privacy_more'] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            </div>
                        </article>

                        <article id="other-terms" class="mb-4 mb-md-6">
                            <h3><p>{{ $copy['section_4'] }}</p></h3>
                            <div>
                                @foreach($copy['other'] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
