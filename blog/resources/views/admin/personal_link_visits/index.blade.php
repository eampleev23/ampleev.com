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
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="include_admin" name="include_admin" value="1" @checked($includeAdmin)>
                            <label class="custom-control-label" for="include_admin">Показывать переходы авторизованного админа</label>
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
                            <td>{{ $row->last_visit_at }}</td>
                            <td><code>https://ampleev.com/me/{{ $row->source }}</code></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Переходов за выбранный период пока нет.</td>
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
                        <th>Админ</th>
                        <th>Пользователь</th>
                        <th>IP-хеш</th>
                        <th>Referer</th>
                        <th>User-Agent</th>
                        <th>Итоговый URL</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($visits as $visit)
                        <tr>
                            <td>{{ $visit->created_at }}</td>
                            <td><strong>{{ $visit->source }}</strong></td>
                            <td>
                                @if($visit->is_admin)
                                    <span class="badge badge-warning">Да</span>
                                @else
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
                            <td class="text-break"><code>{{ $visit->ip_hash ?: '—' }}</code></td>
                            <td class="text-break">{{ $visit->referer ?: '—' }}</td>
                            <td class="text-break">{{ $visit->user_agent ?: '—' }}</td>
                            <td class="text-break"><code>{{ $visit->target_url }}</code></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Переходов пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $visits->links('pagination::bootstrap-4') }}
        </div>
    </section>
@endsection
