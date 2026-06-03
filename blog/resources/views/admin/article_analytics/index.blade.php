@extends('layouts.app')

@section('title', 'Аналитика чтения статей')

@section('content')
    @php
        $percent = function ($value, $total) {
            if ((int) $total <= 0) {
                return 0;
            }

            return round(((int) $value / (int) $total) * 100, 1);
        };

        $seconds = function ($value) {
            $value = (int) $value;
            if ($value < 60) {
                return $value . ' сек';
            }

            return floor($value / 60) . ' мин ' . ($value % 60) . ' сек';
        };
    @endphp

    <section class="bg-primary-alt header-inner o-hidden">
        <div class="container">
            <div class="row my-4">
                <div class="col">
                    <h1>Аналитика чтения статей</h1>
                    <p class="lead mb-0">Собственная статистика по просмотрам, глубине чтения и точкам отвалов.</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            @include('admin.partials.nav')

            <form method="get" action="{{ route('admin.article_analytics.index') }}" class="mb-4">
                <div class="form-row align-items-end">
                    <div class="col-md-3">
                        <label for="period">Период</label>
                        <select id="period" name="period" class="form-control">
                            @foreach($periods as $periodKey => $periodLabel)
                                <option value="{{ $periodKey }}" {{ $period === $periodKey ? 'selected' : '' }}>{{ $periodLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-primary btn-block">Показать</button>
                    </div>
                </div>
            </form>

            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card card-body h-100">
                        <span class="text-muted text-small">Уникальные просмотры</span>
                        <strong class="h3 mb-0">{{ $totals['views_count'] }}</strong>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body h-100">
                        <span class="text-muted text-small">Read-сессии</span>
                        <strong class="h3 mb-0">{{ $totals['sessions_count'] }}</strong>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body h-100">
                        <span class="text-muted text-small">Средняя глубина</span>
                        <strong class="h3 mb-0">{{ $totals['avg_scroll_percent'] }}%</strong>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body h-100">
                        <span class="text-muted text-small">Дочитывание</span>
                        <strong class="h3 mb-0">{{ $totals['completion_rate'] }}%</strong>
                    </div>
                </div>
            </div>

            <h3 class="mb-3">Статьи</h3>
            <div class="table-responsive mb-5">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Статья</th>
                        <th>Раздел</th>
                        <th class="text-right">Просмотры</th>
                        <th class="text-right">Сессии</th>
                        <th class="text-right">Средняя глубина</th>
                        <th>Воронка</th>
                        <th>Чаще всего останавливаются</th>
                        <th class="text-right">Среднее время</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($rows as $row)
                        <tr>
                            <td>
                                <a href="{{ route('blog.show_article', $row['article']->text_url) }}" target="_blank" rel="noopener">
                                    {{ $row['article']->title }}
                                </a>
                                <div class="text-muted text-small">Всего просмотров: {{ $row['total_views_count'] }}</div>
                            </td>
                            <td>{{ optional($row['article']->blog_section)->title ?? '—' }}</td>
                            <td class="text-right">{{ $row['views_count'] }}</td>
                            <td class="text-right">{{ $row['sessions_count'] }}</td>
                            <td class="text-right">{{ $row['avg_scroll_percent'] }}%</td>
                            <td style="min-width: 260px;">
                                <div class="text-small mb-1">
                                    25%: {{ $row['reached_25_count'] }} / {{ $percent($row['reached_25_count'], $row['sessions_count']) }}%
                                </div>
                                <div class="progress mb-2" style="height: 6px;">
                                    <div class="progress-bar" style="width: {{ $percent($row['reached_25_count'], $row['sessions_count']) }}%;"></div>
                                </div>
                                <div class="text-small mb-1">
                                    50%: {{ $row['reached_50_count'] }} / {{ $percent($row['reached_50_count'], $row['sessions_count']) }}%
                                </div>
                                <div class="progress mb-2" style="height: 6px;">
                                    <div class="progress-bar bg-info" style="width: {{ $percent($row['reached_50_count'], $row['sessions_count']) }}%;"></div>
                                </div>
                                <div class="text-small mb-1">
                                    75%: {{ $row['reached_75_count'] }} / {{ $percent($row['reached_75_count'], $row['sessions_count']) }}%
                                </div>
                                <div class="progress mb-2" style="height: 6px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $percent($row['reached_75_count'], $row['sessions_count']) }}%;"></div>
                                </div>
                                <div class="text-small mb-1">
                                    100%: {{ $row['reached_100_count'] }} / {{ $percent($row['reached_100_count'], $row['sessions_count']) }}%
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: {{ $percent($row['reached_100_count'], $row['sessions_count']) }}%;"></div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $row['dominant_bucket_label'] }}</strong>
                                <div class="text-muted text-small">
                                    до 25%: {{ $row['buckets']['drop_0_24'] }},
                                    25-49%: {{ $row['buckets']['drop_25_49'] }},
                                    50-74%: {{ $row['buckets']['drop_50_74'] }},
                                    75-94%: {{ $row['buckets']['drop_75_94'] }},
                                    95-100%: {{ $row['buckets']['complete_95_100'] }}
                                </div>
                            </td>
                            <td class="text-right">{{ $seconds($row['avg_active_seconds']) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Данных пока нет. Они начнут появляться после первого просмотра статей на проде.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <h3 class="mb-3">Последние read-сессии</h3>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Последняя активность</th>
                        <th>Статья</th>
                        <th>Язык</th>
                        <th>Устройство</th>
                        <th>Источник</th>
                        <th class="text-right">Макс. глубина</th>
                        <th class="text-right">Активное время</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($recentSessions as $session)
                        <tr>
                            <td>{{ $session->last_seen_at ?: $session->created_at }}</td>
                            <td>{{ optional($session->article)->title ?? 'Статья удалена' }}</td>
                            <td>{{ $session->locale ?: '—' }}</td>
                            <td>{{ $session->device_type ?: '—' }}</td>
                            <td>{{ $session->source_type ?: '—' }}</td>
                            <td class="text-right">{{ $session->max_scroll_percent }}%</td>
                            <td class="text-right">{{ $seconds($session->active_seconds) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Сессий пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
