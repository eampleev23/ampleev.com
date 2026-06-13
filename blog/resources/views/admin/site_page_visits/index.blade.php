@extends('layouts.app')

@section('title', 'Просмотры страниц')

@section('content')
    <section class="bg-primary-alt header-inner o-hidden">
        <div class="container">
            <div class="row my-4">
                <div class="col">
                    <h1>Просмотры страниц</h1>
                    <p class="lead mb-0">Собственный first-party трекинг публичных страниц сайта.</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            @include('admin.partials.nav')

            <form method="get" action="{{ route('admin.site_page_visits.index') }}" class="card card-body mb-4">
                <div class="form-row align-items-end">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="period">Период</label>
                        <select id="period" name="period" class="form-control">
                            @foreach($periods as $key => $label)
                                <option value="{{ $key }}" @selected($period === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="include_admin" name="include_admin" value="1" @checked($includeAdmin)>
                            <label class="custom-control-label" for="include_admin">Показывать события авторизованного админа</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="include_owner" name="include_owner" value="1" @checked($includeOwner)>
                            <label class="custom-control-label" for="include_owner">Показывать мои устройства</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">Показать</button>
                    </div>
                </div>
            </form>

            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card card-body h-100">
                        <span class="text-muted">Pageviews</span>
                        <strong class="h3 mb-0">{{ $totals['page_views'] }}</strong>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body h-100">
                        <span class="text-muted">Visitors</span>
                        <strong class="h3 mb-0">{{ $totals['visitors'] }}</strong>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body h-100">
                        <span class="text-muted">Sessions</span>
                        <strong class="h3 mb-0">{{ $totals['sessions'] }}</strong>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body h-100">
                        <span class="text-muted">С атрибуцией</span>
                        <strong class="h3 mb-0">{{ $totals['attributed'] }}</strong>
                    </div>
                </div>
            </div>

            <h2 class="h3 mb-3">Страницы</h2>
            <div class="table-responsive mb-5">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>URL path</th>
                        <th>Views</th>
                        <th>Visitors</th>
                        <th>Sessions</th>
                        <th>Последний просмотр</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($pageRows as $row)
                        <tr>
                            <td class="text-break"><code>{{ $row->page_path ?: '—' }}</code></td>
                            <td>{{ $row->views_count }}</td>
                            <td>{{ $row->visitors_count }}</td>
                            <td>{{ $row->sessions_count }}</td>
                            <td>{{ $row->last_visit_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Просмотров пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <h2 class="h3 mb-3">Источники</h2>
            <div class="table-responsive mb-5">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Source</th>
                        <th>Medium</th>
                        <th>Views</th>
                        <th>Visitors</th>
                        <th>Последний просмотр</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($sourceRows as $row)
                        <tr>
                            <td><strong>{{ $row->attribution_source ?: '—' }}</strong></td>
                            <td>{{ $row->attribution_medium ?: '—' }}</td>
                            <td>{{ $row->views_count }}</td>
                            <td>{{ $row->visitors_count }}</td>
                            <td>{{ $row->last_visit_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Источников пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <h2 class="h3 mb-3">Устройства</h2>
            <div class="table-responsive mb-5">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Тип</th>
                        <th>ОС</th>
                        <th>Браузер</th>
                        <th>Views</th>
                        <th>Visitors</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($deviceRows as $row)
                        <tr>
                            <td>{{ $row->device_type ?: 'unknown' }}</td>
                            <td>{{ $row->platform_name ?: '—' }}</td>
                            <td>{{ $row->browser_name ?: '—' }}</td>
                            <td>{{ $row->views_count }}</td>
                            <td>{{ $row->visitors_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Данных по устройствам пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <h2 class="h3 mb-3">Последние события</h2>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Время</th>
                        <th>Страница</th>
                        <th>Источник</th>
                        <th>Visitor / Session</th>
                        <th>Я / Админ</th>
                        <th>Сеть</th>
                        <th>Устройство</th>
                        <th>Клиент</th>
                        <th>Referer</th>
                        <th>Payload</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($visits as $visit)
                        <tr>
                            <td>{{ $visit->created_at }}</td>
                            <td class="text-break">
                                <div><code>{{ $visit->page_path ?: '—' }}</code></div>
                                <div class="small text-muted">{{ $visit->page_title ?: '' }}</div>
                            </td>
                            <td>
                                <div><strong>{{ $visit->attribution_source ?: $visit->utm_source ?: '—' }}</strong></div>
                                <div>{{ $visit->attribution_medium ?: $visit->utm_medium ?: '—' }}</div>
                                <div class="small text-muted">{{ $visit->attribution_campaign ?: $visit->utm_campaign ?: '' }}</div>
                            </td>
                            <td class="text-break">
                                <div><strong>V:</strong> <code>{{ $visit->visitor_key ?: '—' }}</code></div>
                                <div><strong>S:</strong> <code>{{ $visit->session_key ?: '—' }}</code></div>
                            </td>
                            <td>
                                @if($visit->is_owner)
                                    <span class="badge badge-info">Я</span>
                                    <div class="small text-muted">{{ $visit->owner_device_label ?: 'owner' }}</div>
                                @endif
                                @if($visit->is_admin)
                                    <span class="badge badge-warning">Админ</span>
                                @endif
                                @if(!$visit->is_owner && !$visit->is_admin)
                                    <span class="badge badge-light">Нет</span>
                                @endif
                            </td>
                            <td class="text-break">
                                <div><strong>IP:</strong> <code>{{ $visit->ip_hash ? mb_substr($visit->ip_hash, 0, 12) . '…' : '—' }}</code></div>
                                <div>{{ $visit->ip_version ?: '—' }}</div>
                                <div>Encrypted: {{ $visit->ip_encrypted ? 'Да' : '—' }}</div>
                            </td>
                            <td>
                                <div class="text-muted small">Оценка из User-Agent</div>
                                <div><strong>{{ $visit->device_type ?: 'unknown' }}</strong></div>
                                <div>{{ $visit->device_name ?: '—' }}</div>
                                <div>{{ $visit->platform_name ?: '—' }} {{ $visit->platform_version }}</div>
                                <div>{{ $visit->browser_name ?: '—' }} {{ $visit->browser_version }}</div>
                                @if($visit->is_robot)
                                    <span class="badge badge-warning">Robot: {{ $visit->robot_name ?: 'unknown' }}</span>
                                @endif
                            </td>
                            <td>
                                <div><strong>Язык:</strong> {{ $visit->client_language ?: $visit->primary_language ?: '—' }}</div>
                                <div><strong>Таймзона:</strong> {{ $visit->client_timezone ?: '—' }}</div>
                                <div><strong>Экран:</strong> {{ $visit->client_screen_width ?: '—' }}×{{ $visit->client_screen_height ?: '—' }}</div>
                                <div><strong>Viewport:</strong> {{ $visit->client_viewport_width ?: '—' }}×{{ $visit->client_viewport_height ?: '—' }}</div>
                                <div><strong>Touch:</strong> {{ is_null($visit->client_touch_supported) ? '—' : ($visit->client_touch_supported ? 'Да' : 'Нет') }}</div>
                            </td>
                            <td class="text-break">{{ $visit->client_referrer ?: $visit->request_referer ?: '—' }}</td>
                            <td class="text-break">
                                <details>
                                    <summary>server</summary>
                                    <pre class="small mb-0">{{ $visit->server_payload ?: '—' }}</pre>
                                </details>
                                <details>
                                    <summary>client</summary>
                                    <pre class="small mb-0">{{ $visit->client_payload ?: '—' }}</pre>
                                </details>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">Событий пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $visits->links('pagination::bootstrap-4') }}
        </div>
    </section>
@endsection
