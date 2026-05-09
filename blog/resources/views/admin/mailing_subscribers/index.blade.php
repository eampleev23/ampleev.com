@extends('layouts.app')

@section('title', 'Подписчики новых статей')

@section('content')
    <section class="bg-primary-alt header-inner o-hidden">
        <div class="container">
            <div class="row my-4">
                <div class="col">
                    <h1>Подписчики новых статей</h1>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            @include('admin.partials.nav')

            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Статус</th>
                        <th>Создан</th>
                        <th>Обновлен</th>
                        <th>Пользователь</th>
                        <th>IP</th>
                        <th>Язык</th>
                        <th>Referer</th>
                        <th>User-Agent</th>
                        <th>Hash</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($subscribers as $subscriber)
                        <tr>
                            <td>{{ $subscriber->id }}</td>
                            <td>{{ $subscriber->email }}</td>
                            <td>
                                @if($subscriber->confirmed)
                                    <span class="badge badge-success">Подтвержден</span>
                                @else
                                    <span class="badge badge-warning">Ожидает</span>
                                @endif
                            </td>
                            <td>{{ $subscriber->created_at }}</td>
                            <td>{{ $subscriber->updated_at }}</td>
                            <td>
                                @if($subscriber->user)
                                    {{ $subscriber->user->name }}<br>
                                    <span class="text-muted">{{ $subscriber->user->email }}</span>
                                @else
                                    <span class="text-muted">Гость</span>
                                @endif
                            </td>
                            <td>{{ $subscriber->ip ?: '—' }}</td>
                            <td>{{ $subscriber->locale ?: '—' }}</td>
                            <td class="text-break">{{ $subscriber->referer ?: '—' }}</td>
                            <td class="text-break">{{ $subscriber->user_agent ?: '—' }}</td>
                            <td class="text-break">{{ $subscriber->url }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">Подписчиков пока нет.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $subscribers->links('pagination::bootstrap-4') }}
        </div>
    </section>
@endsection
