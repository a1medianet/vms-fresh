@extends('layouts.app')

@section('page-title', __('Import/Export'))

@section('content')
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Import Data') }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.import-export.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('Type') }}</label>
                        <select class="form-select" name="type" required>
                            <option value="visitors">{{ __('Visitors') }}</option>
                            <option value="buildings">{{ __('Buildings') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('File') }}</label>
                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls,.csv" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Import') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Export Data') }}</h4>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('dashboard.import-export.export', ['type' => 'visitors']) }}" class="btn btn-success">{{ __('Export Visitors') }}</a>
                    <a href="{{ route('dashboard.import-export.export', ['type' => 'pre-arrivals']) }}" class="btn btn-success">{{ __('Export Pre-Arrivals') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
