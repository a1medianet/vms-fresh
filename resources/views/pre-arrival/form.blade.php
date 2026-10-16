<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Pre-Arrival Form') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Pre-Arrival Form') }}</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pre-arrival.submit', $preArrival->token) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ __('Full Name') }}</label>
                                <input type="text" class="form-control" name="full_name" value="{{ $preArrival->full_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control" name="email" value="{{ $preArrival->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('Nationality') }}</label>
                                <input type="text" class="form-control" name="nationality" value="{{ $preArrival->nationality }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('Passport Number') }}</label>
                                <input type="text" class="form-control" name="passport_number" value="{{ $preArrival->passport_number }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('Arrival Date') }}</label>
                                <input type="date" class="form-control" name="arrival_date" value="{{ $preArrival->arrival_date->format('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('Departure Date') }}</label>
                                <input type="date" class="form-control" name="departure_date" value="{{ $preArrival->departure_date->format('Y-m-d') }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">{{ __('Submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
