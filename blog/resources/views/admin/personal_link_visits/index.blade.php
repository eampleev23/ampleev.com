@extends('layouts.app')

@section('title', 'Короткие ссылки')

@section('content')
    <section class="bg-primary-alt header-inner o-hidden">
        <div class="container">
            <div class="row my-4">
                <div class="col">
                    <h1>Короткие ссылки</h1>
                    <p class="lead mb-0">Серверные переходы по ссылкам вида <code>/me/source</code>.</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            @include('admin.partials.nav')

            <form method="get" action="{{ route('admin.personal_link_visits.index') }}" class="card card-body mb-4">
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
                            <label class="custom-control-label" for="include_admin">Показывать переходы авторизованного админа</label>
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

            <div class="table-responsive mb-5">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Источник</th>
                        <th>Переходы</th>
                        <th>Уникальные IP-хеши</th>
                        <th>Обогащено JS</th>
                        <th>Роботы</th>
                        <th>Последний переход</th>
                        <th>Красивая ссылка</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($summaryRows as $row)
                        <tr>
                            <td><strong>{{ $row->source }}</strong></td>
                            <td>{{ $row->visits_count }}</td>
                            <td>{{ $row->unique_ips_count }}</td>
                            <td>{{ $row->enriched_count }}</td>
                            <td>{{ $row->robots_count }}</td>
                            <td>{{ $row->last_visit_at }}</td>
                            <td><code>https://ampleev.com/me/{{ $row->source }}</code></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Переходов за выбранный период пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <h2 class="h3 mb-3">Последние переходы</h2>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Время</th>
                        <th>Источник</th>
                        <th>Я / Админ</th>
                        <th>Пользователь</th>
                        <th>Сеть</th>
                        <th>Серверная оценка</th>
                        <th>Клиентские данные</th>
                        <th>Referer</th>
                        <th>User-Agent</th>
                        <th>Итоговый URL</th>
                        <th>Payload</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($visits as $visit)
                        <tr>
                            <td>{{ $visit->created_at }}</td>
                            <td><strong>{{ $visit->source }}</strong></td>
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
                            <td>
                                @if($visit->user)
                                    {{ $visit->user->name }}<br>
                                    <span class="text-muted">{{ $visit->user->email }}</span>
                                @else
                                    <span class="text-muted">Гость</span>
                                @endif
                            </td>
                            <td class="text-break">
                                <div><strong>IP-хеш:</strong> <code>{{ $visit->ip_hash ? mb_substr($visit->ip_hash, 0, 12) . '…' : '—' }}</code></div>
                                <div><strong>Версия:</strong> {{ $visit->ip_version ?: '—' }}</div>
                                <div><strong>Private/reserved:</strong> {{ is_null($visit->ip_is_private) ? '—' : ($visit->ip_is_private ? 'Да' : 'Нет') }}</div>
                                <div><strong>IP encrypted:</strong> {{ $visit->ip_encrypted ? 'Да' : '—' }}</div>
                                <div><strong>X-Forwarded:</strong> <code>{{ $visit->forwarded_for_hash ? mb_substr($visit->forwarded_for_hash, 0, 12) . '…' : '—' }}</code></div>
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
                                <div class="mt-2"><strong>Accept-Language:</strong> {{ $visit->primary_language ?: '—' }}</div>
                                <div class="text-break small">{{ $visit->accept_language ?: '' }}</div>
                            </td>
                            <td>
                                @if($visit->client_enriched_at)
                                    <div><span class="badge badge-success">Есть</span> {{ $visit->client_enriched_at }}</div>
                                    <div><strong>Язык:</strong> {{ $visit->client_language ?: '—' }}</div>
                                    <div><strong>Таймзона:</strong> {{ $visit->client_timezone ?: '—' }} ({{ $visit->client_timezone_offset ?? '—' }})</div>
                                    <div><strong>Экран:</strong> {{ $visit->client_screen_width ?: '—' }}×{{ $visit->client_screen_height ?: '—' }} / DPR {{ $visit->client_device_pixel_ratio ?: '—' }}</div>
                                    <div><strong>Viewport:</strong> {{ $visit->client_viewport_width ?: '—' }}×{{ $visit->client_viewport_height ?: '—' }}</div>
                                    <div><strong>Платформа:</strong> {{ $visit->client_platform ?: '—' }}</div>
                                    <div><strong>Touch:</strong> {{ is_null($visit->client_touch_supported) ? '—' : ($visit->client_touch_supported ? 'Да' : 'Нет') }}</div>
                                    <div><strong>CPU/RAM:</strong> {{ $visit->client_hardware_concurrency ?: '—' }} / {{ $visit->client_device_memory ?: '—' }}</div>
                                    <div><strong>Сеть:</strong> {{ $visit->client_effective_connection_type ?: $visit->client_connection_type ?: '—' }}</div>
                                @else
                                    <span class="badge badge-light">Нет JS-данных</span>
                                @endif
                            </td>
                            <td class="text-break">{{ $visit->referer ?: '—' }}</td>
                            <td class="text-break">{{ $visit->user_agent ?: '—' }}</td>
                            <td class="text-break"><code>{{ $visit->target_url }}</code></td>
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
                            <td colspan="11">Переходов пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $visits->links('pagination::bootstrap-4') }}
        </div>
    </section>
@endsection
