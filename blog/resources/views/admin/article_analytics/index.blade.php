@extends('layouts.app')

@section('title', 'Аналитика чтения статей')

@section('custom_css')
    <style>
        .admin-analytics-shell {
            --admin-analytics-ease-out: cubic-bezier(0.23, 1, 0.32, 1);
            background: linear-gradient(180deg, rgba(245, 247, 255, 0.72), rgba(255, 255, 255, 0));
        }

        .admin-analytics-filter,
        .admin-analytics-kpi,
        .admin-analytics-table-wrap {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 1rem 2.25rem rgba(27, 31, 59, 0.08);
        }

        .admin-analytics-kpi {
            transition:
                transform 180ms var(--admin-analytics-ease-out),
                box-shadow 180ms var(--admin-analytics-ease-out);
        }

        .admin-analytics-kpi:hover {
            transform: translateY(-2px);
            box-shadow: 0 1.25rem 2.6rem rgba(27, 31, 59, 0.12);
        }

        .admin-analytics-kpi-label {
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .admin-analytics-table-wrap {
            background: #fff;
            overflow: auto;
        }

        .admin-analytics-table {
            min-width: 980px;
            margin-bottom: 0;
        }

        .admin-analytics-table thead th {
            position: sticky;
            top: 0;
            z-index: 3;
            border-top: 0;
            background: #fff;
            box-shadow: inset 0 -1px 0 #e7eaf3;
            white-space: nowrap;
        }

        .admin-analytics-table tbody tr {
            transition: background-color 140ms ease;
        }

        .admin-analytics-table tbody tr:hover {
            background-color: rgba(55, 85, 190, 0.045);
        }

        .admin-analytics-funnel {
            min-width: 260px;
        }

        .admin-analytics-progress {
            height: 6px;
            overflow: hidden;
            border-radius: 999px;
            background-color: rgba(55, 85, 190, 0.1);
        }

        .admin-analytics-progress .progress-bar {
            border-radius: inherit;
        }

        .analytics-bucket {
            display: inline-flex;
            align-items: center;
            margin: 0 0.25rem 0.35rem 0;
            padding: 0.25rem 0.45rem;
            border-radius: 999px;
            background: rgba(27, 31, 59, 0.06);
            color: #596174;
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1;
        }

        .analytics-bucket.is-active {
            background: #3755be;
            color: #fff;
            box-shadow: 0 0.45rem 0.9rem rgba(55, 85, 190, 0.18);
        }

        .analytics-bucket.is-complete.is-active {
            background: #2fb344;
            box-shadow: 0 0.45rem 0.9rem rgba(47, 179, 68, 0.18);
        }

        @media (prefers-reduced-motion: reduce) {
            .admin-analytics-kpi,
            .admin-analytics-table tbody tr {
                transition: none;
            }

            .admin-analytics-kpi:hover {
                transform: none;
            }
        }
    </style>
@endsection

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

        $bucketLabels = [
            'drop_0_24' => 'до 25%',
            'drop_25_49' => '25-49%',
            'drop_50_74' => '50-74%',
            'drop_75_94' => '75-94%',
            'complete_95_100' => '95-100%',
        ];
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

    <section class="admin-analytics-shell">
        <div class="container">
            @include('admin.partials.nav')

            <form method="get" action="{{ route('admin.article_analytics.index') }}" class="card card-body admin-analytics-filter mb-4">
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
                    <div class="card card-body h-100 admin-analytics-kpi">
                        <span class="text-muted text-small admin-analytics-kpi-label">Уникальные просмотры</span>
                        <strong class="h3 mb-0">{{ $totals['views_count'] }}</strong>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body h-100 admin-analytics-kpi">
                        <span class="text-muted text-small admin-analytics-kpi-label">Read-сессии</span>
                        <strong class="h3 mb-0">{{ $totals['sessions_count'] }}</strong>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body h-100 admin-analytics-kpi">
                        <span class="text-muted text-small admin-analytics-kpi-label">Средняя глубина</span>
                        <strong class="h3 mb-0">{{ $totals['avg_scroll_percent'] }}%</strong>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-body h-100 admin-analytics-kpi">
                        <span class="text-muted text-small admin-analytics-kpi-label">Дочитывание</span>
                        <strong class="h3 mb-0">{{ $totals['completion_rate'] }}%</strong>
                    </div>
                </div>
            </div>

            <h3 class="mb-3">Статьи</h3>
            <div class="table-responsive admin-analytics-table-wrap mb-5">
                <table class="table table-sm table-striped admin-analytics-table">
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
                            <td class="admin-analytics-funnel">
                                <div class="text-small mb-1">
                                    25%: {{ $row['reached_25_count'] }} / {{ $percent($row['reached_25_count'], $row['sessions_count']) }}%
                                </div>
                                <div class="progress admin-analytics-progress mb-2">
                                    <div class="progress-bar" style="width: {{ $percent($row['reached_25_count'], $row['sessions_count']) }}%;"></div>
                                </div>
                                <div class="text-small mb-1">
                                    50%: {{ $row['reached_50_count'] }} / {{ $percent($row['reached_50_count'], $row['sessions_count']) }}%
                                </div>
                                <div class="progress admin-analytics-progress mb-2">
                                    <div class="progress-bar bg-info" style="width: {{ $percent($row['reached_50_count'], $row['sessions_count']) }}%;"></div>
                                </div>
                                <div class="text-small mb-1">
                                    75%: {{ $row['reached_75_count'] }} / {{ $percent($row['reached_75_count'], $row['sessions_count']) }}%
                                </div>
                                <div class="progress admin-analytics-progress mb-2">
                                    <div class="progress-bar bg-warning" style="width: {{ $percent($row['reached_75_count'], $row['sessions_count']) }}%;"></div>
                                </div>
                                <div class="text-small mb-1">
                                    100%: {{ $row['reached_100_count'] }} / {{ $percent($row['reached_100_count'], $row['sessions_count']) }}%
                                </div>
                                <div class="progress admin-analytics-progress">
                                    <div class="progress-bar bg-success" style="width: {{ $percent($row['reached_100_count'], $row['sessions_count']) }}%;"></div>
                                </div>
                            </td>
                            <td>
                                <strong class="d-block mb-2">{{ $row['dominant_bucket_label'] }}</strong>
                                <div>
                                    @foreach($bucketLabels as $bucketKey => $bucketLabel)
                                        <span class="analytics-bucket {{ $bucketKey === $row['dominant_bucket'] ? 'is-active' : '' }} {{ $bucketKey === 'complete_95_100' ? 'is-complete' : '' }}">
                                            {{ $bucketLabel }}: {{ $row['buckets'][$bucketKey] }}
                                        </span>
                                    @endforeach
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
            <div class="table-responsive admin-analytics-table-wrap">
                <table class="table table-sm table-striped admin-analytics-table">
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
